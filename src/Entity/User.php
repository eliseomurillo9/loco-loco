<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column]
    private ?bool $is_enabled = true;

    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $products;

    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'users', cascade:["persist"])]
    private Collection $Addresses;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Store::class)]
    private Collection $ownedStores;

    #[ORM\ManyToMany(targetEntity: Store::class, inversedBy: 'favouritesUsers')]
    private Collection $favourites;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->Addresses = new ArrayCollection();
        $this->ownedStores = new ArrayCollection();
        $this->favourites = new ArrayCollection();
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
    public function getUserIdentifier(): string
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         //$this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isIsEnabled(): ?bool
    {
        return $this->is_enabled;
    }

    public function setIsEnabled(bool $is_enabled): self
    {
        $this->is_enabled = $is_enabled;

        return $this;
    }


    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->Addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->Addresses->contains($address)) {
            $this->Addresses->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        $this->Addresses->removeElement($address);

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @return Collection<int, Store>
     */
    public function getOwnedStores(): Collection
    {
        return $this->ownedStores;
    }

    public function addOwnedStore(Store $ownedStore): self
    {
        if (!$this->ownedStores->contains($ownedStore)) {
            $this->ownedStores->add($ownedStore);
            $ownedStore->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedStore(Store $ownedStore): self
    {
        if ($this->ownedStores->removeElement($ownedStore)) {
            // set the owning side to null (unless already changed)
            if ($ownedStore->getOwner() === $this) {
                $ownedStore->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Store>
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    public function addFavourite(Store $favourite): self
    {
        if (!$this->favourites->contains($favourite)) {
            $this->favourites->add($favourite);
        }

        return $this;
    }

    public function removeFavourite(Store $favourite): self
    {
        $this->favourites->removeElement($favourite);

        return $this;
    }
}
