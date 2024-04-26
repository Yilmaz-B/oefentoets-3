<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    /**
     * @var Collection<int, ProductLine>
     */
    #[ORM\OneToMany(targetEntity: ProductLine::class, mappedBy: 'product')]
    private Collection $productLines;

    public function __construct()
    {
        $this->productLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProductLine>
     */
    public function getProductLines(): Collection
    {
        return $this->productLines;
    }

    public function addProductLine(ProductLine $productLine): static
    {
        if (!$this->productLines->contains($productLine)) {
            $this->productLines->add($productLine);
            $productLine->setProduct($this);
        }

        return $this;
    }

    public function removeProductLine(ProductLine $productLine): static
    {
        if ($this->productLines->removeElement($productLine)) {
            // set the owning side to null (unless already changed)
            if ($productLine->getProduct() === $this) {
                $productLine->setProduct(null);
            }
        }

        return $this;
    }
}
