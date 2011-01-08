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
 * @version    DataGridOrder.php 2010-09-30 divak@gmail.com
 */

class DataGridOrder extends Object implements IDataGridOrder
{
	/* directions */
	const ASC = 'ASC';
	const DESC = 'DESC';
	const ASC_SHORT = 'A';
	const DESC_SHORT = 'D';
	
	/**
	 * @var array
	 */
	static private $directions = array(
		'A' => self::ASC,
		'D' => self::DESC, 
	);
	
	/**
	 * @var DataGrid
	 */
	private $datagrid;
	
	/**
	 * @var string
	 */
	private $order;
	
	/**
	 * @var string
	 */
	private $direction;
	
	/**
	 * @var boolean
	 */
	private $hasOrder = FALSE;
	
	/**
	 * @param IDataGrid $datagrid
	 */
	public function __construct(IDataGrid $datagrid)
	{
		$this->datagrid = $datagrid;
	}
	
	/**
	 * @return string
	 */
	public function getOrder()
	{
		return $this->order;
	}
	
	/**
	 * @return string
	 */
	public function getDirection()
	{
		return $this->direction;
	}
	
	/**
	 * @return string
	 */
	public function hasOrder()
	{
		return $this->hasOrder;
	}
	
	/**
	 * @param IDataGridColumn $column
	 * @param string $dir
	 * @return string
	 */
	public function getColumnLink(IDataGridColumn $column, $dir)
	{
		$dir = ($dir === self::ASC) ? self::ASC_SHORT : self::DESC_SHORT;
		$params = sprintf("%s=%s%s", $this->getOrderRequestName(), $column->getName(), $dir);
		$url = FTools::addUrlParam($params, NULL, '&');
		return $url;
	}
	
	/**
	 * @return string
	 */
	private function getOrderRequestName()
	{
		$name = sprintf("datagrid-%s-order", $this->datagrid->getCounter());
		return $name;
	}
	
	/**
	 * @return void
	 */
	public function applyOrder()
	{
		if (!$this->datagrid->hasOrderDisabled()) {
			$this->processRequest();
			$datasource = $this->datagrid->getDataSource();
			$columns = $this->datagrid->getColumns();
			/* @var $column DataGridColumn */
			foreach ($columns as $column) {
				if ($column->isOrdered()) {
					$datasource->orderBy(array($column->getName() => $column->getOrderDirection()));
					break;
				}
			}
		}
	}
	
	/**
	 * @return void
	 */
	private function processRequest()
	{
		$request = $_GET;
		$key = $this->getOrderRequestName();
		if (isset($request[$key]) && !empty($request[$key])) {
			// --- order ---
			$this->order = substr($request[$key], 0, -1);
			// --- direction ---
			$dir = strtoupper(substr($request[$key], -1));
			$this->direction = ($dir === self::ASC_SHORT) ? self::ASC : self::DESC;
			$this->hasOrder = TRUE;
		// --- default order ---
		} else {
			foreach ($this->datagrid->getColumns() as $column) {
				if ($column->isOrdered()) {
					$this->order = $column->getName();
					$this->direction = $column->getOrderDirection();
					$this->hasOrder = TRUE;
				}
			}
		}
	}
}