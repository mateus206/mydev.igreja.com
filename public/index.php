<?php
session_start();

require "../app/controllers/WebController.php";
require "../app/controllers/AuthController.php";
require "../app/middleware/AuthMiddleware.php";
require "../app/middleware/AuthMiddlewareWeb.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$isLogin = AuthMiddlewareWeb::isLogin();

function requireLogin(): void
{
    if (!AuthMiddlewareWeb::isLogin()) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Não tem acesso a esta página. Por favor, faça login primeiro.'
        ];
        header("Location: /login");
        exit;
    }

    if (!AuthMiddlewareWeb::isAdmin()) {
        unset($_SESSION['token']);
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Apenas administradores podem acessar este painel.'
        ];
        header("Location: /login");
        exit;
    }
}

if ($uri === '/' || $uri === '/index' || $uri === '/home') {
    (new WebController())->index();
}

elseif ($uri === '/login' && $method === 'GET') {
    (new WebController())->login();
}

elseif ($uri === '/login' && $method === 'POST') {
    (new AuthController())->loginWeb();
}

elseif ($uri === '/dashboard' && $method === 'GET') {
    requireLogin();
    (new WebController())->dashboard();
}

elseif ($uri === '/users' && $method === 'GET') {
    requireLogin();
    (new WebController())->users();
}

elseif ($uri === '/users/edit' && $method === 'GET') {
    requireLogin();
    (new WebController())->editUser();
}

elseif ($uri === '/users/store' && $method === 'POST') {
    requireLogin();
    (new WebController())->storeUser();
}

elseif ($uri === '/users/update' && $method === 'POST') {
    requireLogin();
    (new WebController())->updateUser();
}

elseif ($uri === '/users/delete' && $method === 'POST') {
    requireLogin();
    (new WebController())->deleteUser();
}

elseif ($uri === '/eventos' && $method === 'GET') {
    requireLogin();
    (new WebController())->eventos();
}

elseif ($uri === '/eventos/edit' && $method === 'GET') {
    requireLogin();
    (new WebController())->editEvento();
}

elseif ($uri === '/eventos/store' && $method === 'POST') {
    requireLogin();
    (new WebController())->storeEvento();
}

elseif ($uri === '/eventos/update' && $method === 'POST') {
    requireLogin();
    (new WebController())->updateEvento();
}

elseif ($uri === '/eventos/delete' && $method === 'POST') {
    requireLogin();
    (new WebController())->deleteEvento();
}

elseif ($uri === '/apoio-sociais' && $method === 'GET') {
    requireLogin();
    (new WebController())->apoioSociais();
}

elseif ($uri === '/apoio-sociais/edit' && $method === 'GET') {
    requireLogin();
    (new WebController())->editApoioSocial();
}

elseif ($uri === '/apoio-sociais/store' && $method === 'POST') {
    requireLogin();
    (new WebController())->storeApoioSocial();
}

elseif ($uri === '/apoio-sociais/update' && $method === 'POST') {
    requireLogin();
    (new WebController())->updateApoioSocial();
}

elseif ($uri === '/apoio-sociais/delete' && $method === 'POST') {
    requireLogin();
    (new WebController())->deleteApoioSocial();
}

elseif ($uri === '/pedido-oracoes' && $method === 'GET') {
    requireLogin();
    (new WebController())->pedidoOracoes();
}

elseif ($uri === '/pedido-oracoes/edit' && $method === 'GET') {
    requireLogin();
    (new WebController())->editPedidoOracao();
}

elseif ($uri === '/pedido-oracoes/store' && $method === 'POST') {
    requireLogin();
    (new WebController())->storePedidoOracao();
}

elseif ($uri === '/pedido-oracoes/update' && $method === 'POST') {
    requireLogin();
    (new WebController())->updatePedidoOracao();
}

elseif ($uri === '/pedido-oracoes/delete' && $method === 'POST') {
    requireLogin();
    (new WebController())->deletePedidoOracao();
}

elseif ($uri === '/acao-solidarias' && $method === 'GET') {
    requireLogin();
    (new WebController())->acaoSolidarias();
}

elseif ($uri === '/acao-solidarias/edit' && $method === 'GET') {
    requireLogin();
    (new WebController())->editAcaoSolidaria();
}

elseif ($uri === '/acao-solidarias/store' && $method === 'POST') {
    requireLogin();
    (new WebController())->storeAcaoSolidaria();
}

elseif ($uri === '/acao-solidarias/update' && $method === 'POST') {
    requireLogin();
    (new WebController())->updateAcaoSolidaria();
}

elseif ($uri === '/acao-solidarias/delete' && $method === 'POST') {
    requireLogin();
    (new WebController())->deleteAcaoSolidaria();
}

elseif ($uri === '/campanhas' && $method === 'GET') {
    requireLogin();
    (new WebController())->campanhas();
}

elseif ($uri === '/logout' && $method === 'POST') {
    (new AuthController())->logoutWeb();
}

elseif ($uri === '/verify-email' && $method === 'GET') {
    (new AuthController())->verifyEmailForm();
}

elseif ($uri === '/verify-email' && $method === 'POST') {
    try {
        (new AuthController())->verifyEmailSubmit();
    } catch (Exception $e) {
        $_SESSION['flash_error'] = $e->getMessage();
        header("Location: /verify-email?token=" . urlencode($_POST['token'] ?? ''));
        exit;
    }
}

else {
    echo "Página não encontrada";
}
