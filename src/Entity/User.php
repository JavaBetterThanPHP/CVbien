<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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

    private $htmlDumpDefault;

    /* ===================================
     * =========== Properties ============
     * ===================================
     * */

    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /* =========== ACCOUNT INFO =========== */

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
     * @ORM\Column(type="boolean")
     */
    private $isSearchable;

    /* =========== USER INFO =========== */

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /* =========== IMGs =========== */

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $profilePicture="default.png";

    /**
     * @Vich\UploadableField(mapping="profilePictures", fileNameProperty="profilePicture")
     * @var File
     */
    private $imageFile;
  
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $bannerPicture = "default.png";

    /**
     * @Vich\UploadableField(mapping="bannerPictures", fileNameProperty="bannerPicture")
     * @var File
     */
    private $bannerImageFile;

    /* =========== Relations =========== */

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

    /* =========== Technical =========== */

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
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Blameable(on="update")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $userModulesGridHtmlString = '
          <div class="item muuri-item muuri-item-shown" style="left: 0px; top: 0px; transform: translateX(0px) translateY(0px); display: block; touch-action: none; -moz-user-select: none;">
             <div class="item-content" style="opacity: 1; transform: scale(1);">
                <div class="card">
                   <div class="card-header">
                      Bienvenue sur CVBien
                      <button class="btn btn-link float-right" onclick="deleteModule(this)"><i class="far fa-trash-alt"></i></button>
                   </div>
                   <div class="card-body">
                      <p class="card-text">Remplissez vos information personnelles, et choisissez vos Modules 😉</p>
                   </div>
                </div>
             </div>
          </div>
        ';

    /* ===================================
     * ============ Methods ==============
     * ===================================
     * */

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->setIsActive(true);
        $this->setIsSearchable(true);
        $this->updatedAt = new \DateTime('now');
        $this->date_creation_compte = new \DateTime('now');
        $this->date_derniere_connexion = new \DateTime('now');
        $this->progLanguages = new ArrayCollection();
        $this->userProjects = new ArrayCollection();
        $this->userDiplomas = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
        $this->userProgLanguages = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->userSocieties = new ArrayCollection();
    }

    /**
     * @param File|null $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param File|null $image
     */
    public function setBannerImageFile(File $image = null)
    {
        $this->bannerImageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getBannerImageFile()
    {
        return $this->bannerImageFile;
    }

    /**
     * @param $bannerPicture
     */
    public function setBannerPicture($bannerPicture)
    {
        $this->bannerPicture = $bannerPicture;
    }

    /**
     * @return string
     */
    public function getBannerPicture()
    {
        return $this->bannerPicture;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return User
     */
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

    /**
     * @param string $password
     * @return User
     */
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

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool|null $isActive
     * @return User
     */
    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return User
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return User
     */
    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTimeInterface|null $birthdate
     * @return User
     */
    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param null|string $phoneNumber
     * @return User
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProPhoneNumber(): ?string
    {
        return $this->proPhoneNumber;
    }

    /**
     * @param null|string $proPhoneNumber
     * @return User
     */
    public function setProPhoneNumber(?string $proPhoneNumber): self
    {
        $this->proPhoneNumber = $proPhoneNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAdress(): ?string
    {
        return $this->adress;
    }

    /**
     * @param null|string $adress
     * @return User
     */
    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     * @return User
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCityCode(): ?string
    {
        return $this->cityCode;
    }

    /**
     * @param null|string $cityCode
     * @return User
     */
    public function setCityCode(?string $cityCode): self
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country|null $country
     * @return User
     */
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

    /**
     * @param ProgLanguage $progLanguage
     * @return User
     */
    public function addProgLanguage(ProgLanguage $progLanguage): self
    {
        if (!$this->progLanguages->contains($progLanguage)) {
            $this->progLanguages[] = $progLanguage;
        }

        return $this;
    }

    /**
     * @param ProgLanguage $progLanguage
     * @return User
     */
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

    /**
     * @param UserProject $userProject
     * @return User
     */
    public function addUserProject(UserProject $userProject): self
    {
        if (!$this->userProjects->contains($userProject)) {
            $this->userProjects[] = $userProject;
            $userProject->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserProject $userProject
     * @return User
     */
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

    /**
     * @param UserDiploma $userDiploma
     * @return User
     */
    public function addUserDiploma(UserDiploma $userDiploma): self
    {
        if (!$this->userDiplomas->contains($userDiploma)) {
            $this->userDiplomas[] = $userDiploma;
            $userDiploma->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserDiploma $userDiploma
     * @return User
     */
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

    /**
     * @param UserLanguage $userLanguage
     * @return User
     */
    public function addUserLanguage(UserLanguage $userLanguage): self
    {
        if (!$this->userLanguages->contains($userLanguage)) {
            $this->userLanguages[] = $userLanguage;
            $userLanguage->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserLanguage $userLanguage
     * @return User
     */
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

    /**
     * @return array|bool|float|int|mixed|string
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getJsonUserProgLanguages()
    {
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $data = $serializer->normalize($this->getUserProgLanguages(), null, ['attributes' => ['progLanguage' => ['name'], 'level']]);
        return $data;
    }

    /**
     * @param UserProgLanguage $userProgLanguage
     * @return User
     */
    public function addUserProgLanguage(UserProgLanguage $userProgLanguage): self
    {
        if (!$this->userProgLanguages->contains($userProgLanguage)) {
            $this->userProgLanguages[] = $userProgLanguage;
            $userProgLanguage->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserProgLanguage $userProgLanguage
     * @return User
     */
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

    /**
     * @param Link $link
     * @return User
     */
    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setUser($this);
        }

        return $this;
    }

    /**
     * @param Link $link
     * @return User
     */
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

    /**
     * @return bool|null
     */
    public function getIsSearchable(): ?bool
    {
        return $this->isSearchable;
    }

    /**
     * @param bool $isSearchable
     * @return User
     */
    public function setIsSearchable(bool $isSearchable): self
    {
        $this->isSearchable = $isSearchable;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSpaceName(): ?string
    {
        return $this->spaceName;
    }

    /**
     * @param string $spaceName
     * @return User
     */
    public function setSpaceName(string $spaceName): self
    {
        $this->spaceName = $spaceName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|string $status
     * @return User
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     * @return User
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


    /**
     * @return Collection|UserSociety[]
     */
    public function getUserSocieties(): Collection
    {
        return $this->userSocieties;
    }

    /**
     * @param UserSociety $userSociety
     * @return User
     */
    public function addUserSociety(UserSociety $userSociety): self
    {
        if (!$this->userSocieties->contains($userSociety)) {
            $this->userSocieties[] = $userSociety;
            $userSociety->setUser($this);
        }

        return $this;
    }

    /**
     * @param UserSociety $userSociety
     * @return User
     */
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

    /**
     * @return null|string
     */
    public function getTokenToReset(): ?string
    {
        return $this->tokenToReset;
    }

    /**
     * @param null|string $tokenToReset
     * @return User
     */
    public function setTokenToReset(?string $tokenToReset): self
    {
        $this->tokenToReset = $tokenToReset;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCreationCompte(): ?\DateTimeInterface
    {
        return $this->date_creation_compte;
    }

    /**
     * @param \DateTimeInterface|null $date_creation_compte
     * @return User
     */
    public function setDateCreationCompte(?\DateTimeInterface $date_creation_compte): self
    {
        $this->date_creation_compte = $date_creation_compte;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->date_derniere_connexion;
    }

    /**
     * @param \DateTimeInterface|null $date_derniere_connexion
     * @return User
     */
    public function setDateDerniereConnexion(?\DateTimeInterface $date_derniere_connexion): self
    {
        $this->date_derniere_connexion = $date_derniere_connexion;

        return $this;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function equals(User $user)
    {
        return ($user->getId() === $this->getId());
    }

    /**
     * @return null|string
     */
    public function getUserModulesGridHtmlString(): ?string
    {
        return htmlspecialchars_decode($this->userModulesGridHtmlString);
    }

    /**
     * @param null|string $userModulesGridHtmlString
     * @return User
     */
    public function setUserModulesGridHtmlString(?string $userModulesGridHtmlString): self
    {
        $this->userModulesGridHtmlString = $userModulesGridHtmlString;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFullName(): ?string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @return null|string
     */
    public function getProfilePicturePath(): ?string
    {
        return '/images/profilePictures/' . $this->getProfilePicture();
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getEmail();
    }

}
