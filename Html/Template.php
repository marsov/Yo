<?php

namespace Yo\Html;
use Yo\Event\Manager;

/**
 * Class Template
 * Class for representation of a html template
 * @package Yo\Html
 */
class Template
{
    /**
     * Template file path
     *
     * @var string
     */
    protected $_templateFile;

    /**
     * Template variables
     *
     * @var array
     */
    protected $_vars;

    /**
     * @var string
     */
    protected $_htmlString;

    public function preRender()
    {
        Manager::getInstance()->notify(__METHOD__, $this);
    }

    /**
     * Returns the html as string
     *
     * @return string
     */
    public function render()
    {
        $this->preRender();
        Manager::getInstance()->notify(__METHOD__, $this);

        ob_start();
        // define vars
        foreach ($this->getVars() as $varName => $varValue)
        {
            $$varName = $varValue;
        }

        include $this->getTemplateFile();

        $this->_htmlString = ob_get_contents();
        // TODO, store html in file
        ob_end_clean();

        $this->postRender();

        return $this->_htmlString;
    }

    public function postRender()
    {
        Manager::getInstance()->notify(__METHOD__, $this);
    }

    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->_templateFile;
    }

    public function setTemplateFile($templateScript)
    {
        $templateDir = __DIR__ . "/Templates/";
        if (file_exists($templateDir . $templateScript)) {
            $this->_templateFile = $templateDir . $templateScript;
        } else {
            throw new \InvalidArgumentException(" $templateDir ne e dobra pateka");
        }


    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->_vars;
    }

    /**
     * Construct Template
     */
    public function __construct()
    {
        $this->_vars = array();
    }

    /**
     * Assign variable in the template file
     *
     * @param $varName
     * @param $varValue
     */
    public function assign($varName, $varValue)
    {
        $this->_vars[$varName] = $varValue;
    }
}