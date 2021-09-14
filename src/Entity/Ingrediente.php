<?php

namespace App\Entity;

use App\Repository\IngredienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredienteRepository::class)
 */
class Ingrediente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     */
    private $unidad;

    /**
     * @ORM\OneToMany(targetEntity=RecetaIngrediente::class, mappedBy="ingrediente")
     */
    private $recetaIngredientes;

    public function __toString(){
        return $this->getDescripcion();
    }

    public function __construct()
    {
        $this->recetaIngredientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUnidad(): ?Unidad
    {
        return $this->unidad;
    }

    public function setUnidad(?Unidad $unidad): self
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * @return Collection|RecetaIngrediente[]
     */
    public function getRecetaIngredientes(): Collection
    {
        return $this->recetaIngredientes;
    }

    public function addRecetaIngrediente(RecetaIngrediente $recetaIngrediente): self
    {
        if (!$this->recetaIngredientes->contains($recetaIngrediente)) {
            $this->recetaIngredientes[] = $recetaIngrediente;
            $recetaIngrediente->setIngrediente($this);
        }

        return $this;
    }

    public function removeRecetaIngrediente(RecetaIngrediente $recetaIngrediente): self
    {
        if ($this->recetaIngredientes->removeElement($recetaIngrediente)) {
            // set the owning side to null (unless already changed)
            if ($recetaIngrediente->getIngrediente() === $this) {
                $recetaIngrediente->setIngrediente(null);
            }
        }

        return $this;
    }
}
