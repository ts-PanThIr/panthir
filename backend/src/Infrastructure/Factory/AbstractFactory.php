<?php

namespace Panthir\Infrastructure\Factory;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractFactory implements CommonFactoryInterface
{
    public function __construct (
        protected readonly EntityManagerInterface       $entityManager,
    )
    {
    }

    final public static function create(): object
    {
        $object = new static();

        if($object instanceof BeforeCreatedFactoryInterface) {
            $object->beforeCreated();
        }

        $object->execute();

        if($object instanceof AfterCreatedFactoryInterface) {
            $object->afterCreated();
        }

        return $object;
    }

//    abstract protected function execute(): object;

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}