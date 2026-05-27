<?php

require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/EmailVerificationDAO.php';
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

    // esse metodo e para saber se o token e valido ou não
    public static function requireAuth(): object
    {
        try {
            // ele vai buscar o token no header enviado no HTTP
            $headers = getallheaders();

            // ele vai procurar por Authorization ou authorization
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

            // se nao existir Authorization
            if (!$authHeader) {
                throw new Exception("Token não enviado.");
            }

            // aqui ele vai validar se o formato do token e valido
            if (!preg_match('/Bearer\s+(.+)/i', $authHeader, $matches)) {
                throw new Exception("Formato do token inválido.");
            }

            // ele vai extrair o token do header
            $token = $matches[1];

            // aqui ele vai decodificar o token
            $decoded = JWT::decode($token, new Key(JwtConfig::$secret, 'HS256'));

            return $decoded;

        } catch (ExpiredException $e) {
            $dataResponse = [
                'success' => false,
                'message' => "Token expirado: " . $e->getMessage(),
                'data' => []
            ];

            Utils::jsonResponse($dataResponse, 401);
            exit;

        } catch (SignatureInvalidException $e) {
            $dataResponse = [
                'success' => false,
                'message' => "Assinatura do token inválida: " . $e->getMessage(),
                'data' => []
            ];

            Utils::jsonResponse($dataResponse, 401);
            exit;

        } catch (BeforeValidException $e) {
            $dataResponse = [
                'success' => false,
                'message' => "Token ainda não é válido: " . $e->getMessage(),
                'data' => []
            ];

            Utils::jsonResponse($dataResponse, 401);
            exit;

        } catch (Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => "Erro na autenticação: " . $e->getMessage(),
                'data' => []
            ];

            Utils::jsonResponse($dataResponse, 401);
            exit;
        }
    }


   public function loginWeb()
    {
        //var_dump("Estou no login a validar os dados");
        // Apanhar os dados do formulário
        $email = trim($_POST['email']) ?? '';
 
        $password = trim($_POST['password']) ?? '';
 
        // Se não houver email ou password, mostrar erro
        // é preciso lançar exceção para o index.php apanhar e mostrar o erro via flash message
        if (empty($email) || empty($password)) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Email e password são OBRIGATÓRIOS!'
            ];
            header("Location: /login");
            exit;
        }
 
        $user = (new UserDAO())->findByEmail($email);
      
 
        if (!$user) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Email ou password inválidos ou não existe conta com esse email'
            ];
            header("Location: /login");
            exit;
        }
 
 
        // Utilizador foi encontrado - verificar password
        if (password_verify($password, $user->getPassword())) {
            //var_dump("Password correta");
            $_SESSION['token'] = [
                'id' => $user->getId(),
                'username' => $user->getNome(),
                'email' => $user->getEmail(),
                'is_admin' => $user->getIsAdmin()
            ];
            // Password correta - criar sessão
            //$_SESSION['user_id'] = $user->id;
            //$_SESSION['username'] = $user->username;
 
            // Redirecionar para a home
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => "Bem-vindo de volta, " . $user->getNome() . "!"
            ];
 
            header("Location: /dashboard");
            exit;
 
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => "Dados de login inválidos"
            ];
            header("Location: /login");
            exit;
        }
 
    }
     public function logoutWeb() {
    unset($_SESSION['token']);

    $_SESSION['toast'] = [
      'type' => 'success',
      'message' => 'Sessão terminada com sucesso.'
    ];

    header("Location: /login");

  }
    public function signupApi(): void
    {
       

        $pdo = Databasesingle::connect();

        $pdo->beginTransaction();

        try {

            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($nome === '' || $email === '' || $password === '' || $telefone === '') {
                throw new Exception("Todos os campos são obrigatórios.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email inválido.");
            }

            $userDao = new UserDAO();

            if ($userDao->findByEmail($email)) {
                throw new Exception("Já existe conta com este email.");
            }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$userId = $userDao->createPending($nome, $telefone, $email, $hashedPassword);
           

            $verDao = new EmailVerificationDAO();

            $token = $verDao->createForUser($userId, 300);

            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                ? 'https'
                : 'http';

            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

            $baseUrl = $scheme . '://' . $host;

            $link = $baseUrl . "/verify-email?token=" . urlencode($token);

            $subject = "Verifica o teu email";

            $html = "
                <h2>Olá {$nome}</h2>
                <p>Clica no link abaixo para ativar a tua conta:</p>
                <a href='{$link}'>{$link}</a>
            ";

            (new MyMailerService())->send($email, $subject, $html);

            $pdo->commit();

            http_response_code(200);

            echo json_encode([
                'success' => true,
                'message' => 'signup criado com sucesso',
                'data' => []
            ]);

            exit;

        } catch (Exception $e) {

            $pdo->rollBack();

            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao criar conta',
                'data' => []
            ]);

            exit;
        }
    }

    public function loginApi()
  {
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;

    $user = (new UserDAO())->findByEmail($email);

    if (!$user || !password_verify($password, $user->getPassword())) {
      echo json_encode(["error" => "login inválido"]);
      return;
    }

    $payload = [
      "iat" => time(),
      "exp" => time() + 3600,
      "data" => [
        "id" => $user->getId(),
       "role" => $user->getIsAdmin()
      ]
    ];

    $jwt = JWT::encode($payload, JwtConfig::$secret, 'HS256');

    $responseData = [
      'success' => true,
      'message' => 'Login realizado com sucesso',
      'data' => [
        'user' => $user->toArray(),
        'jwt' => $jwt
      ],
    ];

    Utils::jsonResponse($responseData, 200);
  }
}