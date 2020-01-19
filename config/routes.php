<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

use App\Controller\SeedController;

return function (RoutingConfigurator $routes) {
    $routes->add('seed', '/api/v1/seed')
           ->controller('App\Controller\SeedController::index');

    $routes->add('create_order', '/api/v1/orders/create')
           ->controller('App\Controller\CreateOrderController::index');

    $routes->add('pay', '/api/v1/orders/pay')
           ->controller('App\Controller\PayOrderController::index');
};
