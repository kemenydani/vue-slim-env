<?php

error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

require '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use models\User as User;

//var_dump($user);

$app = new \Slim\App;

$app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
    return $response;
});

$app->get('/', function (Request $request, Response $response) {
    //$response->getBody()->write("Home");
    //return $response;
    echo file_get_contents("./dist-admin/index.html");
    return $response;
});

$app->group('/api/', function () {

    // Get All Customers
    $this->get('users', function(Request $request, Response $response){

        try{

            $users = User::allJSON();

            echo $users;
            return $response->withHeader('Access-Control-Allow-Origin', '*');

        } catch(PDOException $e){
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    });

})->add(function (Request $request, Response $response, $next) {

    $response = $next($request, $response);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

})->add(function (Request $request, Response $response, $next) {

    $authorized = true;

    //$token = $request->getHeader('Authorization');
    //var_dump($token);

    if ($authorized) {
        // authorized, call next middleware
        return $next($request, $response);
    }

    // not authorized, don't call next middleware and return our own response
    $response->getBody()->write("Unauthorized");

    return $response
        ->withStatus(403);
});

$app->run();