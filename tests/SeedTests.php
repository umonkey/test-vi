<?php

use App\Tests\BaseTest;
use App\Entity\Product;

class SeedTests extends BaseTest
{
    public function testSeeding()
    {
        $em = $this->container->get('EntityManager');
        $products = $em->getRepository(Product::class);

        $products->erase();

        $shop = $this->container->get('ShopService');
        $shop->seedProducts();

        $count = $products->count([]);
        $this->assertEquals(20, $count, 'Product seeding is broken.');
    }
}
