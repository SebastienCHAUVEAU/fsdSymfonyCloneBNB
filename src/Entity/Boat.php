<?php

namespace App\Entity;

use App\Repository\BoatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
class Boat extends Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $roofHeight = null;

    #[ORM\Column(nullable: true)]
    private ?int $motor = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isMoving = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoofHeight(): ?int
    {
        return $this->roofHeight;
    }

    public function setRoofHeight(?int $roofHeight): self
    {
        $this->roofHeight = $roofHeight;

        return $this;
    }

    public function getMotor(): ?int
    {
        return $this->motor;
    }

    public function setMotor(?int $motor): self
    {
        $this->motor = $motor;

        return $this;
    }

    public function isIsMoving(): ?bool
    {
        return $this->isMoving;
    }

    public function setIsMoving(?bool $isMoving): self
    {
        $this->isMoving = $isMoving;

        return $this;
    }
}
