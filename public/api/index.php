<?php

require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../../app/controllers/AuthController.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';

require_once __DIR__ . '/../../app/controllers/AcaoSolidariasController.php';
require_once __DIR__ . '/../../app/dao/acaosolidariasDAO.php';
require_once __DIR__ . '/../../app/models/acaosolidarias.php';

require_once __DIR__ . '/../../app/controllers/EventosController.php';
require_once __DIR__ . '/../../app/dao/eventosDAO.php';
require_once __DIR__ . '/../../app/models/eventos.php';

require_once __DIR__ . '/../../app/dao/PedidoOracaoDAO.php';

require_once __DIR__ . '/../../app/dao/ApoioSocialDAO.php';

require_once __DIR__ . '/../../app/dao/ContribuicaoDAO.php';
require_once __DIR__ . '/../../app/dao/MinisterioInscricaoDAO.php';
require_once __DIR__ . '/../../app/dao/NotificacaoDAO.php';

require_once __DIR__ . '/../../app/utils/Utils.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/api', '', $uri);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json; charset=UTF-8');

if ($uri === "/signup" && $method === 'POST') {
    (new AuthController())->signupApi();
    exit;
}

if ($uri === "/login" && $method === 'POST') {
    (new AuthController())->loginApi();
    exit;

} elseif ($uri === "/users/profile" && $method === 'GET') {
    $tokenDecoded = AuthController::requireAuth();
    (new UserController())->listprofileApi($tokenDecoded->data->id);
    exit;

} elseif ($uri === "/users/profile" && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    (new UserController())->updateProfileApi($authUser->getId());
    exit;

} elseif (($uri === "/AcaoSolidarias" || $uri === "/acao-solidarias") && $method === 'GET') {
    AuthMiddleware::check();
    (new AcaoSolidariascontroller())->listApi();
    exit;

} elseif ((preg_match('#^/AcaoSolidarias/(\d+)$#', $uri, $m) || preg_match('#^/acao-solidarias/(\d+)$#', $uri, $m)) && $method === 'GET') {
    AuthMiddleware::check();
    $id = (int)$m[1];
    (new AcaoSolidariascontroller())->showApi($id);
    exit;

} elseif ($uri === "/Eventos" && $method === 'GET') {
    AuthMiddleware::check();
    (new Eventoscontroller())->listApi();
    exit;

} elseif (($uri === "/pedido-oracoes" || $uri === "/PedidoOracoes") && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    (new AuthController())->pedidoOracaoApi($authUser->getId());
    exit;

} elseif (($uri === "/apoio-sociais" || $uri === "/ApoioSociais") && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    (new AuthController())->apoioSocialApi($authUser->getId());
    exit;


} elseif ($uri === "/notificacoes" && $method === 'GET') {
    $authUser = AuthMiddleware::check();
    $notificacoes = (new NotificacaoDAO())->findByUser($authUser->getId());
    Utils::jsonResponse(['success' => true, 'message' => 'Notificações listadas com sucesso', 'data' => ['notificacoes' => $notificacoes]], 200);
    exit;

} elseif (preg_match('#^/notificacoes/(\d+)/lida$#', $uri, $m) && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    (new NotificacaoDAO())->marcarLida((int)$m[1], $authUser->getId());
    Utils::jsonResponse(['success' => true, 'message' => 'Notificação marcada como lida', 'data' => []], 200);
    exit;

} elseif (($uri === "/contribuicoes" || $uri === "/Contribuicoes") && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    try {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!is_array($input)) { $input = $_POST; }
        $tipo = trim($input['tipo'] ?? '');
        $valor = (float)($input['valor'] ?? 0);
        $metodo = trim($input['metodo_pagamento'] ?? '');
        $observacao = trim($input['observacao'] ?? '');
        if ($tipo === '' || $valor <= 0 || $metodo === '') { throw new Exception('tipo, valor e metodo_pagamento são obrigatórios'); }
        $created = (new ContribuicaoDAO())->create($authUser->getId(), $tipo, $valor, $metodo, $observacao);
        Utils::jsonResponse(['success' => true, 'message' => 'Contribuição registada com sucesso', 'data' => ['contribuicao' => $created]], 201);
    } catch (Exception $e) {
        Utils::jsonResponse(['success' => false, 'message' => $e->getMessage(), 'data' => []], 400);
    }
    exit;

} elseif (($uri === "/contribuicoes/minhas" || $uri === "/Contribuicoes/minhas") && $method === 'GET') {
    $authUser = AuthMiddleware::check();
    $items = (new ContribuicaoDAO())->findByUser($authUser->getId());
    Utils::jsonResponse(['success' => true, 'message' => 'Contribuições listadas com sucesso', 'data' => ['contribuicoes' => $items]], 200);
    exit;

} elseif (($uri === "/ministerios/inscricao" || $uri === "/Ministerios/inscricao") && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    try {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!is_array($input)) { $input = $_POST; }
        $ministerio = trim($input['ministerio'] ?? '');
        $experiencia = trim($input['experiencia'] ?? '');
        $disponibilidade = trim($input['disponibilidade'] ?? '');
        $mensagem = trim($input['mensagem'] ?? '');
        if ($ministerio === '') { throw new Exception('ministerio é obrigatório'); }
        $created = (new MinisterioInscricaoDAO())->create($authUser->getId(), $ministerio, $experiencia, $disponibilidade, $mensagem);
        Utils::jsonResponse(['success' => true, 'message' => 'Inscrição no ministério enviada com sucesso', 'data' => ['inscricao' => $created]], 201);
    } catch (Exception $e) {
        Utils::jsonResponse(['success' => false, 'message' => $e->getMessage(), 'data' => []], 400);
    }
    exit;

} elseif (($uri === "/ministerios/minhas-inscricoes" || $uri === "/Ministerios/minhas-inscricoes") && $method === 'GET') {
    $authUser = AuthMiddleware::check();
    $items = (new MinisterioInscricaoDAO())->findByUser($authUser->getId());
    Utils::jsonResponse(['success' => true, 'message' => 'Inscrições listadas com sucesso', 'data' => ['inscricoes' => $items]], 200);
    exit;

} elseif ($uri === "/users/profile/password" && $method === 'POST') {
    $authUser = AuthMiddleware::check();
    (new UserController())->updatePasswordApi($authUser->getId());
    exit;

} else {
    $dataResponse = [
        'success' => false,
        'message' => 'Not found.',
        'data' => []
    ];

    Utils::jsonResponse($dataResponse, 404);
    exit;
}