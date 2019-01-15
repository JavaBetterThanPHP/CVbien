<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDiplomaRepository")
 */
class UserDiploma
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Diploma", inversedBy="userDiplomas")
     */
    private $diploma;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfGrant;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $mention;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiploma(): ?Diploma
    {
        return $this->diploma;
    }

    public function setDiploma(?Diploma $diploma): self
    {
        $this->diploma = $diploma;

        return $this;
    }

    public function getDateOfGrant(): ?\DateTimeInterface
    {
        return $this->dateOfGrant;
    }

    public function setDateOfGrant(?\DateTimeInterface $dateOfGrant): self
    {
        $this->dateOfGrant = $dateOfGrant;

        return $this;
    }

    public function getMention(): ?string
    {
        return $this->mention;
    }

    public function setMention(string $mention): self
    {
        $this->mention = $mention;

        return $this;
    }
}
