<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={"groups"={"reviews:read"}}
 *      },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_ADMIN') "},
 *         "delete"={ "access_control" = "is_granted('ROLE_ADMIN') or object.getAuthorName() == user "}
 *     },
 *     collectionOperations={
 *              "get",
 *              "post"
 * }

 * )
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"reviews:read", "user:read"})
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Groups({"user:read", "album:read", "reviews:read" })
     */
    private $authorName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reviews:read", "user:read"})
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Albums", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     * @Groups({"user:read", "reviews:read"})
     */
    private $albums;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user:read"})
     */
    private $postedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $user_rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): ?User
    {
        return $this->authorName;
    }

    public function setAuthorName(?User $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getAlbums(): ?Albums
    {
        return $this->albums;
    }

    public function setAlbums(?Albums $albums): self
    {
        $this->albums = $albums;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeInterface $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getUserRating(): ?int
    {
        return $this->user_rating;
    }

    public function setUserRating(int $user_rating): self
    {
        $this->user_rating = $user_rating;

        return $this;
    }
}
