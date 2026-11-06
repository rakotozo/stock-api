<?php

namespace App\Entity;

use App\Enum\MovementType;
use App\Repository\StockMovementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: StockMovementRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['movement:read']]
        ),
        new Get(
            normalizationContext: ['groups' => ['movement:read']]
        ),
        new Post(
            normalizationContext: ['groups' => ['movement:read']],
            denormalizationContext: ['groups' => ['movement:write']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['movement:read']],
            denormalizationContext: ['groups' => ['movement:write']]
        ),
    ]
)]
class StockMovement
{
    #[Groups(['movement:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['movement:read', 'movement:write'])]
    #[ORM\Column]
    private ?int $quantity = null;

    #[Groups(['movement:read', 'movement:write'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2, nullable: true)]
    private ?string $unitPrice = null;

    #[Groups(['movement:read', 'movement:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reason = null;

    #[Groups(['movement:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['movement:read', 'movement:write'])]
    #[ORM\ManyToOne(inversedBy: 'stockMovements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductSupplier $productSupplier = null;

    #[Groups(['movement:read', 'movement:write'])]
    #[ORM\Column(type: 'string', enumType: MovementType::class, length: 20)]
    private ?MovementType $type = null;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getType(): ?MovementType
    {
        return $this->type;
    }

    public function setType(MovementType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?string $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

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

    public function getProductSupplier(): ?ProductSupplier
    {
        return $this->productSupplier;
    }

    public function setProductSupplier(?ProductSupplier $productSupplier): static
    {
        $this->productSupplier = $productSupplier;

        return $this;
    }

}
