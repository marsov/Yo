<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mirche
 * Date: 10/25/13
 * Time: 12:57 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Yo\Listeners\Request;
use Yo\Event\Listener as EventListener;

class Listener extends EventListener
{
    public function __construct()
    {
        $this->_listensForEvents = array(
            'Yo\Framework::start'
        );
    }

}