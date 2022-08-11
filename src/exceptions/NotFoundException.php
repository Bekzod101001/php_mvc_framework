<?php

namespace app\exceptions;

class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = "404 - Not found";
}