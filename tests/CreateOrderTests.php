<?php

use App\Tests\BaseTest;
use App\Entity\Order;
use App\Entity\Product;
use App\Exceptions\ProductNotFound;

class CreateOrderTests extends BaseTest
{
    public function testBadProduct()
    {
        $shop = $this->container->get('ShopService');

        try {
            $order = $shop->createOrder([123456]);
            $this->fail('order created with bad product id');
        } catch (ProductNotFound $e) {
            // pass
        }

        try {
            $order = $shop->createOrder(['haha']);
            $this->fail('order created with bad product id');
        } catch (ProductNotFound $e) {
            // pass
        }

        $this->assertTrue(true);
    }

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
