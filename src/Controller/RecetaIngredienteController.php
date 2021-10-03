<?php

namespace App\Controller;

use App\Entity\RecetaIngrediente;
use App\Entity\Receta;
use App\Form\RecetaIngredienteType;
use App\Repository\RecetaIngredienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recetaingrediente")
 */
class RecetaIngredienteController extends AbstractController
{
    /**
     * @Route("/", name="receta_ingrediente_index", methods={"GET"})
     */
    public function index(RecetaIngredienteRepository $recetaIngredienteRepository): Response
    {
        return $this->render('receta_ingrediente/index.html.twig', [
            'receta_ingredientes' => $recetaIngredienteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="receta_ingrediente_new", methods={"GET","POST"})
     */
    public function new(Request $request, Receta $receta): Response
    {
        $recetaIngrediente = new RecetaIngrediente();
        $recetaIngrediente->setReceta($receta);
        $form = $this->createForm(RecetaIngredienteType::class, $recetaIngrediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recetaIngrediente);
            $entityManager->flush();

            return $this->render('receta/ingredientes.html.twig', [
                'receta' => $receta,
                'usuario' => $this->getUser()
            ]);
        }

        return $this->render('receta_ingrediente/new.html.twig', [
            'receta_ingrediente' => $recetaIngrediente,
            'form' => $form->createView(),
            'receta' => $receta,
            'usuario' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}", name="receta_ingrediente_show", methods={"GET"})
     */
    public function show(RecetaIngrediente $recetaIngrediente): Response
    {
        return $this->render('receta_ingrediente/show.html.twig', [
            'receta_ingrediente' => $recetaIngrediente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="receta_ingrediente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RecetaIngrediente $recetaIngrediente): Response
    {
        $form = $this->createForm(RecetaIngredienteType::class, $recetaIngrediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('receta_ingrediente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('receta_ingrediente/edit.html.twig', [
            'receta_ingrediente' => $recetaIngrediente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="receta_ingrediente_delete", methods={"POST"})
     */
    public function delete(Request $request, RecetaIngrediente $recetaIngrediente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recetaIngrediente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recetaIngrediente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('receta_ingredientes', ['id' => $recetaIngrediente->getReceta()->getId()], Response::HTTP_SEE_OTHER);
    }
}
