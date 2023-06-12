<?php

namespace Panthir\UI\Controller\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\UseCase\Customer\POPO\Output\CustomerSearchPOPO;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/customer')]
class GetAll extends APIController
{
    #[Route(path: "/", name: "app_customer_get_all", methods: 'GET')]
    public function get(
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $search = new CustomerSearchPOPO();

        /** @var PersonRepository $person */
        $person = $entityManager->getRepository(PersonEntity::class)->search($search);

        $personDTO = CustomerCreatePOPO::transformFromObjects($person);

        return $this->response(items: $personDTO, groups: ['person']);
    }
}
