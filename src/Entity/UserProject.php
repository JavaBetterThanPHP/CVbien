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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
    private $society;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProjectType", inversedBy="userProjects")
     */
    private $projectType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProgLanguage", inversedBy="userProjects")
     */
    private $progLanguage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProgTechnology", inversedBy="userProjects")
     */
    private $progTechnologies;

    public function __construct()
    {
        $this->projectType = new ArrayCollection();
        $this->progLanguage = new ArrayCollection();
        $this->progTechnologies = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getSociety(): ?UserSociety
    {
        return $this->society;
    }

    public function setSociety(?UserSociety $society): self
    {
        $this->society = $society;

        return $this;
    }

    /**
     * @return Collection|ProjectType[]
     */
    public function getProjectType(): Collection
    {
        return $this->projectType;
    }

    public function addProjectType(ProjectType $projectType): self
    {
        if (!$this->projectType->contains($projectType)) {
            $this->projectType[] = $projectType;
        }

        return $this;
    }

    public function removeProjectType(ProjectType $projectType): self
    {
        if ($this->projectType->contains($projectType)) {
            $this->projectType->removeElement($projectType);
        }

        return $this;
    }

    /**
     * @return Collection|ProgLanguage[]
     */
    public function getProgLanguage(): Collection
    {
        return $this->progLanguage;
    }

    public function addProgLanguage(ProgLanguage $progLanguage): self
    {
        if (!$this->progLanguage->contains($progLanguage)) {
            $this->progLanguage[] = $progLanguage;
        }

        return $this;
    }

    public function removeProgLanguage(ProgLanguage $progLanguage): self
    {
        if ($this->progLanguage->contains($progLanguage)) {
            $this->progLanguage->removeElement($progLanguage);
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
}
