<?php


namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\core\View;
use app\helpers\Helper;
use app\models\User;

class RegisterController extends Controller
{
    public User $model;
    public function __construct()
    {
        $this->model = new User();

    }
    public function show()
    {
        return View::view('auth/register', [
            'model' => $this->model
        ]);
    }


    public function handle(Request $request)
    {
        $this->model->loadData($request->getBody());

        if($this->model->validate() && $this->model->create()) {
            Application::$app->session->setFlashMessage('successRegister', "HOORAY! {$this->model->name} registered successfully");
            Response::redirect('/');
            exit;
        }

        return View::view('auth/register', [
            'model' => $this->model
        ]);
    }


}