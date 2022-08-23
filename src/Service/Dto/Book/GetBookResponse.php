<?php

namespace App\Dto\Book;

class GetBookResponse
{
    /**
     * @var $book Book|null
     */
    private $book;

    /**
     * @return Book|null
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * @param Book|null $book
     */
    public function setBook(?Book $book): void
    {
        $this->book = $book;
    }

}
