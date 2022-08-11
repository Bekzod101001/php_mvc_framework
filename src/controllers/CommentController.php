<?php


namespace app\controllers;

use app\core\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        print_r($request->getBody());
    }

}