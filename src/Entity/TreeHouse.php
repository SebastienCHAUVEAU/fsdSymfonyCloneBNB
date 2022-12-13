<?php

namespace App\Entity;

use App\Repository\TreeHouseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreeHouseRepository::class)]
class TreeHouse extends Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $treeHeight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTreeHeight(): ?int
    {
        return $this->treeHeight;
    }

    public function setTreeHeight(?int $treeHeight): self
    {
        $this->treeHeight = $treeHeight;

        return $this;
    }
}
