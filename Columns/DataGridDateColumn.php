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
 * @version    DataGridTextColumn.php 2010-09-30 divak@gmail.com
 */

class DataGridDateColumn extends DataGridColumn_Abstract
{
	/**
	 * @var string
	 */
	private $format;
	
	/**
	 * @param string $format
	 */
	public function setFormat($format)
	{
		$this->format = (string) $format;
	}
	
	/**
	 * @param string $text
	 * @return string
	 */
	private function applyFormat($text)
	{
		if ($this->format) {
			$text = date($this->format, strtotime($text));
		}
		return $text;
	}
	
	/**
	 * @param string $text
     * @param DibiRow $row
	 */
	public function formatContent($text, DibiRow $row)
	{
		$text = $this->applyFormat($text);
		$text = parent::formatContent($text, $row);
		return $text;
	}
}