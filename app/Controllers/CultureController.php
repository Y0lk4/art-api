<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use App\Domain\Models\CultureModel;
use App\Domain\Services\CulturesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Psr\Container\ContainerInterface;

class CultureController extends BaseController
{
    public function __construct(
        private CultureModel $cultures_model,
        private CulturesService $cultures_service,
        private ContainerInterface $container
    ) {
        $this->container = $container;
    }

    public function handleGetCultures(Request $request, Response $response): Response
    {
        //TODO: Handle Request
        //echo "quack"; exit;
        // 1) Fetch the list of cultures from the DB.
        $filters = $request->getQueryParams();
        $cultures = $this->cultures_model->getCultures($filters);
        //!IMPORTANT: use this function to debug/trace things/inputs.
        // dd();
        return $this->renderJson($response, $cultures);
    }
    public function handleGetCultureById(Request $request, Response $response, array $args): Response
    {
        //!TODO: Handling the alternative path/edge cases: WHAT IF?
        // -1) What if the id was invalid? 400 Bad Request
        // -2) Valid ID: BUT no maching record found in the database -> 404 Not Found
        // -3) Unauthorized 403

        //! Were the inputs recevived as expected?
        //dd($args);
        // 1) Get the culture id from the URI's dynamic segment.
        $culture_id = $args["culture_id"];
        $pattern = "/^\d{1,9}$/";
        if (preg_match($pattern, $culture_id) === 0) {
            echo "Invalid";
            exit;
        }
        echo "Valid";
        // 2) Get the matching culture record from the database.
        $culture = $this->cultures_model->getCultureById($culture_id);
        if (empty($culture) || !is_array($culture) && $culture === false) {
            throw new HttpNotFoundException($request, "No culture found for the ID: " . $culture_id);
        }

        //! What if no record was returned/found? 2nd edge case
        // Option 1): Throw an HTTPSpecializedException

        // Option 2): Prepare a valid HTTP Error Response yourself.

        // 3) Prepare a valid HTTP response: JSON representation
        return $this->renderJson($response, $culture, 200);
    }
    public function handleGetCultureAnthropology(Request $request, Response $response, array $args): Response
    {
        $client = new Client();
        $culture_id = $args["culture_id"];
        $culture = $this->cultures_model->getCultureById($culture_id);
        if (empty($culture) || !is_array($culture) && $culture === false) {
            throw new HttpNotFoundException($request, "No culture found for the ID: " . $culture_id);
        }
        $cultureName = $culture['culture_name'];
        $apiUrl = "https://api.si.edu/openaccess/api/v1.0/search?api_key=DEMO_KEY&q=" . urlencode($cultureName);
        $apiResponse = $client->request('GET',$apiUrl);
        $body = $apiResponse->getBody();
        $apiData = json_decode($body, true);
        $data = [
            'culture'=>$culture,
            'anthropology'=>$apiData
        ];
        return $this->renderJson($response, $data, 200);

    }
    public function handleGetCultureTimeline(Request $request, Response $response, array $args): Response
    {
        $client = new Client();
        $settings = $this->container->get('settings');
        $apiKey = $settings['harvard_api_key'];


        $culture_id = $args["culture_id"];
        $culture = $this->cultures_model->getCultureById($culture_id);
        if (empty($culture) || !is_array($culture) && $culture === false) {
            throw new HttpNotFoundException($request, "No culture found for the ID: " . $culture_id);
        }
        $cultureName = $culture['culture_name'];

        $apiResponse = $client->request('GET','https://api.harvardartmuseums.org/object',[
        'query' => [
            'apikey' => $apiKey,
            'culture' => $cultureName
            ]
        ]);

        $body = $apiResponse->getBody();
        $apiData = json_decode($body, true);
        $data = [
            'culture'=>$culture,
            'timeline'=>$apiData
        ];
        return $this->renderJson($response, $data, 200);

    }
}

