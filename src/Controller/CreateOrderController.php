<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $em = $this->container->get('EntityManager');
        $em->beginTransaction();

        $productIds = $request->request->get('product') ?? [];

        $shop = $this->container->get('ShopService');
        $order = $shop->createOrder($productIds);

        $em->commit();

        return $this->sendJSON([
            'result' => [
                'order_id' => $order->getId(),
                'total' => $order->getTotal(),
            ],
        ]);
    }
}
