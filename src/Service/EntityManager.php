<?php

namespace App\Service;

use Doctrine\ORM\EntityManager as DEM;
use Doctrine\ORM\Tools\Setup;

class EntityManager
{
    private $entityManager;

    public function __construct()
    {
        $isDevMode = $_ENV['APP_ENV'] == 'dev';

        $config = Setup::createAnnotationMetadataConfiguration([
            __DIR__ . '/../Entity',
        ], $isDevMode, null, null, false);

        $config->setProxyDir(__DIR__ . '/../../var/cache');

        $conn = [
            'driver' => $_ENV['DB_DRIVER'],
            'path' => $_ENV['DB_PATH'] ?? null,
            'host' => $_ENV['DB_HOST'] ?? null,
            'user' => $_ENV['DB_USER'] ?? null,
            'passwowrd' => $_ENV['DB_PASSWORD'] ?? null,
            'dbname' => $_ENV['DB_NAME'] ?? null,
            'charset' => $_ENV['DB_CHARSET'] ?? 'UTF-8',
        ];

        $this->entityManager = DEM::create($conn, $config);
    }

    public function __call($method, array $args)
    {
        return call_user_func_array([$this->entityManager, $method], $args);
    }

    public function getManager()
    {
        return $this->entityManager;
    }
}
