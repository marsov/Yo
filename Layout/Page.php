<?php

namespace Yo\Layout;
use \Yo\Html\Page as PageTemplate;

class Page extends Layout {

    public function __construct()
    {
        parent::__construct();
        $this->_template = new PageTemplate();
    }

    public function render()
    {
        return $this->_template->render();
    }

}