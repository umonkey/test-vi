<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders_products")
 **/
class OrderProduct
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="products")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     **/
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     **/
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(Order $value): self
    {
        $this->order = $value;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $value): self
    {
        $this->product = $value;

        return $this;
    }
}
