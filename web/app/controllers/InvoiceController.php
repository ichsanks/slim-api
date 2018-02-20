<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Firebase\JWT\JWT;

use \App\Models\Invoices;
use \App\Models\Jobs;

class InvoiceController {

	public function getAll(Request $request, Response $response, $args) {
		$page 		= $request->getParam('page') > 0 ? $request->getParam('page') : 1;
		$per_page 	= $request->getParam('per_page') > 0 ? $request->getParam('per_page') : 10;
		$search		= $request->getParam('search');
		$year		= $request->getParam('year');
		$month		= $request->getParam('month');

		$query = Invoices::all();
		$total = count($query);

		return $response->withJson([
			"status"	=> "Success",
			"data" 		=> $query,
			"meta" 		=> [
				"pagination" => [
					"total"			=> $total,
					"per_page"		=> $per_page,
					"curr_page"		=> $page,
				]
			]
		], 200);
	}

	public function get(Request $request, Response $response, $args) {
		$query = Invoices::where('id', $args['id'])->get();

		return $response->withJson([
			"status"	=> "Success", 
			"data" 		=> $query
		], 200);
	}

	public function post(Request $request, Response $response, $args) {		
		$data = $request->getParsedBody();
		$invoice = new Invoices;
		
		$invoice->doc_number 		= $data['invoice_doc_number'];
		$invoice->doc_date			= $data['invoice_doc_date'];
		$invoice->acc_number		= $data['invoice_acc_number'];
		$invoice->acc_date			= $data['invoice_acc_date'];
		$invoice->date_received		= $data['invoice_date_received'];

		$invoice->save();

		foreach($data['jobs'] as $datajobs) {
			$job = new Jobs;

			$job->doc_number 		= $datajobs['job_doc_number'];
			$job->doc_date			= $datajobs['job_doc_date'];
			$job->contract_number	= $datajobs['job_contract_number'];
			$job->contract_date		= $datajobs['job_contract_date'];
			$job->description		= $datajobs['job_description'];
			$job->costs				= $datajobs['job_costs'];
			$job->is_vat			= $datajobs['job_is_vat'] ?: 0;

			$invoice->jobs()->save($job);
		}

		return $response->withJson([
			"status"	=> "Success", 
			"data" 		=> $data
		], 201);
	}

	public function put(Request $request, Response $response, $args) {		
		$data = $request->getParsedBody();
		$query = Invoices::find($args['id']);

		$query->doc_number 		= $data['doc_number'] ?: $query->doc_number;
		$query->doc_date 		= $data['doc_date'] ?: $query->doc_date;
		$query->acc_number 		= $data['acc_number'] ?: $query->acc_number;
		$query->acc_date 		= $data['acc_date'] ?: $query->acc_date;
		$query->date_received 	= $data['date_received'] ?: $query->date_received;
		
		if($query->save()) {
			return $response->withJson([
				"status"	=> "Success", 
				"message" 	=> "Update success"
			], 204);	
		}

		return $response->withJson([
			"status"	=> "Error", 
			"message" 	=> "Failed to update"
		], 204);
	}

	public function delete(Request $request, Response $response, $args) {		
		$query = Invoices::find($args['id']);
		 
		if($query->delete()) {
			return $response->withJson([
				"status"	=> "Success", 
				"message"	=> "Update success"
			], 204);
		}

		return $response->withJson([
			"status"	=> "Error", 
			"message" 	=> "Failed to delete"
		], 204);
	}

	public function getAllInvoiceJobs(Request $request, Response $response, $args) {
		$page 		= $request->getParam('page') > 0 ? $request->getParam('page') : 1;
		$per_page 	= $request->getParam('per_page') > 0 ? $request->getParam('per_page') : 10;
		$search		= $request->getParam('search');

		$query = Invoices::find($args['id'])->jobs;
		$total = count($query);

		return $response->withJson([
			"status"	=> "Success", 
			"data" 		=> $query, 
			"meta" 		=> [
				"pagination" => [
					"total"			=> $total,
					"per_page"		=> $per_page,
					"curr_page"		=> $page					
				]
			]
		], 200);
	}

	public function putInvoiceJob(Request $request, Response $response, $args) {		
		$data = $request->getParsedBody();

		$query = Invoices::find($args['id'])->jobs;

		$query->doc_number 		= $data['doc_number'] ?: $query->doc_number;
		$query->doc_date 		= $data['doc_date'] ?: $query->doc_date;
		$query->acc_number 		= $data['acc_number'] ?: $query->acc_number;
		$query->acc_date 		= $data['acc_date'] ?: $query->acc_date;
		$query->date_received 	= $data['date_received'] ?: $query->date_received;
		
		if($query->save()) {
			return $response->withJson([
				"status"	=> "Success", 
				"message" 	=> "Update success"
			], 204);	
		}

		return $response->withJson([
			"status"	=> "Error", 
			"message" 	=> "Failed to update"
		], 204);
	}

	public function deleteInvoiceJob(Request $request, Response $response, $args) {
		$query = Invoices::find($args['id'])->jobs;
		 
		if($query->delete()) {
			return $response->withJson([
				"status"	=> "Success", 
				"message"	=> "Delete success"
			], 204);
		}

		return $response->withJson([
			"status"	=> "Error", 
			"message" 	=> "Failed to delete"
		], 204);
	}

}