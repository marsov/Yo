<?php


namespace Yo\Event;

use SplSubject;
use SplObserver;

abstract class Event implements SplSubject
{
    /**
     * @var \SplObjectStorage
     */
    protected $_observers;

    /**
     * @var string
     */
    protected $_name;

    protected $_notifier;

    public function setNotifier($notifier)
    {
        $this->_notifier = $notifier;
    }

    public function getNotifier()
    {
        return $this->_notifier;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function __construct()
    {
        $this->_observers = new \SplObjectStorage();
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Attach an SplObserver
     * @link http://php.net/manual/en/splsubject.attach.php
     * @param SplObserver $observer <p>
     * The <b>SplObserver</b> to attach.
     * </p>
     * @return void
     */
    public function attach(SplObserver $observer)
    {
        $this->_observers->attach($observer);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Detach an observer
     * @link http://php.net/manual/en/splsubject.detach.php
     * @param SplObserver $observer <p>
     * The <b>SplObserver</b> to detach.
     * </p>
     * @return void
     */
    public function detach(SplObserver $observer)
    {
        $this->_observers->detach($observer);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Notify an observer
     * @link http://php.net/manual/en/splsubject.notify.php
     * @return void
     */
    public function notify()
    {
        $this->_observers->rewind();
        while ($this->_observers->valid()) {
            $this->_observers->current()->update($this);
            $this->_observers->next();
        }
    }
}