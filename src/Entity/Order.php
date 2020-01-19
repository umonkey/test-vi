<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 **/
class Order
{
    const STATUS_NEW = 0,
          STATUS_PAID = 1;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     **/
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="OrderProduct", mappedBy="order", cascade={"persist"})
     **/
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $value): self
    {
        $this->status = $value;

        return $this;
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->getProduct()->getPrice();
        }

        return $total;
    }

    public function addProduct(Product $product): self
    {
        $link = new OrderProduct();
        $link->setOrder($this);
        $link->setProduct($product);

        $this->products->add($link);

        return $this;
    }

    public function getProducts(): PersistentCollection
    {
        return $this->products;
    }

    public function isPaid(): bool
    {
        return $this->status == self::STATUS_PAID;
    }

    public function setPaid(): self
    {
        $this->status = self::STATUS_PAID;

        return $this;
    }
}
