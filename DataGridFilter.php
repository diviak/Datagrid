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
 * @version    DataGridFilter.php 2010-10-20 divak@gmail.com
 */

class DataGridFilter extends ComponentContainer implements IDataGridFilter
{
	/**
	 * @var DataGrid
	 */
	private $datagrid;
	
	/**
	 * @param IDataGrid $datagrid
	 */
	public function __construct(IDataGrid $datagrid)
	{
		$this->datagrid = $datagrid;
		$this->addComponent(new ComponentContainer, 'filters');
	}
	
	/**
	 * @param IDataGridFilterItem $filter
	 */
	public function addFilter(IDataGridFilterItem $filter)
	{
		$this->getComponent('filters')->addComponent($filter, $filter->getName());
	}

	/**
	 * @return ArrayObject<DataGridFilter>
	 */
	private function getFilters()
	{
		$filters = new ArrayObject();
		foreach ($this->getComponent('filters')->getComponents() as $filter) {
			$filters->append($filter);
		}
		return $filters;
	}
	
	/**
	 * @return void
	 */
	public function applyFilter()
	{
		$data = $this->getForm()->getValues();
		$datasource = $this->datagrid->getDataSource();
		foreach ($this->getFilters() as $filter) {
			$name = $filter->getName();
			if (isset($data[$name]) && !empty($data[$name])) {
				$filter->applyFilter($datasource, $data[$name]);
			}
		}
	}
	
	/**
	 * @return boolean
	 */
	private function hasFilters()
	{
		return $this->getFilters()->count(); 
	}
	
	/**
	 * @return FForm
	 */
	public function getHtml()
	{
		if ($this->hasFilters()) {
			return $this->getForm();
		}
		return NULL;
	}
	
	/**
	 * @return string
	 */
	private function getFilterFormName()
	{
		$name = sprintf("datagrid-%s-filter", $this->datagrid->getCounter());
		return $name;
	}
	
	
	/**
	 * @return FForm
	 */
	private function getForm()
	{
		$form = new FForm($this->getFilterFormName(), FForm::METHOD_GET);
		$form->setRenderClass('DataGridFormRenderer');
		
		$form->addFieldset('Filter');
		foreach ($this->getFilters() as $filter) {
			$filter->addFormControl($form);
		}
		$form->addSubmit('submit', 'Submit')->class('submit_button');
		$form->addSubmit('reset', 'Clean')->class('reset_button');
		
		$form->onValid = array($this, 'Form_submitted');
		$form->clean();
		$form->start();
		return $form;
	}
	
	/**
	 * Provides reset form
	 * 
	 * @param FForm $form
	 */
	public function Form_submitted(FForm $form)
	{
		if ($form->isSubmitedBy('reset')) {
			foreach ($this->getFilters() as $filter) {
				$form[$filter->getName()]->setValue(NULL);
			}
		}
	}
}