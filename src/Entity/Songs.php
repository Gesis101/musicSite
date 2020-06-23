<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SongsRepository")
 * @ApiResource(
 *
 *     itemOperations={
            "get",
 *          "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *          "put"={"access_control"="is_granted('ROLE_ADMIN')"}
 *
 *     },
 *      collectionOperations={
            "post"
 *     }
 * )
 *
 */
class Songs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({ "album:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "album:write", "album:read"})
     */
    private $songName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Albums", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favourite_songs")
     * @ApiSubresource()
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSongName(): ?string
    {
        return $this->songName;
    }

    public function setSongName(string $songName): self
    {
        $this->songName = $songName;

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
