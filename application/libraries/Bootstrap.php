<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Bootstrap {
	
	 public function __construct()
    {
        $CI =& get_instance();
    }
	
    public function echo_header()
    {
		$link = array(
          'href' => base_url('assest/css/bootstrap.min.css'),
          'rel' => 'stylesheet',
		);
		echo link_tag($link);

		$link = array(
          'href' => base_url('assest/css/bootstrap.min.css'),
          'rel' => 'stylesheet',
		);
		echo link_tag($link);
		
		$link = array(
          'href' => base_url('assest/css/style.css'),
          'rel' => 'stylesheet',
		);
		echo link_tag($link);
		
		echo '<script src="'.base_url('assest/js/jquery-1.10.2.min.js').'"></script>';
		echo '<script src="'.base_url('assest/js/bootstrap.min.js').'"></script>';
    }
}