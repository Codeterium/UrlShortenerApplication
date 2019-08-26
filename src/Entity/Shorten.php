<?php

namespace App\Entity;

use \DateTime as DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShortenRepository")
 */
class Shorten
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *   max = 255,
     *   maxMessage = "The url cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="short", type="string", unique=true, nullable=true, options={"collation":"utf8_bin"})
     * @Assert\Url(relativeProtocol = false)
     */
    private $short;

    /**
     * @var DateTime
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var int
     * @ORM\Column(name="visit", type="integer", nullable=true)
     */
    private $visit;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->visit = '0';
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

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): self
    {
        $this->short = $short;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getVisit(): ?int
    {
        return $this->visit;
    }

    public function setVisit(?int $visit): self
    {
        $this->visit = $visit;

        return $this;
    }


}
