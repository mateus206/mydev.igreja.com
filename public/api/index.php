<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri =str_replace('/api', '', $uri);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json; charset=UTF-8');

if ($uri === "/signup" && $method === 'POST') {
    (new AuthController())->signupApi();
   
}

if ($uri === "/login" && $method === 'POST') {
    (new AuthController())->loginApi();
   
}elseif ($uri === "/users/profile" && $method === 'GET') {
    $tokeDecoded = Authcontroller::requireAuth();
    (new UserController())->listprofileApi($tokeDecoded->data->id);
}

else {
  $dataResponse = [
    'success' => false,
    'message' => 'Not found.',
    'data'    => []
  ];

  Utils::jsonResponse($dataResponse, 401);

  exit;
}
