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
     * @var SplClassLoader
     */
    protected $_classLoader;

    /**
     * @var Bootstrap
     */
    protected $_bootstrap;

    /**
     * @return SplClassLoader
     */
    public function getClassLoader()
    {
        return $this->_classLoader;
    }

    public function __construct()
    {
        $this->_classLoader = new \SplClassLoader('Yo', __DIR__ ."/..");
        $this->_classLoader->register();
        $this->_bootstrap = new Bootstrap($this);
    }

    public function start()
    {

    }

    public function run()
    {
        $layout = new Page();
        echo $layout->render();
    }

    public function end()
    {

    }
}