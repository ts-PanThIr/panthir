<?php

namespace Panthir\Application\Common\Handler;

use Panthir\Application\Common\POPO\POPOInterface;

class HandlerRunner
{
    /** TODO unit testing here */
    public static function run(CommonHandlerInterface $hadler, POPOInterface $model): object
    {
        if($hadler instanceof BeforeExecutedHandlerInterface) {
            $hadler->beforeExecuted($model);
        }

        $returnedObject = $hadler->execute($model);

        if($hadler instanceof AfterExecutedHandlerInterface) {
            $hadler->afterExecuted($model);
        }

        $hadler->flush();
        return $returnedObject;
    }
}