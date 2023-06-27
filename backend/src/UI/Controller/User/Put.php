<?php

namespace Panthir\UI\Controller\User;

use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\User\Normalizer\DTO\PasswordRecoveryDTO;
use Panthir\Application\UseCase\User\UpdatePasswordHandler;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/user/')]
class Put extends APIController
{
    #[Route(path: "resetPassword", name: "app_user_reset_password", methods: 'PUT')]
    public function resetPassword(
        UpdatePasswordHandler $passwordRecoveryHandler,
        Request               $request,
        HandlerRunner         $runner
    ): JsonResponse
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** TODO can this user insert this role level? */
        /** @var PasswordRecoveryDTO $user */
        $user = $serializer->denormalize(
            data: json_decode($request->getContent(), true),
            type: PasswordRecoveryDTO::class
        );

        $return = $runner($passwordRecoveryHandler, $user);
        return $this->response(items: $return);
    }
}