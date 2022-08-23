<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BooksController  extends AbstractController{


    /**
     * @Route("/serachbooks", name="app_books")
     */
    public function buscarlivros(){

        return $this->render("books.html.twig");

    }

}
