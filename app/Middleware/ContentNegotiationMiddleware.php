<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Exceptions\HttpUnsupportedMediaTypeException;
use Slim\Exception\HttpBadRequestException;

/**
 * Participant in processing a server request and response.
 *
 * An HTTP middleware component participates in processing an HTTP message:
 * by acting on the request, generating the response, or forwarding the
 * request to a subsequent middleware and possibly acting on its response.
 */
class ContentNegotiationMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        // Optional: Handle the incoming request
        //* ...Before middleware!
        //* 1) Extract the Accept Header from the request object.
        $headerValueArray = $request->getHeader('Accept');

        if(empty($headerValueArray)){
            throw new HttpBadRequestException($request, "Missing Accept header.");
        }
        if ($headerValueArray[0] != 'application/json') {
            throw new HttpUnsupportedMediaTypeException($request, "Content type not accepted " . $headerValueArray[0]);
        }


        //! DO NOT remove or change the following statements.
        // Invoke the next middleware and get response
        $response = $handler->handle($request);

        // Optional: Handle the outgoing response
        //* ...After middleware!

        return $response;
    }
}
