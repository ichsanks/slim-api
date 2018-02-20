<?php

return [
	'settings' => [				
		'determineRouteBeforeAppMiddleware' => true,
		'displayErrorDetails' => true,
		'db' => [
			'driver'	=> 'mysql',
			'host'		=> 'mysqldb',
			'database'	=> 'eas',
			'username'	=> 'root',
			'password'	=> 'root',
			'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',	
		],		
	]
];