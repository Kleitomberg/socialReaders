<?php

namespace App\Controller;

use App\Service\Dto\Book\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Dto\Book\GetBookResponse;
use App\Repository\UserRepository;
use App\Service\Books\GetBooks;

class BooksController  extends AbstractController{


    /**
     * @Route("/serachbooks", name="app_books")
     */
    public function buscarlivros(GetBooks $getBooks, UserRepository $userRepository){

          /* @var $getBookResponse GetBookResponse */

          $useronline = $this->getUser()->getUserIdentifier();

          $myuser = $userRepository->findOneBy(array('email' => $useronline));

          $mybooksId = $myuser->getFavoritesBooks();

          $arraylivros = array();

          foreach ($mybooksId as &$bookid) {
            $url = "https://www.googleapis.com/books/v1/volumes/".$bookid;
            $jsonresponse = file_get_contents($url);
            $data = json_decode($jsonresponse);

            array_push($arraylivros, $data);
          }




          if(isset($_POST['books']) || isset($_POST['searchbooks'])){
            $titulo =$_POST['books'];

            $getBookResponse = $getBooks($titulo);
            $books = $getBookResponse->getBook();


            return $this->render("books.html.twig",[
                'books'=>$books,
                'livrosfavoristo'=>$arraylivros
            ]);

          }


        return $this->render("books.html.twig",[
            'books'=>"",
            'livrosfavoristo'=>$arraylivros
        ]);

    }

    /**
     * @Route("/book/{id}", name="app_books_detail")
     */

    public function bookDetail($id){

        $url = "https://www.googleapis.com/books/v1/volumes/".$id;

        $jsonresponse = file_get_contents($url);
        $data = json_decode($jsonresponse);


        //recuperando dados da api

        $title = $data->volumeInfo->title;

        $description = $data->volumeInfo->description;
        $thumbnail = $data->volumeInfo->imageLinks->thumbnail;
        $autores = $data->volumeInfo->authors;
        $id = $data->id;

        //criando objeto book
        $livro = new Book();

        //setando valores vindo da requisição api
        if($title){
            $livro->setTitulo($title);
        }



        if($description){
            $livro->setDescription(strip_tags($description));
        }

        if($thumbnail){
            $livro->setThumb($thumbnail);
        }

        if($autores){
            $livro->setAutors($autores);
        }

        if($id){
            $livro->setId($id);
        }



        return $this->render("booksdetails.html.twig",[
            'livro'=>$livro,
        ]);

    }

    /**
     * @Route("/favorite/{id}", name="app_books_favorite")
     */
    public function favoritarBook($id, UserRepository $userRepository, EntityManagerInterface $em){

        $useronline = $this->getUser()->getUserIdentifier();

        $myuser = $userRepository->findOneBy(array('email' => $useronline));

        $myfavs = $myuser->getFavoritesBooks();


        $livroID = array();

        if (in_array($id, $myfavs)) {

            $key = array_search($id, $myfavs);

            unset($myfavs[$key]);

        }else{
            array_push($myfavs, $id);
        }



        $myuser->setFavoritesBooks($myfavs);
        $em->flush();


        return $this->redirectToRoute("app_books_detail", array('id' => $id));

    }

}
