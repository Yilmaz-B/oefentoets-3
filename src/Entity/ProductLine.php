<?php

namespace App\Entity;

use App\Repository\ProductLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductLineRepository::class)]
class ProductLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productLines')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productLines')]
    private ?Order $orders = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }
}
