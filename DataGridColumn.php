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
 * @version    DataGridColumn.php 2010-09-30 divak@gmail.com
 */

class DataGridColumn extends Object implements IDataGridColumn
{
	/* aligns */
	const ALIGN_LEFT = 'left';
	const ALIGN_CENTER = 'center';
	const ALIGN_RIGHT = 'right';
	
	/**
	 * @var Html
	 */
	private $header;
	
	/**
	 * @var Html
	 */
	private $cell;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var string
	 */
	private $caption;
	
	/**
	 * @var array
	 */
	private $callbacks = array();
	
	/**
	 * @var boolean
	 */
	private $canBeOrdered = TRUE;
	
	/**
	 * @param string $name
	 * @param string $caption
	 */
	public function __construct($name, $caption = NULL)
	{
		$this->setName($name);
		$this->setCaption($caption);
		$this->setHeader(Html::el());
		$this->setCell(Html::el());
	}
	
	
	/****************************************** setters ******************************************/
	
	/**
	 * @param string $name
	 */
	private function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * @param Html $header
	 */
	private function setHeader(Html $header)
	{
		$this->header = $header;
	}
	
	/**
	 * @param Html $cell
	 */
	private function setCell(Html $cell)
	{
		$this->cell = $cell;
	}
	
	/**
	 * @param string $caption
	 * @return IDataGridColumn
	 */
	private function setCaption($caption)
	{
		$this->caption = $caption;
		return $this;	
	}
	
	/**
	 * @param boolean $canBeOrdered
	 */
	public function setCanBeOrdered($canBeOrdered)
	{
		$this->canBeOrdered = (bool) $canBeOrdered;
		return $this;
	}
	
	
	/****************************************** getters ******************************************/
	
	
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @return string
	 */
	public function getCaption()
	{
		if (!$this->caption) return $this->getName();
		return $this->caption;
	}
	
	/**
	 * @return Html
	 */
	public function getHeaderPrototype()
	{
		return $this->header;
	}
	
	/**
	 * @return Html
	 */
	public function getCellPrototype()
	{
		return $this->cell;
	}
	
	/**
	 * @return array
	 */
	public function getCallbacks()
	{
		return $this->callbacks;
	}
	
	/**
	 * @param unknown_type $text
	 */
	public function getModifiedCellText($text)
	{
		foreach ($this->getCallbacks() as $callback) {
			$text = call_user_func($callback, $this, $text);
		}
		return $text;	
	}
	
	/**
	 * @return boolean
	 */
	public function getCanBeOrdered()
	{
		return $this->canBeOrdered;
	}
	
	
	/****************************************** others ******************************************/
	
	
	/**
	 * @param array $callback
	 */
	public function addCallback(array $callback)
	{
		$this->callbacks[] = $callback;
	}
	
	/**
	 * @return void
	 */
	public function disableOrder()
	{
		$this->setCanBeOrdered(FALSE);
	}
	
	/**
	 * @return void
	 */
	public function enableOrder()
	{
		$this->setCanBeOrdered(TRUE);
	}
}