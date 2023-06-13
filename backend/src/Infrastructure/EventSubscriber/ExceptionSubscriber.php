<?php

namespace Panthir\Infrastructure\EventSubscriber;

use Panthir\Application\Services\Notify\Notify;
use Panthir\Infrastructure\CommonBundle\Exception\CustomExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use UnhandledMatchError;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Notify                     $notify,
        private string                     $env,
        protected readonly LoggerInterface $logger
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
        );
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof \Exception) {
            if ($exception->getCode() === 500 && $this->env === 'PROD') {

                $this->logger->error($exception->getMessage());
                $this->notify->addMessage($this->notify::ERROR, "Undefined error");
                $returnable = $this->notify->newReturn("Undefined error");

                $customResponse = JsonResponse::fromJsonString(
                    $returnable, 500, array('Symfony-Debug-Toolbar-Replace' => 1)
                );

                $event->allowCustomResponseCode();
                $event->setResponse($customResponse);
                return;
            }

            $this->notify->addMessage($this->notify::ERROR, $exception->getMessage());
            $customResponse = JsonResponse::fromJsonString(
                $this->notify->newReturn($exception->getMessage()), $exception->getCode(),
                array('Symfony-Debug-Toolbar-Replace' => 1)
            );

            $event->allowCustomResponseCode();
            $event->setResponse($customResponse);
        }
    }
}
