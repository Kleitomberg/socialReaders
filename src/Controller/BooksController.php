<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Dto\Book\GetBookResponse;
use App\Service\Books\GetBooks;

class BooksController  extends AbstractController{


    /**
     * @Route("/serachbooks", name="app_books")
     */
    public function buscarlivros(GetBooks $getBooks){

          /* @var $getBookResponse GetBookResponse */

          if(isset($_POST['books']) || isset($_POST['searchbooks'])){
            $titulo =$_POST['books'];
            dump($titulo);
            $getBookResponse = $getBooks($titulo);
            $books = $getBookResponse->getBook();


            return $this->render("books.html.twig",[
                'books'=>$books
            ]);

          }


        return $this->render("books.html.twig",[
            'books'=>""
        ]);

    }

}
