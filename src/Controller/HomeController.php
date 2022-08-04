<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Postagem;

use App\Repository\PostagemRepository;

class HomeController extends AbstractController{

    /**
     *
     *
     * @Route("/", name="home")
     */
    public function Indexpage(PostagemRepository $postagemRepository){

        $postagens = $postagemRepository->findAll();
        return $this->render("index.html.twig",[
            "postagens"=>$postagens

        ]);
    }


}
