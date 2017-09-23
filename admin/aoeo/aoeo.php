<?php

class aoeo extends app
{	
	public $user;
	
	function __construct(&$parent)
	{
		parent::__construct($parent);
		
	}

	/****************************************************************
	 *                      Controllers                             *
	 ****************************************************************/
	
	/**
	 * Receives index
	 * @return null
	 */
	public function c_index($page = null)
	{	
		$data = array();
		
  		$this->checklogin();
  		
  		if($this->user->logged_in)
  			$data['user'] = $this->user;
  		
  		$this->show('header', $data);
  		
		if(!$page)
		{
			$this->load->view('index');
		}
		else
		{
			echo "Could not access: $page";
		}
		$this->footer();
	}
	
	private function checklogin()
	{
		$this->load->model('user');
		
		//login and get username
		if(isset($this->m_user))
			$this->user = $this->m_user;
	}
	
	public function c_xml($folder, $file)
	{
		$this->header();
		$this->c_axml($folder, $file);
		$this->footer();
	}
	
	public function c_axml($folder, $file)
	{
		$path = $this->config['exportpath'].$folder.'/'.$file.'.xml';
	
		echo '<textarea cols=80 rows=30>';
		echo file_get_contents($path);
		echo '</textarea>';
	
	}
	
	public function c_search()
	{
		$this->load->app('traits');
		$this->traits->c_search($this->input->post('q'));
	}
	
	public function c_dispimg() {
    require 'libraries/imagecreatefromtga.php';
    require 'libraries/dirRecursive.php';
    $imgpath = $this->config['artpath'];
    $destination = 'images/Art';
    //echo '<pre>';
    echo "<body background='http://i.imgur.com/uaOR2h.jpg'>";
    
    $filelist = dirRecursive($destination . '/ui');
    
    foreach ($filelist as $filename) {
      echo "<img src='{$filename}'>";
    }
    
    $filelist = dirRecursive($destination . '/UserInterface');
    
    foreach ($filelist as $filename) {
      echo "<img src='{$filename}'>";
    }
    
    
//    $filelist = substr($filelist, strlen($imgpath));
    
//    print_r($filelist);
//    $c = 0;
    
/*    $imgpath_len = strlen($imgpath);
    foreach ($filelist as $filename) {
      if (substr($filename, -4, 4) == '.tga' && strpos($filename, '(')) {
        $outputfilename = $destination . substr($filename, $imgpath_len, strpos($filename, '.') - $imgpath_len) . '.png';
        echo "<img src='{$outputfilename}'>\n";
        
        if (!file_exists($outputfilename)) {
          $img = imagecreatefromtga_alpha($filename);
          $outputdir = substr($outputfilename, 0, strrpos($outputfilename, '/'));
          
          if (!is_dir($outputdir)) {
            mkdir($outputdir , 0777, true);
          }
          
          imagepng($img, $outputfilename);
          $c++;
        }
        
        if ($c >= 25)
          exit;
      }
    } */
  }

  	public function header()
  	{
  		$data = array();
  		
  		$this->checklogin();
  		
  		if($this->user->logged_in)
  			$data['user'] = $this->user;
  		
  		$this->show('header', $data);
  		$this->show('searchheader');
  	}
  	
  	public function footer()
  	{
  		$this->show('footer');
  	}
  	
  	private function parse_feed($feed) 
  	{
  		$stepOne = explode("<content type=\"html\">", $feed);
  		$stepTwo = explode("</content>", $stepOne[1]);
  		$tweet = $stepTwo[0];
  		$tweet = htmlspecialchars_decode($tweet,ENT_QUOTES);
  		return $tweet;
  	}
  	
  	public function c_tweets()
  	{
		$username = "aoedb";
		$feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";
		$twitterFeed = file_get_contents($feed);
		echo('&quot;'.$this->parse_feed($twitterFeed).'&quot;');
	}
  	
  	public function c_regions()
  	{
  		$this->header();
  		$this->footer();
  	}
  	
  	public function c_vendors()
  	{
  		$this->header();
  		$this->footer();
  	}
  	
  	public function c_videos()
  	{
  		$this->header();
  		$this->footer();
  	}
  	
  	function c_login($backto=null)
  	{
  		if(isset($backto))
  			$this->backto = $backto;
  		
  		$this->checklogin();
  	
  		if($this->input->post('uname') && $this->input->post('password'))
  		{
  			
  			if($this->user->login_form($this->input->post('uname'), $this->input->post('password')))
  			{ //successful login
  				$this->goback();
  			}
  			else
  			{
  				$this->header();
  				$this->show('invalid_login');
  			}
  				
  		}
  		
  		else
  		{
  			$this->header();
  		}
  	
  		if(!isset($this->user->name))		
  			$this->c_login_screen();
  		else
  			$this->goback();
  		
  		$this->footer();
  	
  	}
  	
  	function c_logout($backto = null)
  	{
  		if(isset($backto))
  			$this->backto = $backto;
  		
  		$this->checklogin();
  		 
  		$this->user->logout();
  		
  		$this->header();
  		
  		$this->footer();
  		
  		$this->goback();
  		 
  	}
  	
  	function c_login_screen()
  	{
  		$this->load->view('login');
  	}
  	
  	function c_register_screen()
  	{
  		$this->load->view('register');
  	}
  	
  	function c_register()
  	{
  		if($this->input->post('username') && $this->input->post('password') && $this->input->post('email'))
  		{
  			$this->load->model('user');
  			$this->m_user->register($this->input->post('username'), $this->input->post('password'), $this->input->post('email'));
  			$this->goback();
  		}
  	
  		else if (count($this->input->post) > 0)
  		{
  			echo "Please fill out all fields";
  		}
  	
  		else
  		{
  			$this->header();
  			$this->c_register_screen();
  			$this->footer();
  		}
  	}
 	
  	function goback()
  	{
  		echo '<meta http-equiv="REFRESH" content="0;url=/aoeo/">';

  	}
}

/**end of file*/