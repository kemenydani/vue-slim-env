<?php

session_start();

error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

require '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use models\User as User;
use core\Auth as Auth;
//var_dump($user);

$app = new \Slim\App;

$app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
    return $response;
});

$app->post('/auth', function (Request $request, Response $response) {

    $password = $request->getParsedBody()['password'];
    $username = $request->getParsedBody()['username'];
    $remember = $request->getParsedBody()['remember'];

    $remember = isset($remember) ? true : false;

    $User = User::find($username, 'username');

    if($User){
        $user
    }

    User::login($username, $password, $remember);

    return $response->withRedirect('/');
});

$app->get('/logout', function (Request $request, Response $response) {

    $user = Auth::user();
    $user->logout();

    return $response->withRedirect('/');
});

$app->get('/', function (Request $request, Response $response) {

    if(Auth::user()){
        echo 'logged' . Auth::user()->getUsername();
    } else {
        echo 'not logged';
    };

    echo file_get_contents("index.html");
});

$app->get('/admin/', function (Request $request, Response $response) {
    //$response->getBody()->write("Home");
    //return $response;

    $contents =  file_get_contents("./admin-spa/index.html");

    //$contents =  file_get_contents("./admin-spa/index.html");

    echo str_replace("<base href=\"/\" />", "<base href=\"./public/admin-spa/\" />", $contents);

    echo $contents;

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