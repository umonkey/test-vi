<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function erase(): void
    {
        $this->createQueryBuilder('products')
             ->delete()
             ->getQuery()
             ->execute();
    }
}
