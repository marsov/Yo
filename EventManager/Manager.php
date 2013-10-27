<?php

namespace Yo\Event;
use SplObjectStorage;

/**
 * Class Manager
 * Class for managing events
 *
 * @package Yo\Event
 */
class Manager
{
    /**
     * @var Manager
     */
    protected static $_instance;

    /**
     * @var SplObjectStorage
     */
    protected $_events;

    /**
     * @return SplObjectStorage
     */
    public function getEvents()
    {
        return $this->_events;
    }

    /**
     * @return Manager
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Manager();
        }

        return self::$_instance;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        $this->_events = new SplObjectStorage();
    }

    /**
     * @param string $eventName
     * @param mixed $notifier
     */
    public function notify($eventName, $notifier)
    {
        $event = $this->find($eventName);
        if ($event instanceof Event) {
            $event->setNotifier($notifier);
            $event->notify();
        }
    }

    /**
     * @param Listener $listener
     */
    public function addListener(Listener $listener)
    {
        $events = $listener->getListOfEvents();
        foreach ($events as $event => $args) {
            if ($event instanceof Event) {
                $this->_events->detach($event);
                $event->attach($listener);
            } else {
                // event is given by name
                $eventName = $event;
                $event = $this->find($eventName);
                if ($event instanceof Event) {
                    $event->setName($eventName);
                    $event->attach($listener);
                } else {
                    if (isset($args['event-type'])) {
                        $eventClassType = $args['event-type'];
                        if (class_exists($eventClassType)) {
                            $event = new $eventClassType;
                        }
                    }
                }
            }

            $this->_events->attach($event);
        }
    }

    /**
     * @param $eventName
     * @return null|Event
     */
    protected function find($eventName)
    {
        $this->_events->rewind();
        while ($this->_events->valid()) {
            if($this->_events->current()->getName() == $eventName) {
                return $this->_events->current();
            }
            $this->_events->next();
        }

        return null;
    }
}