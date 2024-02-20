<?php

namespace Panthir\Domain\Product\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Panthir\Domain\Common\Model\CountableTrait;
use Panthir\Infrastructure\Repository\Product\ProductRepository;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'product')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    use CountableTrait;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    #[Groups(['product'])]
    private string $id;

    #[ORM\Column]
    #[Groups(['product'])]
    private string $name;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    #[Groups(['product'])]
    private Category $category;

    #[ORM\Column]
    #[Groups(['product'])]
    private string $brand;

    #[ORM\Column]
    #[Groups(['product'])]
    private float $value;

    public function __construct(
        protected UuidInterface $uuid
    )
    {
        $this->id = $uuid->__toString();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Product
     */
    public function setCategory(Category $category): Product
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return Product
     */
    public function setBrand(string $brand): Product
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Product
     */
    public function setValue(float $value): Product
    {
        $this->value = $value;
        return $this;
    }
}
