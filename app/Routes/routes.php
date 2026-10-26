<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Domain\Services\ExhibitsService;
use App\Controllers\ExhibitController;
use App\Controllers\CultureController;
use App\Helpers\DateTimeHelper;
use App\Controllers\ExhibitObjectController;
use App\Controllers\ArtistController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    //* ROUTE: GET /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);
    $app->get('/exhibits', [ExhibitController::class, 'handleGetExhibits']);
    $app->get('/exhibits/{exhibit_id}', [ExhibitController::class, 'handleGetByExhibitId']);
    $app->get('/exhibits/{location_id}', [ExhibitController::class, 'handleGetByLocationId']);

    $app->get('/exhibits/objects', [ExhibitObjectController::class, 'handleGetExhibitObjects']);
    $app->get('/exhibits/objects/{exhibit_object_id}', [ExhibitObjectController::class, 'handleGetByExhibitObjectId']);
    $app->get('/exhibits/{exhibit_id}/objects', [ExhibitObjectController::class, 'handleGetByExhibitId']);
    

    $app->get('/artists', [ArtistController::class, 'handleGetArtists']);
    $app->get('/artists/{artist_id}', [ArtistController::class, 'handleGetArtistById']);

    //* ROUTE: POST /exhibits
    $app->post('/exhibits', [ExhibitController::class, 'handleCreateExhibit']);

    //* ROUTE: POST /artists
    $app->post('/artists', [ArtistController::class, 'handleCreateArtist']);

    //* NOTE: callback naming pattern: handle<ActionName>, e.g. handleGetPlayers
    //* ROUTE: GET /players
    //$app->get('/players', [PlayersController::class, 'handleGetPlayers']);

    //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });

    // Example route to test error handling.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
    });

    //* ROUTE: GET /phpinfo -> Display PHP configuration (useful for Docker)
    //* Docker URL: http://localhost:8080/phpinfo
    $app->get('/phpinfo', function (Request $request, Response $response, $args) {
        ob_start();
        phpinfo();
        $info = ob_get_clean();
        $response->getBody()->write($info);
        return $response->withHeader('Content-Type', 'text/html');
    });

    //* ROUTE:POST /cultures
    $app->post("/cultures", [CultureController::class, "handleCreateCultures"]);

    //* ROUTE: GET /cultures/{culture_id}/
    $app->get('/cultures', [CultureController::class, 'handleGetCultures']);
    $app->get('/cultures/{culture_id}', [CultureController::class, 'handleGetCultureById']);
    $app->get('/cultures/{culture_id}/anthropology', [CultureController::class, 'handleGetCultureAnthropology']);
    $app->get('/cultures/{culture_id}/timeline', [CultureController::class, 'handleGetCultureTimeline']);


};
