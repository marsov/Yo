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

    public function update(\SplSubject $subject)
    {
        echo "Listener .... update<br/>";
        var_dump($subject->getNotifier());
        var_dump($subject);
    }
}