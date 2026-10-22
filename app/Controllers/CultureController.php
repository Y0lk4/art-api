<?php

namespace App\Controllers;

use App\Domain\Models\CultureModel;
use App\Domain\Services\CulturesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class CultureController extends BaseController
{
    public function __construct(
        private CultureModel $cultures_model,
        private CulturesService $cultures_service
    ) {}

    /* public function handlePostCultures(Request $request, Response $response): Response
    {
        1)Get/retrieve the representation of the collection to be created
        from the request body.
        TODO: Check the NULL edge case, check if its valid JSON
        $payload = $request->getParsedBody();
        //dd($payload);
        2)Pass the new items to be created to the service so that they can be validated and inserted into the DB.
        $result = $this->cultures_service->doCreateCultures($payload);
        if($result->isFailure()){}
        TODO: Preapre and return a JSON Success response.

        echo"bo";
        return $response;
    }


    public function handleCreateCultures(Request $request, Response $response, array $args): Response
    {
        //!TODO: Handling the alternative path/edge cases: WHAT IF?
        // -1) What if the id was invalid? 400 Bad Request
        // -2) Valid ID: BUT no maching record found in the database -> 404 Not Found
        // -3) Unauthorized 403

        //! Were the inputs recevived as expected?
        //dd($args);
        // 1) Get the keyboard id from the URI's dynamic segment.
        $keyboard_id = $args["keyboard_id"];
        $pattern = "/^\d{1,9}$/";
        if (preg_match($pattern, $keyboard_id) === 0) {
            echo "Invalid";
            exit;
        }
        echo "Valid";
        // 2) Get the matching keyboard record from the database.
        $keyboard = $this->keyboards_model->getKeyboardById($keyboard_id);
        if (empty($keyboard) || !is_array($keyboard) && $keyboard === false) {
            throw new HttpNotFoundException($request, "No keyboard found for the ID: " . $keyboard_id);
        }

        //! What if no record was returned/found? 2nd edge case
        // Option 1): Throw an HTTPSpecializedException

        // Option 2): Prepare a valid HTTP Error Response yourself.

        //dd($keyboard);
        // 3) Prepare a valid HTTP response: JSON representation
        return $this->renderJson($response, $keyboard, 200);
    }
    public function handleGetKeyboardCases(Request $request, Response $response, array $args): Response
    {
        $keyboardId = (int) $args['keyboard_id'];

        $cases = $this->keyboards_model->getCasesByKeyboardId($keyboardId);

        return $this->renderJson($response, $cases, 200);
    }
*/
}
