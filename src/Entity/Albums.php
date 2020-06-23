<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ApiResource(
 *     attributes={
 *     "normalization_context"={"groups"={"album:read"}}
 *      },
 *        itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_ADMIN') "},
 *         "delete"={ "access_control" = "is_granted('ROLE_ADMIN') "}
 *     },
 *     collectionOperations={
 *              "get",
 *              "post"
 *         }
 *  )
 *
 * @ApiFilter(SearchFilter::class, properties={"title" : "partial", "artist":"partial"})
 * @ORM\Entity(repositoryClass="App\Repository\AlbumsRepository")
 *
 */
class Albums
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"album:read",  "reviews:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"album:read", "reviews:write"})
     *
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"album:read", "reviews:write"})
     *
     */
    private $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $average_rating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $category;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"album:read"})
     */
    private $imageSource;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="albums")
     * @ApiSubresource()
     * @Groups({"album:read"})
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Songs", mappedBy="album")
     *
     * @ApiSubresource()
     * @Groups({"album:read"})
     */
    private $songs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read"})
     *
     */
    private $genre;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="album_fav")
     */
    private $user_fav;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->songs = new ArrayCollection();
        $this->users_favourite = new ArrayCollection();
        $this->user_fav = new ArrayCollection();
    }




    public function getId(): ?int
    {

        return $this->id;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getAverageRating(): ?int
    {
        return $this->average_rating;
    }

    public function setAverageRating(?int $average_rating): self
    {
        $this->average_rating = $average_rating;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(?int $category): self
    {
        $this->category = $category;

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
            $review->setAlbums($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getAlbums() === $this) {
                $review->setAlbums(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Songs[]
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Songs $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->setAlbum($this);
        }

        return $this;
    }

    public function removeSong(Songs $song): self
    {
        if ($this->songs->contains($song)) {
            $this->songs->removeElement($song);
            // set the owning side to null (unless already changed)
            if ($song->getAlbum() === $this) {
                $song->setAlbum(null);
            }
        }

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getUserFav(): Collection
    {
        return $this->user_fav;
    }

    public function addUserFav(User $userFav): self
    {
        if (!$this->user_fav->contains($userFav)) {
            $this->user_fav[] = $userFav;
            $userFav->addAlbumFav($this);
        }

        return $this;
    }

    public function removeUserFav(User $userFav): self
    {
        if ($this->user_fav->contains($userFav)) {
            $this->user_fav->removeElement($userFav);
            $userFav->removeAlbumFav($this);
        }

        return $this;
    }

    public function getImageSource(): ?string
    {
        return $this->imageSource;
    }

    public function setImageSource(?string $imageSource): self
    {
        $this->imageSource = $imageSource;

        return $this;
    }


}
