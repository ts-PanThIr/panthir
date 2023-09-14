<?php

namespace Panthir\UI\Controller\Customer;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\Services\SerializerHelper;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerAddressDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerContactDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerCreateDTO;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use Symfony\Component\Serializer\Encoder\JsonEncoder;
=======
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
>>>>>>> 5ed5a497a264e41717581a939ce2d42a8971cc85
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/api/customer')]
class Post extends APIController
{
    #[Route(path: "/", name: "app_customer_post", methods: 'POST')]
    public function post(
        CustomerCreateHandler  $customerCreateHandler,
        Request                $request,
        EntityManagerInterface $entityManager,
        HandlerRunner          $handlerRunner,
    ): JsonResponse
    {
<<<<<<< HEAD

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'contacts' => [
                    new SerializerHelper(CustomerContactDTO::class),
                    'collectionCallback'
                ],
//                'birthDate' => [$serializerHelper, 'dateCallback'],
                'addresses' => [
                    new SerializerHelper(CustomerAddressDTO::class),
                    'collectionCallback'
                ]
=======
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'contacts' => [new SerializerHelper(CustomerContactDTO::class), 'collectionCallback'],
//                'birthDate' => [$serializerHelper, 'dateCallback'],
                'addresses' => [new SerializerHelper(CustomerAddressDTO::class), 'collectionCallback']
>>>>>>> 5ed5a497a264e41717581a939ce2d42a8971cc85
            ],
        ];

        $serializer = new Serializer(
            normalizers: [
                new ObjectNormalizer(
                    propertyTypeExtractor: new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]),
                    defaultContext: $defaultContext
                )
            ]
        );

        /** @var CustomerCreateDTO $customer */
        $customer = $serializer->denormalize(
            data: $request->request->all(),
            type: CustomerCreateDTO::class,
        );

        $return = $handlerRunner($customerCreateHandler, $customer);
        $entityManager->flush();
        return $this->response(items: $return);
    }
}
