<?php

require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/EmailVerificationDAO.php';
require_once __DIR__ . '/../dao/PedidoOracaoDAO.php';
require_once __DIR__ . '/../dao/ApoioSocialDAO.php';
require_once __DIR__ . '/../config/Databasesingle.php';
require_once __DIR__ . '/../services/MyMailerService.php';
require_once __DIR__ . '/../utils/Utils.php';
require_once __DIR__ . '/../config/jwt.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

class AuthController
{
    private function view($name, $data = [])
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public static function requireAuth(): object
    {
        try {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

            if (!$authHeader) {
                throw new Exception("Token não enviado.");
            }

            if (!preg_match('/Bearer\s+(.+)/i', $authHeader, $matches)) {
                throw new Exception("Formato do token inválido.");
            }

            $token = $matches[1];
            $decoded = JWT::decode($token, new Key(JwtConfig::$secret, 'HS256'));

            return $decoded;

        } catch (ExpiredException $e) {
            Utils::jsonResponse(['success' => false, 'message' => "Token expirado: " . $e->getMessage(), 'data' => []], 401);
            exit;

        } catch (SignatureInvalidException $e) {
            Utils::jsonResponse(['success' => false, 'message' => "Assinatura do token inválida: " . $e->getMessage(), 'data' => []], 401);
            exit;

        } catch (BeforeValidException $e) {
            Utils::jsonResponse(['success' => false, 'message' => "Token ainda não é válido: " . $e->getMessage(), 'data' => []], 401);
            exit;

        } catch (Exception $e) {
            Utils::jsonResponse(['success' => false, 'message' => "Erro na autenticação: " . $e->getMessage(), 'data' => []], 401);
            exit;
        }
    }

    public function loginWeb()
    {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => 'Email e password são OBRIGATÓRIOS!'];
            header("Location: /login");
            exit;
        }

        $user = (new UserDAO())->findByEmail($email);
        if (!$user) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => 'Email ou password inválidos ou não existe conta com esse email'];
            header("Location: /login");
            exit;
        }

        if (!password_verify($password, $user->getPassword())) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => "Dados de login inválidos"];
            header("Location: /login");
            exit;
        }

        // No login do site/painel, a conta não precisa estar verificada.
        // Só é necessário confirmar que é administrador.
        if (!$user->getIsAdmin()) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => 'Apenas administradores podem fazer login neste painel.'];
            header("Location: /login");
            exit;
        }

        $_SESSION['token'] = [
            'id'       => $user->getId(),
            'username' => $user->getNome(),
            'email'    => $user->getEmail(),
            'is_admin' => $user->getIsAdmin()
        ];

        $_SESSION['toast'] = ['type' => 'success', 'message' => "Bem-vindo de volta, " . $user->getNome() . "!"];
        header("Location: /dashboard");
        exit;
    }

    public function logoutWeb()
    {
        unset($_SESSION['token']);

        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Sessão terminada com sucesso.'];
        header("Location: /login");
        exit;
    }

    public function signupApi(): void
    {
        $pdo = Databasesingle::connect();
        $pdo->beginTransaction();

        try {
            $nome     = trim($_POST['nome'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($nome === '' || $email === '' || $password === '' || $telefone === '') {
                throw new Exception("Todos os campos são obrigatórios.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email inválido.");
            }

            $userDAO = new UserDAO();

            if ($userDAO->findByEmail($email)) {
                throw new Exception("Já existe uma conta com esse email.");
            }

            // CORRIGIDO: ordem correta ($nome, $email, $telefone, $password)
            // a password ainda não é definida aqui — o utilizador define-a ao verificar o email
            // por isso guardamos um placeholder vazio (será preenchido em verifyEmailSubmit)
            $userId = $userDAO->createPending($nome, $email, $telefone, password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT));

            $verifyDAO = new EmailVerificationDAO();
            $token = $verifyDAO->createForUser($userId, 600);

            $scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host    = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $baseUrl = $scheme . '://' . $host;
            $link    = $baseUrl . "/verify-email?token=" . urlencode($token);

            $subject = "Verifica o teu email (expira em 10 min)";
            $html = "
                <div style='font-family: Arial, sans-serif;'>
                    <h2>Olá, " . $nome . "!</h2>
                    <p>Para ativares a tua conta e definires a tua password, clica no link abaixo (válido por <b>10 minutos</b>):</p>
                    <p><a href='{$link}'>{$link}</a></p>
                    <p>Se o link expirar, faz signup novamente (ou pede reenvio do link).</p>
                </div>
            ";

            (new MyMailerService())->send($email, $subject, $html);

            $pdo->commit();

            Utils::jsonResponse(['success' => true, 'message' => 'Signup realizado com sucesso. Verifica o teu email.', 'data' => []], 200);

        } catch (Exception $e) {
            $pdo->rollBack();
            Utils::jsonResponse(['success' => false, 'message' => 'Erro no signup: ' . $e->getMessage(), 'data' => []], 400);
        }
    }

    public function verifyEmailForm(): void
    {
        $token = $_GET['token'] ?? '';

        if ($token === '') {
            http_response_code(400);
            echo "Token em falta.";
            return;
        }

        // Passa o token para a view
        require __DIR__ . '/../../public/views/verify-email.php';
    }

    public function verifyEmailSubmit(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $token    = (string)($_POST['token'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $confirmPassword = (string)($_POST['confirm_password'] ?? '');

        if ($token === '' || $password === '') {
            throw new Exception("Token e password são obrigatórios.");
        }

        if ($password !== $confirmPassword) {
            throw new Exception("As passwords não coincidem.");
        }

        if (strlen($password) < 6) {
            throw new Exception("A password deve ter pelo menos 6 caracteres.");
        }

        $verDao = new EmailVerificationDAO();
        $userId = $verDao->validate($token);

        if (!$userId) {
            throw new Exception("Link inválido ou expirado (10 min). Pede um novo.");
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        // CORRIGIDO: método agora existe no UserDAO e define password + is_verified=1
        (new UserDAO())->setPasswordAndVerify($userId, $hash);

        $verDao->markUsed($token);

        $_SESSION['toast'] = [
            'type'    => 'success',
            'message' => 'Email verificado e password definida. Já podes fazer login!'
        ];
        header("Location: /login");
        exit;
    }

    public function loginApi()
    {
        $email    = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;

        $user = (new UserDAO())->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            Utils::jsonResponse(['success' => false, 'message' => 'Login inválido', 'data' => []], 401);
            return;
        }

        // CORRIGIDO: verificar se o email foi verificado
        if (!$user->getIsVerified()) {
            Utils::jsonResponse(['success' => false, 'message' => 'Conta ainda não verificada.', 'data' => []], 403);
            return;
        }

        $payload = [
            "iat"  => time(),
            "exp"  => time() + 3600,
            "data" => [
                "id"   => $user->getId(),
                "role" => $user->getIsAdmin()
            ]
        ];

        $jwt = JWT::encode($payload, JwtConfig::$secret, 'HS256');

        Utils::jsonResponse([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'data'    => [
                'user' => $user->toArray(),
                'jwt'  => $jwt
            ],
        ], 200);
    }

    public function pedidoOracaoApi(int $userId): void
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);
            if (!is_array($input)) {
                $input = $_POST;
            }

            $email      = trim($input["email"] ?? "");
            $tipoPedido = trim($input["tipo_pedido"] ?? "");
            $descricao  = trim($input["descricao"] ?? "");

            if ($email === "" || $tipoPedido === "" || $descricao === "") {
                throw new Exception("email, tipo_pedido e descricao são obrigatórios");
            }

            $createdPedido = (new PedidoOracaoDAO())->create($userId, $email, $tipoPedido, $descricao);

            Utils::jsonResponse(['success' => true, 'message' => 'Pedido de oração enviado com sucesso', 'data' => ['pedido_oracao' => $createdPedido]], 201);
            exit;

        } catch (Exception $e) {
            Utils::jsonResponse(['success' => false, 'message' => $e->getMessage(), 'data' => []], 400);
            exit;
        }
    }

    public function apoioSocialApi(int $userId): void
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);
            if (!is_array($input)) {
                $input = $_POST;
            }

            $local            = trim($input["local"] ?? "");
            $codigoPostal     = trim($input["codigo_postal"] ?? "");
            $telefone         = trim($input["telefone"] ?? "");
            $membrosDeFamilia = $input["membros_de_familia"] ?? "";
            $pedidoAjuda      = trim($input["pedido_ajuda"] ?? "");

            if ($local === "" || $codigoPostal === "" || $telefone === "" || $membrosDeFamilia === "" || $pedidoAjuda === "") {
                throw new Exception("local, codigo_postal, telefone, membros_de_familia e pedido_ajuda são obrigatórios");
            }

            $createdPedido = (new ApoioSocialDAO())->create($userId, $local, $codigoPostal, $telefone, $membrosDeFamilia, $pedidoAjuda);

            Utils::jsonResponse(['success' => true, 'message' => 'Pedido de apoio social enviado com sucesso', 'data' => ['apoio_social' => $createdPedido]], 201);
            exit;

        } catch (Exception $e) {
            Utils::jsonResponse(['success' => false, 'message' => $e->getMessage(), 'data' => []], 400);
            exit;
        }
    }
}