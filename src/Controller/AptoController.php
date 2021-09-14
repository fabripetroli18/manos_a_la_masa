<?php

namespace App\Controller;

use App\Entity\Apto;
use App\Form\AptoType;
use App\Repository\AptoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apto")
 */
class AptoController extends AbstractController
{
    /**
     * @Route("/", name="apto_index", methods={"GET"})
     */
    public function index(AptoRepository $aptoRepository): Response
    {
        return $this->render('apto/index.html.twig', [
            'aptos' => $aptoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="apto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apto = new Apto();
        $form = $this->createForm(AptoType::class, $apto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apto);
            $entityManager->flush();

            return $this->redirectToRoute('apto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('apto/new.html.twig', [
            'apto' => $apto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="apto_show", methods={"GET"})
     */
    public function show(Apto $apto): Response
    {
        return $this->render('apto/show.html.twig', [
            'apto' => $apto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="apto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Apto $apto): Response
    {
        $form = $this->createForm(AptoType::class, $apto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('apto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('apto/edit.html.twig', [
            'apto' => $apto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="apto_delete", methods={"POST"})
     */
    public function delete(Request $request, Apto $apto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('apto_index', [], Response::HTTP_SEE_OTHER);
    }
}
