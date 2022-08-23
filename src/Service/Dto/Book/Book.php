<?php

namespace App\Dto\Book;

class Book{

    /**
     * @var $titulo string|null
     */
    private $titulo;

    /**
     * @var $subtitle string | null
     */
    private $subtitle;


     /**
     * @var $description string
     */
    private $description;

    /**
     * @var $id integer
     */
    private $id;

     /**
     * @var $autors string
     */
    private $autors;

      /**
     * @var $thumb string
     */
    private $thumb;


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $titulo
     */

     //titulo
    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    //subtitle
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    //description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
//autors

public function getAutors(): ?string
{
    return $this->autors;
}

public function setAutors(string $autors): void
{
    $this->autors = $autors;
}

//thumb
public function getThumb(): ?string
{
    return $this->thumb;
}

public function setThumb(string $thumb): void
{
    $this->thumb = $thumb;
}


}
