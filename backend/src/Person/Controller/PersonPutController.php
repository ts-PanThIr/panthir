<?php

namespace App\Person\Controller;

use App\Shared\Notify\NotifyInterface;
use App\User\Manager\UserManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/person')]
class PersonPutController
{
    #[Route(path: "/:id", name: "app_person_put", methods: 'PUT')]
    public function get(UserManagerInterface $userManager, NotifyInterface $notify, string $id): JsonResponse
    {
        $notify->addMessage($notify::WARNING, "teste de warning");
        $users = $userManager->search();
        return $this->response(items: $users, groups:['user']);
    }
}