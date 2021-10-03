<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="Ya existe un usuario con ese correo")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apellido;

    /**
     * @ORM\OneToMany(targetEntity=Receta::class, mappedBy="Usuario")
     */
    private $recetas;

    /**
     * @ORM\ManyToMany(targetEntity=Apto::class)
     */
    private $apto;

    /**
     * @ORM\ManyToMany(targetEntity=Receta::class)
     */
    private $recetaFavorita;

    /**
     * @ORM\ManyToMany(targetEntity=Ingrediente::class)
     */
    private $ingredienteFavorito;

    public function __toString(){
        return $this->getEmail();
    }

    public function __construct()
    {
        $this->recetas = new ArrayCollection();
        $this->apto = new ArrayCollection();
        $this->recetaFavorita = new ArrayCollection();
        $this->ingredienteFavorito = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;

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
            $receta->setUsuario($this);
        }

        return $this;
    }

    public function removeReceta(Receta $receta): self
    {
        if ($this->recetas->removeElement($receta)) {
            // set the owning side to null (unless already changed)
            if ($receta->getUsuario() === $this) {
                $receta->setUsuario(null);
            }
        }

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
     * @return Collection|Receta[]
     */
    public function getRecetaFavorita(): Collection
    {
        return $this->recetaFavorita;
    }

    public function addRecetaFavoritum(Receta $recetaFavoritum): self
    {
        if (!$this->recetaFavorita->contains($recetaFavoritum)) {
            $this->recetaFavorita[] = $recetaFavoritum;
        }

        return $this;
    }

    public function removeRecetaFavoritum(Receta $recetaFavoritum): self
    {
        $this->recetaFavorita->removeElement($recetaFavoritum);

        return $this;
    }

    /**
     * @return Collection|Ingrediente[]
     */
    public function getIngredienteFavorito(): Collection
    {
        return $this->ingredienteFavorito;
    }

    public function addIngredienteFavorito(Ingrediente $ingredienteFavorito): self
    {
        if (!$this->ingredienteFavorito->contains($ingredienteFavorito)) {
            $this->ingredienteFavorito[] = $ingredienteFavorito;
        }

        return $this;
    }

    public function removeIngredienteFavorito(Ingrediente $ingredienteFavorito): self
    {
        $this->ingredienteFavorito->removeElement($ingredienteFavorito);

        return $this;
    }
}
