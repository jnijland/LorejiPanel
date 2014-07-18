<?php defined('SYSPATH') or die('No direct script access allowed.');

class Guide extends Controller
{	
	// Class namespace 
	static $namespace = "com.daltcore.loreji\Guide";

	/* *
	*
		The index()
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Index()
	{	
		Parent::view('index');
	}
}
?>