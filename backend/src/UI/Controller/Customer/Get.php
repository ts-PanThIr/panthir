<?php

namespace Panthir\UI\Controller\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/person')]
class Get extends APIController
{
    #[Route(path: "/{id}", name: "app_person_get", methods: 'GET')]
    public function get(
        EntityManagerInterface $entityManager,
        string $id
    ): JsonResponse
    {
        $serializer = new Serializer(normalizers: [new ObjectNormalizer()]);

        /** @var UserSearchDTO $user */
        $searchDTO = $serializer->denormalize(
            data: $request->query->all(),
            type: UserSearchDTO::class
        );

        $users = $runner($userSearchHandler, $searchDTO);
        return $this->response(items: $users);

        $person = $entityManager->getRepository(Customer::class)->find($id);
        return $this->response(items: $person, groups: ['person']);
    }
}
