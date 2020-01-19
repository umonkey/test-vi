<?php

require __DIR__ . '/../vendor/autoload.php';

$_ENV['APP_ENV'] = getenv('APP_ENV') ?: 'dev';
$_ENV['APP_DEBUG'] = $_ENV['APP_ENV'] == 'dev';

if ($_ENV['APP_ENV'] == 'dev') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

$envFiles = [
    __DIR__ . '/../.env.php',
    __DIR__ . '/../.env.' . $_ENV['APP_ENV'] . '.php',
    __DIR__ . '/../.env.local.php',
];

foreach ($envFiles as $fn) {
    if (is_readable($fn)) {
        if (is_array($vars = include $fn)) {
            $_ENV = array_replace($_ENV, $vars);
        }
    }
}
