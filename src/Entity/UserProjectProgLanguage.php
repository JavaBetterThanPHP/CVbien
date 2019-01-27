<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProjectProgLanguageRepository")
 */
class UserProjectProgLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgLanguage", inversedBy="userProjectProgLanguages")
     */
    private $progLanguage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserProject", inversedBy="userProjectProgLanguages")
     */
    private $userProject;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserProject(): ?UserProject
    {
        return $this->userProject;
    }

    public function setUserProject(?UserProject $userProject): self
    {
        $this->userProject = $userProject;

        return $this;
    }
}
