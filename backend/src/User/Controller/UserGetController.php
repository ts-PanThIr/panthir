<?php

namespace App\User\Controller;

use App\Shared\APIController;
use App\Shared\Notify\Notify;
use App\User\DTO\UserSearchDTO;
use App\User\Entity\UserEntity;
use App\User\Manager\UserManager;
use App\User\UserRoles;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route(path: '/api/users')]
class UserGetController extends APIController
{
    #[Route(path: "/", name: "app_users_getAll", methods: 'GET')]
    public function getAll(UserManager $userManager): JsonResponse
    {
        $users = $userManager->search();
        return $this->response(items: $users, groups:['user']);
    }

    #[Route(path: "/token/{token}", name: "app_users_get_byToken", methods: 'GET')]
    public function getByToken(UserManager $userManager, Request $request, Notify $notify): JsonResponse
    {
        $searchDTO = UserSearchDTO::transformFromObject($request);
        $this->notify->addMessage($notify::ERROR, 'test de erro');
        $users = $userManager->search($searchDTO);
        return $this->response(items: $users, groups:['user']);
    }

    #[Route(path: "/profile", name: "app_users_getProfileByUser", methods: 'GET')]
    public function getProfileByUser(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse
    {
        $decodedJwtToken = $jwtManager->decode($tokenStorageInterface->getToken());
        $currentProfile = UserRoles::getProfileByRoles($decodedJwtToken["roles"]);
        $list = array_slice(UserRoles::LIST_PROFILES, 0, array_search($currentProfile, UserRoles::LIST_PROFILES));
        return $this->response(items: $list);
    }

    #[Route(path: "/{id}", name: "app_users_getById", methods: 'GET')]
    public function getById(EntityManagerInterface $entityManager, string $id): JsonResponse
    {
        $user = $entityManager->getRepository(UserEntity::class)->find($id);
        return $this->response(items: $user, groups:['user']);
    }
}
