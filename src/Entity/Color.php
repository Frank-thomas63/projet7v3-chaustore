<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color
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
     * @ORM\OneToMany(targetEntity="App\Entity\product", mappedBy="color")
     */
    private $color_id;

    public function __construct()
    {
        $this->color_id = new ArrayCollection();
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
    public function getColorId(): Collection
    {
        return $this->color_id;
    }

    public function addColorId(product $colorId): self
    {
        if (!$this->color_id->contains($colorId)) {
            $this->color_id[] = $colorId;
            $colorId->setColor($this);
        }

        return $this;
    }

    public function removeColorId(product $colorId): self
    {
        if ($this->color_id->contains($colorId)) {
            $this->color_id->removeElement($colorId);
            // set the owning side to null (unless already changed)
            if ($colorId->getColor() === $this) {
                $colorId->setColor(null);
            }
        }

        return $this;
    }
}
