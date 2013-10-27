<?php

namespace Yo;

require '../ClassLoader/SplClassLoader.php';
use SplClassLoader;

class Environment
{
    /**
     * @var SplClassLoader
     */
    protected $_classLoader;

    protected $_config;

    /**
     * @return SplClassLoader
     */
    public function getClassLoader()
    {
        return $this->_classLoader;
    }

    public function __construct($config)
    {
        $this->_classLoader = new \SplClassLoader('Yo', __DIR__ ."/..");
        $this->_classLoader->register();
        $this->initConfig($config);
    }

    public function initConfig($config)
    {
        if (file_exists($config)) {
            $this->_config = simplexml_load_file($config);
        } else {
            throw new \RuntimeException("Config file is not found");
        }
    }

    public function getConfig()
    {
        return $this->_config;
    }
}