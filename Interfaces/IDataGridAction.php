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
 * @version    IDataGridAction.php 2010-10-11 divak@gmail.com
 */


interface IDataGridAction
{
	/**
	 * @param string $name
	 * @param string $caption
	 * @param string $url
	 * @param string $type
	 */
	function __construct($name, $caption, $url, $type);

    /**
     * @return string
     */
    function getType();

	/**
	 * @param DibiRow $row
	 * @return Html
	 */
	function formatContent(DibiRow $row);
}