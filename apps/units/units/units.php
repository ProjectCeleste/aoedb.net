<?php

class units extends app
{	
	function __construct(&$parent)
	{
		parent::__construct($parent);
		
		$this->load->app('aoeo');
		$this->load->app('comments');
		
		$this->config['protopath'] = $this->aoeo->config['protopath'];
		
		$this->load->model('proto');	
			
	}
	
	protected function header()
	{
		$this->aoeo->header();
	}
	
	protected function footer()
	{
		//$this->comments->c_tips();
		$this->aoeo->footer();
	}
	
	public function c_index($id = null)
	{
		$this->header();
		
		if(!$id)
		{
			$this->load->view('unitsmain');
		}
		
		else if($this->m_proto->load($id))
		{
			$unit = $this->m_proto;
			$unit->info['config'] = $this->config;
			$this->load->view('unit', $unit->info);
		}
		else
		{
			echo 'Could not load unit';
		}
		
		$this->footer();
	}
	
	public function xml($name)
	{
		if(is_file($this->config['exportpath'].'proto/'.$name.'xml'))
			echo file_get_contents($this->config['exportpath'].'proto/'.$name.'xml');
		else
			return null;
	}
	
	public function c_update()
	{
		$this->m_proto->db_update();
		$this->m_proto->db_update_toc();
	}
	
	function c_list()
	{
		$this->header();
		$qs = $this->m_proto->get_all();
		foreach($qs as $q)
		{
			echo "<a href='/aoeo/units/{$q['DBID']}'>{$q['DisplayName']}</a> <br />";
		}
		$this->footer();
	}
	
	public function c_type($utype)
	{
		$this->aoeo->header();
		$units = $this->m_proto->GetAllByType($utype);
		$units['config'] = $this->config;
		$this->load->view('unitslist', $units);
		$this->aoeo->footer();
	}

	public function c_utype($utype)
	{
		$this->aoeo->header();
		$units = $this->m_proto->GetAllByUType($utype);
		$units['config'] = $this->config;
		$this->load->view('unitslist', $units);
		$this->aoeo->footer();
	}
	
	public function c_civ($uciv)
	{
		$this->aoeo->header();
		$units = $this->m_proto->GetAllByCiv($uciv);
		$units['config'] = $this->config;
		$this->load->view('unitslist', $units);
		$this->aoeo->footer();
	}
	
	public function c_units()
	{
	
		$this->header();
		$this->load->view('unitsmain');
		$this->footer();
	}
	
}
	

/**end of file*/