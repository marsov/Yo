<?php

namespace Yo\FileSystem;


class Iterator
{
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
     * @param null $dir
     * @param ProcessFile $callback
     * @throws \Exception
     */
    public function iterate($dir = null, $callback)
    {
        if ($dir != null) {
            self::getStack()->push($dir);
        }

        // build path
        $stack = self::cloneStack();
        $path = $this->_baseDir;

        while ($stack->valid()) {
            $path.= "/".$stack->current();
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

                            $callback->process(new File($listener, $path), array());

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