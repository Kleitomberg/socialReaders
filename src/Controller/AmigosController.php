<?php

namespace App\Controller;

use App\Entity\Amigos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SolicitacaoAmizade;

use App\Repository\SolicitacaoAmizadeRepository;

use App\Repository\UserRepository;

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
            $amigos = $solicitacaoAmizadeRepository->findBy(

                array('id_solicitante' => $id_solicitante_strng, 'situacao' => 1,

                )

            );

            foreach ($amigos as &$amigo) {
                $amigo->getIdSolicitado()->getId();
                dump($amigo);

                $meusamigos = $userRepository->findBy(

                    array('id' => $amigo,

                    )

                );


            }




            //dump($amigos[0]->getIdSolicitado()->getId());
            dump($meusamigos);


        return $this->render("amigos/listar.html.twig");
    }


}
