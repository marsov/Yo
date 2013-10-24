<?php

namespace Yo\Event;


use SplSubject;

abstract class Listener implements \SplObserver
{
    /**
     * Array of event names that the listener is going to listen
     *
     * @var array
     */
    protected $_listensForEvents = array();

    /**
     * @return array
     */
    public function getListOfEvents()
    {
        return $this->_listensForEvents;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Receive update from subject
     * @link http://php.net/manual/en/splobserver.update.php
     * @param SplSubject $subject <p>
     * The <b>SplSubject</b> notifying the observer of an update.
     * </p>
     * @return void
     */
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
    }
}