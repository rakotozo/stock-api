<?php

namespace App\Entity;

use App\Repository\ProductSupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ProductSupplierRepository::class)]
#[ORM\Table(name: 'product_supplier')]
#[ORM\UniqueConstraint(
    name: 'unique_product_supplier',
    columns: ['product_id', 'supplier_id']
)]
#[ApiResource(
    normalizationContext: ['groups' => ['product_supplier:read']],
    denormalizationContext: ['groups' => ['product_supplier:write']]
)]
class ProductSupplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product_supplier:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $supplierReference = null;


    #[Groups(['product_supplier:read', 'product_supplier:write'])]
    #[ORM\ManyToOne(inversedBy: 'productSuppliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[Groups(['product_supplier:read', 'product_supplier:write'])]
    #[ORM\ManyToOne(inversedBy: 'productSuppliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supplier $supplier = null;

    #[ORM\Column]
    #[Groups(['product_supplier:read'])]
    private int $quantity = 0;

    #[Groups(['product_supplier:read','product_supplier:write'])]
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $purchasePrice = null;

    #[Groups(['product_supplier:read','product_supplier:write'])]
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $sellingPrice = null;

    #[ORM\Column]
    #[Groups(['product_supplier:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['product_supplier:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, StockMovement>
     */
    #[ORM\OneToMany(targetEntity: StockMovement::class, mappedBy: 'productSupplier')]
    private Collection $stockMovements;


    #[Groups(['product_supplier:read'])]
    public function getMargin(): ?string
    {
        $sellingPrice = $this->product?->getSellingPrice();

        if ($sellingPrice === null || $this->purchasePrice === null) {
            return null;
        }

        return bcsub($sellingPrice, $this->purchasePrice, 2);
    }

    public function __construct()
    {
        $this->stockMovements = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplierReference(): ?string
    {
        return $this->supplierReference;
    }

    public function setSupplierReference(?string $supplierReference): static
    {
        $this->supplierReference = $supplierReference;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, StockMovement>
     */
    public function getStockMovements(): Collection
    {
        return $this->stockMovements;
    }

    public function addStockMovement(StockMovement $stockMovement): static
    {
        if (!$this->stockMovements->contains($stockMovement)) {
            $this->stockMovements->add($stockMovement);
            $stockMovement->setProductSupplier($this);
        }

        return $this;
    }

    public function removeStockMovement(StockMovement $stockMovement): static
    {
        if ($this->stockMovements->removeElement($stockMovement)) {
            // set the owning side to null (unless already changed)
            if ($stockMovement->getProductSupplier() === $this) {
                $stockMovement->setProductSupplier(null);
            }
        }

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

     public function getPurchasePrice(): ?string
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?string $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;
        return $this;
    }
     public function getSellingPrice(): ?string
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(?string $sellingPrice): static
    {
        $this->sellingPrice = $sellingPrice;
        return $this;
    }
}
