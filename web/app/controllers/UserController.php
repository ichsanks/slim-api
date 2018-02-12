<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Models\Users;

class UserController {

	public function getAll(Request $request, Response $response, $args) {
		$query = Users::all();

		$result = $query->toArray();

		return $response->withJson(["status"=>"Success", "data" => $result], 200);
	}

	public function get(Request $request, Response $response, $args) {
		$query = Users::where('id', $args['id'])->get();		

		$result = $query->toArray();		

		return $response->withJson(["status"=>"Success", "data" => $result], 200);
	}

	public function getUserReviews(Request $request, Response $response, $args) {
		return 'User Controller:getReviews';
	}

}