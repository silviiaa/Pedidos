<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestauranteRepository::class)
 */
class Restaurante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="codRes")
     */
    private $codRes;

    /**
     * @ORM\Column(type="string", length=90, unique=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $clave;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $pais;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $ciudad;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $direccion;

    /**
     * @ORM\OneToMany(targetEntity=Categoria::class, mappedBy="restaurante")
     */
    private $categoria;

    public function __construct()
    {
        $this->categoria = new ArrayCollection();
    }
    
    
    public function getCodRes(): ?int
    {
        return $this->codRes;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return Collection|Categoria[]
     */
    public function getCategoria(): Collection
    {
        return $this->categoria;
    }

    public function addCategorium(Categoria $categorium): self
    {
        if (!$this->categoria->contains($categorium)) {
            $this->categoria[] = $categorium;
            $categorium->setRestaurante($this);
        }

        return $this;
    }

    public function removeCategorium(Categoria $categorium): self
    {
        if ($this->categoria->removeElement($categorium)) {
            // set the owning side to null (unless already changed)
            if ($categorium->getRestaurante() === $this) {
                $categorium->setRestaurante(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->correo;
    }
}
