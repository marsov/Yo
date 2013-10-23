<?php

namespace Yo\Html;

use Yo\Html\Element;
use Yo\Html\Table\Tbody;
use Yo\Html\Table\Thead;

class Table extends Element
{
    /**
     * @var Thead
     */
    protected $_thead;

    /**
     * @var Tbody
     */
    protected $_tbody;

    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function preRender()
    {
        $this->_template->assign('thead', $this->_thead);
        $this->_template->assign('tbody', $this->_tbody);
    }
}