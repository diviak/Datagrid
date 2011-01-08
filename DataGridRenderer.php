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
 * @version    DataGridRenderer.php 2010-09-29 divak@gmail.com
 */

class DataGridRenderer extends Object implements IDataGridRenderer
{
	/**
	 * @var string
	 */
	private $cssClass = 'datagrid';
	
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
	
	/**
	 * @param string $cssClass
	 * @return DataGridRenderer
	 */
	public function setCssClass($cssClass)
	{
		$this->cssClass = $cssClass;
		return $this;
	}
	
	/**
	 * @return Html
	 */
	public function getHtml()
	{
		$el = Html::el('div')->class($this->cssClass);
		$this->addFilter($el);
        $this->addTopActions($el);
		
		$rows = $this->datagrid->getRows();
		if ($rows->count()) {
			$table = $el->create('table')->class('grid')->cellpading(0)->cellspacing(0);
			$this->addHeader($table, $rows);
			$this->addBody($table, $rows);
			$this->addPaginator($el, $rows);
		} else {
			$this->addNoResults($rows, $el);
		}
		return $el->render(1);
	}
	
	/**
	 * @param Html $el
	 */
	private function addFilter(Html $el)
	{
		$filter = $el->create('div')->class('filter');
		$form = $this->datagrid->getFilter();
		$filter->setHtml($form->getHtml()); 
	}


    /**
     * @param Html $el
     */
    private function addTopActions(Html $el)
    {
        $columns = $this->datagrid->getColumns();
        $ul = Html::el('ul')->class('top-action');

        foreach ($columns as $column) {
            if ($column instanceof IDataGridActionColumn) {
                foreach ($column->getActions() as $action) {
                   if ($action->getType() === DataGridAction::WITHOUT_KEY) {
                       $li = $ul->create('li');
                       $li->setHtml($action->formatContent());
                   }
                }
            }
        }

        // --- add to container only if has any children
        if ($ul->getChildren()) {
            $el->add($ul);
        }
    }


	/**
	 * @param Html $table
	 * @param DibiResultIterator $rows
	 * @throws Exception
	 */
	private function addHeader(Html $table, DibiResultIterator $rows)
	{
		$tr = $table->create('tr');
		
		/* @var $column DataGridColumn */
		$columns = $this->datagrid->getColumns();
		foreach ($columns as $column) {
			
			// --- checking actions for DataGridActionColumn ---
			if ($column instanceof IDataGridActionColumn && !$column->hasActions()) {
				continue;
			}
			
			$caption = $column->getCaption();
			
			// --- order ---
			if ($column->getCanBeOrdered() && !$this->datagrid->hasOrderDisabled()) {
				$caption = Html::el('span')->class('order');
				
				// --- asc ---
				$asc = Html::el('a')->href($column->getOrderLink(DataGridOrder::ASC))->setText('▲')->title(DataGridOrder::ASC)->class('asc');
				if ($column->isOrdered() && $column->getOrderDirection() === DataGridOrder::ASC) $asc->attrs['class'] .= ' active';
				$caption->add($asc);
				
				// --- caption ---
				$caption->add($column->getCaption());
				
				// --- desc ---
				$desc = Html::el('a')->href($column->getOrderLink(DataGridOrder::DESC))->setText('▼')->title(DataGridOrder::DESC)->class('desc');
				if ($column->isOrdered() && $column->getOrderDirection() === DataGridOrder::DESC) $desc->attrs['class'] .= ' active';
				$caption->add($desc);
			}

            // --- actions column ---
			if ($column instanceof IDataGridActionColumn ) {
                $colspan = 0;
                $actions = $column->getActions();
                foreach ($actions as $action) {
                    if ($action->getType() === DataGridAction::WITH_KEY) {
                        $colspan += 1;
                    }
                }
                if ($colspan > 0) {
                    $th = $tr->create('th')->add($caption);
                    $th->attrs = $column->getHeaderPrototype()->attrs;
                    $th->colspan($colspan);
                }
			} else {
                $th = $tr->create('th')->add($caption);
                $th->attrs = $column->getHeaderPrototype()->attrs;
            }
		}
	}
	
	/**
	 * @param Html $table
	 * @param DibiResultIterator $rows
	 * @throws Exception
	 */
	private function addBody(Html $table, DibiResultIterator $rows)
	{
		/* @var $column DataGridColumn */
		$columns = $this->datagrid->getColumns();
		foreach($rows as $row) {
			$tr = $table->create('tr');
			foreach ($columns as $column) {
				$name = $column->getName();
				
				// --- actions ---
				if ($column instanceof IDataGridActionColumn ) {
					if (!$column->hasActions()) continue;
					$actions = $column->getActions();
					
					foreach ($actions as $action) {
                        if ($action->getType() === DataGridAction::WITH_KEY) {
                            $text = clone $action->formatContent($row);
                            $td = $tr->create('td')->add($text);
                            $td->attrs = $action->getCellPrototype()->attrs;
                            $td->class('action');
                        }
					}
					
				// --- cell ----
				} elseif (array_key_exists($name, $row)) {
					$text = $column->formatContent($row[$name], $row);
					$td = $tr->create('td')->setHtml($text);
					$td->attrs = $column->getCellPrototype()->attrs;
				} else {
					throw new Exception("Column $name doesn't exists");
				}
			}
		}
	}
	
	/**
	 * @param Html $el
	 * @param DibiResultIterator $rows
	 */
	private function addPaginator(Html $el, DibiResultIterator $rows)
	{
		$div = $el->create('div')->class('paginator');
		$paginator = $this->datagrid->getPaginator();
		$div->add($paginator->getHtml());
	}
	
	/**
     * @param DibiResultIterator $rows
	 * @param Html $el
	 */
	private function addNoResults(DibiResultIterator $rows, Html $el)
	{
        $table = $el->create('table')->class('grid')->cellpading(0)->cellspacing(0);

        // --- header ---
        $this->addHeader($table, $rows);

        // --- empty row text ---
        $colspan = 0;
        $columns = $this->datagrid->getColumns();
		foreach ($columns as $column) {
			if ($column instanceof IDataGridActionColumn) {
                $actions = $column->getActions();
                foreach ($actions as $action) {
                    if ($action->getType() === DataGridAction::WITH_KEY) {
                        $colspan += 1;
                    }
                }
			} else {
                $colspan += 1;
            }
        }
        $tr = $table->create('tr')->create('td')->setText('No results')->colspan($colspan);
	}
}