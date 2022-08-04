<?php

namespace App\Controller;

use App\Entity\Postagem;
use App\Form\PostagemType;
use App\Repository\PostagemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/postagem')]
class PostagemController extends AbstractController
{
    #[Route('/', name: 'app_postagem_index', methods: ['GET'])]
    public function index(PostagemRepository $postagemRepository): Response
    {
        return $this->render('postagem/index.html.twig', [
            'postagems' => $postagemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_postagem_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostagemRepository $postagemRepository): Response
    {
        $postagem = new Postagem();
        $form = $this->createForm(PostagemType::class, $postagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postagemRepository->add($postagem, true);

            return $this->redirectToRoute('app_postagem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postagem/new.html.twig', [
            'postagem' => $postagem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postagem_show', methods: ['GET'])]
    public function show(Postagem $postagem): Response
    {
        return $this->render('postagem/show.html.twig', [
            'postagem' => $postagem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_postagem_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Postagem $postagem, PostagemRepository $postagemRepository): Response
    {
        $form = $this->createForm(PostagemType::class, $postagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postagemRepository->add($postagem, true);

            return $this->redirectToRoute('app_postagem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postagem/edit.html.twig', [
            'postagem' => $postagem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postagem_delete', methods: ['POST'])]
    public function delete(Request $request, Postagem $postagem, PostagemRepository $postagemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postagem->getId(), $request->request->get('_token'))) {
            $postagemRepository->remove($postagem, true);
        }

        return $this->redirectToRoute('app_postagem_index', [], Response::HTTP_SEE_OTHER);
    }
}
