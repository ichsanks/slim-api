<?php

$container = $app->getContainer();

$container['db'] = function($container) {
	$capsule = new \Illuminate\Database\Capsule\Manager;
	$capsule->addConnection($container['settings']['db']);
	$capsule->setAsGlobal();
	$capsule->bootEloquent();

	return $capsule;
};

$container['AuthController'] = function($container) {
	$table = $container->get('db');
	return new \App\Controllers\AuthController($table);
};

$container['UserController'] = function($container) {
	$table = $container->get('db');
	return new \App\Controllers\UserController($table);
};

$container['InvoiceController'] = function($container) {
	$table = $container->get('db');
	return new \App\Controllers\InvoiceController($table);
};

$container['JobController'] = function($container) {
	$table = $container->get('db');
	return new \App\Controllers\JobController($table);
};

$container['PaymentController'] = function($container) {
	$table = $container->get('db');
	return new \App\Controllers\PaymentController($table);
};