<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

use App\Controller\SeedController;

return function (RoutingConfigurator $routes) {
    $routes->add('seed', '/api/v1/seed')
           ->controller('App\Controller\SeedController::index')
           ->methods(['POST']);

    $routes->add('create_order', '/api/v1/orders/create')
           ->controller('App\Controller\CreateOrderController::index')
           ->methods(['POST']);

    $routes->add('pay_order', '/api/v1/orders/{id<\d+>}/pay')
           ->controller('App\Controller\PayOrderController::index')
           ->methods(['POST']);
};
