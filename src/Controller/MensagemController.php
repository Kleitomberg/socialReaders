<?php

namespace App\Controller;

use App\Entity\Conversa;
use App\Entity\Mensagem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\MensagemRepository;
use App\Repository\ConversaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mensagens", name="mensagens.")
 */
class MensagemController extends AbstractController{

    /**
     *
     * @var UserRepository
     */
    private $userRepository;

      /**
     *
     * @var MensagemRepository
     */
    private $mensagemRepository;

      /**
     *
     * @var EntityManagerInterface
     */
    private $em;

     /**
     *
     * @var ConversaRepository
     */
    private $conversaRepository;

    public function __construct(EntityManagerInterface $em, MensagemRepository $mensagemRepository, UserRepository $userRepository, ConversaRepository $conversaRepository)
    {
        $this->em = $em;
        $this->mensagemRepository = $mensagemRepository;
        $this->userRepository= $userRepository;
        $this->conversaRepository = $conversaRepository;

    }


    /**
     * @Route("/{id}", name="lista")
     */
    public function indexMensagem(Request $request, Conversa $conversa, Mensagem $mensagem){

       // $this -> denyAccessUnlessGranted ( 'view' , $conversa );

        $mymensagens = $this->mensagemRepository->findMessageByConversationId(
            $conversa->getId()
        );

        dump($mymensagens);

        $user = $this->getUser()->getUserIdentifier();
        $eu = $this->userRepository->findOneBy(array('email' => $user));
        $myId = $eu->getId();
        $minhasConversas = $this->conversaRepository->findConversationsByUser($myId);

         /**
         * @var $mensagem Mensagem
         */
        array_map(function ($mensagem) {
            $user = $this->getUser()->getUserIdentifier();
            $eu = $this->userRepository->findOneBy(array('email' => $user));
            $myId = $eu->getId();
            $mensagem->setMine(

                $mensagem->getUsuario()->getId() === $myId ? true : false);
        }, $mymensagens);

        return $this->render("chat/conversa.twig",[
            'mensagens'=>$mymensagens,
            "conversas"=>$minhasConversas,
        ]);

    }

     /**
     * @Route("/enviar/{id}", name="enviar", methods={"POST"})
     */
    public function sendMensagem(Request $request, Conversa $conversa){

        if( isset($_POST['conteudo']) ){


            // TODO: put everything back
            $user = $this->getUser()->getUserIdentifier();
            $eu = $this->userRepository->findOneBy(array('email' => $user));
            $myId = $eu->getId();

         $content = $_POST['conteudo'];
            dump($content);
        $mensagem = new Mensagem();
        $mensagem->setConteudo($content);
        $mensagem->setUsuario($this->userRepository->findOneBy(['id' => $myId]));
        $mensagem->setMine(true);

        $conversa->addMessage($mensagem);
        $conversa->setUltimaMensagem($mensagem);

        $this->em->getConnection()->beginTransaction();
        try {
            $this->em->persist($mensagem);
            $this->em->persist($conversa);
            $this->em->flush();
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

        $cinversaId = $request->get("id");

        return $this->redirectToRoute("mensagens.lista",["id"=>$cinversaId]);
        }

    }


}
