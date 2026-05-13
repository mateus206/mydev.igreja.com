<?php
session_start();
require "../app/controllers/WebController.php";
require "../app/controllers/AuthController.php";
require "../app/middleware/AuthMiddlewareWeb.php";

 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$isLogin = AuthMiddlewareWeb::isLogin();
 
if ($uri === '/' || $uri === '/index' || $uri === '/home') {
    (new WebController())->index();
 
} elseif ($uri === '/login' && $method === 'GET') {
    (new WebController())->login();

}

elseif ($uri === '/login' && $method === 'POST') {
    (new AuthController())->loginWeb();

}
elseif ($uri === '/dashboard' && $method === 'GET') {
    if (!$isLogin) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Não tem acesso a esta página. 
        Por favor, faça login primeiro.'
        ];
        header("Location: /login");
        exit;
    } else {
        (new WebController())->dashboard();
    }
}

elseif ($uri === '/ativos' && $method === 'GET') {
    if (!$isLogin) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Não tem acesso a esta página. 
        Por favor, faça login primeiro.'
        ];  
        header("Location: /login");
        exit;
    } else {
        (new WebController())->ativos();
    }
}

elseif ($uri === '/campanhas' && $method === 'GET') {
    if (!$isLogin) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Não tem acesso a esta página. 
        Por favor, faça login primeiro.'
        ];  
        header("Location: /login");
        exit;
    } else {
        (new WebController())->campanhas();
    }
}

elseif ($uri === '/logout' && $method === 'POST') {
    (new AuthController())->logoutWeb();
}

else {
    echo "Página não encontrada";
}
