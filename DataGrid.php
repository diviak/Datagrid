<?php

/**
 * CMS
 *
 * Copyright (c) 2008, 2009 Stanislav Bazik (http://flue-ex.com)
 *
 * @copyright  Copyright (c) 2008, 2009 Stanislav Bazik
 * @license    GPL
 * @link       http://flue-ex.com
 * @category   Project
 * @package    CMS
 * @version    DataGrid.php 2010-09-29 divak@gmail.com
 */

class DataGrid extends Control implements IDataGrid
{
	/**
	 * @var int
	 */
	static private $counter = 0; 
	
	/**
	 * @var DibiDataSource 
	 */
	private $datasource;
	
	/**
	 * @var string
	 */
	private $primaryKey;
	
	/**
	 * @var DataGridRenderer
	 */
	private $renderer;
	
	/**
	 * @var DataGridPaginator
	 */
	private $paginator;
	
	/**
	 * @var DataGridOrder
	 */
	private $order;
	
	/**
	 * @var DataGridFilter
	 */
	private $filter;
	
	/**
	 * @var boolean
	 */
	private $disableOrder = FALSE;

	/**
	 * @param DibiDataSource $datasource
     * @param string $primaryKey
	 */
	public function __construct(DibiDataSource $datasource, $primaryKey)
	{
		parent::__construct();
		self::$counter++;
		$this->datasource = $datasource;
		$this->primaryKey = $primaryKey;
		$this->renderer = new DataGridRenderer($this);
		$this->paginator = new DataGridPaginator($this);
		$this->order = new DataGridOrder($this);
		$this->filter = new DataGridFilter($this);

        $this->init();
	}


    /**
     * @return void
     */
    protected function init()
    {
        return;
    }
	
	
	/****************************************** getters ******************************************/
	
	/**
	 * @return string
	 */
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}
	
	/**
	 * @return int
	 */
	public function getCounter()
	{
		return self::$counter;
	}
	
	/**
	 * @return array<DibiRow>
	 */
	public function getRows()
	{
		$rows = $this->datasource->getIterator();
		return $rows;	
	}
	
	/**
	 * @return int
	 */
	public function getRowsCount()
	{
		$count = $this->datasource->count();
		return $count;
	}
	
	/**
	 * @return DataGridPaginator
	 */
	public function getPaginator()
	{
		return $this->paginator;
	}
	
	/**
	 * @return DataGridOrder
	 */
	public function getOrder()
	{
		return $this->order;
	}
	
	/**
	 * @return DataGridFilter
	 */
	public function getFilter()
	{
		return $this->filter;
	}
	
	/**
	 * @return Html
	 */
	public function getHtml()
	{
		$this->applyFilters();
		return $this->renderer->getHtml();
	}
	
	/**
	 * @return array<DataGridColumn>
	 */
	public function getColumns()
	{
		$columns = new ArrayObject();
		foreach ($this->getComponents() as $column) {
			$columns->append($column);
		}
		return $columns;
	}
	
	/**
	 * @param string $name
	 * @return DataGridColumn
	 * @throws Exception
	 */
	public function getColumn($name)
	{
		$columns = $this->getColumns();
		if (!isset($columns[$name])) throw new Exception("Column $name doesn't exits");
		return $columns[$name];
	}
	
	
	/**
	 * @return DibiDataSource
	 */
	public function getDataSource()
	{
		return $this->datasource;
	}
	
	
	
	/****************************************** other ******************************************/
	
	/**
	 * @return void
	 */
	private function applyFilters()
	{
		$this->filter->applyFilter();
		$this->order->applyOrder();
		$this->paginator->applyPaginator();
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 * @param int $width
	 * @return DataGridTextColumn
	 */
	public function addTextColumn($name, $caption = NULL, $width = NULL)
	{
		$column = new DataGridTextColumn($name, $caption);
		$column->getHeaderPrototype()->width($width);
		$column = $this->addColumn($column);
		return $column;
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 * @param int $width
	 * @return DataGridNumericColumn
	 */
	public function addNumericColumn($name, $caption = NULL, $width = NULL)
	{
		$column = new DataGridNumericColumn($name, $caption);
		$column->getHeaderPrototype()->width($width);
		$column = $this->addColumn($column);
		return $column;
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 * @param int $width
	 * @return DataGridDateColumn
	 */
	public function addDateColumn($name, $caption = NULL, $width = NULL, $format = NULL)
	{
		$column = new DataGridDateColumn($name, $caption);
		$column->getHeaderPrototype()->width($width);
		$column->setFormat($format);
		$column = $this->addColumn($column);
		return $column;
	}

	/**
	 * @param string $name
	 * @param string $caption
	 * @param int $width
	 * @param string $class
	 * @return DataGridActionColumn
	 */
	public function addActionColumn($name, $caption = NULL, $width = NULL, $class = NULL)
	{
		$columns = $this->getColumns();
		if (isset($columns[$name])) throw new Exception("Column $name already exists");
		$column = new DataGridActionColumn($name, $caption);
		$column->getHeaderPrototype()->width($width);
		$column->getCellPrototype()->class($class);
		$this[$name] = $column;
		return $column;
	}
	
	/**
	 * @param IDataGridColumn $column
	 * @return IDataGridColumn
	 */
	public function addColumn(IDataGridColumn $column)
	{
		$name = $column->getName(); 
		$columns = $this->getColumns();
		if (isset($columns[$name])) throw new Exception("Column $name already exists");
		$this[$name] = $column;
		return $column;
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 */
	public function addTextFilter($name, $caption = NULL)
	{
		$filter = new DataGridFilterText($name, $caption);
		$this->filter->addFilter($filter);
		return $filter;
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 */
	public function addNumericFilter($name, $caption = NULL)
	{
		$filter = new DataGridFilterNumeric($name, $caption);
		$this->filter->addFilter($filter);
		return $filter;
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 */
	public function addDateFilter($name, $caption = NULL)
	{
		$filter = new DataGridFilterDate($name, $caption);
		$this->filter->addFilter($filter);
		return $filter;
	}
	
	/**
	 * @param string $name
	 * @param string $caption
	 * @param array $options
	 */
	public function addSelectFilter($name, $caption = NULL, array $options = array())
	{
		$filter = new DataGridFilterSelect($name, $caption);
		$filter->setOptions($options);
		$this->filter->addFilter($filter);
		return $filter;
	}
	
	/**
	 * @return void
	 */
	public function disableOrder()
	{
		$this->disableOrder = TRUE;
	}
	
	/**
	 * @return void
	 */
	public function enableOrder()
	{
		$this->disableOrder = FALSE;
	}
	
	/**
	 * @return boolean
	 */
	public function hasOrderDisabled()
	{
        $count = $this->getRowsCount();
        if ($count == 0) {
            return TRUE;
        }
		return $this->disableOrder;
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getHtml();
	}
}