<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri =str_replace('/api', '', $uri);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json; charset=UTF-8');



if ($uri === "/signup" && $method === 'POST') {
    (new AuthController())->signupApi();
    exit;
}

if ($uri === "/login" && $method === 'POST') {
    (new AuthController())->loginApi();
    exit;
}



http_response_code(404);

echo json_encode([
    'success' => false,
    'message' => 'Página não encontrada'
]);