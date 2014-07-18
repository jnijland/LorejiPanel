<?php defined('SYSPATH') or die('No direct script access allowed.');

class Home extends Controller
{

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Home";

	/* *
	*
		The factory() function handles the init of the base tempalte

	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Index()
	{	
		//print_r(parent::module_array());
		parent::view('index');
	}
}