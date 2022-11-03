<?php

namespace App\Person\Controller;

use App\Person\DTO\PersonSearchDTO;
use App\Person\Entity\PersonEntity;
use App\Person\Repository\PersonRepository;
use App\Shared\ApiController;
use App\Shared\Notify\NotifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/person')]
class PersonGetAllController extends ApiController
{
    #[Route(path: "/", name: "app_person_get_all", methods: 'GET')]
    public function get(
        NotifyInterface $notify,
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse
    {
        $search = new PersonSearchDTO();
        $search->setIndividual($request->query->get("individual"));
        /** @var PersonRepository $person */
        $person = $entityManager->getRepository(PersonEntity::class)->search($search);
        $notify->addMessage($notify::WARNING, "teste de warning");
        return $this->response(items: $person, groups: ['person']);
    }
}
