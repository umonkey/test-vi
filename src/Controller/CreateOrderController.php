<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $productIds = $request->request->get('product');

        $shop = $this->container->get('ShopService');
        $order = $shop->createOrder($productIds);

        return $this->sendJSON([
            'result' => [
                'order_id' => $order->getId(),
                'total' => $order->getTotal(),
            ],
        ]);
    }
}
