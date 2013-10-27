<?php

namespace Yo\EventListeners;

use Yo\Environment;
use Yo\FileSystem\FileCommand;

class LoadListenerCommand extends FileCommand
{
    /**
     * @var Environment
     */
    protected $_environment;

    /**
     * @param Environment $environment
     */
    public function setEnvironment($environment)
    {
        $this->_environment = $environment;
    }

    public function execute()
    {
        $namespace = $this->_params['namespace'];
        $listener = $this->_file->getName();
        $listenerClass = rtrim($listener, ".php");
        $classLoader = $this->_environment->getClassLoader();
        $classFullName = $namespace.$classLoader->getNamespaceSeparator(). $listenerClass;
        $classLoader->loadClass($classFullName);

        Manager::getInstance()->addListener(new $classFullName);
    }
}