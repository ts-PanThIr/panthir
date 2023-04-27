<?php

namespace App\Person\Controller;

use App\Person\DTO\PersonDTO;
use App\Person\DTO\PersonSearchDTO;
use App\Person\Entity\PersonEntity;
use App\Person\Repository\PersonRepository;
use App\Shared\APIController;
use App\Shared\Notify\NotifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/person')]
class PersonGetAllController extends APIController
{
    #[Route(path: "/", name: "app_person_get_all", methods: 'GET')]
    public function get(
        NotifyInterface $notify,
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse
    {
        $search = new PersonSearchDTO();

        /** @var PersonRepository $person */
        $person = $entityManager->getRepository(PersonEntity::class)->search($search);

        $personDTO = PersonDTO::transformFromObjects($person);

        return $this->response(items: $personDTO, groups: ['person']);
    }
}
