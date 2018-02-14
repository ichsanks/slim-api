<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Firebase\JWT\JWT;

$app->add(function($request, $response, $next) {
    $jwt = $request->getHeaders();

    $key ='supersecret';

    try {
        $decoded = JWT::decode($jwt['HTTP_AUTHORIZATION'][0], $key, array('HS256'));
    } catch (UnexpectedValueException $e) {
        echo $e->getMessage();
    }

    $response = $next($request, $response);

    if(isset($decoded)) {
        return $response;
    }

    return $response;
});