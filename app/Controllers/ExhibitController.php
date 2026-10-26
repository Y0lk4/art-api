<?php

namespace App\Controllers;

use App\Helpers\Validator;
use App\Domain\Services\ExhibitsService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ExhibitModel;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use function DI\string;

class ExhibitController extends BaseController
{

    public function __construct(private ExhibitModel $exhibit_model, private ExhibitsService $exhibits_service) {}

    public function handleGetExhibits(Request $request, Response $response) : Response
    {
        $filters = $request->getQueryParams();


        if (isset($params['visibility']) && !Validator::isInArray($filters['visibility'], ['public', 'private'])) {
            throw new HttpBadRequestException($request, "Invalid visibility filter. Allowed: public, private.");
        }

        if (isset($params['location_id']) && !Validator::isPositiveInt($filters['location_id'])) {
            throw new HttpBadRequestException($request, "location_id must be a positive integer.");
        }

        if (isset($params['views_min']) && !Validator::isPositiveInt($filters['views_min'])) {
            throw new HttpBadRequestException($request, "views_min must be a positive integer.");
        }

        if (isset($params['views_max']) && !Validator::isPositiveInt($filters['views_max'])) {
            throw new HttpBadRequestException($request, "views_max must be a positive integer.");
        }

        if (isset($params['created_after']) && !Validator::isIsoDate($filters['created_after'])) {
            throw new HttpBadRequestException($request, "created_after must be a valid ISO 8601 date-time.");
        }

        if (isset($params['page']) && !Validator::isPositiveInt($filters['page'])) {
            throw new HttpBadRequestException($request, "page must be a positive integer.");
        }

        if (isset($params['page_size']) && !Validator::isPositiveInt($filters['page_size'])) {
            throw new HttpBadRequestException($request, "page_size must be a positive integer.");
        } 
        
        $exhibits = $this->exhibit_model->getExhibits($filters);

        return $this->renderJson($response, $exhibits, 200);
    }   

    public function handleGetByExhibitId(Request $request, Response $response, $args) : Response
    {
        $exhibit_id = $args['exhibit_id'];

        if (!Validator::isPositiveInt($exhibit_id)) {
            throw new HttpBadRequestException(
                $request,
                "The exhibit ID must be a positive integer."
            );
        }

        $exhibit = $this->exhibit_model->getExhibitById($exhibit_id);
        if (empty($exhibit) || ($exhibit === false)) {
            throw new HttpNotFoundException($request, "No exhibit found for the ID: " . $exhibit_id);
        }

        return $this->renderJson($response, $exhibit, 200);
    }

    public function handleGetByLocationId(Request $request, Response $response, $args) : Response
    {
        $filters = $request->getQueryParams();
        $location_id = $args['location_id'];

        if (!Validator::isPositiveInt($location_id)) {
            throw new HttpBadRequestException(
                $request,
                "The location ID must be a positive integer."
            );
        }

        $exhibit = $this->exhibit_model->getExhibitsByLocationId($location_id, $filters);
        if (empty($exhibits) || ($exhibits === false)) {
            throw new HttpNotFoundException($request, "No exhibit found with the location ID: " . $location_id);
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
