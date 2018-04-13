<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetalMaidenRepository")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $attire;

    public function getId()
    {
        return $this->id;
    }

    // public function getAttireCategory(): AttireCategory
    public function getAttireCategory()
    {
        return $this->attireCategory;
    }

    public function setAttireCategory(AttireCategory $attireCategory)
    {
        $this->attireCategory = $attireCategory;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAttire(): ?string
    {
        return $this->attire;
    }

    public function setAttire(string $attire): self
    {
        $this->attire = $attire;

        return $this;
    }
}
