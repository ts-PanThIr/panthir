<?php

namespace Panthir\UI\Controller\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/person')]
class PersonGetController extends APIController
{
    #[Route(path: "/{id}", name: "app_person_get", methods: 'GET')]
    public function get(
        EntityManagerInterface $entityManager,
        string $id
    ): JsonResponse
    {
        $person = $entityManager->getRepository(Customer::class)->find($id);
        return $this->response(items: $person, groups: ['person']);
    }
}
