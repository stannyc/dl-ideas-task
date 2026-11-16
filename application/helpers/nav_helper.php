<?php
defined('BASEPATH') or exit('No direct script access allowed');

if ( ! function_exists('nav_active')) {	
	function nav_active($controller)	{
		$CI =& get_instance();
		return strtolower($CI->router->fetch_class()) === strtolower($controller) ? ' active' : '';
	}
}
