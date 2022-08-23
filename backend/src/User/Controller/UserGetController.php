<?php

namespace App\User\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class UserGetController
{
    #[Route(path: "/user/number/{max}", name: "app_user_number", methods: 'GET')]
    public function number(int $max): JsonResponse
    {
        $number = random_int(0, $max);

        return JsonResponse::fromJsonString($number);
    }
}