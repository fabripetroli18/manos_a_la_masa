<?php

namespace App\Entity;

use App\Repository\RecetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecetaRepository::class)
 */
class Receta
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recetas")
     */
    private $Usuario;

    /**
     * @ORM\ManyToMany(targetEntity=Apto::class, inversedBy="recetas")
     */
    private $apto;

    /**
     * @ORM\OneToMany(targetEntity=RecetaIngrediente::class, mappedBy="receta")
     */
    private $recetaIngredientes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detalle;

    public function __toString(){
        return $this->getDescripcion();
    }

    public function __construct()
    {
        $this->apto = new ArrayCollection();
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

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->Usuario;
    }

    public function setUsuario(?User $Usuario): self
    {
        $this->Usuario = $Usuario;

        return $this;
    }

    /**
     * @return Collection|Apto[]
     */
    public function getApto(): Collection
    {
        return $this->apto;
    }

    public function addApto(Apto $apto): self
    {
        if (!$this->apto->contains($apto)) {
            $this->apto[] = $apto;
        }

        return $this;
    }

    public function removeApto(Apto $apto): self
    {
        $this->apto->removeElement($apto);

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
            $recetaIngrediente->setReceta($this);
        }

        return $this;
    }

    public function removeRecetaIngrediente(RecetaIngrediente $recetaIngrediente): self
    {
        if ($this->recetaIngredientes->removeElement($recetaIngrediente)) {
            // set the owning side to null (unless already changed)
            if ($recetaIngrediente->getReceta() === $this) {
                $recetaIngrediente->setReceta(null);
            }
        }

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getDetalle(): ?string
    {
        return $this->detalle;
    }

    public function setDetalle(?string $detalle): self
    {
        $this->detalle = $detalle;

        return $this;
    }
}
