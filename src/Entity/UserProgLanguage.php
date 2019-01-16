<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProgLanguageRepository")
 */
class UserProgLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProgLanguage", inversedBy="userProgLanguages")
     */
    private $progLanguage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userProgLanguages")
     */
    private $user;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $level;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }
}
