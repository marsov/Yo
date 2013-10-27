<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mirche
 * Date: 10/26/13
 * Time: 3:22 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Yo\FileSystem;


class File
{
    protected $_absolutePath;

    protected $_fileName;

    public function __construct($absoluteFilePath)
    {
        $this->_absolutePath = $absoluteFilePath;
    }

    public function getName()
    {
        return $this->_fileName;
    }

    public function getAbsolutePath()
    {
        return $this->_absolutePath;
    }
}