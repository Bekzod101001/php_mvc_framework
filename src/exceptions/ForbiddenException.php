<?php

namespace app\exceptions;

class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = "Permission denied for this route/action";
}