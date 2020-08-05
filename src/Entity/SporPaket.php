<?php

namespace App\Entity;

use App\Repository\SporPaketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SporPaketRepository::class)
 */
class SporPaket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    private $Trainer;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $Saat;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $days;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kisisayisi;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fiyat;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /*
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="sporPakets")
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detail;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="sporPaket")
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getTrainer(): ?string
    {
        return $this->Trainer;
    }

    public function setTrainer(?string $Trainer): self
    {
        $this->Trainer = $Trainer;

        return $this;
    }

    public function getSaat(): ?\DateTimeInterface
    {
        return $this->Saat;
    }

    public function setSaat(?\DateTimeInterface $Saat): self
    {
        $this->Saat = $Saat;

        return $this;
    }

    public function getDays(): ?string
    {
        return $this->days;
    }

    public function setDays(?string $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getKisisayisi(): ?int
    {
        return $this->kisisayisi;
    }

    public function setKisisayisi(?int $kisisayisi): self
    {
        $this->kisisayisi = $kisisayisi;

        return $this;
    }

    public function getFiyat(): ?int
    {
        return $this->fiyat;
    }

    public function setFiyat(?int $fiyat): self
    {
        $this->fiyat = $fiyat;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setSporPaket($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getSporPaket() === $this) {
                $image->setSporPaket(null);
            }
        }

        return $this;
    }
    public  function __toString()
    {
        return $this->title;
    }
}
