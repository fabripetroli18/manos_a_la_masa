<?php

namespace App\Entity;

use App\Repository\AptoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AptoRepository::class)
 */
class Apto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity=Receta::class, mappedBy="apto")
     */
    private $recetas;

    public function __toString(){
        return $this->getDescripcion();
    }

    public function __construct()
    {
        $this->recetas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|Receta[]
     */
    public function getRecetas(): Collection
    {
        return $this->recetas;
    }

    public function addReceta(Receta $receta): self
    {
        if (!$this->recetas->contains($receta)) {
            $this->recetas[] = $receta;
            $receta->addApto($this);
        }

        return $this;
    }

    public function removeReceta(Receta $receta): self
    {
        if ($this->recetas->removeElement($receta)) {
            $receta->removeApto($this);
        }

        return $this;
    }
}
