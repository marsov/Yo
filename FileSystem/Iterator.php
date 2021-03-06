<?php

namespace Yo\FileSystem;

/**
 * Class Iterator
 * @package Yo\FileSystem
 */
class Iterator
{
    /**
     * @var \SplStack
     */
    protected static $_stack;

    /**
     * @return \SplStack
     */
    public static function getStack()
    {
        if (null == self::$_stack) {
            self::$_stack = new \SplStack();
        }

        return self::$_stack;
    }

    /**
     * @return \SplStack
     */
    public static function cloneStack()
    {
        return clone self::getStack();
    }

    protected $_baseDir;

    public function __construct($dir)
    {
        $this->_baseDir = $dir;
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

        while ($stack->valid()) {
            $path.= FileSystem::PATH_SEPARATOR . $stack->current();
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
            throw new \Exception("Given path is not directory");
        }
    }
}