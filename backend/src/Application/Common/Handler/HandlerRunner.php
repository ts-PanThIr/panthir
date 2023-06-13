<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\POPO\POPOInterface;
use Symfony\Component\Serializer\SerializerInterface;

class HandlerRunner
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {

    }

    /** TODO unit testing here */
    public function __invoke(CommonHandlerInterface $hadler, POPOInterface $model): object
    {
        if($hadler instanceof BeforeExecutedHandlerInterface) {
            $hadler->beforeExecuted($model);
        }

        $returnedObject = $hadler->execute($model);

        if($hadler instanceof AfterExecutedHandlerInterface) {
            $hadler->afterExecuted($model);
        }

        $hadler->flush();

        $user = $this->serializer->normalize(
            $returnedObject,
            $hadler::class
        );

        return $returnedObject;
    }
}