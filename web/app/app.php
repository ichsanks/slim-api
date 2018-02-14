<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/handlers/exceptions.php';

$settings = require __DIR__ . '/settings.php';
$container = new \Slim\Container($settings);
$app = new \Slim\App($container);

require __DIR__ . '/dependencies.php';

//require __DIR__ . '/middlewares/jwt.php';

require __DIR__ . '/routes.php';

$app->run();