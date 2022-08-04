<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $senha = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Postagem::class)]
    private Collection $postagens;

    public function __construct()
    {
        $this->postagens = new ArrayCollection();
    }

    public function __toString()
    {
       return strval( $this->getNome() );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * @return Collection<int, Postagem>
     */
    public function getPostagens(): Collection
    {
        return $this->postagens;
    }

    public function addPostagen(Postagem $postagen): self
    {
        if (!$this->postagens->contains($postagen)) {
            $this->postagens->add($postagen);
            $postagen->setUsuario($this);
        }

        return $this;
    }

    public function removePostagen(Postagem $postagen): self
    {
        if ($this->postagens->removeElement($postagen)) {
            // set the owning side to null (unless already changed)
            if ($postagen->getUsuario() === $this) {
                $postagen->setUsuario(null);
            }
        }

        return $this;
    }
}
