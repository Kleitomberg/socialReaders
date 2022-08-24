<?php

namespace App\Controller;

use App\Dto\Book\Book;
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

    /**
     * @Route("/book/{id}", name="app_books_detail")
     */

    public function bookDetail($id){

        $url = "https://www.googleapis.com/books/v1/volumes/".$id;

        $jsonresponse = file_get_contents($url);
        $data = json_decode($jsonresponse);
        //var_dump($data->title);

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

        //var_dump($livro);

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
        dump($myfavs);

        $livroID = array();

        if (in_array($id, $myfavs)) {
            dump("Já existe!");
            $key = array_search($id, $myfavs);
            dump($key);
            unset($myfavs[$key]);
            //$myfavs = $myfavs;
        }else{
            array_push($myfavs, $id);
        }



        $myuser->setFavoritesBooks($myfavs);
        $em->flush();


        return $this->redirectToRoute("app_books_detail", array('id' => $id));

    }

}
