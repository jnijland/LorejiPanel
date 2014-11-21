<?php defined('SYSPATH') or die('No direct script access allowed.');

class Mail extends Controller
{

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Mail";

	// Caller
	public static function action_Index()
	{
		parent::view('index');
	}

	public static function action_Addaccount()
	{
		parent::view('addaccount');
	}
}
?>