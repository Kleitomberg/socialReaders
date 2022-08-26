<?php
/*
namespace App\Service\Books;
use App\Dto\Book;
use App\Exception\HttpRequestException;
use Symfony\Component\HttpFoundation\Response;



use App\Dto\Book\GetBookResponse;


class GetBooks{

    public function __invoke($titulo): GetBookResponse
    {
        $url = "https://www.googleapis.com/books/v1/volumes?q=".$titulo;
        $response = $this->httpClient->get($url);
        dump($url);

        $statusCode = $response->getStatusCode();

        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();

        $json = json_decode($content,true);

        $getBookResponse = new GetBookResponse();

        $item = $json["resposta"];

        $book = new Book();
        $book->setTitulo(@$item['title']);
        $book->setSubtitle(@$item['subtitle']);
        $book->setDescription(@$item['description']);
        $book->setThumb(@$item['imageLinks']);
        $book->setId(@$item['id']);
        $book->setAutors(@$item['authors']);


        $getBookResponse->setBook($book);

        return $getBookResponse;


    }

}
*/
