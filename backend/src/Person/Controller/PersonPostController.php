<?php

namespace App\Person\Controller;

use App\Person\DTO\PersonAddressDTO;
use App\Person\DTO\PersonContactDTO;
use App\Person\DTO\PersonDTO;
use App\Person\Manager\PersonManager;
use App\Shared\ApiController;
use App\Shared\Notify\NotifyInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Attribute;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
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
        $serializer = new Serializer([new ObjectNormalizer()], []);

        /** @var PersonDTO $person */
        $person = $serializer->denormalize(
            data: $request->request->all(),
            type: PersonDTO::class,
            context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['contacts', 'addresses']]
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
        $person->setIsIndividual(true);
        $notify->addMessage($notify::WARNING, "teste de warning");
        $personManager->savePerson($person);
        //$entityManager->flush();
        return $this->response(items: $person, groups: ['user']);
    }
}
