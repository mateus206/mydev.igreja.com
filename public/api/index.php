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