<?php

namespace App\Controller;

use App\Entity\Ingrediente;
use App\Form\IngredienteType;
use App\Repository\IngredienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingrediente")
 */
class IngredienteController extends AbstractController
{
    /**
     * @Route("/", name="ingrediente_index", methods={"GET"})
     */
    public function index(IngredienteRepository $ingredienteRepository): Response
    {
        return $this->render('ingrediente/index.html.twig', [
            'ingredientes' => $ingredienteRepository->findAll(),
            'usuario' => $this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="ingrediente_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ingrediente = new Ingrediente();
        $form = $this->createForm(IngredienteType::class, $ingrediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingrediente);
            $entityManager->flush();

            return $this->redirectToRoute('ingrediente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingrediente/new.html.twig', [
            'ingrediente' => $ingrediente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingrediente_show", methods={"GET"})
     */
    public function show(Ingrediente $ingrediente): Response
    {
        return $this->render('ingrediente/show.html.twig', [
            'ingrediente' => $ingrediente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ingrediente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ingrediente $ingrediente): Response
    {
        $form = $this->createForm(IngredienteType::class, $ingrediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ingrediente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingrediente/edit.html.twig', [
            'ingrediente' => $ingrediente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingrediente_delete", methods={"POST"})
     */
    public function delete(Request $request, Ingrediente $ingrediente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingrediente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingrediente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ingrediente_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/favorito", name="ingrediente_favorito", methods={"GET"})
     */
    public function favorito(IngredienteRepository $ingredientesRepository, Ingrediente $ingrediente): Response
    {

        $entityManager = $this->getDoctrine()->getManager();      

        $usuario = $this->getUser();
        $existe = false;

        $ingFavs = $usuario->getIngredienteFavorito();
        foreach ($ingFavs as $ingredienteFav) {
            if($ingrediente == $ingredienteFav){
                $usuario->removeIngredienteFavorito($ingrediente);
                $existe = true;
            }
        }

        if(!$existe){
            $usuario->addIngredienteFavorito($ingrediente);
        }
       
        $entityManager->flush();

        return $this->render('ingrediente/index.html.twig', [
            'ingredientes' => $ingredientesRepository->findAll(),
            'usuario' => $usuario
        ]);
    }
}
