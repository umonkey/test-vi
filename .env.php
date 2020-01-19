<?php
/**
 * Default environment variables.
 * Override in .env.local.php
 **/

return [
    'DB_DRIVER' => 'pdo_sqlite',
    'DB_PATH' => __DIR__ . '/var/data/database.sqlite',
];
