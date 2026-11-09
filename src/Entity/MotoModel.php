<?php

namespace App\Entity;

use App\Repository\MotoModelRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: MotoModelRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['moto_model:read']],
    denormalizationContext: ['groups' => ['moto_model:write']]
)]
class MotoModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['moto_model:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['moto_model:read', 'moto_model:write'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
