<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeedController extends AbstractController
{
    public function index(Request $request): Response
    {
        $em = $this->container->get('EntityManager');
        $shop = $this->container->get('ShopService');

        $em->beginTransaction();

        $shop->seedProducts();

        $em->commit();

        return $this->sendJSON([
            'result' => [
                'success' => true,
            ],
        ]);
    }
}
