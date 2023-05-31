<?php

namespace Panthir\Infrastructure\CommonBundle\Event;

use Panthir\Domain\Common\Event\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as InfrastructureDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    /** @var InfrastructureDispatcher */
    private $dispatcher;

    /** @var EventCollector */
    private $collector;

    public function __construct(InfrastructureDispatcher $dispatcher, EventCollector $collector)
    {
        $this->dispatcher = $dispatcher;
        $this->collector = $collector;
        $this->bootPublisher();
    }

    private function bootPublisher(): void
    {
        EventPublisher::boot($this);
    }

    public function record(EventInterface $event): void
    {
        $this->collector->collect($event);
    }

    public function dispatch(): void
    {
        foreach ($this->collector->events() as $key => $event) {

            $this->dispatcher->dispatch($event->type(), new EventAware($event));

            $this->collector->remove($key);
        }
    }
}
