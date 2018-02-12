<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Models\Payments;

class PaymentController {

	public function getAll(Request $request, Response $response, $args) {
		$query = Payments::all();

		return $response->withJson(["status"=>"Success", "data" => $query], 200);
	}

	public function get(Request $request, Response $response, $args) {
		$query = Payments::where('id', $args['id'])->get();

		return $response->withJson(["status"=>"Success", "data" => $query	], 200);
	}

	public function post(Request $request, Response $response, $args) {		
		$data = $request->getParsedBody();
		$payments = new Payments;
		
		$payments->doc_number 		= $data['payment_doc_number'];
		$payments->doc_date 		= $data['payment_doc_date'];
		$payments->acc_number 		= $data['acc_number'];
		$payments->acc_date			= $data['acc_date'];
		$payments->date_received	= $data['date_received'];

		$payments->save();

		foreach($data['jobs'] as $jobs) {
			$jobs = new Jobs;

			$jobs->doc_number			= $data['doc_number'];
			$jobs->doc_date				= $data['doc_date'];

			$payments->jobs()->save($jobs);
		}
		
		return $response->withJson(["status"=>"Success", "data" => $data], 201);
			
	}

	public function put(Request $request, Response $response, $args) {		
		$data = $request->getParsedBody();
		$query = Payments::find($args['id']);

		$query->doc_number = $data['doc_number'] ?: $query->doc_number;
		$query->doc_date = $data['doc_date'] ?: $query->doc_date;
		$query->acc_number = $data['acc_number'] ?: $query->acc_number;
		$query->acc_date = $data['acc_date'] ?: $query->acc_date;
		$query->date_received = $data['date_received'] ?: $query->date_received;
		
		if($query->save()) {
			return $response->withJson(["status"=>"Success", "message" => "Update success"], 204);	
		}
		return $response->withJson(["status"=>"Error", "message" => "Failed to update"], 204);
	}

	public function delete(Request $request, Response $response, $args) {		
		$query = Payments::find($args['id']);
		if($query->delete()) {
			return $response->withJson(["status"=>"Success", "message" => "Update success"], 204);
		}
		return $response->withJson(["status"=>"Error", "message" => "Failed to update"], 204);
	}

	public function getInvoiceJobs(Request $request, Response $response, $args) {
		$query = Payments::find($args['id'])->jobs;
		return $response->withJson(["status"=>"Success", "data" => $query], 200);
	}

}