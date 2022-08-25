<?php

namespace App\Entity;

use App\Repository\MensagemRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: MensagemRepository::class)]

    /**
      * @ORM\Table(indexes={@Index(name="criado_em_index", columns={"criado_em"})})
     * @ORM\HasLifecycleCallbacks()
     */
    #[ORM\HasLifecycleCallbacks]
class Mensagem
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @ORM\Column(type="text")
     */
    #[ORM\Column]
    private $conteudo;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="mensagens")
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mensagens')]
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Conversa", inversedBy="mensagens")
     */

    #[ORM\ManyToOne(targetEntity: Conversa::class, inversedBy: 'mensagens')]
    private $conversa;

    private $mine;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConteudo(): ?string
    {
        return $this->conteudo;
    }

    public function setConteudo(string $conteudo): self
    {
        $this->conteudo = $conteudo;

        return $this;
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


     /**
     * @return mixed
     */
    public function getMine()
    {
        return $this->mine;
    }

    /**
     * @param mixed $mine
     */
    public function setMine($mine): void
    {
        $this->mine = $mine;
    }
}
