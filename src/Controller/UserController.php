<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class UserController extends AbstractController{


        /**
         * @Route("/criarUser", name="app_cadastro")
         */

    public function criarUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils){

        if ( isset( $_POST["cadastrar"] )) {

            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $senha = $_POST["password"];


        $usuario = new User();
        $usuario->setEmail($email);
        $usuario->setNome($nome);
        $usuario->setPassword($senha);


        $hashedPassword = $passwordHasher->hashPassword(
            $usuario,
            $senha
        );
        $usuario->setPassword($hashedPassword);



        $userRepository->add($usuario, true);


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();




        return $this->render('login/index.html.twig', [

            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
        }//end if
        return new Response('ERRO');
    }

        /**
         * @Route("/editarUser", name="app_useredit")
         */

    public function editUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils)
    {


        return $this->render("login/useredit.html.twig");
    }
}
