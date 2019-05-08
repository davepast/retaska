<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryOptionsRepository")
 */
class CountryOptions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ordering", mappedBy="addressCountry")
     */
    private $orderings;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->orderings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Ordering[]
     */
    public function getOrderings(): Collection
    {
        return $this->orderings;
    }

    public function addOrdering(Ordering $ordering): self
    {
        if (!$this->orderings->contains($ordering)) {
            $this->orderings[] = $ordering;
            $ordering->setAddressCountry($this);
        }

        return $this;
    }

    public function removeOrdering(Ordering $ordering): self
    {
        if ($this->orderings->contains($ordering)) {
            $this->orderings->removeElement($ordering);
            // set the owning side to null (unless already changed)
            if ($ordering->getAddressCountry() === $this) {
                $ordering->setAddressCountry(null);
            }
        }

        return $this;
    }
}
