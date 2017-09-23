<?php
class comments extends app
{
	function __construct(&$parent)
	{
		parent::__construct($parent);
	

		$this->load->model('comment');
		
		
	}
	
	public function c_index()
	{
		
	}
	
	public function c_tips()
	{
		//$page = $this->parent->uri->urlstring;
		
		//$results =  $this->m_comment->page_by_type($page, 'tips');
		
		$this->show('comments', 'tips');
	}
			
	public function c_show($page, $type)
	{
		$results = $this->m_comment->page_by_type($page, $type);
	}
	
	public function c_show_tips($page)
	{
		$results = $this->m_comment->page_by_type($page, 'tips');
	}
	
}
	
?>