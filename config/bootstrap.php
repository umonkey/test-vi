<?php

require __DIR__ . '/../vendor/autoload.php';

$env = getenv('APP_ENV');

$_ENV['APP_ENV'] = $env == 'prod' ? 'prod' : 'dev';
$_ENV['APP_DEBUG'] = $_ENV['APP_ENV'] == 'dev';

if ($_ENV['APP_ENV'] == 'dev') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
