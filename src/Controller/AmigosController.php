<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AmigosController extends AbstractController{


    /**
         * @Route("/amigos", name="app_amigos")
         */

    public function listaramigos(){


        return $this->render("amigos/listar.html.twig");
    }


}
