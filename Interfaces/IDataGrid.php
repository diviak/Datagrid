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
 * @version    IDataGrid.php 2010-09-29 divak@gmail.com
 */


interface IDataGrid
{
	/**
	 * @return string
	 */
	function getPrimaryKey();
	
	
	/**
	 * @return int
	 */
	function getCounter();
	
	/**
	 * @return DibiResultIterator
	 */
	function getRows();
	
	/**
	 * @return int
	 */
	function getRowsCount();
	
	/**
	 * @return IDataGridPaginator
	 */
	function getPaginator();
	
	/**
	 * @return IDataGridOrder
	 */
	function getOrder();
	
	/**
	 * @return DataGridFilter
	 */
	function getFilter();
	
	/**
	 * @return array<DataGridColumn>
	 */
	function getColumns();
	
	/**
	 * @param string $name
	 * @return IDataGridColumn
	 */
	function getColumn($name);
	
	/**
	 * @return Html
	 */
	function getHtml();	
	
	/**
	 * @return DibiDataSource
	 */
	function getDatasource();
	
	/**
	 * @return boolean
	 */
	function hasOrderDisabled();
}