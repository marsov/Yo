<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mirche
 * Date: 10/26/13
 * Time: 3:35 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Yo\FileSystem;


abstract class FileCommand implements Command
{
    /**
     * @var File
     */
    protected $_file;

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->_file = $file;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }

    public function setParams($params)
    {
        // TODO: Implement setParams() method.
    }
}