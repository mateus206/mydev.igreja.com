<?php

require __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../../app/controllers/AuthController.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';

require_once __DIR__ . '/../../app/controllers/AcaoSolidariasController.php';
require_once __DIR__ . '/../../app/dao/acaosolidariasDAO.php';
require_once __DIR__ . '/../../app/models/acaosolidarias.php';

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

} elseif ($uri === "/AcaoSolidarias" && $method === 'GET') {
    AuthMiddleware::check();
    (new AcaoSolidariascontroller())->listApi();
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