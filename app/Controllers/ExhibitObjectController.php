<?php

namespace App\Controllers;

use App\Helpers\Validator;
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

        if (isset($filters['exhibit_id']) && !Validator::isPositiveInt($filters['exhibit_id'])) {
            throw new HttpBadRequestException($request, "exhibit_id must be a positive integer.");
        }

        if (isset($filters['object_id']) && !Validator::isPositiveInt($filters['object_id'])) {
            throw new HttpBadRequestException($request, "object_id must be a positive integer.");
        }

        if (isset($filters['is_featured']) && !Validator::isBoolean($filters['is_featured'])) {
            throw new HttpBadRequestException($request, "is_featured must be a boolean value (true/false, 1/0).");
        }

        if (isset($filters['added_after']) && !Validator::isIsoDate($filters['added_after'])) {
            throw new HttpBadRequestException($request, "added_after must be a valid ISO 8601 date-time.");
        }

        if (isset($filters['page']) && !Validator::isPositiveInt($filters['page'])) {
            throw new HttpBadRequestException($request, "page must be a positive integer.");
        }

        if (isset($filters['page_size']) && !Validator::isPositiveInt($filters['page_size'])) {
            throw new HttpBadRequestException($request, "page_size must be a positive integer.");
        }

        $exhibit_object = $this->exhibit_object_model->getExhibitObjects($filters);

        return $this->renderJson($response, $exhibit_object, 200);
    }   

    public function handleGetByExhibitObjectId(Request $request, Response $response, $args) : Response
    {
        $exhibit_object_id = $args['exhibit_object_id'];

        if (!Validator::isPositiveInt($exhibit_object_id)) {
            throw new HttpBadRequestException(
                $request,
                "The exhibit object ID must be a positive integer."
            );
        }

        $exhibit_object = $this->exhibit_object_model->getExhibitObjectById($exhibit_object_id);
        if (empty($exhibit) || !is_array($exhibit) && $exhibit === false){
            throw new HttpNotFoundException($request, "No exhibit object found for the ID: " . $exhibit_object_id);
        }

        return $this->renderJson($response, $exhibit_object, 200);
    }

    public function handleGetByExhibitId(Request $request, Response $response, $args) : Response
    {
        $filters = $request->getQueryParams();
        $exhibit_id = $args['exhibit_id'];

        if (!Validator::isPositiveInt($exhibit_id)) {
            throw new HttpBadRequestException(
                $request,
                "The exhibit ID must be a positive integer."
            );
        }

        $exhibit_object = $this->exhibit_object_model->getExhibitObjectsByExhibitId($exhibit_id, $filters);
        if (empty($exhibit_object) || ($exhibit_object === false)) {
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
