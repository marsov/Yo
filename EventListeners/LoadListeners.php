<?php
/**
 * Created by JetBrains PhpStorm.
 * User: arsovi
 * Date: 10/27/13
 * Time: 9:27 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Yo\EventListeners;

use Yo\Environment;
use Yo\FileSystem\ClassIterator;
use Yo\FileSystem\ProcessFile;

class LoadListeners extends ProcessFile
{
    /**
     * @var ClassIterator
     */
    protected $_iterator;

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

    public function __construct($dir, $baseNamespace)
    {
        $this->_command = new LoadListenerCommand();
        $this->_command->setEnvironment($this->_environment);

        $this->_iterator = new ClassIterator($dir, $baseNamespace);
    }

    public function load()
    {
        $this->_iterator->iterate(null, $this);
    }

}