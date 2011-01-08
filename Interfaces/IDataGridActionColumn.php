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
 * @version    IDataGridActionColumn.php 2010-09-30 divak@gmail.com
 */


interface IDataGridActionColumn
{
	/**
	 * @return array<IDataGridAction>
	 */
	function getActions();
	
	/**
	 * @return boolean
	 */
	function hasActions();
}