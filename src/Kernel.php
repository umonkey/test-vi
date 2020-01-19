<?php

namespace App;

use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Kernel implements HttpKernelInterface
{
    /**
     * @var RouteCollection
     **/
    protected $routes;

    /**
     * @var PsrContainerInterface
     **/
    protected $container;

    public function __construct()
    {
        $this->routes = $this->loadRoutes();
        $this->container = $this->loadServices();
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $attributes = $matcher->match($request->getPathInfo());

            foreach ($attributes as $k => $v) {
                $request->attributes->set($k, $v);
            }

            $_parts = explode('::', $attributes['_controller']);
            if (count($_parts) == 2) {
                $controller = new $_parts[0];
                $controller->setContainer($this->container);
                $response = $controller->{$_parts[1]}($request);
            } else {
                $response = $_parts[0]();
            }
        } catch (MethodNotAllowedException $e) {
            $response = new Response('Method not allowed.', Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Resource not found.', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $data = [
                'error' => [
                    'class' => get_class($e),
                    'message' => $e->getMessage(),
                ],
            ];

            $response = new Response(json_encode($data), Response::HTTP_INTERNAL_SERVER_ERROR, [
                'Content-Type' => 'application/json',
            ]);
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

    protected function loadServices(): PsrContainerInterface
    {
        return include __DIR__ . '/../config/services.php';
    }

    /**
     * Returns the dependency container.
     *
     * Used in tests.
     *
     * @return PsrContainerInterface Container instance or null.
     **/
    public function getContainer(): ?PsrContainerInterface
    {
        return $this->container;
    }
}
