<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = Illuminate\Support\Facades\Route::getRoutes();

$route = $routes->getByName('login');

if (! $route) {
    exit("Route not found\n");
}

var_export($route->gatherMiddleware());