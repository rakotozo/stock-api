<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Attribute\Groups;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['product:read']]
        ),
        new Get(
            normalizationContext: ['groups' => ['product:read']]
        ),
        new Post(
            normalizationContext: ['groups' => ['product:read']],
            denormalizationContext: ['groups' => ['product:write']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['product:read']],
            denormalizationContext: ['groups' => ['product:write']]
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['category' => 'exact'])]
class Product
{
    #[Groups(['product:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(length: 100)]
    private ?string $reference = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;





    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column]
    private ?int $minStock = null;

    #[Groups(['product:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


    #[Groups(['product:read', 'product:write'])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
    * @var Collection<int, ProductSupplier>
    */
    #[ORM\OneToMany(targetEntity: ProductSupplier::class, mappedBy: 'product')]
    private Collection $productSuppliers;

    public function __construct()
    {
        $this->productSuppliers = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getProductSuppliers(): Collection
    {
        return $this->productSuppliers;
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getMinStock(): ?int
    {
        return $this->minStock;
    }

    public function setMinStock(int $minStock): static
    {
        $this->minStock = $minStock;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    #[Groups(['product:read', 'product_supplier:read'])]
    public function getTotalStock(): int
    {
        $total = 0;
        foreach ($this->productSuppliers as $productSupplier) {
            $total += $productSupplier->getQuantity();
        }

        return $total;
    }

    #[Groups(['product:read', 'product_supplier:read'])]
    public function isLowStock(): bool
    {
        return $this->getTotalStock() <= $this->minStock;
    }
}
