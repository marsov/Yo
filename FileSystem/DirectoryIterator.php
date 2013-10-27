<?php

namespace Yo\FileSystem;

use RecursiveIterator;

/**
 * Class DirectoryIterator
 * @package Yo\FileSystem
 */
class DirectoryIterator implements \RecursiveIterator
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

    /**
     * Absolute path of the directory
     *
     * @var string
     */
    protected $_baseDir;

    /**
     * Absolute path of the current element
     *
     * @var string
     */
    protected $_current;

    /**
     * @var \SplObjectStorage;
     */
    protected $_children;

    public function __construct($dir)
    {
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException("The given path is not a directory");
        }

        $this->_baseDir = $dir;
        $this->_current = $dir;
        $this->_children = new \SplObjectStorage();

        $children = scandir($dir);
        if ($children !== false) {
            foreach ($children as $child) {
                $t = array('.', '..');

                if (!in_array($child, $t)) {
                    if (is_dir($this->_baseDir .FileSystem::PATH_SEPARATOR. $child)) {
                        $this->_children->attach(new DirectoryIterator($this->_baseDir .FileSystem::PATH_SEPARATOR. $child));
                    } else {
                        $this->_children->attach(new File($this->_baseDir .FileSystem::PATH_SEPARATOR. $child));
                    }
                }
            }

            $this->_children->rewind();
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->_children->current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_children->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->_children->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_current = $this->_baseDir;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Returns if an iterator can be created for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.haschildren.php
     * @return bool true if the current entry can be iterated over, otherwise returns false.
     */
    public function hasChildren()
    {
        if (is_dir($this->_current)) {
            return true;
        }

        return false;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Returns an iterator for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.getchildren.php
     * @return RecursiveIterator An iterator for the current entry.
     */
    public function getChildren()
    {
        return new DirectoryIterator($this->_current);
    }
}