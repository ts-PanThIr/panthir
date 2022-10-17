<?php

namespace App\Person\Controller;

use App\Person\DTO\PersonDTO;
use App\Person\Manager\PersonManager;
use App\Shared\ApiController;
use App\Shared\Notify\NotifyInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/api/person')]
class PersonPostController extends ApiController
{
    #[Route(path: "/", name: "app_person_post", methods: 'POST')]
    public function get(
        PersonManager $personManager,
        NotifyInterface $notify,
        Request $request,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $teste = $this->arrayToObject($request->request->all(), PersonDTO::class);


//        $dto = $serializer->deserialize($request->request->all(), PersonDTO::class, 'json');

        $dto = new PersonDTO();
        $notify->addMessage($notify::WARNING, "teste de warning");
        $personManager->savePerson($dto);
        return $this->response(items: $dto, groups: ['user']);
    }
}