<?php

namespace App\Controllers;

use App\Domain\Services\ExhibitsService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ExhibitObjectModel;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use function DI\string;

class ExhibitObjectController extends BaseController
{

    public function __construct(private ExhibitObjectModel $exhibit_object_model, private ExhibitsService $exhibits_service) {}

    public function handleGetExhibitObjects(Request $request, Response $response) : Response
    {
        $filters = $request->getQueryParams();

        $exhibits = $this->exhibit_object_model->getExhibitObjects($filters);

        return $this->renderJson($response, $exhibits, 200);
    }   

    public function handleGetByExhibitObjectId(Request $request, Response $response, $args) : Response
    {
        $exhibit_id = $args['exhibit_object_id'];

        $pattern = "/^\d{1,9}$/";
        if (preg_match($pattern, $exhibit_id) === 0){

            throw new HttpBadRequestException(
                $request,
                "The exhibit object id does not exist"
            );
            }

        $exhibit = $this->exhibit_object_model->getExhibitObjectById($exhibit_id);
        if (empty($exhibit) || !is_array($exhibit) && $exhibit === false){
            throw new HttpNotFoundException($request, "No exhibit object found for the ID: " . $exhibit_id);
        }

        return $this->renderJson($response, $exhibit, 200);
    }

    public function handleGetByExhibitId(Request $request, Response $response, $args) : Response
    {
        $filters = $request->getQueryParams();
        $exhibit_id = $args['exhibit_id'];

        $pattern = "/^\d{1,9}$/";
        if (preg_match($pattern, $exhibit_id) === 0){

            throw new HttpBadRequestException(
                $request,
                "The exhibit id does not exist"
            );
            }

        $exhibit_object = $this->exhibit_object_model->getExhibitObjectsByExhibitId($exhibit_id, $filters);
        if (empty($exhibit) || !is_array($exhibit) && $exhibit === false){
            throw new HttpNotFoundException($request, "No exhibit objects found with the exhibit ID: " . $exhibit_id);
        }

        return $this->renderJson($response, $exhibit_object, 200);
    }

    // public function handleCreateExhibitObject(Request $request, Response $response): Response
    // {
    //     //* Get/retrieve from the body the representation of the collection to be created.
    //     //TODO: Check the null edge case
    //     $payload = $request->getParsedBody();

    //     //* send the new items to service where they handle the validation
    //     $result = $this->exhibits_service->doCreateExhibit($payload);
    //     if ($result->isFailure()) {
    //     }

    //     $data = [
    //         "code" => 201,
    //         "message" => "list of exhibits was bueno"
    //     ];

    //     //TODO: json success response
    //     // dd();
    //     return $this->renderJson($response, $data, 201);
    // }
}
