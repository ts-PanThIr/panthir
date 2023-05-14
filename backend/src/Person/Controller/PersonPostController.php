<?php

namespace App\Person\Controller;

use App\Shared\DTO\PersonAddressDTO;
use App\Shared\DTO\PersonContactDTO;
use App\Shared\DTO\PersonDTO;
use App\Person\Manager\PersonManager;
use App\Shared\APIController;
use App\Shared\Helper\SerializerHelper;
use App\Shared\Notify\NotifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/person')]
class PersonPostController extends APIController
{
    #[Route(path: "/", name: "app_person_post", methods: 'POST')]
    public function post(
        PersonManager $personManager,
        NotifyInterface $notify,
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerHelper $serializerHelper
    ): JsonResponse {
        $serializerHelperContacts = new SerializerHelper(PersonContactDTO::class);
        $serializerHelperAddress = new SerializerHelper(PersonAddressDTO::class);

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'contacts' => [$serializerHelperContacts, 'collectionCallback'],
                'birthDate' => [$serializerHelper, 'dateCallback'],
                'addresses' => [$serializerHelperAddress, 'collectionCallback']
            ],
        ];

        $serializer = new Serializer(
            normalizers: [new ObjectNormalizer(defaultContext: $defaultContext)]
        );

        /** @var PersonDTO $person */
        $person = $serializer->denormalize(
            data: $request->request->all(),
            type: PersonDTO::class
        );

        $notify->addMessage($notify::WARNING, "teste de warning");
        $return = $personManager->savePerson($person);
        $entityManager->flush();
        return $this->response(items: $return, groups: ['person']);
    }
}
