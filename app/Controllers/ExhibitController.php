<?php

namespace App\Controllers;

use App\Domain\Models\ExhibitModel;
use App\Domain\Services\ExhibitsService;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

use Slim\Exception\HttpNotFoundException;
use function DI\string;

class ExhibitController extends BaseController
{

    public function __construct(private ExhibitModel $exhibit_model, private ExhibitsService $exhibits_service) {}
    public function handleCreateExhibit(Request $request, Response $response): Response
    {
        //* Get/retrieve from the body the representation of the collection to be created.
        //TODO: Check the null edge case
        $payload = $request->getParsedBody();

        //* send the new items to service where they handle the validation
        $result = $this->exhibits_service->doCreateExhibit($payload);
        if ($result->isFailure()) {
        }

        $data = [
            "code" => 201,
            "message" => "list of exhibits was bueno"
        ];

        //TODO: json success response
        // dd();
        return $this->renderJson($response, $data, 201);
    }
}
