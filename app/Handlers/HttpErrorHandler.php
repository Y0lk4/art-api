<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpException;
use Slim\Handlers\ErrorHandler;


class HttpErrorHandler extends ErrorHandler
{
    protected function logErrorDetails(): void
    {
        $exception = $this->exception;
        $request = $this->request;
    }
    protected function respond(): ResponseInterface
    {
        $statusCode = 400;
        $exception = $this->exception;

        $statusCode = $exception instanceof HttpException ? $exception->getCode() : 500;
        if ($exception instanceof HttpException) {
            $this->logErrorDetails();
            $description = $exception->getDescription();
        }elseif ($exception instanceof \InvalidArgumentException) {
            $statusCode = 400;
            $description = 'Bad Request';
        }else {
            $statusCode = 500;
            $description = 'Internal Server Error';
        }
        $data = [
            'code' => $statusCode,
            'type' => $this->getClassName($exception),
            'message' => $exception->getMessage(),
            'description' => $description
        ];

        return $this->getErrorResponse($data, $statusCode);
    }
    private function getClassName($object)
    {
        $path = explode('\\', get_class($object));
        return array_pop($path);
    }

    private function getErrorResponse($data, $statusCode = 400): ResponseInterface
    {
        $response = $this->responseFactory->createResponse($statusCode)->withHeader('Content-type', 'application/json');

       
        $payload = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
        
        $response->getBody()->write($payload);
        return $response;
    }
}
