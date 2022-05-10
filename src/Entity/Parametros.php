<?php

namespace App\Entity;

use App\Repository\ParametrosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametrosRepository::class)
 */
class Parametros
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $Datastore;

    /**
     * @ORM\Column(type="integer")
     */
    private $CPU;

    /**
     * @ORM\Column(type="integer")
     */
    private $Memoria;

    /**
     * @ORM\Column(type="text")
     */
    private $SistemaOperativo;

    /**
     * @ORM\Column(type="text")
     */
    private $Nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $AdaptadorRed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatastore(): ?string
    {
        return $this->Datastore;
    }

    public function setDatastore(string $Datastore): self
    {
        $this->Datastore = $Datastore;

        return $this;
    }

    public function getCPU(): ?int
    {
        return $this->CPU;
    }

    public function setCPU(int $CPU): self
    {
        $this->CPU = $CPU;

        return $this;
    }

    public function getMemoria(): ?int
    {
        return $this->Memoria;
    }

    public function setMemoria(int $Memoria): self
    {
        $this->Memoria = $Memoria;

        return $this;
    }

    public function getSistemaOperativo(): ?string
    {
        return $this->SistemaOperativo;
    }

    public function setSistemaOperativo(string $SistemaOperativo): self
    {
        $this->SistemaOperativo = $SistemaOperativo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getAdaptadorRed(): ?string
    {
        return $this->AdaptadorRed;
    }

    public function setAdaptadorRed(?string $AdaptadorRed): self
    {
        $this->AdaptadorRed = $AdaptadorRed;

        return $this;
    }
}
