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

    protected static $_stack;

    /**
     * @return \SplStack
     */
    public static function getStack()
    {
        if (null == self::$_stack) {
            self::$_stack = new \SplStack();
        }

        return self::$_stack;
    }

    /**
     * @return \SplStack
     */
    public static function cloneStack()
    {
        return clone self::getStack();
    }

    protected $_listenersBaseDir;

    protected $_listenersNamespace;

    public function __construct(Framework $yo)
    {
        $this->_framework = $yo;
        $this->_listenersBaseDir = __DIR__."/Listeners";
        $this->_listenersNamespace = "Yo\\Listeners";
        $this->initListeners();
    }

    public function initListeners($listenersDir = null)
    {
        if ($listenersDir != null) {
            self::getStack()->push($listenersDir);
        }

        // build path
        $stack = self::cloneStack();
        $listenersPath = $this->_listenersBaseDir;
        $listenerNamespace = $this->_listenersNamespace;
        while ($stack->valid()) {
            $listenersPath.= "/".$stack->current();
            $listenerNamespace.= "\\".$stack->current();
            $stack->prev();
        }

        if (is_dir($listenersPath))
        {
            $listeners = scandir($listenersPath);
            foreach ($listeners as $listener) {
                $t = array('.', '..');

                if (!in_array($listener, $t)) {

                    if (is_dir($listenersPath ."/". $listener)) {
                        $this->initListeners($listener);
                    } else {
                        $file = $listenersPath ."/". $listener;
                        if (file_exists($file)) {

                            $listenerClass = rtrim($listener, ".php");
                            $this->_framework->getClassLoader()->loadClass($listenerNamespace."\\". $listenerClass);

                            if (class_exists($listenerNamespace."\\". $listenerClass)) {

                                $listenerClass = $listenerNamespace."\\". $listenerClass;
                                $listenerObject = new $listenerClass;
                                Manager::getInstance()->addListener($listenerObject);

                            } else {
                                throw new \Exception('Class '.$listenerClass.' does not exist');
                            }
                        } else {
                            throw new \Exception("File $file does not exist");
                        }
                    }
                }
            }

            if (!self::getStack()->isEmpty()) {
                self::getStack()->pop();
            }
        } else {
            throw new \Exception("Listener path is not directory");
        }
    }
}