<?php

namespace App\Controller;

use App\Entity\Receta;
use App\Form\RecetaType;
use App\Repository\RecetaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/receta")
 */
class RecetaController extends AbstractController
{
    /**
     * @Route("/", name="receta_index", methods={"GET"})
     */
    public function index(RecetaRepository $recetaRepository): Response
    {
        return $this->render('receta/index.html.twig', [
            'recetas' => $recetaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/recetaIngfavorita", name="receta_ing_favorita", methods={"GET"})
     */
    public function recetaIngfavorita(RecetaRepository $recetaRepository): Response
    {

        $entityManager = $this->getDoctrine()->getManager();      

        $usuario = $this->getUser();

        $ingredientesFav = $usuario->getIngredienteFavorito();

        $recetasFav = [];

        foreach ($recetaRepository->findAll() as $receta) {
            $ingredientesReceta = $receta->getRecetaIngredientes();

            foreach ($ingredientesReceta as $ingredienteReceta) {
                foreach ($ingredientesFav as $ingredienteFav) {
                   if($ingredienteReceta->getIngrediente()->getId() == $ingredienteFav->getId()){
                        $recetasFav[$receta->getId()] = $receta;
                   }
                }
            }
        }

        return $this->render('receta/index.html.twig', [
            'recetas' => $recetasFav,
        ]);
    }

    /**
     * @Route("/new", name="receta_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $recetum = new Receta();
        $form = $this->createForm(RecetaType::class, $recetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $recetum->setUsuario($this->getUser());
            $recetum->setFecha(new \DateTime());
            $entityManager->persist($recetum);
            $entityManager->flush();

            return $this->redirectToRoute('receta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('receta/new.html.twig', [
            'recetum' => $recetum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="receta_show", methods={"GET"})
     */
    public function show(Receta $recetum): Response
    {
        return $this->render('receta/show.html.twig', [
            'recetum' => $recetum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="receta_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Receta $recetum): Response
    {
        $form = $this->createForm(RecetaType::class, $recetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('receta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('receta/edit.html.twig', [
            'recetum' => $recetum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="receta_delete", methods={"POST"})
     */
    public function delete(Request $request, Receta $recetum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recetum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recetum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('receta_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/favorita", name="receta_favorita", methods={"GET"})
     */
    public function favorita(RecetaRepository $recetaRepository, Receta $recetum): Response
    {

        $entityManager = $this->getDoctrine()->getManager();      

        $usuario = $this->getUser();
        $existe = false;

        $recFavs = $usuario->getRecetaFavorita();
        foreach ($recFavs as $recetaFav) {
            if($recetum == $recetaFav){
                $usuario->removeRecetaFavoritum($recetum);
                $existe = true;
            }
        }

        if(!$existe){
            $usuario->addRecetaFavoritum($recetum);
        }
       
        $entityManager->flush();

        return $this->render('receta/index.html.twig', [
            'recetas' => $recetaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/ingredientes", name="receta_ingredientes", methods={"GET"})
     */
    public function ingredientes(Receta $recetum): Response
    {

        $entityManager = $this->getDoctrine()->getManager();      
       
        return $this->render('receta/ingredientes.html.twig', [
            'receta' => $recetum,
        ]);
    }
}
