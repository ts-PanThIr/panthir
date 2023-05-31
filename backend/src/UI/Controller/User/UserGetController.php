<?php

namespace Panthir\UI\Controller\User;

use App\Domain\User\Manager\UserFactory;
use App\Domain\User\UserRoles;
use App\Shared\DTO\UserSearchPOPO;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route(path: '/api/users')]
class UserGetController extends APIController
{
    #[Route(path: "/", name: "app_users_getAll", methods: 'GET')]
    public function getAll(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $searchDTO = UserSearchPOPO::transformFromObject($request);
        $users = $entityManager->getRepository(UserEntity::class)->search($searchDTO);
        return $this->response(items: $users, groups:['user', 'countable']);
    }

    #[Route(path: "/token/{token}", name: "app_users_get_byToken", methods: 'GET')]
    public function getByToken(UserFactory $userManager, Request $request, Notify $notify): JsonResponse
    {
        $searchDTO = UserSearchPOPO::transformFromObject($request);
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
