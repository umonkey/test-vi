<?php

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use App\Service\ShopService;

$container = new ContainerBuilder();

$container->register('EntityManager', 'App\Service\EntityManager');

$container->register('ShopService', ShopService::class)
          ->addArgument($container);

return $container;
