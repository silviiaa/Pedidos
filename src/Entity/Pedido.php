<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidoRepository::class)
 */
class Pedido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="codPed")
     */
    private $codPed;

    /**
     * @ORM\Column(type="datetime", name="fecha")
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer", name="enviado")
     */
    private $enviado;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class)
     * @ORM\JoinColumn(name="Restaurante", referencedColumnName="codRes")
     */
    private $restaurante;

    public function getCodPed(): ?int
    {
        return $this->codPed;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEnviado(): ?int
    {
        return $this->enviado;
    }

    public function setEnviado(int $enviado): self
    {
        $this->enviado = $enviado;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): self
    {
        $this->restaurante = $restaurante;

        return $this;
    }
}
