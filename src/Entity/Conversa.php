<?php

namespace App\Entity;

use App\Repository\ConversaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: ConversaRepository::class)]

/**
 * @ORM\Table(indexes={@Index(name="ultima_Mensagem_id_index", columns={"ultima_Mensagem_id"})})
 */

class Conversa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    /**
     * @ORM\OneToMany(targetEntity="Participante", mappedBy="conversa")
     */
    #[ORM\OneToMany(targetEntity: Participante::class, mappedBy: 'conversa')]
    private $participantes;

     /**
     * @ORM\OneToOne(targetEntity="Mensagem")
     * @ORM\JoinColumn(name="ultima_Mensagem_id", referencedColumnName="id")
     */
    #[ORM\OneToOne(targetEntity: Mensagem::class)]
    #[ORM\JoinColumn(name: "ultima_Mensagem_id", referencedColumnName: "id")]
    private $ultimaMensagem;

    /**
     * @ORM\OneToMany(targetEntity="Mensagem", mappedBy="conversa")
     */
    #[ORM\OneToMany(targetEntity: Mensagem::class, mappedBy: 'conversa')]

    private $mensagens;


    //construtor

    public function __construct()
    {
        $this->participantes = new ArrayCollection();
        $this->mensagens = new ArrayCollection();
    }

    //metodos

    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * @return Collection|Participante[]
     */
    public function getParticipantes(): Collection
    {
        return $this->participantes;
    }

    public function addParticipant(Participante $participante): self
    {
        if (!$this->participantes->contains($participante)) {
            $this->participantes[] = $participante;
            $participante->setConversa($this);
        }

        return $this;
    }

    public function removeParticipant(Participante $participante): self
    {
        if ($this->participantes->contains($participante)) {
            $this->participantes->removeElement($participante);
            // set the owning side to null (unless already changed)
            if ($participante->getConversa() === $this) {
                $participante->setConversa(null);
            }
        }

        return $this;
    }

    public function getUltimaMensagem(): ?Mensagem
    {
        return $this->ultimaMensagem;
    }

    public function setUltimaMensagem(?Mensagem $ultimaMensagem): self
    {
        $this->ultimaMensagem = $ultimaMensagem;

        return $this;
    }

    /**
     * @return Collection|Mensagem[]
     */
    public function getMensagem(): Collection
    {
        return $this->mensagens;
    }

    public function addMessage(Mensagem $mensagem): self
    {
        if (!$this->mensagens->contains($mensagem)) {
            $this->mensagens[] = $mensagem;
            $mensagem->setConversa($this);
        }

        return $this;
    }

    public function removeMessage(Mensagem $mensagem): self
    {
        if ($this->mensagens->contains($mensagem)) {
            $this->mensagens->removeElement($mensagem);
            // set the owning side to null (unless already changed)
            if ($mensagem->getConversa() === $this) {
                $mensagem->setConversa(null);
            }
        }

        return $this;
    }
}
