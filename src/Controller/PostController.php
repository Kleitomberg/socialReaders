<?php

namespace App\Controller;

use App\Entity\Postagem;
use App\Entity\Usuario;
use App\Repository\PostagemRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PostController extends AbstractController{

/**
 * @Route("/createPost")
 */

    public function createPost(Request $request, PostagemRepository $postagemRepository, UsuarioRepository $usuarioRepository){


        if ( isset( $_POST["postar"] )) {
            $usuarios = [];
            $conteudo = $_POST["conteudo"];
            $usuarios = $usuarioRepository->findAll();
            $usuario = $usuarios[0];


        $post = new Postagem();
        $post->setConteudo($conteudo);
        $post->setUsuario($usuario);
        $postagemRepository->add($post, true);




        $postagens = $postagemRepository->findAll();

        #return $this->render("index.html.twig", [ "postagens"=>$postagens]);
        return $this->redirectToRoute("home", [ "postagens"=>$postagens], Response::HTTP_SEE_OTHER);
        #return new Response(' Livro Salvo com id '.$livro->getId());

    }
        return new Response(' ERROR');
       // return $this->render("index.html.twig");



    }






}
