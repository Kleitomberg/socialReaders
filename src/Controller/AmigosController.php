<?php

namespace App\Controller;

use App\Entity\Amigos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SolicitacaoAmizade;

use App\Repository\SolicitacaoAmizadeRepository;

use App\Repository\UserRepository;
use DateTime;
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
        dump($arrayAmigos);

        //$arrayobjeto = $arrayFriends;
        //dump($arrayobjeto);
if($solicitacoes){
        $usersolicitante = $userRepository->findBy(
            array(
            'id'=> $solicitacoes[0]->getIdSolicitante()->getId()
        ));

        //dump($solicitacoes);
        $solicitantee=[];
        foreach ($solicitacoes as &$idsol) {
            dump($idsol->getIdSolicitante());
             array_push($solicitantee, $idsol->getIdSolicitante());

         }
         dump($solicitantee);

       // dump($usersolicitante);

        return $this->render("amigos/listar.html.twig",[
            "myfriends" => $arrayAmigos,
            'frindssearch'=>'',
            'solicitacoes'=>$solicitacoes,
            'solicitante'=>$solicitantee
        ]);
    }else{
        $usersolicitante=[];
        return $this->render("amigos/listar.html.twig",[
            "myfriends" => $arrayAmigos,
            'frindssearch'=>'',
            'solicitacoes'=>$solicitacoes,

        ]);
    }

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
                'myfriends'=>'',
                'solicitacoes'=>""

            ]);

        }

        return new Response('Erro');
       // return $this->redirectToRoute("app_serachamigos",);


    }

     /**
         * @Route("/addamigos", name="app_addamimgos")
         */

    public function addAmigos(SolicitacaoAmizadeRepository $solicitacaoAmizadeRepository, UserRepository $userRepository){

        if(isset($_POST["amizade"])){



            $data_solicitacao =date('y-m-d h:i:s');
            dump($data_solicitacao);
            $data_confirmacao =date('d/m/Y');
            $situacao = 0;
            $solicitante = $_POST["meuid"];
            dump($solicitante);
            $solicitado =$_POST["userid"];
            dump($solicitado);
            $friend = $userRepository->findOneBy(array(
                'id' => $solicitado
                )
            );

            $eu = $userRepository->findOneBy(array(
                'id' => $solicitante
                )
            );

            $newformat = strtotime($data_solicitacao);

            $amizade = new SolicitacaoAmizade();

            $amizade->setSituacao($situacao);
            $amizade->setIdSolicitante($eu);
            $amizade->setIdSolicitado($friend);
            dump($data_solicitacao);
            //$amizade->setDataSolicitacao($data_solicitacao);
            //$amizade->setDataSolicitacao($newformat, bool $a= false);

            $solicitacaoAmizadeRepository->add($amizade, true);


            return $this->redirectToRoute('app_amigos');

        }

        return new Response("FALHA NO PROCESSAMENTO");


    }

    public function confirmSolicitacao(){

    }


}
