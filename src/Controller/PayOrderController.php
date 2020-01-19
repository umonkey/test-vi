<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayOrderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $orderId = $request->attributes->get('id');
        $amount = $request->request->get('amount');

        $shop = $this->container->get('ShopService');
        $shop->setOrderPaid($orderId, $amount);

        return $this->sendJSON([
            'result' => [
                'success' => true,
            ],
        ]);
    }
}
