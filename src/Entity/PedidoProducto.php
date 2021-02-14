<?php

namespace App\Entity;

use App\Repository\PedidoProductoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidoProductoRepository::class)
 */
class PedidoProducto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codPedProd;

    /**
     * @ORM\ManyToOne(targetEntity=Pedido::class)
     * @ORM\JoinColumn(name="Pedido", referencedColumnName="codPed")
     */
    private $codPed;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class)
     * @ORM\JoinColumn(name="Producto", referencedColumnName="codProd")
     */
    private $codProd;

    /**
     * @ORM\Column(type="integer", name="unidades")
     */
    private $unidades;

    public function getCodPedProd(): ?int
    {
        return $this->codPedProd;
    }

    public function getCodPed(): ?Pedido
    {
        return $this->codPed;
    }

    public function setCodPed(?Pedido $codPed): self
    {
        $this->codPed = $codPed;

        return $this;
    }

    public function getCodProd(): ?Producto
    {
        return $this->codProd;
    }

    public function setCodProd(?Producto $codProd): self
    {
        $this->codProd = $codProd;

        return $this;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }
}
