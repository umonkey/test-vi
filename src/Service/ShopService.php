<?php

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;

class ShopService
{
    use ContainerAwareTrait;

    public function __construct(PsrContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function seedProducts(): self
    {
        $em = $this->container->get('EntityManager');

        $products = $em->getRepository(Product::class);
        $products->erase();

        for ($n = 0; $n < 20; $n++) {
            $product = new Product();
            $product->setName(sprintf('Product nr.%04u', rand(1000, 9999)));
            $product->setPrice(rand(1, 10) * 100);

            $em->persist($product);
        }

        $em->flush();

        return $this;
    }

    public function createOrder(array $productIds): Order
    {
        $em = $this->container->get('EntityManager');
        $products = $em->getRepository(Product::class);

        $order = new Order;
        $order->setStatus(Order::STATUS_NEW);

        foreach ($productIds as $id) {
            if (!($product = $products->findOneById($id))) {
                throw new \RuntimeException("product {$id} not found");
            }

            $order->addProduct($product);
        }

        $em->persist($order);

        $em->flush();

        return $order;
    }

    public function setOrderPaid(int $orderId, int $amount): void
    {
        $em = $this->container->get('EntityManager');
        $orders = $em->getRepository(Order::class);

        $em->beginTransaction();

        if (!($order = $orders->findOneById($orderId))) {
            throw new \RuntimeException('order not found');
        }

        if ($order->isPaid()) {
            throw new \RuntimeException('order is paid already');
        }

        $total = $order->getTotal();
        if ($total != $amount) {
            throw new \RuntimeException('order amount mismatch');
        }

        $httpClient = new Client();
        $response = $httpClient->get('http://ya.ru/');

        if ($response->getStatusCode() == 200) {
            $order->setPaid();
            $em->persist($order);
            $em->flush();
            $em->commit();
        } else {
            throw new \RuntimeException('error checking payment');
        }
    }
}
