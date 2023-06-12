<?php

namespace Panthir\UI\Controller\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Common\Handler\HandlerRunner;
use Panthir\Application\Services\SerializerHelper;
use Panthir\Application\UseCase\Customer\CustomerCreateHandler;
use Panthir\Application\UseCase\Customer\POPO\Input\CustomerPOPO;
use Panthir\UI\Controller\APIController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/api/customer')]
class Post extends APIController
{
    #[Route(path: "/", name: "app_customer_post", methods: 'POST')]
    public function post(
        CustomerCreateHandler  $customerCreateHandler,
        Request                $request,
        EntityManagerInterface $entityManager,
        SerializerHelper       $serializerHelper
    ): JsonResponse
    {
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

        /** @var CustomerPOPO $customer */
        $customer = $serializer->denormalize(
            data: $request->request->all(),
            type: CustomerPOPO::class
        );

        $return = HandlerRunner::run($customerCreateHandler, $customer);
        $entityManager->flush();
        return $this->response(items: $return, groups: ['customer']);
    }
}
