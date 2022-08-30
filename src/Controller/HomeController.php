<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Postagem;
use App\Repository\UserRepository;
use App\Repository\ConversaRepository;

use App\Repository\PostRepository;

class HomeController extends AbstractController{

    /**
     *
     *
     * @Route("/", name="home")
     */
    public function Indexpage(PostRepository $postagemRepository, UserRepository $userRepository, ConversaRepository $conversaRepository){

        $user = $this->getUser()->getUserIdentifier();
        $eu = $userRepository->findOneBy(array('email' => $user));
        $myId = $eu->getId();

        $minhasConversas = $conversaRepository->findConversationsByUser($myId);





        $postagens = $postagemRepository->findBy(
            array(),
            array('criado_em' => 'DESC')
          );

          $user = $this->getUser();
        return $this->render("index.html.twig",[
            "postagens"=>$postagens,
            "usuario"=>$user,
            "conversas"=>$minhasConversas

        ]);
    }


}
