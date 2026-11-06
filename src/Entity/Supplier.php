<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
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

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['supplier:read']]
        ),
        new Get(
            normalizationContext: ['groups' => ['supplier:read']]
        ),
        new Post(
            normalizationContext: ['groups' => ['supplier:read']],
            denormalizationContext: ['groups' => ['supplier:write']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['supplier:read']],
            denormalizationContext: ['groups' => ['supplier:write']]
        ),
    ]
)]
class Supplier
{
    #[Groups(['supplier:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['supplier:read', 'supplier:write'])]
    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[Groups(['supplier:read', 'supplier:write'])]
    #[ORM\Column(length: 200, nullable: true)]
    private ?string $email = null;

    #[Groups(['supplier:read', 'supplier:write'])]
    #[ORM\Column(length: 30, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'supplier', targetEntity: ProductSupplier::class)]
    private Collection $productSuppliers;

    #[Groups(['supplier:read', 'supplier:write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $address = null;

    #[Groups(['supplier:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

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
}
