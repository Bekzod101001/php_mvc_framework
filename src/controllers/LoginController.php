<?php


namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\core\View;
use app\models\Login;

class LoginController extends Controller
{
    public Login $login;
    public function __construct()
    {
        $this->login = new Login();
    }

    public function show()
    {
        return View::view('auth/login', [
            'login' => $this->login
        ]);
    }


    public function handle(Request $request)
    {
        $this->login->loadData($request->getBody());

        if($this->login->validate()){
            $this->login->handle();
            Response::redirect('/auth/me');
            return true;
        }

        return View::view('auth/login', [
            'login' => $this->login
        ]);
    }

}