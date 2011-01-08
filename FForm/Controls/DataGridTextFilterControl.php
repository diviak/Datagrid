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
 * @version    DataGridTextFilterControl.php 2010-10-22 divak@gmail.com
 */

class DataGridTextFilterControl extends FControl
{
	/**
	 * @var array
	 */
	private $options = array(
		'%' => 'LIKE %%',
		'like' => 'LIKE',
		'=' => '=',
	);
	
	/**
	 * @param array $value
	 * @return DataGridTextFilterControl
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
	

	/**
	 * @return Html
	 */
	public function getControl()
	{
		$form = $this->owner;
		$table = Html::el('table')->border(0);
		$tr = $table->create('tr');
		
		// --- text ---
		$td = $tr->create('td')->style('padding: 0;');
		$text = $form->getElement('Text', 'value', NULL, $this->getName());
		if (isset($this->value['value'])) $text->setValue($this->value['value']);
		$td->add($text->getControl());
		
		// --- dropdown ---
		$td = $tr->create('td')->style('padding: 0;');
		$dropdown = $form->getElement('Select', 'operand', NULL, $this->getName())
			->setOptions($this->options)
			->style('height: 25px;');
		if (isset($this->value['operand'])) $dropdown->setValue($this->value['operand']);
		$td->add($dropdown->getControl());
		
		return $table;
	}
}