<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;

class ArtifactAcceptMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $accept = trim($request->getHeaderLine('Accept'));
        $quality = $accept === '' ? 1.0 : 0.0;
        $specificity = -1;
        if ($accept !== '') {
            foreach (explode(',', $accept) as $range) {
                $parts = array_map('trim', explode(';', $range));
                $media_type = strtolower(array_shift($parts));
                $range_quality = 1.0;
                foreach ($parts as $part) {
                    if (preg_match('/^q\s*=\s*(.*)$/i', $part, $matches)) {
                        if (!preg_match('/^(0(?:\.[0-9]{0,3})?|1(?:\.0{0,3})?)$/D', $matches[1])) {
                            throw new HttpBadRequestException($request, 'Invalid Accept quality value.');
                        }
                        $range_quality = (float) $matches[1];
                    }
                }
                $range_specificity = match ($media_type) {
                    'application/json' => 2,
                    'application/*' => 1,
                    '*/*' => 0,
                    default => -1
                };
                if ($range_specificity > $specificity) {
                    $specificity = $range_specificity;
                    $quality = $range_quality;
                } elseif ($range_specificity === $specificity && $range_specificity >= 0) {
                    $quality = max($quality, $range_quality);
                }
            }
        }
        if ($quality <= 0) {
            throw new HttpException($request, 'Only application/json responses are available.', 406);
        }

        return $handler->handle($request)->withAddedHeader('Vary', 'Accept');
    }
}
