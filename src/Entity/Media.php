<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    const TYPE_IMAGE = 'image';

    const TYPE_VIDEO = 'video';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TwitterUser", inversedBy="media")
     * @ORM\JoinColumn(nullable=false)
     */
    private $twitterUser;

    /**
     * @ORM\Column(type="string")
     */
    private $tweetIdentifier;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTwitterUser(): ?TwitterUser
    {
        return $this->twitterUser;
    }

    public function setTwitterUser(?TwitterUser $twitterUser): self
    {
        $this->twitterUser = $twitterUser;

        return $this;
    }

    public function getTweetIdentifier(): ?string
    {
        return $this->tweetIdentifier;
    }

    public function setTweetIdentifier(string $tweetIdentifier): self
    {
        $this->tweetIdentifier = $tweetIdentifier;

        return $this;
    }
}
