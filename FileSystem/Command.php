<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mirche
 * Date: 10/26/13
 * Time: 3:23 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Yo\FileSystem;


interface Command
{
    public function execute();
    public function setParams($params);
}