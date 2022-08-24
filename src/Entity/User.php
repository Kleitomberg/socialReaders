<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\ManyToMany(targetEntity: Amigos::class, mappedBy: 'id_solicitante')]
    private Collection $amigos;

    #[ORM\Column(length: 255, nullable: true)]
    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg", "image/jpg" })
     */
    private ?string $imageprofile = null;

    #[ORM\Column(nullable: true)]
    private array $favoritesBooks = [];


    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->amigos = new ArrayCollection();
    }

    public function __toString()
    {
       return strval( $this->getNome() );
    }




    public function getId(): ?int
    {
        return $this->id;
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

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }
    public function getNome(): ?string
    {
        return $this->nome;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */

    public function getIdentificdorUnique(): ?int
    {
        return $this->id;
    }

       /**
     * @see UserInterface
     */

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     * @return string the hashed password for this user
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUsuario($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUsuario() === $this) {
                $post->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Amigos>
     */
    public function getAmigos(): Collection
    {
        return $this->amigos;
    }

    public function addAmigo(Amigos $amigo): self
    {
        if (!$this->amigos->contains($amigo)) {
            $this->amigos->add($amigo);
            $amigo->addIdSolicitante($this);
        }

        return $this;
    }

    public function removeAmigo(Amigos $amigo): self
    {
        if ($this->amigos->removeElement($amigo)) {
            $amigo->removeIdSolicitante($this);
        }

        return $this;
    }

    public function getImageprofile(): ?string
    {
        return $this->imageprofile;
    }

    public function setImageprofile(?string $imageprofile): self
    {
        $this->imageprofile = $imageprofile;

        return $this;
    }

    public function getFavoritesBooks(): array
    {
        return $this->favoritesBooks;
    }

    public function setFavoritesBooks(?array $favoritesBooks): self
    {
        $this->favoritesBooks = $favoritesBooks;

        return $this;
    }




}
