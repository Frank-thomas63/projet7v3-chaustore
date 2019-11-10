<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="brand")
     */
    private $brand_id;

    public function __construct()
    {
        $this->brand_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|product[]
     */
    public function getBrandId(): Collection
    {
        return $this->brand_id;
    }

    public function addBrandId(product $brandId): self
    {
        if (!$this->brand_id->contains($brandId)) {
            $this->brand_id[] = $brandId;
            $brandId->setBrand($this);
        }

        return $this;
    }

    public function removeBrandId(product $brandId): self
    {
        if ($this->brand_id->contains($brandId)) {
            $this->brand_id->removeElement($brandId);
            // set the owning side to null (unless already changed)
            if ($brandId->getBrand() === $this) {
                $brandId->setBrand(null);
            }
        }

        return $this;
    }
}
