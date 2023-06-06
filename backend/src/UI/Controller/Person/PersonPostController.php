<?php

namespace Panthir\UI\Controller\Person;

use App\Domain\Person\Manager\PersonFactory;
use App\Shared\DTO\PersonPOPO;
use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Services\SerializerHelper;
use Panthir\UI\Controller\APIController;
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
        PersonFactory          $personManager,
        Request                $request,
        EntityManagerInterface $entityManager,
        SerializerHelper       $serializerHelper
    ): JsonResponse {
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'contacts' => [$serializerHelper, 'collectionCallback'],
                'birthDate' => [$serializerHelper, 'dateCallback'],
                'addresses' => [$serializerHelper, 'collectionCallback']
            ],
        ];

        $serializer = new Serializer(
            normalizers: [new ObjectNormalizer(defaultContext: $defaultContext)]
        );

        /** @var PersonPOPO $person */
        $person = $serializer->denormalize(
            data: $request->request->all(),
            type: PersonPOPO::class
        );

        $return = $personManager->savePerson($person);
        $entityManager->flush();
        return $this->response(items: $return, groups: ['person']);
    }
}
