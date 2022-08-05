<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PostController extends AbstractController{

/**
 * @Route("/createPost")
 */

    public function createPost(Request $request, PostRepository $postagemRepository, UserRepository $usuarioRepository){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ( isset( $_POST["postar"] )) {

            $user = $this->getUser();
            $conteudo = $_POST["conteudo"];

            $usuario = $user;


        $post = new Post();
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
