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
    #[Route('/', name: 'user_register')]
    public function register(Request $request, HttpClientInterface $client): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            $response = $client->request('POST', 'http://nginx-container/api/users', [
                'json' => [
                    'name' => $formData->getName(),
                    'password' => $formData->getPassword(),
                    'email' => $formData->getEmail(),
                    'role' => $formData->getRole(),
                ]
            ]);
        }


        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form,
        ]);
    }
}
