<?php defined('SYSPATH') or die('No direct script access allowed.');

class Ftp extends Controller
{

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Ftp";

	// Caller
	public static function action_Index()
	{
		parent::view('index');
	}

	public static function action_Createuser()
	{
		parent::view('createuser');
	}

	public static function action_Edit()
	{
		parent::view('edit');
	}
}
?>