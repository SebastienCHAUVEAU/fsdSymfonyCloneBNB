<?php

namespace App\Entity;

use App\Entity\Boat;
use App\Entity\Room;
use App\Entity\House;
use App\Entity\Apartment;

use App\Entity\TreeHouse;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccomodationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;


//choix entre JOINED ou SINGLE_TABLE
#[ORM\InheritanceType("JOINED")] 
//nom de la colonne créée pour les liaisons entre Mère et Fille
#[ORM\DiscriminatorColumn(name:"placeType", type:"string")]
//quelles classes Filles sont acceptées ?
#[ORM\DiscriminatorMap(["treeHouse" => TreeHouse::class, "house" => House::class, "apartment" => Apartment::class, "boat" => Boat::class])]
#[ORM\Entity(repositoryClass: AccomodationRepository::class)]
class Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;


    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $city = null;

    #[ORM\Column(nullable: true)]
    protected ?int $price = null;

    #[ORM\Column(nullable: true)]
    protected ?int $area = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'accomodations')]
    protected ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'accomodation', targetEntity: Room::class)]
    protected Collection $rooms;

    #[ORM\OneToMany(mappedBy: 'accomodation', targetEntity: Booking::class)]
    private Collection $booking_acc;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->booking_acc = new ArrayCollection();
    }

    public function __toString()
    {
        return $this-> address;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(?int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setAccomodation($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getAccomodation() === $this) {
                $room->setAccomodation(null);
            }
        }

        return $this;
    }

    public function getPeopleMax() {
        $roomsLoop = $this->getRooms();
        $maxPeople = 0;

        foreach($roomsLoop as $room){
            foreach($room->getRoombeds() as $roombed){
                $qty = $roombed->getQuantity();
                $bed = $roombed->getBed();
                $size = $bed->getSize();
                $multiplication = (int)$size * (int)$qty;

               //echo("$qty x $size =  $multiplication");
                $maxPeople += $multiplication;
                //echo("TOTAL $maxPeople espace");
               
                // for($i=1 ; $i <= $roombed->getQuantity() ; $i++){
                //     $maxPeople += (int)$roombed->getBed()->getSize();
                // }
            }
        }
        return $maxPeople;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookingAcc(): Collection
    {
        return $this->booking_acc;
    }

    public function addBookingAcc(Booking $bookingAcc): self
    {
        if (!$this->booking_acc->contains($bookingAcc)) {
            $this->booking_acc->add($bookingAcc);
            $bookingAcc->setAccomodation($this);
        }

        return $this;
    }

    public function removeBookingAcc(Booking $bookingAcc): self
    {
        if ($this->booking_acc->removeElement($bookingAcc)) {
            // set the owning side to null (unless already changed)
            if ($bookingAcc->getAccomodation() === $this) {
                $bookingAcc->setAccomodation(null);
            }
        }

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
