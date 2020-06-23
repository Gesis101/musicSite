<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\ApiToken;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     attributes={
 *     "access_control"="is_granted('ROLE_ADMIN')",
 *     "normalization_context"={"groups"={"user:read"}},
 *     "denormalization_context"={"groups"={"user:write"}},
 *     "enable_max_depth"=true
 *  },
 *
 *      collectionOperations={"get"},
 *        itemOperations={
 *                  "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *                  "put"= {"access_control"="is_granted('ROLE_ADMIN')  "}
 * }
 * )
 *
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
     * @Groups({"user:read" })
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @var User
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = ["ROLE_USER"];
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $active = false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="authorName", cascade={"all"})
     * @ApiSubresource()
     *
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Songs", mappedBy="user", cascade={"all"})
     *
     */
    private $favourite_songs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Albums", inversedBy="user_fav", cascade={"all"})
     * @ApiSubresource()
     *
     */
    private $album_fav;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ApiToken", mappedBy="user", orphanRemoval=true)
     * @Groups({"user:read"})
     */
    private $apiTokens;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->favourite_songs = new ArrayCollection();
        $this->album_fav = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();

    }



    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
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


    public function getActive(): ?bool
    {
        $this->active = false;
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setAuthorName($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getAuthorName() === $this) {
                $review->setAuthorName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Songs[]
     */
    public function getFavouriteSongs(): Collection
    {
        return $this->favourite_songs;
    }

    public function addFavouriteSong(Songs $favouriteSong): self
    {
        if (!$this->favourite_songs->contains($favouriteSong)) {
            $this->favourite_songs[] = $favouriteSong;
            $favouriteSong->setUser($this);
        }

        return $this;
    }

    public function removeFavouriteSong(Songs $favouriteSong): self
    {
        if ($this->favourite_songs->contains($favouriteSong)) {
            $this->favourite_songs->removeElement($favouriteSong);
            // set the owning side to null (unless already changed)
            if ($favouriteSong->getUser() === $this) {
                $favouriteSong->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Albums[]
     */
    public function getAlbumFav(): Collection
    {
        return $this->album_fav;
    }

    public function addAlbumFav(Albums $albumFav): self
    {
        if (!$this->album_fav->contains($albumFav)) {
            $this->album_fav[] = $albumFav;
        }

        return $this;
    }

    public function removeAlbumFav(Albums $albumFav): self
    {
        if ($this->album_fav->contains($albumFav)) {
            $this->album_fav->removeElement($albumFav);
        }

        return $this;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
            $apiToken->setUser($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): self
    {
        if ($this->apiTokens->contains($apiToken)) {
            $this->apiTokens->removeElement($apiToken);
            // set the owning side to null (unless already changed)
            if ($apiToken->getUser() === $this) {
                $apiToken->setUser(null);
            }
        }

        return $this;
    }

    public function giveApiToken(ApiToken $apiToken)
    {
        if (!$this->apiTokens->contains($this->apiTokens)){
            $apiToken->setUser($this);

            return $apiToken;
        }
        return $this->getApiTokens();
    }

    /**
     * @inheritDoc
     */
    public function isEqualTo(UserInterface $user)
    {
        // TODO: Implement isEqualTo() method.
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        return true;
    }
}
