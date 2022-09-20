<?php

namespace App\User\Controller;

use App\Shared\OCR\TesseractOCR;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route(path: "/user/upload", name: "app_user_upload", methods: 'POST')]
    public function upload(Request $request): JsonResponse
    {
        $txt = (new TesseractOCR('../var/img.png'))->run();

        return JsonResponse::fromJsonString($txt);
    }

    #[Route(path: "/users", name: "app_users_getAll", methods: 'GET')]
    public function get(Request $request): JsonResponse
    {

    }
}