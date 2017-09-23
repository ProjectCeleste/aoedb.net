<?php

class comment extends model
{
  protected $xmlpath;
  
	function __construct(&$parent)
	{
		parent::__construct($parent);
	
		$this->table = 'comments';
		$this->idfield = 'cid';
		$this->orderby_field = 'time';

	}
	
	
	public function make_comment($page, $comment)
	{
		
	}
	
}

?>