<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;

use App\Service\ShopService;
use App\Service\EntityManager;

$container = new ContainerBuilder();

$container->register('EntityManager', EntityManager::class);

$container->register('ShopService', ShopService::class)
          ->addArgument($container);

return $container;
