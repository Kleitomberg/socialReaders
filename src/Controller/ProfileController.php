<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SolicitacaoAmizadeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class ProfileController extends AbstractController{



    public function profilePage($username,PostRepository $postRepository, SolicitacaoAmizadeRepository $solicitacaoAmizadeRepository, UserRepository $userRepository, ){

        $user = $this->getUser()->getUserIdentifier();
        //dump($user);
        $solicitante = $userRepository->findOneBy(array('email' => $user));
        $id_solicitante = $solicitante->getId();

        $meusposts = $postRepository->findBy(
            array('usuario'=>$solicitante)
        );

        $myFbooks = $solicitante->getFavoritesBooks();

       // dump($meusposts);

        $id_solicitante_strng = (string)$id_solicitante;


            //dump($id_solicitante_strng);

            $solicitacoes = $solicitacaoAmizadeRepository->findBy(

                array('id_solicitado' => $id_solicitante_strng, 'situacao' => 0,)

            );




            if($id_solicitante==$id_solicitante_strng){

            $amigos = $solicitacaoAmizadeRepository->findBy(

                array('id_solicitante' => $id_solicitante_strng, 'situacao' => 1,)

            );

        }else{

            $amigos = $solicitacaoAmizadeRepository->findBy(

                array('id_solicitado' => $id_solicitante_strng, 'situacao' => 1,)

            );
        }


            $array = [];
            $arrayFriends = [];
            foreach ($amigos as &$amigo) {
               $friend = array($amigo->getIdSolicitado()->getId());
              // array_push($array, $friend);
               //dump($array);




            $meusamigos = $userRepository->findBy(

                array('id' => $friend,

                )

            );

            array_push($arrayFriends, $meusamigos);


        }

        $arrayAmigos=[];
        foreach ($arrayFriends as &$af) {
           // dump($af[0]);
            array_push($arrayAmigos, $af[0]);

        }
       // dump($arrayAmigos);

        return $this->render('profile.html.twig',[
            "paginetitle"=>"profile",
            "myfriends" => $arrayAmigos,
            'myposts'=>$meusposts,
            'myFbooks'=>$myFbooks,
        ]);
    }


}
