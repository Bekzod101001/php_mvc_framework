<?php


namespace app\core;

use app\core\interfaces\MiddlewareInterface;
use app\core\interfaces\MigrationInterface;
use app\helpers\Helper;

abstract class Middleware implements MiddlewareInterface
{
    abstract public function handle();
}