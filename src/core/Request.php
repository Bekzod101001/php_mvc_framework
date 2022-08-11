<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $positionOfQueryQuestion = strpos($path, '?');

        if($positionOfQueryQuestion){
            return substr($path, 0, $positionOfQueryQuestion);
        }

        return $path;
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function getBody()
    {
        $body = [];
        $method = $this->getMethod();
        $values = $method === 'GET' ? $_GET : $_POST;
        $inputType = $method === 'GET' ? INPUT_GET : INPUT_POST;

        foreach($values as $key => $value){
            $body[$key] = filter_input($inputType, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

}