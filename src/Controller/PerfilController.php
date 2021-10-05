<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\PerfilType;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/perfil")
 */
class PerfilController extends AbstractController
{
    /**
     * @Route("/{id}", name="perfil_show", methods={"GET"})
     */
    public function verPerfil(User $user): Response
    {
        return $this->render('perfil/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="perfil_edit", methods={"GET","POST"})
     */
    public function editarPerfil(Request $request, User $user): Response
    {
        $form = $this->createForm(PerfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('perfil_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('perfil/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
