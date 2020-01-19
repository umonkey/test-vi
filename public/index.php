<?php

require __DIR__ . '/../config/bootstrap.php';

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

$kernel = new Kernel();

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();
