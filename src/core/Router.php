<?php

namespace app\core;

use app\controllers\Controller;
use app\exceptions\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;

    public $currentController;
    public string $currentControllerAction = '';


    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->extractRoutesByMethod('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->extractRoutesByMethod('POST', $path, $callback);
    }

    public function extractRoutesByMethod(string $method, string $path, $callback)
    {
        $this->routes[$method][$path] = $callback;
    }

    public function resolve()
    {
        $callback = $this->routes[$this->request->getMethod()][$this->request->getPath()] ?? false;

        if(!$callback)
        {
            throw new NotFoundException();
        }

        if(is_string($callback))
        {
            return View::view($callback);
        }

        if(is_array($callback))
        {
            /** @var Controller $controller */
            $controller = new $callback[0]();

            foreach($controller->middlewares as $middleware){
                $middleware->handle();
            }

            $callback[0] = $controller;
            $this->currentController = $callback[0];
            $this->currentControllerAction = $callback[1];

            return $controller->{$callback[1]}($this->request);
        }
    }




}