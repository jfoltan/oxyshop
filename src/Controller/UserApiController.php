<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class UserApiController extends AbstractController
{
    #[Route('/users', name: 'create_user')]
    public function createUser(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();

        $errors = $validator->validate($user);

        if (count($errors) > 0)
        {
            $errorMesseages = [];
            foreach ($errors as $error)
            {
                $errorMesseages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMesseages], Response::HTTP_BAD_REQUEST);
        }

        $user->setName($data['name']);
        $user->setPassword($data['password']);
        $user->setEmail($data['email']);
        $user->setRole($data['role']);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Uživatel byl vytvořen.'], Response::HTTP_CREATED);
    }
}
