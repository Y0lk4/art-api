<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Services\ArtifactsService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class ArtController extends BaseController
{
    public function __construct(private ArtifactsService $artifacts_service) {}

    public function handleGetArtifacts(Request $request, Response $response): Response
    {
        try {
            $artifacts = $this->artifacts_service->getArtifacts($request->getQueryParams());
        } catch (\InvalidArgumentException $exception) {
            throw new HttpBadRequestException($request, $exception->getMessage(), $exception);
        }

        return $this->renderJson($response, $artifacts);
    }

    public function handleGetArtifactById(Request $request, Response $response, array $args): Response
    {
        try {
            $artifact = $this->artifacts_service->getArtifactById($args['artifact_id'], $request->getQueryParams());
        } catch (\InvalidArgumentException $exception) {
            throw new HttpBadRequestException($request, $exception->getMessage(), $exception);
        }

        if ($artifact === false) {
            throw new HttpNotFoundException($request, 'Artifact not found.');
        }

        return $this->renderJson($response, $artifact);
    }

    public function handleCreateArt(Request $request, Response $response): Response
    {
        //TODO: prepare AND return a JSON success response.
        return $this->renderJson($response, [
            'code' => 500,
            'message' => 'Artifact creation is not implemented.'
        ], 500);
    }
}
