<?php

namespace App\Person\Controller;

use App\Person\Entity\PersonEntity;
use App\Shared\ApiController;
use App\Shared\Notify\NotifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/person')]
class PersonGetController extends ApiController
{
    #[Route(path: "/{id}", name: "app_person_get", methods: 'GET')]
    public function get(
        NotifyInterface $notify,
        EntityManagerInterface $entityManager,
        string $id
    ): JsonResponse
    {
        $person = $entityManager->getRepository(PersonEntity::class)->find($id);

        $notify->addMessage($notify::WARNING, "teste de warning");
        return $this->response(items: $person, groups: ['person']);
    }
}
