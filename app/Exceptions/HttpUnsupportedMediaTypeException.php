<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpUnsupportedMediaTypeException extends HttpSpecializedException
{
    protected $code = 415;
    protected $message = 'Invalid Content-Type';
    protected string $title = '415 Unsupported Media Type';
    protected string $description = 'The requested content-type is not supported.';
}
