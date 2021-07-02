<?php

namespace App\Controller;

use App\Entity\Externo;
use App\Form\ExternoType;
use App\Form\ExternoEType;
use App\Repository\ExternoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/externo')]
class ExternoController extends AbstractController
{
    #[Route('/', name: 'externo_index', methods: ['GET'])]
    public function index(ExternoRepository $externoRepository): Response
    {
        return $this->render('externo/index.html.twig', [
            'externos' => $externoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'externo_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $externo = new Externo();
        $form = $this->createForm(ExternoType::class, $externo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($externo);
            $entityManager->flush();

            return $this->redirectToRoute('externo_index');
        }

        return $this->render('externo/new.html.twig', [
            'externo' => $externo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/newe', name: 'externo_newe', methods: ['GET', 'POST'])]
    public function newe(Request $request): Response
    {
        $externo = new Externo();
        $form = $this->createForm(ExternoEType::class, $externo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $externo->setExternoAdmin(False);
            $externo->setExternoActivo(False);
           
            $entityManager->persist($externo);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('externo/new.html.twig', [
            'externo' => $externo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'externo_show', methods: ['GET'])]
    public function show(Externo $externo): Response
    {
        return $this->render('externo/show.html.twig', [
            'externo' => $externo,
        ]);
    }

    #[Route('/{id}/edit', name: 'externo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Externo $externo): Response
    {
        $form = $this->createForm(ExternoType::class, $externo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('externo_index');
        }

        return $this->render('externo/edit.html.twig', [
            'externo' => $externo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'externo_delete', methods: ['POST'])]
    public function delete(Request $request, Externo $externo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$externo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($externo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('externo_index');
    }
}
