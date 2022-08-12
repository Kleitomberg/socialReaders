<?php

namespace App\Controller;

use App\Entity\Amigos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SolicitacaoAmizade;

use App\Repository\SolicitacaoAmizadeRepository;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class AmigosController extends AbstractController{


    /**
         * @Route("/amigos", name="app_amigos")
         */

    public function listaramigos(SolicitacaoAmizadeRepository $solicitacaoAmizadeRepository, UserRepository $userRepository){

        $user = $this->getUser()->getUserIdentifier();
        dump($user);
        $solicitante = $userRepository->findOneBy(array('email' => $user));
        $id_solicitante = $solicitante->getId();

        $id_solicitante_strng = (string)$id_solicitante;


            dump($id_solicitante_strng);

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
        dump($arrayAmigos);

        //$arrayobjeto = $arrayFriends;
        //dump($arrayobjeto);

        return $this->render("amigos/listar.html.twig",[
            "myfriends" => $arrayAmigos
        ]);
    }



    /**
         * @Route("/buscaramigos", name="app_serachamigos")
         */


    public function buscarAmigos(SolicitacaoAmizadeRepository $solicitacaoAmizadeRepository, UserRepository $userRepository){



        if ( isset( $_POST["friends"] ))
        {
            $amigobusca = $_POST['friends'];

            dump($amigobusca);

            $serachfriend = $userRepository->findBy(

                array('nome' => (string)$amigobusca,

                )

            );
            dump($serachfriend);

            return $this->render("amigos/listar.html.twig",[
                'frindssearch'=>$serachfriend,
                'myfriends'=>''

            ]);

        }

        return new Response('Erro');
       // return $this->redirectToRoute("app_serachamigos",);


    }


}
