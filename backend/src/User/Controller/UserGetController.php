<?php

namespace App\User\Controller;

use App\Shared\APIController;
use App\Shared\Notify\NotifyInterface;
use App\User\Manager\UserManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class UserGetController extends APIController
{
    #[Route(path: "/users", name: "app_users_getAll", methods: 'GET')]
    public function get(UserManager $userManager, NotifyInterface $notify): JsonResponse
    {
        $notify->addMessage($notify::WARNING, "teste de warning");
        $users = $userManager->search();
        return $this->response(items: $users, groups:['user']);
    }
}