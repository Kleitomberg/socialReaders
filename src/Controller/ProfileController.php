<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController{



    public function profilePage($username){

        return $this->render('profile.html.twig',[
            "paginetitle"=>"profile"
        ]);
    }


}
