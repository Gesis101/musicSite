<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SongsRepository")
 */
class Songs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $song_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Albums", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favourite_songs")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSongName(): ?string
    {
        return $this->song_name;
    }

    public function setSongName(string $song_name): self
    {
        $this->song_name = $song_name;

        return $this;
    }

    public function getAlbum(): ?Albums
    {
        return $this->album;
    }

    public function setAlbum(?Albums $album): self
    {
        $this->album = $album;

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
}
