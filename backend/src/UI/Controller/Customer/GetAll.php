<?php

namespace Panthir\UI\Controller\Customer;

use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerSearchHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerSearchDTO;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/customer')]
class GetAll extends APIController
{
    #[Route(path: "/", name: "app_customer_get_all", methods: 'GET')]
    public function get(
        HandlerRunner         $runner,
        CustomerSearchHandler $customerSearchHandler,
        Request               $request
    ): JsonResponse
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** @var CustomerSearchDTO $user */
        $searchDTO = $serializer->denormalize(
            data: $request->query->all(),
            type: CustomerSearchDTO::class
        );

        $users = $runner($customerSearchHandler, $searchDTO);
        return $this->response(items: $users);
    }
}
