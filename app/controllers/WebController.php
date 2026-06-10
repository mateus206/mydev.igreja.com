<?php

class WebController
{
    private function view($viewName, $data = [])
    {
        extract($data, EXTR_SKIP);
        require_once __DIR__ . "/../../public/views/{$viewName}.php";
    }
    public function index()
    {
        $this->view('home');
    }

    public function login()
    {
        $this->view('login');
    }

    public function dashboard()
    {
        $userCount = (new UserDAO())->getUsersCount();
        $eventCount = (new UserDAO())->getEventCount();
        $apoioSocialCount = (new UserDAO())->getApoioSocialCount();
        $pedidosOracaoCount = (new UserDAO())->getPedidosOracaoCount();
        $this->view('dashboard', ['userCount' => $userCount, 'eventCount' => $eventCount, 'apoioSocialCount' => $apoioSocialCount, 'pedidosOracaoCount' => $pedidosOracaoCount]);
    }

    public function users()
    {
        $users = (new UserDAO())->getUsers();
        $this->view('users', ['users' => $users]);
    }

    public function campanhas()
    {
        $this->view('campanhas');
    }

    public function verifyEmail(string $token): void
    {
        $this->view("verify-email", ["token" => $token]);
    }


}