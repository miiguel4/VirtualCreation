<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogRepository::class)
 */
class Log
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
    private $Accion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccion(): ?string
    {
        return $this->Accion;
    }

    public function setAccion(string $Accion): self
    {
        $this->Accion = $Accion;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->Fecha;
    }

    public function setFecha(string $Fecha): self
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
