<?php

namespace App\User\Controller;

use App\Person\DTO\PersonDTO;
use App\Person\Entity\PersonEntity;
use App\Person\Manager\PersonManager;
use App\Shared\APIController;
use App\User\DTO\UserDTO;
use App\User\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/user')]
class UserPostController extends APIController
{
    #[Route(path: "/", name: "app_user_post", methods: 'POST')]
    public function post(
        UserManager $userManager,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** TODO can this user insert this role level? */
        /** @var UserDTO $user */
        $user = $serializer->denormalize(
            data: $request->request->all(),
            type: UserDTO::class
        );

        if($request->request->get("client")){
            $client = $entityManager->getReference(PersonEntity::class, $request->request->get("client"));
            $user->setClient($client);
        }

        $return = $userManager->saveUser($user);
        $entityManager->flush();
        return $this->response(items: $return, groups: ['user']);
    }
}
