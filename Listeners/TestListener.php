<?php

namespace Yo\Listeners;

use Yo\Event\Listener;

class TestListener extends Listener
{
    public function __construct()
    {
        $this->_listensForEvents = array(
            'Yo\Html\Template::preRender'
        );
    }
}