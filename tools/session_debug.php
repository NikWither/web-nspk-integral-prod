<?php
require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(\Illuminate\Http\Request::create('/register', 'GET'));

var_export([
    'headers' => $response->headers->all(),
    'cookies' => array_map(fn(\Symfony\Component\HttpFoundation\Cookie $cookie) => [
        'name' => $cookie->getName(),
        'value' => $cookie->getValue(),
        'domain' => $cookie->getDomain(),
        'path' => $cookie->getPath(),
        'secure' => $cookie->isSecure(),
        'httpOnly' => $cookie->isHttpOnly(),
        'sameSite' => $cookie->getSameSite(),
    ], $response->headers->getCookies()),
    'session_id' => session()->getId(),
]);
