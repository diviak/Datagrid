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
 * @version    DataGridAction.php 2010-10-11 divak@gmail.com
 */

class DataGridAction extends Component implements IDataGridAction
{
	/* types */
	const WITH_KEY 		= TRUE;
	const WITHOUT_KEY 	= FALSE;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var Html
	 */
	private $caption;
	
	/**
	 * @var string
	 */
	private $url;
	
	/**
	 * @var string
	 */
	private $type;
	
	/**
	 * @var Html
	 */
	private $cell;
	
	
	
	/***************************** interface IDataGridAction *****************************/ 
	
	
	/**
	 * @param string $name
	 * @param string $caption
	 * @param string $url
	 * @param string $type
	 */
	public function __construct($name, $caption, $url, $type)
	{
		parent::__construct();
		$this->name = $name;
		$this->setCaption($caption);
		$this->url = $url;
		$this->setType($type);
		$this->cell = Html::el();
	}
	
	/**
	 * @return DataGridActionColumn
	 */
	private function getColumn()
	{
		return $this->getParent()->getParent();
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
    public function getType()
    {
        return $this->type;
    }
	
	/**
	 * @param string $type
	 */
	private function setType($type)
	{
		if ($type !== self::WITH_KEY && $type !== self::WITHOUT_KEY) throw new Exception("Wrong type entered `$type`");
		$this->type = $type;
		return $this;
	}

	/**
	 * @param mixed $caption (string, Html)
	 */
	private function setCaption($caption)
	{
		if ($caption instanceof Html) {
			$this->caption = $caption;
		} else {
			$this->caption = Html::el('a')->setText($caption);
		}
		return $this;
	}
	
	/**
	 * @return Html
	 */
	public function getCellPrototype()
	{
		return $this->cell;
	}
	
	/**
	 * @param DibiRow $row
	 * @return Html
	 */
	public function formatContent(DibiRow $row = NULL)
	{
		// --- url ---
		if ($this->type === self::WITHOUT_KEY) {
			$this->caption->href($this->url);
		} else {
			$key = $this->getDataGrid()->getPrimaryKey();
			$params = array($key => $row->$key);
			$url = FTools::addUrlParam($params, $this->url);
			$this->caption->href($url);
		}
		return $this->caption;
	}
}