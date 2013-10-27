<?php

namespace Yo;
use Yo\App\Loader;
use Yo\Event\Manager;
use Yo\FileSystem\FileSystem;

/**
 * Class Bootstrap
 * @package Yo
 */
class Bootstrap
{
    const CONFIG_FILE = 'config.xml';

    protected $_framework;

    protected $_config;

    protected static $_stack;

    /**
     * @var Environment
     */
    protected $_environment;

    /**
     * @param Environment $env
     */
    public function setEnvironment($env)
    {
        $this->_environment = $env;
    }

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

        // this should be removed
        $this->_listenersBaseDir = __DIR__."/Listeners";
        $this->_listenersNamespace = "Yo\\Listeners";
        // end

        $this->setEnvironment($yo->getEnvironment());
        $this->initApps();
    }

    public function initConfig()
    {
        if (file_exists(__DIR__ . FileSystem::PATH_SEPARATOR . self::CONFIG_FILE)) {
            $this->_config = simplexml_load_file(__DIR__ . FileSystem::PATH_SEPARATOR . self::CONFIG_FILE);
        } else {
            throw new \RuntimeException("Config file is not found");
        }
    }

    public function initApps()
    {
        $appLoader = new Loader($this->_config->applications);
        $appLoader->setEnvironment($this->_environment);
        $appLoader->load();
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