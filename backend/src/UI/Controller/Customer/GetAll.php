<?php

namespace Panthir\UI\Controller\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\UseCase\Customer\POPO\Output\CustomerSearchPOPO;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/customer')]
class GetAll extends APIController
{
    #[Route(path: "/", name: "app_customer_get_all", methods: 'GET')]
    public function get(
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** @var CustomerSearchDTO $user */
        $searchDTO = $serializer->denormalize(
            data: $request->query->all(),
            type: UserSearchDTO::class
        );

        $users = $runner($userSearchHandler, $searchDTO);
        return $this->response(items: $users);


        $search = new CustomerSearchPOPO();

        /** @var PersonRepository $person */
        $person = $entityManager->getRepository(PersonEntity::class)->search($search);

        $personDTO = CustomerCreatePOPO::transformFromObjects($person);

        return $this->response(items: $personDTO, groups: ['person']);
    }
}
