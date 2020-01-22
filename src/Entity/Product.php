<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 **/
class Product
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     **/
    private $name;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     **/
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function getPrice(): ?int
    {
        return (int)$this->price;
    }

    public function setPrice(int $value): self
    {
        $this->price = $value;

        return $this;
    }
}
