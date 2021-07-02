<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 */
class Usuario
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
    private $usuarioMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usuarioPass;

    /**
     * @ORM\Column(type="boolean")
     */
    private $usuarioAdmin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $usuarioActivo;

    /**
     * @ORM\OneToOne(targetEntity=Perfil::class, inversedBy="usuario", cascade={"persist", "remove"})
     */
    private $perfil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioMail(): ?string
    {
        return $this->usuarioMail;
    }

    public function setUsuarioMail(string $usuarioMail): self
    {
        $this->usuarioMail = $usuarioMail;

        return $this;
    }

    public function getUsuarioPass(): ?string
    {
        return $this->usuarioPass;
    }

    public function setUsuarioPass(string $usuarioPass): self
    {
        $this->usuarioPass = $usuarioPass;

        return $this;
    }

    public function getUsuarioAdmin(): ?bool
    {
        return $this->usuarioAdmin;
    }

    public function setUsuarioAdmin(bool $usuarioAdmin): self
    {
        $this->usuarioAdmin = $usuarioAdmin;

        return $this;
    }

    public function getUsuarioActivo(): ?bool
    {
        return $this->usuarioActivo;
    }

    public function setUsuarioActivo(bool $usuarioActivo): self
    {
        $this->usuarioActivo = $usuarioActivo;

        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(?Perfil $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }

    public function __toString() {
        return $this->usuarioMail;
    }
}
