<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;

$controllers = [
    User::class,
];

$router = new Router();
$router->registerControllers($controllers);
$router->run();