<?php

namespace App\Entity;

use App\Repository\RecetaIngredienteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecetaIngredienteRepository::class)
 */
class RecetaIngrediente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Receta::class, inversedBy="recetaIngredientes")
     */
    private $receta;

    /**
     * @ORM\ManyToOne(targetEntity=Ingrediente::class, inversedBy="recetaIngredientes")
     */
    private $ingrediente;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cantidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceta(): ?Receta
    {
        return $this->receta;
    }

    public function setReceta(?Receta $receta): self
    {
        $this->receta = $receta;

        return $this;
    }

    public function getIngrediente(): ?Ingrediente
    {
        return $this->ingrediente;
    }

    public function setIngrediente(?Ingrediente $ingrediente): self
    {
        $this->ingrediente = $ingrediente;

        return $this;
    }

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(?string $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }
}
