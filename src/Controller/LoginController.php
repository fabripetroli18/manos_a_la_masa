<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Externo;


class LoginController extends AbstractController
{
    #[Route('/', name: 'login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/login/validacion', name: 'login_validacion')]
    public function loginValidacionAction(Request $request ): Response
    {
        $repository = $this->getDoctrine()->getRepository(Externo::class);

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        
        $externo = $repository->findOneBy([
            'externoMail' => $username,
            'externoPass' => $password,
        ]);

        if(empty($externo)) {
            return $this->render('login/error.html.twig', [
            ]);
        } else {
            return $this->redirectToRoute('receta_index');
        }
    }
}
