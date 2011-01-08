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
 * @version    DataGridFilterSelect.php 2010-10-22 divak@gmail.com
 */

class DataGridFilterSelect extends DataGridFilterItem_Abstract
{
	/**
	 * @var array
	 */
	private $options = array();
	
	/**
	 * @param array $options
	 */
	public function setOptions(array $options)
	{
		$this->options = $options;
	}
	
	/**
	 * @return void
	 */
	public function applyFilter(DibiDataSource $datasource, $value)
	{
		$datasource->where('%n=%s', $this->getName(), $value);
	}
	
	/**
	 * @param FForm $form
	 */
	public function addFormControl(FForm $form)
	{
		$control = $form->addSelect($this->getName(), $this->caption, $this->options)->setFirstOption('--- Select ---');
		if ($this->defaultValue !== NULL) $control->setValue($this->defaultValue);
		return $control;
	}
}