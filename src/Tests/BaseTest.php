<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

use App\Kernel;

class BaseTest extends TestCase
{
    protected $kernel;

    protected $container;

    public function setUp(): void
    {
        $this->kernel = new Kernel();
        $this->container = $this->kernel->getContainer();
    }

    protected function request(string $method, string $path, array $options = [])
    {
        $request = Request::create($path, $method);

        $response = $this->kernel->handle($request);

        return $response;
    }
}
