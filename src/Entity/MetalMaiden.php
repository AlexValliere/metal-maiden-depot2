<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetalMaidenRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class MetalMaiden
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AttireCategory", inversedBy="metalMaidens")
     * @ORM\JoinColumn(nullable=true)
     */
    private $attireCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nation", inversedBy="metalMaidens")
     * @ORM\JoinColumn(nullable=true)
     */
    private $nation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $attire;

    /**
     * @Gedmo\Slug(fields={"attire"})
     * @ORM\Column(name="attireSlug", type="string", length=255, unique=true)
    */
    private $attireSlug;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $rarity;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="metal_maiden_portrait", fileNameProperty="portraitImageName", size="portraitImageSize")
     * 
     * @var File
     */
    private $portraitImageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $portraitImageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $portraitImageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttireCategory(): ?AttireCategory
    {
        return $this->attireCategory;
    }

    public function setAttireCategory(AttireCategory $attireCategory): void
    {
        $this->attireCategory = $attireCategory;
    }

    public function getNation(): ?Nation
    {
        return $this->nation;
    }

    public function setNation(Nation $nation): void
    {
        $this->nation = $nation;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getAttire(): ?string
    {
        return $this->attire;
    }

    public function setAttire(string $attire): void
    {
        $this->attire = $attire;
    }

    public function getAttireSlug(): ?string
    {
        return $this->attireSlug;
    }

    public function setAttireSlug(string $attireSlug): void
    {
        $this->attireSlug = $attireSlug;
    }

    public function getRarity(): ?int
    {
        return $this->rarity;
    }

    public function setRarity(int $rarity): void
    {
        $this->rarity = $rarity;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setPortraitImageFile(?File $image = null): void
    {
        $this->portraitImageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getPortraitImageFile(): ?File
    {
        return $this->portraitImageFile;
    }

    public function setPortraitImageName(?string $portraitImageName): void
    {
        $this->portraitImageName = $portraitImageName;
    }

    public function getPortraitImageName(): ?string
    {
        return $this->portraitImageName;
    }

    public function setPortraitImageSize(?int $portraitImageSize): void
    {
        $this->portraitImageSize = $portraitImageSize;
    }

    public function getPortraitImageSize(): ?int
    {
        return $this->portraitImageSize;
    }

    public function hasPortraitImageFile(): ?bool
    {
        return (null !== $this->portraitImageName) ? true : false;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate(): void
    {
        $this->setUpdatedAt(new \Datetime());
    }
}
