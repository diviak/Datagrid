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
 * @version    DataGridFilterNumeric.php 2010-10-25 divak@gmail.com
 */

class DataGridFilterNumeric extends DataGridFilterItem_Abstract
{
	/**
	 * @return void
	 */
	public function applyFilter(DibiDataSource $datasource, $value)
	{
		$datasource->where('%n = %s', $this->getName(), $value);
	}
	
	/**
	 * @param FForm $form
	 */
	public function addFormControl(FForm $form)
	{
		$control = $form->addText($this->getName(), $this->caption);
		if ($this->defaultValue !== NULL) $control->setValue($this->defaultValue);
		return $control;
	}
}