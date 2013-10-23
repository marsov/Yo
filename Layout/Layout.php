<?php

namespace Yo\Layout;

use SplObjectStorage;
use \Yo\Block;
use Yo\Html\Template;

abstract class Layout implements \Yo\Layout\Interfaces\Layout
{
    /**
     * @var SplObjectStorage
     */
    protected $_blocks;

    /**
     * @var Template
     */
    protected $_template;

    /**
     * @param Template $template
     */
    public function setTemplate($template)
    {
        $this->_template = new $template;
    }

    public function __construct()
    {

    }
}