<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class UserApiController extends AbstractController
{
    #[Route('/users', name: 'create_user')]
    public function createUser(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setName($data['name']);
        $user->setPassword($data['password']);
        $user->setEmail($data['email']);
        $user->setRole($data['role']);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Uživatel byl vytvořen.'], Response::HTTP_CREATED);
    }
}
