<?php

namespace Panthir\UI\Controller\Customer;

use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\UseCase\Customer\CustomerSearchHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerSearchDTO;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/customer')]
class Get extends APIController
{
    #[Route(path: "/{id}", name: "app_person_get", methods: 'GET')]
    public function get(
        string                $id,
        HandlerRunner         $runner,
        CustomerSearchHandler $customerSearchHandler
    ): JsonResponse
    {
        $searchDTO = new CustomerSearchDTO(id: $id);

        $customer = $runner($customerSearchHandler, $searchDTO);
        if (null === $customer) {
            throw new InvalidFieldException("The given Id is invalid", 400);
        }

        return $this->response(items: $customer);
    }
}
