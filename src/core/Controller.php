<?php


namespace app\controllers;

use app\core\Application;
use app\core\Middleware;

class Controller
{

    public array $middlewares = [];

    public function registerMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }


}