<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserController extends AbstractController
{
    #[Route('/', name: 'user_register', methods: ['GET', 'POST'])]
    public function register(Request $request, HttpClientInterface $client): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            $plainPassword = $form->get('plainPassword')->getData();

            $client->request('POST', 'http://nginx-container/api/users', [
                'json' => [
                    'name' => $formData->getName(),
                    'password' => $plainPassword,
                    'email' => $formData->getEmail(),
                    'role' => $formData->getRole(),
                ]
            ]);

            return $this->redirectToRoute('user_register');
        }


        return $this->render('register.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form,
        ]);
    }
}
