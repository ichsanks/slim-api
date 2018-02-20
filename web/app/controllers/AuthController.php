<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Firebase\JWT\JWT;

use \App\Models\Users;

class AuthController {

	public function Login(Request $request, Response $response, $args) {
		$data = $request->getParsedBody();

		$query = Users::where([
			'username' => $data['username'],
			'password' => $data['password']
		])->first();		

        if(count($query) == 1) {
			$key = "supersecret";
            $payload = array(
                "iat"     => time(),
                "exp"     => time() + (3600 * 24 * 15),
                "context" => [
                    "user" => [
                        "user_login" => $query->username,
                        "user_id"    => $query->id
                    ]
                ]
			);
			
            try {
                $jwt = JWT::encode($payload, $key);
            } catch (Exception $e) {
                echo json_encode($e);
			}
			
            return $response->withJson([
                "status"	=> "Success", 
                "data" 		=> $jwt
            ], 200);
		} else {
			return $response->withJson([
				"status"	=> "Error",
				"message"	=> "Wrong username or password"
			], 200);
		}
	}

}