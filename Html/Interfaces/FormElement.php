<?php

namespace Yo\Html\Interfaces;


interface FormElement extends Element {

    public function setValue();
    public function getValue();

}