<?php
/**
 * Doctrine migrations config.
 **/

require __DIR__ . '/bootstrap.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

use App\Kernel;

$kernel = new Kernel();
$em = $kernel->getContainer()->get('EntityManager')->getManager();
return ConsoleRunner::createHelperSet($em);
