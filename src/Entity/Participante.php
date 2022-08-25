<?php

namespace App\Entity;

use App\Repository\ParticipanteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipanteRepository::class)]
class Participante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="participantes")
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'participantes')]
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Conversa", inversedBy="participantes")
     */
    #[ORM\ManyToOne(targetEntity: Conversa::class, inversedBy: 'participantes')]
    private $conversa;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getConversa(): ?Conversa
    {
        return $this->conversa;
    }

    public function setConversa(?Conversa $conversa): self
    {
        $this->conversa = $conversa;

        return $this;
    }
}
