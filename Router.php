<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function checkRoutes()
    {

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            header('Location: /404');
        }
    }

    public function render($view, $data = [])
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';

        foreach ($data as $key => $value) {
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $content = ob_get_clean(); // Limpia el Buffer

        if(str_contains($currentUrl, '/auth')) {
            include_once __DIR__ . '/views/layouts/auth-layout.php';
        } else if(str_contains($currentUrl, '/admin') ) {
            include_once __DIR__ . '/views/layouts/admin-layout.php';
        } else {
            include_once __DIR__ . '/views/layouts/main-layout.php';
        }

    }

    public function logout(){ 
        session_start();
        setcookie(session_name(), '', 100);
        session_unset();
        session_destroy();
        $_SESSION = [];
    }

}
