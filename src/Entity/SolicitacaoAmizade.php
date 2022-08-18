<?php

namespace App\Entity;

use App\Repository\SolicitacaoAmizadeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: SolicitacaoAmizadeRepository::class)]

class SolicitacaoAmizade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $situacao = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_solicitacao = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_confirmacao = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $id_solicitante = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $id_solicitado = null;

    public function __construct()
    {
        $this->setDataSolicitacao(new \DateTime());
        //$this->setAtualizadoEm(new \DateTime());

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSituacao(): ?bool
    {
        return $this->situacao;
    }

    public function setSituacao(bool $situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    public function getDataSolicitacao(): ?\DateTimeInterface
    {
        return $this->data_solicitacao;
    }

    public function setDataSolicitacao(\DateTimeInterface $data_solicitacao): self
    {
        $this->data_solicitacao = $data_solicitacao;

        return $this;
    }

    public function getDataConfirmacao(): ?\DateTimeInterface
    {
        return $this->data_confirmacao;
    }

    public function setDataConfirmacao(\DateTimeInterface $data_confirmacao): self
    {
        $this->data_confirmacao = $data_confirmacao;

        return $this;
    }

    public function getIdSolicitante(): ?User
    {
        return $this->id_solicitante;
    }

    public function setIdSolicitante(?User $id_solicitante): self
    {
        $this->id_solicitante = $id_solicitante;

        return $this;
    }

    public function getIdSolicitado(): ?User
    {
        return $this->id_solicitado;
    }

    public function setIdSolicitado(?User $id_solicitado): self
    {
        $this->id_solicitado = $id_solicitado;

        return $this;
    }
}
