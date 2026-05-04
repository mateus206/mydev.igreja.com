<?php
 
class WebController
{
    private function view($viewName)
    {
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

}