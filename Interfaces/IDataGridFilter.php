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
 * @version    IDataGridFilter.php 2010-10-20 divak@gmail.com
 */


interface IDataGridFilter
{
	/**
	 * @param IDataGrid $datagrid
	 */
	function __construct(IDataGrid $datagrid);
	
	/**
	 * @param IDataGridFilterItem $filter
	 */
	function addFilter(IDataGridFilterItem $filter);
	
	/**
	 * @return void
	 */
	function applyFilter();
	
	/**
	 * @return FForm
	 */
	function getHtml();
}