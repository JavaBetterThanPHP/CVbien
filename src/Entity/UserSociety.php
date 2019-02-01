<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSocietyRepository")
 */
class UserSociety
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Society", inversedBy="userSocieties")
     */
    private $society;

    /**
     * @ORM\Column(type="date")
     */
    private $firstDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $lastDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobType", inversedBy="userSocieties")
     */
    private $jobType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userSocieties")
     */
    private $user;

    public function __construct()
    {
        $this->userProjects = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

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

    public function getFirstDate(): ?\DateTimeInterface
    {
        return $this->firstDate;
    }

    public function setFirstDate(\DateTimeInterface $firstDate): self
    {
        $this->firstDate = $firstDate;

        return $this;
    }

    public function getLastDate(): ?\DateTimeInterface
    {
        return $this->lastDate;
    }

    public function setLastDate(?\DateTimeInterface $lastDate): self
    {
        $this->lastDate = $lastDate;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getJobType(): ?JobType
    {
        return $this->jobType;
    }

    public function setJobType(?JobType $jobType): self
    {
        $this->jobType = $jobType;

        return $this;
    }
}
