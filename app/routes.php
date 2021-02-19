<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    // Add this handler for PHP-CRUD-API:
    $app->any('/api[/{params:.*}]', function (Request $request, Response $response, array $args) {
        $api = new Tqdev\PhpCrudApi\Api(new Tqdev\PhpCrudApi\Config([
            'address' => 'sdm688990573.my3w.com',
            'username' => 'sdm688990573',
            'password' => 'asAS12!@',
            'database' => 'sdm688990573_db',
            'basePath' => '/api',
        ]));
        $response = $api->handle($request);
        return $response;
    });

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
