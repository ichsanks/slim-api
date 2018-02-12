<?php

$app->group('/invoices', function() {

	$this->get('', 'InvoiceController:getAll');
	$this->get('/{id:[0-9]+}', 'InvoiceController:get');
	$this->post('', 'InvoiceController:post');
	$this->put('/{id:[0-9]+}', 'InvoiceController:put');
	$this->delete('/{id:[0-9]+}', 'InvoiceController:delete');

	$this->get('/{id:[0-9]+}/jobs', 'InvoiceController:getAllInvoiceJobs');
	$this->put('/{id:[0-9]+}/jobs/{nid:[0-9]+}', 'InvoiceController:putInvoiceJob');
	$this->delete('/{id:[0-9]+}/jobs/{nid:[0-9]+}', 'InvoiceController:deleteInvoiceJob');

});

$app->group('/payments', function() {

	$this->get('', 'PaymentController:getAll');
	$this->get('/{id:[0-9]+}', 'PaymentController:get');
	$this->post('', 'PaymentController:post');
	$this->put('/{id:[0-9]+}', 'PaymentController:put');
	$this->delete('/{id:[0-9]+}', 'PaymentController:delete');
	
	$this->get('/{id:[0-9]+}/jobs', 'PaymentController:getPaymentJobs');

});

$app->group('/vendors', function() {

	$this->get('', 'VendorController:getAll');
	$this->get('/{id:[0-9]+}', 'VendorController:get');
	$this->post('', 'VendorController:post');
	$this->put('/{id:[0-9]+}', 'VendorController:put');
	$this->delete('/{id:[0-9]+}', 'VendorController:delete');
	
	$this->get('/{id:[0-9]+}/invoices', 'VendorController:getVendorInvoices');

});

$app->group('/users', function() {

	$this->get('', 'UserController:getAll');
	$this->get('/{id:[0-9]+}', 'UserController:get');
	$this->post('', 'UserController:post');
	$this->put('/{id:[0-9]+}', 'UserController:put');
	$this->delete('/{id:[0-9]+}', 'UserController:delete');

});