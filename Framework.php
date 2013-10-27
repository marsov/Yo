<?php

namespace Yo;
use Yo\Event\Manager;
use Yo\Layout\Page;
use SplClassLoader;

require '../ClassLoader/SplClassLoader.php';

/**
 * Class Framework
 * @package Yo
 */
class Framework
{
    /**
     * @var Bootstrap
     */
    protected $_bootstrap;

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
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }

    public function __construct(Environment $env)
    {
        $this->_environment = $env;
        $this->_bootstrap = new Bootstrap($this);
    }

    public function start()
    {
        Manager::getInstance()->notify(__METHOD__, $this);
    }

    public function run()
    {
        $this->start();
        Manager::getInstance()->notify(__METHOD__, $this);
        $layout = new Page();
        echo $layout->render();
    }

    public function end()
    {
        Manager::getInstance()->notify(__METHOD__, $this);
    }
}