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
 * @version    IDataGridOrder.php 2010-09-30 divak@gmail.com
 */


interface IDataGridOrder
{
	/**
	 * @param IDataGrid $datagrid
	 */
	function __construct(IDataGrid $datagrid);
	
	/**
	 * @return string
	 */
	function getOrder();
	
	/**
	 * @return string
	 */
	function getDirection();
	
	/**
	 * @return boolean
	 */
	function hasOrder();
	
	/**
	 * @param IDataGridColumn $column
	 * @param string $dir
	 * @return string
	 */
	function getColumnLink(IDataGridColumn $column, $dir);
	
	/**
	 * @return void
	 */
	function applyOrder();
}