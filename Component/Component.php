<?php

namespace Yo\Component;
use \Yo\Html\Element;
use \Yo\Html\Template;


abstract class Component extends Element implements \Yo\Component\Interfaces\Component
{
    protected $_config;

    /**
     * @var Template
     */
    protected $_template;

    /**
     * @return string
     */
    public function render()
    {
        return $this->_template->render();
    }

}