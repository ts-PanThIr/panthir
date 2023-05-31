<?php

namespace Panthir\UI\Controller\Person;

use App\Shared\DTO\PersonPOPO;
use App\Shared\DTO\PersonSearchDTO;
use Doctrine\ORM\EntityManagerInterface;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/person')]
class PersonGetAllController extends APIController
{
    #[Route(path: "/", name: "app_person_get_all", methods: 'GET')]
    public function get(
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $search = new PersonSearchDTO();

        /** @var PersonRepository $person */
        $person = $entityManager->getRepository(PersonEntity::class)->search($search);

        $personDTO = PersonPOPO::transformFromObjects($person);

        return $this->response(items: $personDTO, groups: ['person']);
    }
}
