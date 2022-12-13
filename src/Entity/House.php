<?php

namespace App\Entity;

use App\Repository\HouseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HouseRepository::class)]
class House extends Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $garage = null;

    #[ORM\Column(nullable: true)]
    private ?int $pool = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGarage(): ?int
    {
        return $this->garage;
    }

    public function setGarage(?int $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getPool(): ?int
    {
        return $this->pool;
    }

    public function setPool(?int $pool): self
    {
        $this->pool = $pool;

        return $this;
    }
}
