<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobTypeRepository")
 */
class JobType
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSociety", mappedBy="jobType")
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $userSociety->setJobType($this);
        }

        return $this;
    }

    public function removeUserSociety(UserSociety $userSociety): self
    {
        if ($this->userSocieties->contains($userSociety)) {
            $this->userSocieties->removeElement($userSociety);
            // set the owning side to null (unless already changed)
            if ($userSociety->getJobType() === $this) {
                $userSociety->setJobType(null);
            }
        }

        return $this;
    }
}
