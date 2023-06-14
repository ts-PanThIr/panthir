<?php

namespace Panthir\Application\UseCase\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\Common\Handler\BeforeExecutedHandlerInterface;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerAddressDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerContactDTO;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerCreateDTO;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Domain\Customer\Model\CustomerAddress;
use Panthir\Domain\Customer\Model\CustomerContact;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerCreateHandler extends AbstractHandler implements BeforeExecutedHandlerInterface
{
    private ?Customer $customer;

    public function __construct(
        EntityManagerInterface              $entityManager,
        protected MessageBusInterface       $bus,
        private readonly ValidatorInterface $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    /**
     * @param DTOInterface $model
     * @return void
     * @throws InvalidFieldException
     */
    public function beforeExecuted(DTOInterface $model): void
    {
        $errors = $this->validator->validate($model);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string)$errors, 400);
        }

//        if ($model->getId()) {
//            $this->customer = $this->entityManager->getRepository(Customer::class)->find($model->getId());
//            if (empty($this->customer)) {
//                throw new HandlerException("The Id to update the person register is invalid.", 400);
//            }
//        }

    }

    /**
     * @param CustomerCreateDTO $model
     * @return Customer
     * @throws InvalidFieldException
     */
    public function execute(DTOInterface $model): Customer
    {
        $this->customer = new Customer(
            uuid: Uuid::uuid4(),
            name: $model->getName(),
            surname: $model->getSurname(),
            document: $model->getDocument(),
            secondaryDocument: $model->getSecondaryDocument(),
            mainAddress: $model->getMainContact(),
            mainContact: $model->getMainAddress(),
            birthDate: $model->getRawBirthDate(),
            additionalInformation: $model->getAdditionalInformation()
        );
        $this->entityManager->persist($this->customer);

        if (!empty($model->getAddresses())) {
            /** @var CustomerAddressDTO $address */
            foreach ($model->getAddresses() as $address) {
                $dbAddress = $this->saveAddress($address);
                $this->customer->addAddresses($dbAddress);
            }
        }

        if (!empty($model->getContacts())) {
            /** @var CustomerContactDTO $contact */
            foreach ($model->getContacts() as $contact) {
                $dbContact = $this->saveContact($contact);
                $this->customer->addContacts($dbContact);
            }
        }

        return $this->customer;
    }

    /**
     * @throws InvalidFieldException
     */
    private function saveAddress(CustomerAddressDTO $model): CustomerAddress
    {
        $errors = $this->validator->validate($model);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string) $errors, 400);
        }

//        if($addressDTO->getId()) {
//            $address = $this->entityManager->getRepository(CustomerAddress::class)->find($addressDTO->getId());
//            if (empty($address)) {
//                throw new HandlerException("Invalid Address Id.", 400);
//            }
//        }
//        else{
//            $address = new CustomerAddress();
//        }

        $address = new CustomerAddress(
            uuid: Uuid::uuid4(),
            name: $model->getName(),
            country: $model->getCountry(),
            district: $model->getDistrict(),
            city: $model->getCity(),
            address: $model->getAddress(),
            number: $model->getNumber(),
            zip: $model->getZip(),
            customer: $this->customer,
            addressComplement: $model->getAddressComplement()
        );

        $this->entityManager->persist($address);

        return $address;
    }

    /**
     * @throws InvalidFieldException
     */
    private function saveContact(CustomerContactDTO $contactDTO): CustomerContact
    {
        $errors = $this->validator->validate($contactDTO);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string) $errors, 400);
        }

//        if($contactDTO->getId()) {
//            $contact = $this->entityManager->getRepository(PersonContactEntity::class)->find($contactDTO->getId());
//            if (empty($contact)) {
//                throw new ManagerException("Invalid Contact Id.", 400);
//            }
//        }
//        else{
//            $contact = new PersonContactEntity();
//        }

        $contact = new CustomerContact(
            uuid: Uuid::uuid4(),
            name: $contactDTO->getName(),
            phone: $contactDTO->getPhone(),
            email: $contactDTO->getEmail(),
            customer: $this->customer
        );

        $this->entityManager->persist($contact);

        return $contact;
    }
}
