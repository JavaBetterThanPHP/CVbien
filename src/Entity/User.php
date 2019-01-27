<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_account")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proPhoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cityCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="users")
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserStatus", inversedBy="users")
     */
    private $userStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProject", mappedBy="user")
     */
    private $userProjects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserDiploma", mappedBy="user")
     */
    private $userDiplomas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserLanguage", mappedBy="user")
     */
    private $userLanguages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProgLanguage", mappedBy="user")
     */
    private $userProgLanguages;

    /**
     * @ORM\Column(type="string", length=255, options={"default" : "default.jpg"})
     * @var string
     */
    private $profilePicture;

    /**
     * @Vich\UploadableField(mapping="profilePictures", fileNameProperty="profilePicture")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function __construct()
    {
        $this->progLanguages = new ArrayCollection();
        $this->userProjects = new ArrayCollection();
        $this->userDiplomas = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
        $this->userProgLanguages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getProPhoneNumber(): ?string
    {
        return $this->proPhoneNumber;
    }

    public function setProPhoneNumber(?string $proPhoneNumber): self
    {
        $this->proPhoneNumber = $proPhoneNumber;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCityCode(): ?string
    {
        return $this->cityCode;
    }

    public function setCityCode(?string $cityCode): self
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getUserStatus(): ?UserStatus
    {
        return $this->userStatus;
    }

    public function setUserStatus(?UserStatus $userStatus): self
    {
        $this->userStatus = $userStatus;

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
            $userProject->setUser($this);
        }

        return $this;
    }

    public function removeUserProject(UserProject $userProject): self
    {
        if ($this->userProjects->contains($userProject)) {
            $this->userProjects->removeElement($userProject);
            // set the owning side to null (unless already changed)
            if ($userProject->getUser() === $this) {
                $userProject->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserDiploma[]
     */
    public function getUserDiplomas(): Collection
    {
        return $this->userDiplomas;
    }

    public function addUserDiploma(UserDiploma $userDiploma): self
    {
        if (!$this->userDiplomas->contains($userDiploma)) {
            $this->userDiplomas[] = $userDiploma;
            $userDiploma->setUser($this);
        }

        return $this;
    }

    public function removeUserDiploma(UserDiploma $userDiploma): self
    {
        if ($this->userDiplomas->contains($userDiploma)) {
            $this->userDiplomas->removeElement($userDiploma);
            // set the owning side to null (unless already changed)
            if ($userDiploma->getUser() === $this) {
                $userDiploma->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|UserLanguage[]
     */
    public function getUserLanguages(): Collection
    {
        return $this->userLanguages;
    }

    public function addUserLanguage(UserLanguage $userLanguage): self
    {
        if (!$this->userLanguages->contains($userLanguage)) {
            $this->userLanguages[] = $userLanguage;
            $userLanguage->setUser($this);
        }

        return $this;
    }

    public function removeUserLanguage(UserLanguage $userLanguage): self
    {
        if ($this->userLanguages->contains($userLanguage)) {
            $this->userLanguages->removeElement($userLanguage);
            // set the owning side to null (unless already changed)
            if ($userLanguage->getUser() === $this) {
                $userLanguage->setUser(null);
            }
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
            $userProgLanguage->setUser($this);
        }

        return $this;
    }

    public function removeUserProgLanguage(UserProgLanguage $userProgLanguage): self
    {
        if ($this->userProgLanguages->contains($userProgLanguage)) {
            $this->userProgLanguages->removeElement($userProgLanguage);
            // set the owning side to null (unless already changed)
            if ($userProgLanguage->getUser() === $this) {
                $userProgLanguage->setUser(null);
            }
        }

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->profilePicture,
            $this->email,
            $this->password
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->profilePicture,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }

}
