<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderingRepository")
 */
class Ordering
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Prosím zadejte platný email")
     */

    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressStreet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressCity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Range(
     *     min=00000,
     *     max=99999,
     *     minMessage="Zadejte platné PSČ",
     *     maxMessage="Zadejte platné PSČ"
     * )
     */
    private $addressZip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CountryOptions", inversedBy="orderings")
     */
    private $addressCountry;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryOptions", inversedBy="orderings")
     */
    private $delivery;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaymentOptions", inversedBy="orderings")
     */
    private $payment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
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

    public function getAddressStreet(): ?string
    {
        return $this->addressStreet;
    }

    public function setAddressStreet(string $addressStreet): self
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    public function getAddressZip(): ?string
    {
        return $this->addressZip;
    }

    public function setAddressZip(string $addressZip): self
    {
        $this->addressZip = $addressZip;

        return $this;
    }

    public function getAddressCountry(): ?CountryOptions
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(?CountryOptions $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    public function getDelivery(): ?DeliveryOptions
    {
        return $this->delivery;
    }

    public function setDelivery(?DeliveryOptions $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getPayment(): ?PaymentOptions
    {
        return $this->payment;
    }

    public function setPayment(?PaymentOptions $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getOrderedProducts(): ?array
    {
        return $this->products;
    }

    public function setOrderedProducts(?array $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function addProduct($product)
    {
        $this->products[] = $product;
    }
}
