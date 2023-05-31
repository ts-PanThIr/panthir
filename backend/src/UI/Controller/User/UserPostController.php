<?php

namespace Panthir\UI\Controller\User;

use App\Domain\User\Manager\UserFactory;
use App\Shared\DTO\UserPOPO;
use Doctrine\ORM\EntityManagerInterface;
use Panthir\UI\Controller\APIController;
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
        UserFactory            $userManager,
        Request                $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** TODO can this user insert this role level? */
        /** @var UserPOPO $user */
        $user = $serializer->denormalize(
            data: $request->request->all(),
            type: UserPOPO::class
        );

        $return = $userManager->createUser($user);
        $entityManager->flush();
        return $this->response(items: $return, groups: ['user']);
    }
}
