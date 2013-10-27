<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mirche
 * Date: 10/25/13
 * Time: 3:09 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Yo\Listeners\Request\Handler\Plugins;


use Yo\Event\Listener;

class Logger extends Listener
{
    public function __construct()
    {
        $this->_listensForEvents = array(
            'Yo\Framework::start'
        );
    }
}