<?php

namespace Yo\App;


use Yo\EventListeners\LoadListeners;

class Loader
{
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
     * @var array
     */
    protected $_appDirectories;

    public function __construct(array $appDirectories)
    {
        if (!is_array($appDirectories)) {
            throw new \InvalidArgumentException("App directory argument is not array");
        }

        $this->_appDirectories = $appDirectories;
    }

    public function addAppDirectory($appNamespace, $appDirectory)
    {
        $this->_appDirectories[$appNamespace] = $appDirectory;
    }

    public function load()
    {
        foreach ($this->_appDirectories as $namespace => $directory) {
            $loader = new LoadListeners($directory, $namespace);
            $loader->setEnvironment($this->_environment);
            $loader->load();
        }
    }
}