<?php

namespace Yo\App;

use Yo\Event\Event;
use Yo\Event\Listener;
use SplSubject;
use Yo\Framework;

class App extends Listener
{
    /**
     * @var Framework
     */
    protected $_framework;

    public function setFramework($framework)
    {
        $this->_framework = $framework;
    }

    public function __construct()
    {
        $this->_listensForEvents = array(
            'Yo\Framework::run'
        );
    }

    /**
     * Subject for App listeners is the Framework object
     *
     * @param SplSubject $listener
     */
    public function update(SplSubject $event)
    {
        $this->_framework = $event->getNotifier();
    }
}