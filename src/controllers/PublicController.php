<?php


namespace app\controllers;

use app\core\Request;
use app\core\View;

class PublicController extends Controller
{

    public function home()
    {
        return View::view('home');
    }

}