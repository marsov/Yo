<?php

namespace Yo\Listeners\Yo;

use Yo\Event\Listener;

/**
 * Class IsInstalled
 * Checks if the framework is installed
 *
 * @package Yo\Listeners\Yo
 */
class IsInstalled extends Listener
{
    public function __construct()
    {
        $this->_listensForEvents = array(
            'Yo\Framework::start'
        );
    }


}