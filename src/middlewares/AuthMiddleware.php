<?php

namespace app\middlewares;

use app\core\Application;
use app\exceptions\ForbiddenException;
use app\core\Middleware;

class AuthMiddleware extends Middleware
{

    public array $actions;

    public function __construct(array $actions = [])
    {
        return $this->actions = $actions;
    }


    /**
     * @throws ForbiddenException
     */
    public function handle()
    {
        if(Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->router->currentControllerAction, $this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}