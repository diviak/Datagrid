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
 * @version    IDataGridColumn.php 2010-09-30 divak@gmail.com
 */


interface IDataGridColumn
{
	/**
	 * @return string
	 */
	function getCaption();
	
	/**
	 * @param string $text
     * @param DibiRow $row
	 */
	function formatContent($text, DibiRow $row);
	
	/**
	 * @return boolean
	 */
	function getCanBeOrdered();
	
	/**
	 * @param string $dir(ASC,DESC)
	 */
	function getOrderLink($dir);
	
	/**
	 * @return boolean
	 */
	function isOrdered();
	
	/**
	 * @return string (ASC,DESC)
	 */
	function getOrderDirection();
}