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
 * @version    DataGridPaginator.php 2010-09-29 divak@gmail.com
 */

class DataGridPaginator extends Object implements IDataGridPaginator
{
	/**
	 * @var DataGrid
	 */
	private $datagrid;
	
	
	/**
	 * @param DataGrid $datagrid
	 */
	public function __construct(IDataGrid $datagrid)
	{
		$this->datagrid = $datagrid;
	}
	
	
	/****************************************** setters ******************************************/ 
	
	
	/**
	 * @param int $itemsPerPage
	 */
	public function setItemsPerPage($itemsPerPage)
	{
		$this->getPaginator()->itemsPerPage = $itemsPerPage;
	}
	
	
	/****************************************** getters ******************************************/
	
	
	/**
	 * @return FPaginator2
	 */
	private function getPaginator()
	{
		static $paginator;
		if ($paginator === NULL) {
			$paginator = new FPaginator2();
			$paginator->htmlDisplayEnabled = FALSE;
            $paginator->beginTextEnabled = FALSE;
            $paginator->htmlDelim = '';
            $paginator->htmlFirst = 'First';
            $paginator->htmlPrevious = 'Previous';
            $paginator->htmlLast = 'Last';
            $paginator->htmlNext = 'Next';
			$paginator->getName = $this->getPaginatorRequestName();
            $paginator->itemsPerPage = 25;
		}
		return $paginator; 
	}
	
	/**
	 * @return string
	 */
	private function getPaginatorRequestName()
	{
		$name = sprintf("datagrid-%s-page", $this->datagrid->getCounter());
		return $name;
	}
	
	/**
	 * @return Html
	 */
	public function getHtml()
	{
		return $this->getPaginator()->render();
	}
	
	/**
	 * @return void
	 */
	public function applyPaginator()
	{
		$paginator = $this->getPaginator();
		$paginator->items = $this->datagrid->getRowsCount();
		$this->datagrid->getDataSource()->applyLimit($paginator->getLimit(), $paginator->getOffset());
	}
}