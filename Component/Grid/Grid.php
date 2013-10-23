<?php

namespace Yo\Component\Grid;


class Grid extends \Yo\Component\Component
{

    protected $_filters;

    /**
     * @var \Yo\Data\Source\Source
     */
    protected $_dataSource;

    protected $_actions;

    /**
     * @param \Yo\Data\Source\Source $dataSource
     */
    public function setSource($dataSource)
    {
        $this->_dataSource = $dataSource;
    }

}