<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CadastroController extends AbstractController{

/**
 * @Route("/cadastro", name="cadastro")
 */
    public function criarUser(){


        return $this->render("login/cadastro.twig");

    }

}
