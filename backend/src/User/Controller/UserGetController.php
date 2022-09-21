<?php

namespace App\User\Controller;

use App\Shared\ApiController;
use App\Shared\Notify\NotifyInterface;
use App\Shared\OCR\TesseractOCR;
use App\User\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class UserGetController extends ApiController
{
    #[Route(path: "/user/number/{max}", name: "app_user_number", methods: 'GET')]
    public function number(int $max): JsonResponse
    {
        $number = random_int(0, $max);

        return JsonResponse::fromJsonString($number);
    }

    #[Route(path: "/user/upload", name: "app_user_upload", methods: 'POST')]
    public function upload(Request $request): JsonResponse
    {
        $txt = (new TesseractOCR('../var/img.png'))->run();

        return JsonResponse::fromJsonString($txt);
    }

    #[Route(path: "/users", name: "app_users_getAll", methods: 'GET')]
    public function get(EntityManagerInterface $entityManager, NotifyInterface $notify): JsonResponse
    {
        $notify->addMessage($notify::WARNING, "teste de warning");
        $users = $entityManager->getRepository(UserEntity::class)->findAll();
        return $this->response(items: $users, groups:['user']);
    }
}