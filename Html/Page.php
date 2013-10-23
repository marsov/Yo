<?php

namespace Yo\Html;


class Page extends Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplateFile('Page.php');
    }
}