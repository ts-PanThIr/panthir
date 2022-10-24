<?php

namespace App\Person\Controller;

use App\Person\DTO\PersonAddressDTO;
use App\Person\DTO\PersonContactDTO;
use App\Person\DTO\PersonDTO;
use App\Person\Manager\PersonManager;
use App\Shared\ApiController;
use App\Shared\Notify\NotifyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/person')]
class PersonPostController extends ApiController
{
    #[Route(path: "/", name: "app_person_post", methods: 'POST')]
    public function get(
        PersonManager $personManager,
        NotifyInterface $notify,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {

        $dateCallback = function ($innerObject) {
            return !empty($innerObject) ? new \DateTime($innerObject) : null;
        };

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'birthDate' => $dateCallback
            ],
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['contacts', 'addresses']
        ];

        $serializer = new Serializer([new ObjectNormalizer(defaultContext: $defaultContext)], []);

        /** @var PersonDTO $person */
        $person = $serializer->denormalize(
            data: $request->request->all(),
            type: PersonDTO::class
        );

        if(isset($request->request->all()["contacts"])) {
            foreach ($request->request->all()["contacts"] as $row) {
                $person->addContacts($serializer->denormalize($row, PersonContactDTO::class));
            }
        }

        if(isset($request->request->all()["addresses"])) {
            foreach ($request->request->all()["addresses"] as $row) {
                $person->addAddresses($serializer->denormalize($row, PersonAddressDTO::class));
            }
        }

        $notify->addMessage($notify::WARNING, "teste de warning");
        $return = $personManager->savePerson($person);
        $entityManager->flush();
        return $this->response(items: $return, groups: ['person']);
    }
}
