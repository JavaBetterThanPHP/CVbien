<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProjectRepository")
 */
class UserProject
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userProjects")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlProject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlWebsite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserSociety", inversedBy="userProjects")
     */
    private $userSociety;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProgTechnology", inversedBy="userProjects")
     */
    private $progTechnologies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProgLanguage", inversedBy="userProjects")
     */
    private $progLanguages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    public function __construct()
    {
        $this->progTechnologies = new ArrayCollection();
        $this->progLanguages = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function getUrlProject(): ?string
    {
        return $this->urlProject;
    }

    public function setUrlProject(string $urlProject): self
    {
        $this->urlProject = $urlProject;

        return $this;
    }

    public function getUrlWebsite(): ?string
    {
        return $this->urlWebsite;
    }

    public function setUrlWebsite(?string $urlWebsite): self
    {
        $this->urlWebsite = $urlWebsite;

        return $this;
    }

    public function getUserSociety(): ?UserSociety
    {
        return $this->userSociety;
    }

    public function setUserSociety(?UserSociety $userSociety): self
    {
        $this->userSociety = $userSociety;

        return $this;
    }

    /**
     * @return Collection|ProgLanguage[]
     */
    public function getProgLanguages(): Collection
    {
        return $this->progLanguages;
    }

    public function addProgLanguage(ProgLanguage $progLanguage): self
    {
        if (!$this->progLanguages->contains($progLanguage)) {
            $this->progLanguages[] = $progLanguage;
        }

        return $this;
    }

    public function removeProgLanguage(ProgLanguage $progLanguage): self
    {
        if ($this->progLanguages->contains($progLanguage)) {
            $this->progLanguages->removeElement($progLanguage);
        }

        return $this;
    }

    /**
     * @return Collection|ProgTechnology[]
     */
    public function getProgTechnologies(): Collection
    {
        return $this->progTechnologies;
    }

    public function addProgTechnology(ProgTechnology $progTechnology): self
    {
        if (!$this->progTechnologies->contains($progTechnology)) {
            $this->progTechnologies[] = $progTechnology;
        }

        return $this;
    }

    public function removeProgTechnology(ProgTechnology $progTechnology): self
    {
        if ($this->progTechnologies->contains($progTechnology)) {
            $this->progTechnologies->removeElement($progTechnology);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
