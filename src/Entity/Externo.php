<?php

namespace App\Entity;

use App\Repository\ExternoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExternoRepository::class)
 */
class Externo
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
    private $externoMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $externoPass;

    /**
     * @ORM\Column(type="boolean")
     */
    private $externoAdmin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $externoActivo;

    /**
     * @ORM\ManyToMany(targetEntity=Perfil::class, inversedBy="externos")
     */
    private $perfiles;

    public function __construct()
    {
        $this->perfiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternoMail(): ?string
    {
        return $this->externoMail;
    }

    public function setExternoMail(string $externoMail): self
    {
        $this->externoMail = $externoMail;

        return $this;
    }

    public function getExternoPass(): ?string
    {
        return $this->externoPass;
    }

    public function setExternoPass(string $externoPass): self
    {
        $this->externoPass = $externoPass;

        return $this;
    }

    public function getExternoAdmin(): ?bool
    {
        return $this->externoAdmin;
    }

    public function setExternoAdmin(bool $externoAdmin): self
    {
        $this->externoAdmin = $externoAdmin;

        return $this;
    }

    public function getExternoActivo(): ?bool
    {
        return $this->externoActivo;
    }

    public function setExternoActivo(bool $externoActivo): self
    {
        $this->externoActivo = $externoActivo;

        return $this;
    }

    /**
     * @return Collection|Perfil[]
     */
    public function getPerfiles(): Collection
    {
        return $this->perfiles;
    }

    public function addPerfile(Perfil $perfile): self
    {
        if (!$this->perfiles->contains($perfile)) {
            $this->perfiles[] = $perfile;
        }

        return $this;
    }

    public function removePerfile(Perfil $perfile): self
    {
        $this->perfiles->removeElement($perfile);

        return $this;
    }
}
