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
    /**
     * Initializes the controller.
     *
     * @param ArtistModel $artist_model Artist model.
     * @param ArtistService $artist_service Artist service.
     */
    public function __construct(
        private ArtistModel $artist_model,
        private ArtistService $artist_service,
    ) {}

    /**
     * Gets all artists.
     *
     * @param Request $request HTTP request.
     * @param Response $response HTTP response.
     * @return Response JSON response.
     */
    public function handleGetArtists(Request $request, Response $response): Response
    {
        $filters = $request->getQueryParams();
        $artists = $this->artist_model->getArtists($filters);

        return $this->renderJson($response, $artists);
    }

    /**
     * Gets an artist by ID.
     *
     * @param Request $request HTTP request.
     * @param Response $response HTTP response.
     * @param array $args Route parameters.
     * @return Response JSON response.
     */
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

    /**
     * creates a new artist.
     *
     * @param Request $request HTTP request.
     * @param Response $response HTTP response.
     * @return Response JSON response.
     */
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