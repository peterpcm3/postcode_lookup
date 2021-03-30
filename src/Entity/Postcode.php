<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostcodeRepository;

/**
 * @ORM\Entity
 * @ORM\Table(name="postcode")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=PostcodeRepository::class)
 */
class Postcode
{
    /**
     * Distance in miles
     *
     * @var int NEAREST_DISTANCE
     */
    const NEAREST_DISTANCE = 10;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postcode;

    /**
     * @ORM\Column(type="integer")
     */
    private $easting;

    /**
     * @ORM\Column(type="integer")
     */
    private $northing;

    /**
     * @ORM\Column(type="decimal", scale=3)
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", scale=3)
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $modifiedAt;


    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get postcode string
     *
     * @return null|string
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * Set postcode string
     *
     * @param string $postcode
     *
     * @return Postcode
     */
    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return null|string
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Postcode
     */
    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return null|string
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Postcode
     */
    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get easting
     *
     * @return null|string
     */
    public function getEasting(): ?string
    {
        return $this->easting;
    }

    /**
     * Set easting
     *
     * @param string $easting
     *
     * @return Postcode
     */
    public function setEasting(string $easting): self
    {
        $this->easting = $easting;

        return $this;
    }

    /**
     * Get northing
     *
     * @return null|string
     */
    public function getNorthing(): ?string
    {
        return $this->northing;
    }

    /**
     * Set northing
     *
     * @param string $northing
     *
     * @return Postcode
     */
    public function setNorthing(string $northing): self
    {
        $this->northing = $northing;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     *
     * @return Postcode
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTimeInterface|null
     */
    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTimeInterface $modifiedAt
     *
     * @return Postcode
     */
    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamp(): void
    {
        $this->setModifiedAt(new \DateTime());

        if($this->getCreatedAt() === null)
        {
            $this->setCreatedAt(new \DateTime());
        }
    }
}
