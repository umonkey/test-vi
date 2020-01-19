<?php

use App\Tests\BaseTest;
use App\Entity\Order;
use App\Entity\Product;

class CreateOrderTests extends BaseTest
{
    public function testCreate()
    {
        $em = $this->container->get('EntityManager');
        $products = $em->getRepository(Product::class);
        $shop = $this->container->get('ShopService');

        $product = new Product();
        $product->setName('Test product');
        $product->setPrice(100);
        $em->persist($product);
        $em->flush();

        $order = $shop->createOrder([$product->getId()]);
        $this->assertEquals(false, empty($order), 'order not created');
        $this->assertEquals(true, (bool)$order->getId(), 'order id not assigned');
        $this->assertEquals($product->getPrice(), $order->getTotal(), 'wrong order total');
    }
}
