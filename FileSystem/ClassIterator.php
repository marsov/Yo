<?php

namespace Yo\FileSystem;

/**
 * Class Iterator
 * @package Yo\FileSystem
 */
class ClassIterator extends Iterator
{
    const NAMESPACE_SEPARATOR = '\\';

    /**
     * @var string
     */
    protected $_baseNamespace;

    public function __construct($dir, $baseNamespace)
    {
        $this->_baseNamespace = $baseNamespace;
        parent::__construct($dir);
    }

    /**
     * @param string $dir
     * @param ProcessFile $callback
     * @throws \Exception
     */
    public function iterate($dir = null, $callback, $args = array())
    {
        if ($dir != null) {
            self::getStack()->push($dir);
        }

        // build path
        $stack = self::cloneStack();
        $path = $this->_baseDir;
        $namespace = $this->_baseNamespace;
        while ($stack->valid()) {
            $path.= FileSystem::PATH_SEPARATOR.$stack->current();
            $namespace.= self::NAMESPACE_SEPARATOR.$stack->current();
            $stack->prev();
        }

        if (is_dir($path))
        {
            $listeners = scandir($path);
            foreach ($listeners as $listener) {
                $t = array('.', '..');

                if (!in_array($listener, $t)) {

                    if (is_dir($path .FileSystem::PATH_SEPARATOR. $listener)) {
                        $this->iterate($listener);
                    } else {
                        $file = $path .FileSystem::PATH_SEPARATOR. $listener;
                        if (file_exists($file)) {
                            $args = array_merge($args, array('namespace' => $namespace));
                            $callback->process(new File($file), $args);
                        } else {
                            throw new \Exception("File $file does not exist");
                        }
                    }
                }
            }

            if (!self::getStack()->isEmpty()) {
                self::getStack()->pop();
            }
        } else {
            throw new \Exception("Listener path is not directory");
        }
    }
}