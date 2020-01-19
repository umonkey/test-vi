<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeedController extends AbstractController
{
    public function index(Request $request): Response
    {
        $em = $this->container->get('EntityManager');
        $em->beginTransaction();

        $shop = $this->container->get('ShopService');
        $shop->seedProducts();

        $em->commit();

        return new Response('OK', Response::HTTP_OK, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
