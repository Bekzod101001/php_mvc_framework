<?php


namespace app\controllers;

use app\core\Application;
use app\core\View;
use app\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }
    public function showMe()
    {
        return View::view('auth/me');
    }

    public function logout()
    {
        Application::$app->logout();

        Response::redirect('/');
    }

}