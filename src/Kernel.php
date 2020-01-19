<?php

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Kernel implements HttpKernelInterface
{
    /**
     * @var RouteCollection
     **/
    protected $routes;

    public function __construct()
    {
        $this->routes = $this->loadRoutes();
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $attributes = $matcher->match($request->getPathInfo());

            $_parts = explode('::', $attributes['_controller']);
            if (count($_parts) == 2) {
                $controller = new $_parts[0];
                $response = $controller->{$_parts[1]}($request);
            } else {
                $response = $_parts[0]();
            }
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Resource not found.', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    protected function loadRoutes()
    {
        $fileLocator = new FileLocator([__DIR__ . '/../config']);
        $loader = new PhpFileLoader($fileLocator);
        $routes = $loader->load('routes.php');
        return $routes;
    }
}
