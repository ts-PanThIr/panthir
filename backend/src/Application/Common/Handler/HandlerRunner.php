<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\DTO\DTOInterface;
use Symfony\Component\Serializer\SerializerInterface;

class HandlerRunner
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {

    }

    /** TODO unit testing here */
    public function __invoke(CommonHandlerInterface $handler, DTOInterface $model): mixed
    {
        if($handler instanceof BeforeExecutedHandlerInterface) {
            $handler->beforeExecuted($model);
        }

        $returnedObject = $handler->execute($model);

        if($handler instanceof AfterExecutedHandlerInterface) {
            $handler->afterExecuted($model);
        }

        $handler->flush();

        return $this->serializer->normalize(
            $returnedObject,
            $handler::class
        );
    }
}
