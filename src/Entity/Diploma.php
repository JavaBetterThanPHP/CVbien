<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiplomaRepository")
 */
class Diploma
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInternational;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="diplomas")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserDiploma", mappedBy="diploma")
     */
    private $userDiplomas;

    public function __construct()
    {
        $this->userDiplomas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getIsInternational(): ?bool
    {
        return $this->isInternational;
    }

    public function setIsInternational(bool $isInternational): self
    {
        $this->isInternational = $isInternational;

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
     * @return Collection|UserDiploma[]
     */
    public function getUserDiplomas(): Collection
    {
        return $this->userDiplomas;
    }

    public function addUserDiploma(UserDiploma $userDiploma): self
    {
        if (!$this->userDiplomas->contains($userDiploma)) {
            $this->userDiplomas[] = $userDiploma;
            $userDiploma->setDiploma($this);
        }

        return $this;
    }

    public function removeUserDiploma(UserDiploma $userDiploma): self
    {
        if ($this->userDiplomas->contains($userDiploma)) {
            $this->userDiplomas->removeElement($userDiploma);
            // set the owning side to null (unless already changed)
            if ($userDiploma->getDiploma() === $this) {
                $userDiploma->setDiploma(null);
            }
        }

        return $this;
    }
}
