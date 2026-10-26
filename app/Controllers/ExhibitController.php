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

    public function handleGetExhibits(Request $request, Response $response) : Response
    {
        $filters = $request->getQueryParams();

        $exhibits = $this->exhibit_model->getExhibits($filters);

        return $this->renderJson($response, $exhibits, 200);
    }   

    public function handleGetByExhibitId(Request $request, Response $response, $args) : Response
    {
        $exhibit_id = $args['exhibit_id'];

        $pattern = "/^\d{1,9}$/";
        if (preg_match($pattern, $exhibit_id) === 0){

            throw new HttpBadRequestException(
                $request,
                "The exhibit id does not exist"
            );
            }

        $exhibit = $this->exhibit_model->getExhibitById($exhibit_id);
        if (empty($exhibit) || !is_array($exhibit) && $exhibit === false){
            throw new HttpNotFoundException($request, "No exhibit found for the ID: " . $exhibit_id);
        }

        return $this->renderJson($response, $exhibit, 200);
    }

    public function handleGetByLocationId(Request $request, Response $response, $args) : Response
    {
        $filters = $request->getQueryParams();
        $location_id = $args['location_id'];

        $pattern = "/^\d{1,9}$/";
        if (preg_match($pattern, $location_id) === 0){

            throw new HttpBadRequestException(
                $request,
                "The location id does not exist"
            );
            }

        $exhibit = $this->exhibit_model->getExhibitsByLocationId($location_id, $filters);
        if (empty($exhibit) || !is_array($exhibit) && $exhibit === false){
            throw new HttpNotFoundException($request, "No exhibit found withe the location ID: " . $location_id);
        }

        return $this->renderJson($response, $exhibit, 200);
    }

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
