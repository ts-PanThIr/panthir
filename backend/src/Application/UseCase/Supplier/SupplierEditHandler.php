<?php

namespace Panthir\Application\UseCase\Supplier;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\Common\Handler\BeforeExecutedHandlerInterface;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierAddressDTO;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierContactDTO;
use Panthir\Application\UseCase\Supplier\Normalizer\DTO\SupplierCreateDTO;
use Panthir\Domain\Supplier\Model\Supplier;
use Panthir\Domain\Supplier\Model\SupplierAddress;
use Panthir\Domain\Supplier\Model\SupplierContact;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SupplierEditHandler extends AbstractHandler implements BeforeExecutedHandlerInterface
{
    private ?Supplier $supplier;

    public function __construct(
        EntityManagerInterface              $entityManager,
        private readonly ValidatorInterface $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    public function supports(DTOInterface $object): bool
    {
        return $object instanceof SupplierCreateDTO;
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
    }

    /**
     * @param SupplierCreateDTO $model
     * @return Supplier
     * @throws InvalidFieldException
     */
    public function execute(DTOInterface $model): Supplier
    {
        $this->supplier = new Supplier(
            name: $model->name,
            document: $model->document,
            uuid: Uuid::uuid4(),
            nickName: $model->nickName,
            secondaryDocument: $model->secondaryDocument,
            additionalInformation: $model->additionalInformation,
        );
        $this->entityManager->persist($this->supplier);

        if (!empty($model->getAddresses())) {
            /** @var SupplierAddressDTO $address */
            foreach ($model->getAddresses() as $address) {
                $dbAddress = $this->saveAddress($address);
                $this->supplier->addAddresses($dbAddress);
            }
        }

        if (!empty($model->getContacts())) {
            /** @var SupplierContactDTO $contact */
            foreach ($model->getContacts() as $contact) {
                $dbContact = $this->saveContact($contact);
                $this->supplier->addContacts($dbContact);
            }
        }

        return $this->supplier;
    }

    /**
     * @throws InvalidFieldException
     */
    private function saveAddress(SupplierAddressDTO $model): SupplierAddress
    {
        $errors = $this->validator->validate($model);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string)$errors, 400);
        }

        $address = new SupplierAddress(
            name: $model->name,
            address: $model->address,
            addressComplement: $model->addressComplement,
            city: $model->city,
            country: $model->country,
            district: $model->district,
            number: $model->number,
            zip: $model->zip,
            uuid: Uuid::uuid4(),
            type: $model->getType(),
            person: $this->supplier
        );

        $this->entityManager->persist($address);

        return $address;
    }

    /**
     * @throws InvalidFieldException
     */
    private function saveContact(SupplierContactDTO $contactDTO): SupplierContact
    {
        $errors = $this->validator->validate($contactDTO);

        if (count($errors) > 0) {
            throw new InvalidFieldException((string)$errors, 400);
        }

        $contact = new SupplierContact(
            name: $contactDTO->name,
            email: $contactDTO->email,
            phone: $contactDTO->phone,
            uuid: Uuid::uuid4(),
            type: $contactDTO->getType(),
            person: $this->supplier,
        );

        $this->entityManager->persist($contact);

        return $contact;
    }
}
