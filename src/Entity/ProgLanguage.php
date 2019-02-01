<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgLanguageRepository")
 */
class ProgLanguage
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProgLanguage", mappedBy="progLanguage")
     */
    private $userProgLanguages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgTechnology", mappedBy="progLanguage")
     */
    private $progTechnologies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserProject", mappedBy="progLanguages")
     */
    private $userProjects;

    public function __construct()
    {
        $this->userProjects = new ArrayCollection();
        $this->userProgLanguages = new ArrayCollection();
        $this->progTechnologies = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|UserProject[]
     */
    public function getUserProjects(): Collection
    {
        return $this->userProjects;
    }

    public function addUserProject(UserProject $userProject): self
    {
        if (!$this->userProjects->contains($userProject)) {
            $this->userProjects[] = $userProject;
            $userProject->addProgLanguage($this);
        }

        return $this;
    }

    public function removeUserProject(UserProject $userProject): self
    {
        if ($this->userProjects->contains($userProject)) {
            $this->userProjects->removeElement($userProject);
            $userProject->removeProgLanguage($this);
        }

        return $this;
    }

    /**
     * @return Collection|UserProgLanguage[]
     */
    public function getUserProgLanguages(): Collection
    {
        return $this->userProgLanguages;
    }

    public function addUserProgLanguage(UserProgLanguage $userProgLanguage): self
    {
        if (!$this->userProgLanguages->contains($userProgLanguage)) {
            $this->userProgLanguages[] = $userProgLanguage;
            $userProgLanguage->setProgLanguage($this);
        }

        return $this;
    }

    public function removeUserProgLanguage(UserProgLanguage $userProgLanguage): self
    {
        if ($this->userProgLanguages->contains($userProgLanguage)) {
            $this->userProgLanguages->removeElement($userProgLanguage);
            // set the owning side to null (unless already changed)
            if ($userProgLanguage->getProgLanguage() === $this) {
                $userProgLanguage->setProgLanguage(null);
            }
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
            $progTechnology->setProgLanguage($this);
        }

        return $this;
    }

    public function removeProgTechnology(ProgTechnology $progTechnology): self
    {
        if ($this->progTechnologies->contains($progTechnology)) {
            $this->progTechnologies->removeElement($progTechnology);
            // set the owning side to null (unless already changed)
            if ($progTechnology->getProgLanguage() === $this) {
                $progTechnology->setProgLanguage(null);
            }
        }

        return $this;
    }
}
