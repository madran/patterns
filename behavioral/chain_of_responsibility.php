<?php
abstract class EventListener
{
    private $nextEventListener;

    public function addNextEventListener($eventListener)
    {
        $this->nextEventListener = $eventListener;
        return $eventListener;
    }

    public function catchEvent($event)
    {
        $result = $this->process($event);

        if($result == null && $this->nextEventListener != null) {
            $result = $this->nextEventListener->catchEvent($event);
        }

        return $result;
    }

    public function process($event)
    {
        if ($event->getEventTrigger() == $this->eventTrigger) {
            return $event->getEventType() . ': ' . $event->getEventTrigger();
        } else {
            return null;
        }
    }
}

class EventListenerKeyA extends EventListener {
    protected $eventTrigger = 'A';
}

class EventListenerKeyB extends EventListener {
    protected $eventTrigger = 'B';
}

class EventListenerKeyC extends EventListener {
    protected $eventTrigger = 'C';
}

class Event
{
    private $eventType;
    private $eventTrigger;

    public function __construct($eventType, $eventTrigger)
    {
        $this->eventType = $eventType;
        $this->eventTrigger = $eventTrigger;
    }

    public function getEventType()
    {
        return $this->eventType;
    }

    public function getEventTrigger()
    {
        return $this->eventTrigger;
    }
}

$eventListenerA = new EventListenerKeyA();
$eventListenerA->addNextEventListener(new EventListenerKeyB())
               ->addNextEventListener(new EventListenerKeyC());

$event = new Event('keypress', 'B');

echo $eventListenerA->catchEvent($event) . PHP_EOL;
