<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryOptionsRepository")
 */
class DeliveryOptions
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
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ordering", mappedBy="delivery")
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            $ordering->setDelivery($this);
        }

        return $this;
    }

    public function removeOrdering(Ordering $ordering): self
    {
        if ($this->orderings->contains($ordering)) {
            $this->orderings->removeElement($ordering);
            // set the owning side to null (unless already changed)
            if ($ordering->getDelivery() === $this) {
                $ordering->setDelivery(null);
            }
        }

        return $this;
    }
}
