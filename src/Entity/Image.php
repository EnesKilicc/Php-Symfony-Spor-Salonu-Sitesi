<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=SporPaket::class, inversedBy="images")
     */
    private $sporPaket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSporPaket(): ?SporPaket
    {
        return $this->sporPaket;
    }

    public function setSporPaket(?SporPaket $sporPaket): self
    {
        $this->sporPaket = $sporPaket;

        return $this;
    }
}
