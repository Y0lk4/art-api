<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AboutController extends BaseController
{
    private const API_NAME = 'art-api';

    private const API_VERSION = '1.0.0';

    public function handleAboutWebService(Request $request, Response $response): Response
    {

        $data = array(
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'about' => 'API that displays arts and artifacts with their different cultures, exhibits and artists that it belongs to',
            'authors' => 'Jonathan, Renz, Adyen, Fahad',
            'resources' => '/exhibits, /artists, /cultures, /artifacts'
        );

        return $this->renderJson($response, $data);
    }
}
