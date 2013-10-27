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

    protected $_pathParts;

    public function __construct($absoluteFilePath)
    {
        $this->_absolutePath = $absoluteFilePath;

        $this->_pathParts = explode(FileSystem::PATH_SEPARATOR, $absoluteFilePath);

        $this->_fileName = $this->_pathParts[sizeof($this->_pathParts) - 1];
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