<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $capture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAnswered;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="media")
     */
    private $videos;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function getCapture(): ?string
    {
        return $this->capture;
    }

    public function setCapture(?string $capture): self
    {
        $this->capture = $capture;

        return $this;
    }

    public function getIsAnswered(): ?bool
    {
        return $this->isAnswered;
    }

    public function setIsAnswered(bool $isAnswered): self
    {
        $this->isAnswered = $isAnswered;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setMedia($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getMedia() === $this) {
                $video->setMedia(null);
            }
        }

        return $this;
    }
}
