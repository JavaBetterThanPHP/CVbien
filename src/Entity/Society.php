<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocietyRepository")
 */
class Society
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="societies")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSociety", mappedBy="society")
     */
    private $userSocieties;

    public function __construct()
    {
        $this->userSocieties = new ArrayCollection();
    }

    public function getId()
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCityCode(): ?string
    {
        return $this->cityCode;
    }

    public function setCityCode(string $cityCode): self
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|UserSociety[]
     */
    public function getUserSocieties(): Collection
    {
        return $this->userSocieties;
    }

    public function addUserSociety(UserSociety $userSociety): self
    {
        if (!$this->userSocieties->contains($userSociety)) {
            $this->userSocieties[] = $userSociety;
            $userSociety->setSociety($this);
        }

        return $this;
    }

    public function removeUserSociety(UserSociety $userSociety): self
    {
        if ($this->userSocieties->contains($userSociety)) {
            $this->userSocieties->removeElement($userSociety);
            // set the owning side to null (unless already changed)
            if ($userSociety->getSociety() === $this) {
                $userSociety->setSociety(null);
            }
        }

        return $this;
    }
}
