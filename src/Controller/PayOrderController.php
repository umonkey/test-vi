<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayOrderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $orderId = (int)$request->attributes->get('id');
        $amount = (int)$request->request->get('amount');

        $em = $this->container->get('EntityManager');
        $shop = $this->container->get('ShopService');

        $em->beginTransaction();

        $shop->setOrderPaid($orderId, $amount);

        $em->commit();

        return $this->sendJSON([
            'result' => [
                'success' => true,
            ],
        ]);
    }
}
