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
 * @version    DataGridColumn_Abstract.php 2010-09-30 divak@gmail.com
 */

abstract class DataGridColumn_Abstract extends ComponentContainer implements IDataGridColumn
{
	/**
	 * @var Html
	 */
	protected $header;
	
	/**
	 * @var Html
	 */
	protected $cell;
	
	/**
	 * @var string
	 */
	protected $caption;
	
	/**
	 * @var array
	 */
	protected $replacements = array();
	
	/**
	 * @var array
	 */
	protected $callbacks = array();
	
	/**
	 * @var boolean
	 */
	protected $canBeOrdered = TRUE;
	
	/**
	 * @var mixed
	 */
	protected $defaultOrder = FALSE;
	
	/**
	 * @param string $name
	 * @param string $caption
	 */
	public function __construct($name, $caption = NULL)
	{
		parent::__construct(NULL, $name);
		$this->caption = $caption;
		$this->header = Html::el();
		$this->cell = Html::el();
		$this->monitor('DataGrid');
	}
	
	/**
	 * @param DataGrid $component
	 * @return void
	 */
	protected function attached($component)	
	{
		if ($component instanceof IDataGrid) {
			$this->setParent($component);
		}
	}
	
	
	/****************************************** getters ******************************************/
	
	
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
	 * @param string $text
     * @param DibiRow $row
	 */
	public function formatContent($text, DibiRow $row)
	{
		// --- replacement ---
		if (!empty($this->replacements)) {
			foreach ($this->replacements as $key => $replacement) {
				if ($text == $key) {
					$text = $replacement;
					break;
				}
			}
		}
		
		// --- callbacks ----
		foreach ($this->callbacks as $callback) {
			$text = call_user_func($callback, $this, $text, $row);
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
	
	/**
	 * @param string $dir
	 */
	public function getOrderLink($dir)
	{
		$link = $this->getDataGrid()->getOrder()->getColumnLink($this, $dir);
		return $link;
	}
	
	/**
	 * @return string
	 */
	public function getOrderDirection()
	{
		$order = $this->getDataGrid()->getOrder();
		if ($order->hasOrder() && $order->getOrder() === $this->getName()) {
			return $order->getDirection();
		}
		return DataGridOrder::ASC;
	}
	
	
	/****************************************** others ******************************************/
	
	
	public function replacement(array $replacements)
	{
		$this->replacements = $replacements;
	}
	
	/**
	 * @param string $dir
	 * @return DataGridColumn_Abstract
	 */
	public function defaultOrder($dir)
	{
		$this->defaultOrder = ($dir === DataGridOrder::ASC) ? DataGridOrder::ASC : DataGridOrder::DESC;
		return $this;
	}
	
	/**
	 * @param array $callback
	 * @return DataGridColumn_Abstract
	 */
	public function addCallback(array $callback)
	{
		$this->callbacks[] = $callback;
		return $this;
	}
	
	/**
	 * @return DataGridColumn_Abstract
	 */
	public function disableOrder()
	{
		$this->canBeOrdered = FALSE;
		return $this;
	}
	
	/**
	 * @return DataGridColumn_Abstract
	 */
	public function enableOrder()
	{
		$this->canBeOrdered = TRUE;
		return $this;
	}
	
	/**
	 * @param boolean $need
	 * @return DataGrid
	 */
	private function getDataGrid($need = TRUE)
	{
		return $this->lookup('DataGrid', $need);
	}
	
	/**
	 * @return boolean
	 */
	public function isOrdered()
	{
		$order = $this->getDataGrid()->getOrder();
		if (!$order->hasOrder() && $this->defaultOrder) {
			return TRUE;
		} elseif ($order->hasOrder() && $order->getOrder() === $this->getName()) {
			return TRUE;
		}
		return FALSE;
	}
}