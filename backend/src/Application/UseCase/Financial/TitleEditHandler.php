<?php

namespace Panthir\Application\UseCase\Financial;

use Doctrine\ORM\EntityManagerInterface;
use Panthir\Application\Common\DTO\DTOInterface;
use Panthir\Application\Common\Handler\AbstractHandler;
use Panthir\Application\Common\Handler\BeforeExecutedHandlerInterface;
use Panthir\Application\UseCase\Customer\Normalizer\DTO\CustomerCreateDTO;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Infrastructure\CommonBundle\Exception\InvalidFieldException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TitleEditHandler extends AbstractHandler implements BeforeExecutedHandlerInterface
{
    private ?Customer $title;

    public function __construct(
        EntityManagerInterface              $entityManager,
        protected MessageBusInterface       $bus,
        private readonly ValidatorInterface $validator
    )
    {
        parent::__construct(entityManager: $entityManager);
    }

    public function supports(DTOInterface $object): bool
    {
        return $object instanceof CustomerCreateDTO;
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

        if (!empty($model->getId())) {
            $this->title = $this->entityManager->getRepository(Customer::class)->find($model->getId());

        } else {
            $this->title = (new Customer())->setUuid(Uuid::uuid4());
        }

    }

    /**
     * @param CustomerCreateDTO $model
     * @return Customer
     * @throws InvalidFieldException
     */
    public function execute(DTOInterface $model): Customer
    {
        $this->title
            ->setName($model->getName())
            ->setDocument($model->getDocument())
            ->setSurname($model->getSurname())
            ->setBirthDate($model->getRawBirthDate())
            ->setSecondaryDocument($model->getSecondaryDocument())
            ->setAdditionalInformation($model->getAdditionalInformation());

        $this->entityManager->persist($this->title);
        return $this->title;
    }
}
