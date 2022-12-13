<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $size = null;

    #[ORM\OneToMany(mappedBy: 'bed', targetEntity: RoomBed::class)]
    private Collection $roombeds;

    public function __construct()
    {
        $this->roombeds = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, RoomBed>
     */
    public function getRoombeds(): Collection
    {
        return $this->roombeds;
    }

    public function addRoombed(RoomBed $roombed): self
    {
        if (!$this->roombeds->contains($roombed)) {
            $this->roombeds->add($roombed);
            $roombed->setBed($this);
        }

        return $this;
    }

    public function removeRoombed(RoomBed $roombed): self
    {
        if ($this->roombeds->removeElement($roombed)) {
            // set the owning side to null (unless already changed)
            if ($roombed->getBed() === $this) {
                $roombed->setBed(null);
            }
        }

        return $this;
    }
}
