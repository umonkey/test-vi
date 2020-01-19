<?php

use App\Tests\BaseTest;
use App\Entity\Order;
use App\Entity\Product;
use App\Exceptions\OrderAlreadyPaid;
use App\Exceptions\OrderNotFound;
use App\Exceptions\BadOrderAmount;

class PayOrderTests extends BaseTest
{
    public function testBadOrder()
    {
        $em = $this->container->get('EntityManager');
        $shop = $this->container->get('ShopService');

        try {
            $shop->setOrderPaid(123456, 1);
            $this->fail('setOrderPaid does not fail on bad id');
        } catch (OrderNotFound $e) {
            // pass
        }

        $product = new Product();
        $product->setName('test product');
        $product->setPrice('100');
        $em->persist($product);
        $em->flush();

        $order = $shop->createOrder([$product->getId()]);

        try {
            $shop->setOrderPaid($order->getId(), 200);
            $this->fail('order amount mismatch not hanled');
        } catch (BadOrderAmount $e) {
            $this->assertTrue(true);
        }

        try {
            $order->setPaid();
            $shop->setOrderPaid($order->getId(), 200);
            $this->fail('order paid twice');
        } catch (OrderAlreadyPaid $e) {
            $this->assertTrue(true);
        }
    }
}
