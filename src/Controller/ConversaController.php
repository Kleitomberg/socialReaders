<?php

namespace App\Controller;

use App\Entity\Conversa;
use App\Entity\Participante;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Repository\ConversaRepository;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpFoundation\Response;

/**
     * @Route("/conversa", name="conversa.")
     */
class ConversaController extends AbstractController{

      /**
     *
     * @var MensagemRepository
     */
    private $mensagemRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ConversaRepository
     */
    private $conversaRepository;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, ConversaRepository $conversaRepository)
    {
        $this->userRepository = $userRepository;
        $this->em =$em;
        $this->conversaRepository = $conversaRepository;

    }

    /**
     * @Route("/", name="listaConversa")
     */
    public function conversaIndex(Request $request){

        $user = $this->getUser()->getUserIdentifier();
        $eu = $this->userRepository->findOneBy(array('email' => $user));
        $myId = $eu->getId();

        $minhasConversas = $this->conversaRepository->findConversationsByUser($myId);
        $cinversaId = $request->get("id");


        return $this->render("chat/conversa.twig",[
            "conversas"=>$minhasConversas,
            'mensagens'=>"",
            'id'=>$cinversaId
        ]);


    }

    /**
     * @Route("/new", name="CriarConversa")
     */
    public function criarConversa(Request $request){

        if(isset($_POST['chat']) || isset($_POST['idusuario'])){

            $outrosParticipantesId=$_POST['idusuario'];

            $destinatario = $this->userRepository->find($outrosParticipantesId);

            //verifica se exite um destinatario
            if (is_null($destinatario)) {
                throw new \Exception("Erro: Usuario n??o encontrado");

            }

            //verifica se o destinatario ?? igual ao remetente
            $user = $this->getUser()->getUserIdentifier();
            $eu = $this->userRepository->findOneBy(array('email' => $user));
            $myId = $eu->getId();

            if ($destinatario->getId() === $myId) {
                throw new \Exception("Error: Voc?? n??o pode crar conversa com voc?? mesmo");
            }

             // Verifica se a conversa j?? existe
             $conversa = $this->conversaRepository->findConversationByParticipants(
                $destinatario->getId(),
                $myId
        );



        if (count($conversa)) {
            $converID = $conversa;

            return $this->redirectToRoute('conversa.listaConversa');
            throw new \Exception("A Conversa j?? existe");


        }

        //caso contrario n??o ocorra nenhum erro criamos a conversa

        $newConversa = new Conversa();

        $remetente = new Participante();
        $remetente->setUsuario($this->getUser());
        $remetente->setConversa($newConversa);

        $otherParticipant = new Participante();
        $otherParticipant->setUsuario($destinatario);
        $otherParticipant->setConversa($newConversa);


        $this->em->getConnection()->beginTransaction();
        try {


            $this->em->persist($newConversa);
            $this->em->persist($remetente);
            $this->em->persist($otherParticipant);

            $this->em->flush();
            $this->em->commit();

        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;

        }
        $cinversaId = $request->get("id");
        return $this->redirectToRoute("conversa.listaConversa",['id'=>$cinversaId]);

        }



    }


}
