<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class UserApiController extends AbstractController
{
    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, SerializerInterface $serializer, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $serializer->deserialize(json_encode($data), User::class, 'json');

        $plainPassword = $data['password'];
        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashedPassword);

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

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Uživatel byl vytvořen.'], Response::HTTP_CREATED);
    }

    #[Route('/users', name: 'users', methods: ['GET'])]
    public function Users(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        $jsonUsers = $serializer->serialize($users, 'json');

        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }
}
