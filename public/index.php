<?php
require "../app/controllers/WebController.php";
//require "../app/controllers/AuthController.php"; // <- faltava isto
 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
 
if ($uri === '/' || $uri === '/index' || $uri === '/home') {
    (new WebController())->index();
 
} elseif ($uri === '/login' && $method === 'GET') {
    (new WebController())->login();

}else {
    echo "Página não encontrada";
}