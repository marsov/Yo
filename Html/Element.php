<?php

namespace Yo\Html;

abstract class Element implements \Yo\Html\Interfaces\Element
{
    /**
     * @var \SplObjectStorage
     */
    protected $_children;

    /**
     * @var Template
     */
    protected $_template;

    /**
     * @var string
     */
    protected $_htmlString;

    /**
     * @return \SplObjectStorage
     */
    public function getChildren()
    {
        return $this->_children;
    }

    public function __construct()
    {
        $this->_template = new Template();
    }

    /**
     *
     */
    public function preRender()
    {
        $this->_children->rewind();
        while ($this->_children->valid())
        {
            $this->_children->current()->preRender();
            $this->_children->next();
        }
    }

    /**
     * Returns the html as string
     *
     * @return string
     */
    public function render()
    {
        $this->_htmlString = $this->_template->render();
        // TODO, store html in file
        return $this->_htmlString;
    }

    /**
     *
     */
    public function postRender()
    {

    }
}