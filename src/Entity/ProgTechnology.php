<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgTechnologyRepository")
 */
class ProgTechnology
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
     * @ORM\ManyToMany(targetEntity="App\Entity\UserProject", mappedBy="progTechnologies")
     */
    private $userProjects;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgLanguage", inversedBy="progTechnologies")
     */
    private $progLanguage;

    public function __construct()
    {
        $this->userProjects = new ArrayCollection();
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
            $userProject->addProgTechnology($this);
        }

        return $this;
    }

    public function removeUserProject(UserProject $userProject): self
    {
        if ($this->userProjects->contains($userProject)) {
            $this->userProjects->removeElement($userProject);
            $userProject->removeProgTechnology($this);
        }

        return $this;
    }

    public function getProgLanguage(): ?ProgLanguage
    {
        return $this->progLanguage;
    }

    public function setProgLanguage(?ProgLanguage $progLanguage): self
    {
        $this->progLanguage = $progLanguage;

        return $this;
    }
}
