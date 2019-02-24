<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_account")
 * @UniqueEntity("email", message="Il existe déjà un compte avec cette email")
 * @UniqueEntity("spaceName", message="Ce nom d'espace est déjà attribué")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     * @Assert\Length(
     *      min = 6,
     *      max = 20,
     *      minMessage = "Your space name must be at least {{ limit }} characters long",
     *      maxMessage = "Your space name cannot be longer than {{ limit }} characters"
     * )
     */
    private $spaceName;

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
     * @ORM\Column(type="boolean")
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
     * @ORM\Column(type="boolean")
     */
    private $isSearchable;

    /**
     * @ORM\Column(type="string", length=255, options={"default":"default.png"})
     * @var string
     */
    private $profilePicture = "default.png";

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

    /**
     * @ORM\Column(type="string", length=255, options={"default" : "default.png"})
     * @var string
     */
    private $bannerPicture = "default.png";

    /**
     * @Vich\UploadableField(mapping="bannerPictures", fileNameProperty="bannerPicture")
     * @var File
     */
    private $bannerImageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="user")
     */
    private $links;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSociety", mappedBy="user")
     */
    private $userSocieties;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $tokenToReset;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_creation_compte;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_derniere_connexion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $userModulesGridHtmlString;

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

    public function setBannerImageFile(File $image = null)
    {
        $this->bannerImageFile = $image;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getBannerImageFile()
    {
        return $this->bannerImageFile;
    }

    public function setBannerPicture($bannerPicture)
    {
        $this->bannerPicture = $bannerPicture;
    }

    public function getBannerPicture()
    {
        return $this->bannerPicture;
    }

    public function __construct()
    {
        $this->setIsActive(true);
        $this->setIsSearchable(true);
        $this->progLanguages = new ArrayCollection();
        $this->userProjects = new ArrayCollection();
        $this->userDiplomas = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
        $this->userProgLanguages = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->userSocieties = new ArrayCollection();
    }

    public function getId()
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
        return (string)$this->email;
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
        return (string)$this->password;
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
            $this->password,
            $this->bannerPicture,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->profilePicture,
            $this->email,
            $this->password,
            $this->bannerPicture,
            ) = unserialize($serialized);
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setUser($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getUser() === $this) {
                $link->setUser(null);
            }
        }

        return $this;
    }

    public function getIsSearchable(): ?bool
    {
        return $this->isSearchable;
    }

    public function setIsSearchable(bool $isSearchable): self
    {
        $this->isSearchable = $isSearchable;

        return $this;
    }

    public function getSpaceName(): ?string
    {
        return $this->spaceName;
    }

    public function setSpaceName(string $spaceName): self
    {
        $this->spaceName = $spaceName;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection|UserSociety[]
     */
    public function getUserSocieties(): Collection
    {
        return $this->userSocieties;
    }

    public function addUserSociety(UserSociety $userSociety): self
    {
        if (!$this->userSocieties->contains($userSociety)) {
            $this->userSocieties[] = $userSociety;
            $userSociety->setUser($this);
        }

        return $this;
    }

    public function removeUserSociety(UserSociety $userSociety): self
    {
        if ($this->userSocieties->contains($userSociety)) {
            $this->userSocieties->removeElement($userSociety);
            // set the owning side to null (unless already changed)
            if ($userSociety->getUser() === $this) {
                $userSociety->setUser(null);
            }
        }

        return $this;
    }

    public function getTokenToReset(): ?string
    {
        return $this->tokenToReset;
    }

    public function setTokenToReset(?string $tokenToReset): self
    {
        $this->tokenToReset = $tokenToReset;

        return $this;
    }

    public function getDateCreationCompte(): ?\DateTimeInterface
    {
        return $this->date_creation_compte;
    }

    public function setDateCreationCompte(?\DateTimeInterface $date_creation_compte): self
    {
        $this->date_creation_compte = $date_creation_compte;

        return $this;
    }

    public function getDateDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->date_derniere_connexion;
    }

    public function setDateDerniereConnexion(?\DateTimeInterface $date_derniere_connexion): self
    {
        $this->date_derniere_connexion = $date_derniere_connexion;

        return $this;
    }

    public function getUserModulesGridHtmlString(): ?string
    {
        return $this->userModulesGridHtmlString;
    }

    public function setUserModulesGridHtmlString(?string $userModulesGridHtmlString): self
    {
        $this->userModulesGridHtmlString = $userModulesGridHtmlString;

        return $this;
    }

    //TODO searialize all user properties just to be sure

}
