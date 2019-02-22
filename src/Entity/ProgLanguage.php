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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProgLanguage", mappedBy="progLanguage")
     */
    private $userProgLanguages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserProject", mappedBy="progLanguages")
     */
    private $userProjects;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgLanguage", inversedBy="childProgLanguages")
     */
    private $parentProgLanguage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgLanguage", mappedBy="parentProgLanguage")
     */
    private $childProgLanguages;

    public function __construct()
    {
        $this->userProjects = new ArrayCollection();
        $this->userProgLanguages = new ArrayCollection();
        $this->childProgLanguages = new ArrayCollection();
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

    public function getParentProgLanguage(): ?self
    {
        return $this->parentProgLanguage;
    }

    public function setParentProgLanguage(?self $parentProgLanguage): self
    {
        $this->parentProgLanguage = $parentProgLanguage;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildProgLanguages(): Collection
    {
        return $this->childProgLanguages;
    }

    public function addChildProgLanguage(self $childProgLanguage): self
    {
        if (!$this->childProgLanguages->contains($childProgLanguage)) {
            $this->childProgLanguages[] = $childProgLanguage;
            $childProgLanguage->setParentProgLanguage($this);
        }

        return $this;
    }

    public function removeChildProgLanguage(self $childProgLanguage): self
    {
        if ($this->childProgLanguages->contains($childProgLanguage)) {
            $this->childProgLanguages->removeElement($childProgLanguage);
            // set the owning side to null (unless already changed)
            if ($childProgLanguage->getParentProgLanguage() === $this) {
                $childProgLanguage->setParentProgLanguage(null);
            }
        }

        return $this;
    }
}
