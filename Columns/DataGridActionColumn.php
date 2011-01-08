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

class DataGridActionColumn extends ComponentContainer implements IDataGridColumn, IDataGridActionColumn
{
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
	
	
	/****************************** interface IDataGridColumn ************************************/
	
	
	/**
	 * @param string $name
	 * @param string $caption
	 */
	public function __construct($name, $caption = NULL)
	{
		parent::__construct();
		$this->name = $name;
		$this->caption = $caption;
		$this->header = Html::el();
		$this->cell = Html::el();
		
		$this->addComponent(new ComponentContainer, 'actions');
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
	
	/**
	 * @param string $name
	 * @param string $caption
	 * @param string $url
	 * @param string $type
	 * @return DataGridActionColumn
	 */
	public function addAction($name, $caption, $url, $type = DataGridAction::WITH_KEY)
	{
		$actions = $this->getActions();
		if (isset($actions[$name])) throw new Exception("Action `$name` allready exists");
		$action = new DataGridAction($name, $caption, $url, $type);
		$this->getComponent('actions')->addComponent($action, $name);
		return $action;
	}
	
	/**
	 * @return ArrayObject<DataGridAction>
	 */
	public function getActions()
	{
		$actions = new ArrayObject();
		foreach ($this->getComponent('actions')->getComponents() as $action) {
			$actions->append($action);
		}
		return $actions;
	}
	
	/**
	 * @param boolean $need
	 * @return DataGrid
	 */
	public function getDataGrid($need = TRUE)
	{
		return $this->lookup('DataGrid', $need);
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
	 * @param string $text
     * @param DibiRow $row
	 */
	public function formatContent($text, DibiRow $row)
	{
		throw new Exception("Not implemented.");
	}
	
	/**
	 * @return boolean
	 */
	public function getCanBeOrdered()
	{
		return FALSE;
	}
	
	/**
	 * @param string $dir
	 */
	public function getOrderLink($dir)
	{
		throw new Exception("Not implemented.");
	}
	
	/**
	 * @return string
	 */
	public function getOrderDirection()
	{
		throw new Exception("Not implemented.");
	}
	
	/**
	 * @return boolean
	 */
	public function isOrdered()
	{
		return FALSE;
	}
	
	
	/****************************** interface IDataGridActionColumn ******************************/
	
	
	/**
	 * @return boolean
	 */
	public function hasActions()
	{
		$actions = $this->getActions();
		return (bool) $actions->count();
	}
	
}