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
 * @version    IDataGridFilterItem.php 2010-10-20 divak@gmail.com
 */


interface IDataGridFilterItem
{
	/**
	 * @param string $name
	 */
	function __construct($name);
	
	/**
	 * @param DibiDataSource $datasource
	 * @param mixed $value
	 */
	function applyFilter(DibiDataSource $datasource, $value);
	
	/**
	 * @param FForm $form
	 */
	function addFormControl(FForm $form);
}