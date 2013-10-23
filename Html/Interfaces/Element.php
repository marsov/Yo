<?php

namespace Yo\Html\Interfaces;

/**
 * Class Element
 * @package Yo\Html\Interfaces
 */
interface Element
{
    public function preRender();
    public function render();
    public function postRender();
}