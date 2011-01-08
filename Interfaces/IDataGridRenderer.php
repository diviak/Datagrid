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
 * @version    IDataGridRenderer.php 2010-09-29 divak@gmail.com
 */


interface IDataGridRenderer
{
	/**
	 * @param IDataGrid $datagrid
	 */
	function __construct(IDataGrid $datagrid);
	
	/**
	 * @return Html 
	 */
	function getHtml();
}