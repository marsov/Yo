<?php

namespace Yo;
use Yo\Event\Manager;

/**
 * Class Bootstrap
 * @package Yo
 */
class Bootstrap
{
    protected $_framework;

    public function __construct(Framework $yo)
    {
        $this->_framework = $yo;
        $this->initListeners();
    }

    public function initListeners()
    {
        // init observers
        $listeners = scandir(__DIR__."/Listeners");

        foreach ($listeners as $listener) {
            $t = array('.', '..');
            if (!in_array($listener, $t)) {
                $listener = rtrim($listener, ".php");
                $this->_framework->getClassLoader()->loadClass("Yo\\Listeners\\". $listener);

                if (class_exists("Yo\\Listeners\\". $listener)) {
                    $listenerName = "Yo\\Listeners\\". $listener;
                    $listenerObject = new $listenerName();
                    Manager::getInstance()->addListener($listenerObject);
                }
            }
        }
    }

}