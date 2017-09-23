<?php

class test extends app
{
	function __construct(&$parent)
	{
		parent::__construct($parent);

		//easy database handler
		$this->load->lib('easydb', $this->db);
		$this->load->app('aoeo');
		$this->load->config('traits');

		//$this->config = $this->aoeo->config;
		$this->load->model('traiteffect');
		$this->load->model('trait');
		
			
	}
	
	public function c_index($name = null)
	{
		$this->aoeo->header();
		$designs = $this->m_trait->get_all();
		
		$this->show('designsmain', $designs);
    	  $this->aoeo->footer();
 
	}
	
  public function c_type($type) {
      $this->aoeo->header();
			$designs = $this->m_design->get_all_by_type($type);
			$this->show('designlist', $designs);
			$this->aoeo->footer();
	}
	
	public function c_update()
	{
		$this->m_design->db_update();
	}
}
?>