<?php

namespace Yo\FileSystem;


class ProcessFile
{
    /**
     * @var File
     */
    protected $_file;

    /**
     * @var FileCommand
     */
    protected $_command;

    public function __construct(Command $cmd = null)
    {
        if ($cmd != null) {
            $this->_command = $cmd;
        }
    }

    public function process(File $file, $args)
    {
        $this->_command->setParams($args);
        $this->_command->setFile($file);
        return $this->_command->execute();
    }

}