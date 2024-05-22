<?php

namespace Panthir\Domain\Sale\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Panthir\Domain\Common\Model\CountableTrait;
use Panthir\Domain\Product\Model\Category;
use Panthir\Infrastructure\Repository\Sale\SaleRepository;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'sale')]
#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    use CountableTrait;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('NONE')]
    private string $id;

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private string $value;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    #[ManyToOne(targetEntity: Brand::class, inversedBy: "sales")]
    #[JoinColumn(name: "brand_id", referencedColumnName: "id")]
    private Brand $brand;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Sale
     */
    public function setTitle(string $title): Sale
    {
        $this->title = $title;
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
     * @return Sale
     */
    public function setCategory(Category $category): Sale
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return Sale
     */
    public function setBrand(Brand $brand): Sale
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Sale
     */
    public function setValue(string $value): Sale
    {
        $this->value = $value;
        return $this;
    }
}
