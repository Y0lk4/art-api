<?php

namespace App\Controllers;


use App\Domain\Models\ArtistModel;
use App\Domain\Services\ArtistService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use App\Helpers\Validator;

class ArtistController extends BaseController 
{
    public function __construct(
        private ArtistModel $artist_model,
        private ArtistService $artist_service,
    ) {}

    public function handleGetArtists(Request $request, Response $response): Response
    {
        $filters = $request->getQueryParams();
        $artists = $this->artist_model->getArtists($filters);

        return $this->renderJson($response, $artists);
    }

    public function handleGetArtistById(Request $request, Response $response, array $args): Response
    {
        $artist_id = $args["artist_id"];

        if (!Validator::isPositiveInt($artist_id)) {
            throw new HttpBadRequestException($request, "Invalid artist ID format.");
        }

        $artist = $this->artist_model->getArtistById($artist_id);
        if(empty($artist) || ($artist === false)) {
            throw new HttpNotFoundException($request, "No artist found for the ID: " . $artist_id);
        }

        return $this->renderJson($response, $artist, 200);
    }

    public function handleCreateArtist(Request $request, Response $response): Response
    {
        $payload = $request->getParsedBody();
        
        $result = $this->artist_service->doCreateArtist($payload);
        if ($result->isFailure()) {
        }

        $data = [
            "code" => 201,
            "message" => "Success"
        ];

        return $this->renderJson($response, $data, 201);
    }
}