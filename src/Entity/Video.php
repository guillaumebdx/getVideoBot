<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    const TYPES = [
        'video/mp4' => 'mp4',
        'application/x-mpegURL' => 'm3u8',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bitrate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Media", inversedBy="videos")
     */
    private $media;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        $type = $this->type;
        if (in_array($this->type, self::TYPES)) {
            $type = self::TYPES[$this->type];
        }
        return $type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getBitrate(): ?int
    {
        return $this->bitrate;
    }

    public function setBitrate(?int $bitrate): self
    {
        $this->bitrate = $bitrate;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }
}
