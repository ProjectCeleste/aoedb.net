<?php

class spot5differences extends app {

  function __construct(&$parent) 
  {
    parent::__construct($parent);
   
  }
  
  public function c_index($imagename = null) {
    $images = array('gettime' => 0,
    'test' => 1320373936);
    
    if (array_key_exists($imagename, $images)) {
      $this->load_if_elapsed($imagename, $images[$imagename]);
    }
    else {
      $this->error("Image {$imagename} is invalid.");
    }
  }
  
  private function load_if_elapsed($imagename, $time) {
    if ($imagename == 'gettime') {
      echo time();
      exit;
    }
  
    if (time() > $time) {
      header('Content-Type: image/jpeg');
      $im = imagecreatefromjpeg("/apps/spot5differences/{$imagename}.jpg");
      imagejpeg($im);
      imagedestroy($im);
      exit;
    }
    else {
      $timeleft = $time - microtime(true);
      $timestr = date('i:s.u', $timeleft);
      $str = "MWAHAHAHA. I HAVE SOLVED YOUR PUZZLE.\n\nI WILL RELEASE THE SOLUTION TO THE WORLD IN:\n\n" . $timestr;
      $this->error($str);
    }
  }
  
  private function error($str) {
    $width = 400;
    $err_str = $this->wrap(11, 0, 'fonts/arialbd.ttf', $str, $width-24);
    $err_size = imagettfbbox(11, 0, 'fonts/arialbd.ttf', $err_str);
    $height = 24 + $err_size[1] +24;
    
    $im = imagecreatetruecolor($width, $height);
    imagefill($im, 0, 0, imagecolorallocate($im, 0, 0, 0));
    imagefttext($im, 11, 0, 12, 12+11/.75, imagecolorallocate($im, 200, 200, 200), 'fonts/arialbd.ttf', $err_str);
    
    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
    exit;
    
  }
  
  private function wrap($fontSize, $angle, $fontFace, $string, $width) {
    // By ben@spooty.net
    $ret = "";
    $arr = explode(' ', $string);
    foreach ($arr as $word) {
      $teststring = $ret.' '.$word;
      $testbox = imagettfbbox($fontSize, $angle, $fontFace, $teststring);
      if ($testbox[2] > $width) {
        $ret .= ($ret==""?"":"\n").$word;
      }
      else {
        $ret .= ($ret==""?"":' ').$word;
      }
    }
    return $ret;
  }
  
}

/**end of file*/