<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    private ?Accomodation $accomodation = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: RoomBed::class, cascade:["persist"])]
    private Collection $roombeds;

    public function __construct()
    {
        $this->roombeds = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAccomodation(): ?Accomodation
    {
        return $this->accomodation;
    }

    public function setAccomodation(?Accomodation $accomodation): self
    {
        $this->accomodation = $accomodation;

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
            $roombed->setRoom($this);
        }

        return $this;
    }

    public function removeRoombed(RoomBed $roombed): self
    {
        if ($this->roombeds->removeElement($roombed)) {
            // set the owning side to null (unless already changed)
            if ($roombed->getRoom() === $this) {
                $roombed->setRoom(null);
            }
        }

        return $this;
    }
}
