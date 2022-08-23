<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\ImageUpload;


use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class UserController extends AbstractController{


        /**
         * @Route("/criarUser", name="app_cadastro")
         */

    public function criarUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils, ImageUpload $imageUpload){

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

    public function editUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils, EntityManagerInterface $em,SluggerInterface $slugger, ImageUpload $imageUpload)
    {

        if(isset($_POST['editarusuario'])){



            $username = $_POST['nome'];
            $email = $_POST['email'];
            $foto = $_FILES['imageprofile'] ['name'];
            $ffoto = $_FILES['imageprofile'];



            $useronline = $this->getUser()->getUserIdentifier();

            $myuser = $userRepository->findOneBy(array('email' => $useronline));



                if($foto){

                    $ext = explode('.', $foto);// get the extension of the file
                    $tamanho = count($ext);
                    dump($ext[$tamanho-1]);
                    $newname = $username.$ext[0]."profile.".$ext[$tamanho-1];

                    $g =  $this->getParameter('images_directory');
                    $target = $g.$newname;

                    dump($g);
                    dump($target);
                    move_uploaded_file( $_FILES['imageprofile']['tmp_name'], $target);
                    //move_uploaded_file($foto, $target);





                    //$fotof = File($foto);
                   // $fotoFileName = $imageUpload->upload($foto);
                    $myuser->setImageprofile($newname);

                }






            dump($foto);


            $myuser->setNome($username);
            $myuser->setEmail($email);
            $em->flush();



            return $this->redirectToRoute("profile",array('username' => $myuser->getNome()));

        }


        return $this->render("login/useredit.html.twig");
    }

                public function getTargetDirectory()
                {
                    return $this->targetDirectory;
                }
}
