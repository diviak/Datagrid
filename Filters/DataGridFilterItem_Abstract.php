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
 * @version    DataGridTextFilter.php 2010-10-20 divak@gmail.com
 */

class DataGridFilterItem_Abstract extends Component implements IDataGridFilterItem
{
	/**
	 * @var string
	 */
	protected $caption;
	
	/**
	 * @var mixed
	 */
	protected $defaultValue;
	
	/**
	 * @param string $caption
	 */
	public function __construct($name, $caption = NULL)
	{
		parent::__construct(NULL, $name);
		$this->caption = $caption;
	}
	
	/**
	 * @param string $value
	 * @return DataGridTextFilter
	 */
	public function defaultFilter($value)
	{
		$this->defaultValue = $value;
		return $this;
	}
	
	/**
	 * @return void
	 */
	public function applyFilter(DibiDataSource $datasource, $value)
	{
	}
	
	/**
	 * @param FForm $form
	 */
	public function addFormControl(FForm $form)
	{
	}
}