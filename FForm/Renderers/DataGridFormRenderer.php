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
 * @version    DataGridFormRenderer.php 2009-03-19 divak@gmail.com
 */


class DataGridFormRenderer extends DefaultRender
{
	/**
	 * @return string
	 */
	public function getBody()
	{
		$el = Html::el();
		$this->addElements($el);
		$this->addSubmit($el);
		return (string) $el;
	}
	
	/**
	 * @return string
	 */
	public function getHtml()
	{
		$form = Html::el('form');
		$this->addBegin($form);
		$this->addErrorMessage($form);
		$this->addElements($form);
		$this->addEnd($form);
		return (string) $form;
	}
	
	/**
	 * @param Html $form
	 */
	private function addBegin(Html $form)
	{
		$form->action($this->ff->action)->method($this->ff->method)->name($this->ff->name);
		if ($this->ff->hasEnctype()) $form->enctype($this->ff->enctype);
	}

	/**
	 * @param Html $form
	 */
	private function addErrorMessage(Html $form)
	{
		$errors = $this->ff->errors;
		if (!empty($errors)) {
			$form->create('div')
				->class('flash error')
				->setHtml(str_replace('[count]', count($errors), $this->error_info_msg));
		}
	}
	
	/**
	 * @param Html $form
	 */
	private function addElements(Html $form)
	{
		foreach ($this->ff->groups as $group) {
			if ($group['type'] === 'fieldset') {
				$fieldset = $form->create('fieldset');
				$fieldset->create('legend')->setText($group['legend']);
				$table = $fieldset->create('table')->class('form-table');
				
				// --- elements ---
				foreach ($group['elements'] as $key => $name) {
					/* @var $element FControl */
					$element = $this->ff[$name];
					$className = $element->getReflection()->getName();
					if ($className === 'Hidden' || $className === 'Submit') continue;
					
					$tr = $table->create('tr');
					$tr->create('th')->add($element->getLabel());	
					$tr->create('td')->add($element->getControl());
				}
				
				// ---- submits ---
				$tr = $table->create('tr');
				$th = $tr->create('th')->colspan(2);
				foreach ($this->ff->getElements() as $element) {
					if ($element->getReflection()->getName() === 'Submit') {
						$th->add($element->getControl());
					}
				}
			}
		}
	}
	
	/**
	 * @param Html $form
	 */
	private function addEnd(Html $form)
	{
		/* @var $element FControl */
		foreach ($this->ff->elements as $element) {
			if ($element->getReflection()->getName() === 'Hidden') {
				$control = $element->getControl();
				$form->add($control);
			}
		}
	}
}