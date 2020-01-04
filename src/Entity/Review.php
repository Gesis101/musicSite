<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Albums", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $albums;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): ?User
    {
        return $this->author_name;
    }

    public function setAuthorName(?User $author_name): self
    {
        $this->author_name = $author_name;

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
}
