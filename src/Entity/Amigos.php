<?php

namespace App\Entity;

use App\Repository\AmigosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmigosRepository::class)]
class Amigos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'amigos')]
    private Collection $id_solicitante;

    public function __construct()
    {
        $this->id_solicitante = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdSolicitante(): Collection
    {
        return $this->id_solicitante;
    }

    public function addIdSolicitante(User $idSolicitante): self
    {
        if (!$this->id_solicitante->contains($idSolicitante)) {
            $this->id_solicitante->add($idSolicitante);
        }

        return $this;
    }

    public function removeIdSolicitante(User $idSolicitante): self
    {
        $this->id_solicitante->removeElement($idSolicitante);

        return $this;
    }
}
