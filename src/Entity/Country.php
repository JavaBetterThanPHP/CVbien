<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
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
     * @ORM\OneToMany(targetEntity="App\Entity\Diploma", mappedBy="country")
     */
    private $diplomas;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Society", mappedBy="country")
     */
    private $societies;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="country")
     */
    private $users;


    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->diplomas = new ArrayCollection();
        $this->societies = new ArrayCollection();
        $this->users = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return Country
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection|Diploma[]
     */
    public function getDiplomas(): Collection
    {
        return $this->diplomas;
    }


    /**
     * @param Diploma $diploma
     * @return Country
     */
    public function addDiploma(Diploma $diploma): self
    {
        if (!$this->diplomas->contains($diploma)) {
            $this->diplomas[] = $diploma;
            $diploma->setCountry($this);
        }

        return $this;
    }


    /**
     * @param Diploma $diploma
     * @return Country
     */
    public function removeDiploma(Diploma $diploma): self
    {
        if ($this->diplomas->contains($diploma)) {
            $this->diplomas->removeElement($diploma);
            // set the owning side to null (unless already changed)
            if ($diploma->getCountry() === $this) {
                $diploma->setCountry(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Society[]
     */
    public function getSocieties(): Collection
    {
        return $this->societies;
    }


    /**
     * @param Society $society
     * @return Country
     */
    public function addSociety(Society $society): self
    {
        if (!$this->societies->contains($society)) {
            $this->societies[] = $society;
            $society->setCountry($this);
        }

        return $this;
    }


    /**
     * @param Society $society
     * @return Country
     */
    public function removeSociety(Society $society): self
    {
        if ($this->societies->contains($society)) {
            $this->societies->removeElement($society);
            // set the owning side to null (unless already changed)
            if ($society->getCountry() === $this) {
                $society->setCountry(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }


    /**
     * @param User $user
     * @return Country
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCountry($this);
        }

        return $this;
    }


    /**
     * @param User $user
     * @return Country
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCountry() === $this) {
                $user->setCountry(null);
            }
        }

        return $this;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->getName() != null) {
            return $this->getName();
        }
        return "";
    }
}
