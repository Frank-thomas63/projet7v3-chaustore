<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SizeRepository")
 */
class Size
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
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="size")
     */
    private $size_id;

    public function __construct()
    {
        $this->size_id = new ArrayCollection();
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
     * @return Collection|stock[]
     */
    public function getSizeId(): Collection
    {
        return $this->size_id;
    }

    public function addSizeId(stock $sizeId): self
    {
        if (!$this->size_id->contains($sizeId)) {
            $this->size_id[] = $sizeId;
            $sizeId->setSize($this);
        }

        return $this;
    }

    public function removeSizeId(stock $sizeId): self
    {
        if ($this->size_id->contains($sizeId)) {
            $this->size_id->removeElement($sizeId);
            // set the owning side to null (unless already changed)
            if ($sizeId->getSize() === $this) {
                $sizeId->setSize(null);
            }
        }

        return $this;
    }
}
