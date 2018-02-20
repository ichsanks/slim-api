<?php

use App\Middlewares\JwtAuthentication;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Firebase\JWT\JWT;

$app->add(function(Request $request, Response $response, $next) {
    $jwt = $request->getHeaders();

    $key ='supersecret';
    $auth = $jwt['HTTP_AUTHORIZATION'][0];

    $pass = "auth";
    $uri = $request->getUri()->getPath();
    $path = explode('/', $uri);    
    
    if(!in_array($pass, $path)) {
        if(!empty($auth) && preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
            $token = $matches[1];
        } else {
            return $response->withJson([
                "status"    => "Error",
                "message"   => "Unauthorized"
            ], 401);
        }

        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
        } catch (UnexpectedValueException $e) {
            return $response->withJson([
                "status"    => "Error",
                "message"   => $e->getMessage()
            ], 401); 
        }
    }

    $response = $next($request, $response);

    return $response;
});