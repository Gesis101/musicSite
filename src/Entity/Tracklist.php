<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TracklistRepository")
 */
class Tracklist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $song;

    /**
     * @ORM\Column(type="integer")
     */
    private $album_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?string
    {
        return $this->song;
    }

    public function setSong(string $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getAlbumId(): ?int
    {
        return $this->album_id;
    }

    public function setAlbumId(int $album_id): self
    {
        $this->album_id = $album_id;

        return $this;
    }
}
