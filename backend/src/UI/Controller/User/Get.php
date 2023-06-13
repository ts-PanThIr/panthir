<?php

namespace Panthir\UI\Controller\User;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\User\Normalizer\DTO\UserSearchDTO;
use Panthir\Application\UseCase\User\UserSearchHandler;
use Panthir\Domain\User\Model\User;
use Panthir\Domain\User\ValueObject\UserRoles;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/users')]
class Get extends APIController
{
    #[Route(path: "/", name: "app_users_getAll", methods: 'GET')]
    public function getAll(
        Request             $request,
        UserSearchHandler   $userSearchHandler,
        HandlerRunner       $runner,
    ): JsonResponse
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** @var UserSearchDTO $user */
        $searchDTO = $serializer->denormalize(
            data: $request->query->all(),
            type: UserSearchDTO::class
        );

        $users = $runner($userSearchHandler, $searchDTO);
        return $this->response(items: $users);
    }

    #[Route(path: "/token/{token}", name: "app_users_get_byToken", methods: 'GET')]
    public function getByToken(
        Request $request,
        UserSearchHandler   $userSearchHandler,
        HandlerRunner       $runner
    ): JsonResponse
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** @var UserSearchDTO $user */
        $searchDTO = $serializer->denormalize(
            data: $request->query->all(),
            type: UserSearchDTO::class
        );

        $users = $runner($userSearchHandler, $searchDTO);


        return $this->response(items: $users);
    }

    #[Route(path: "/profile", name: "app_users_getProfileByUser", methods: 'GET')]
    public function getProfileByUser(
        TokenStorageInterface    $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse
    {
        $decodedJwtToken = $jwtManager->decode($tokenStorageInterface->getToken());
        $currentProfile = UserRoles::getProfileByRoles($decodedJwtToken["roles"]);
        $list = array_slice(UserRoles::LIST_PROFILES, 0, array_search($currentProfile, UserRoles::LIST_PROFILES));
        return $this->response(items: $list);
    }

    #[Route(path: "/{id}", name: "app_users_getById", methods: 'GET')]
    public function getById(string $id): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        return $this->response(items: $user, groups: ['user']);
    }
}
