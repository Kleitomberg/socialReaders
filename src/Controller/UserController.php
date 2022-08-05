<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController{


        /**
         * @Route("/criarUser", name="app_cadastro")
         */

    public function criarUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher){

        if ( isset( $_POST["cadastrar"] )) {

            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $senha = $_POST["password"];






        $plaintextPassword = "...";
        $usuario = new User();
        $usuario->setEmail($email);
        $usuario->setNome($nome);
        $usuario->setPassword($senha);


        $hashedPassword = $passwordHasher->hashPassword(
            $usuario,
            $plaintextPassword
        );
        $usuario->setPassword($hashedPassword);



        $userRepository->add($usuario, true);


        return new Response("Criou");
        }//end if
        return new Response('ERRO');
    }
}
