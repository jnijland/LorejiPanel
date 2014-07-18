<?php defined('SYSPATH') or die('No direct script access allowed.');

class Mysql extends Controller
{	

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Mysql";

	/**
	*
	*	The action_Index() function shows the index page
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function action_Index()
	{	
		Parent::view('index');
	}


	/**
	*
	*	The root_db() function handles the root of the DATABASE 
	*
	* @author Ramon SMit <rsmit@loreji.com>
	* @version 0.1.0
	* @package Core
	* @param $databasename string optional database name 
	* @return array PDO statement
	*/
	public static function root_db($databasename = NULL)
	{
		$user = MYSQL_USER;
		$pass = MYSQL_PASS;
		$server = MYSQL_HOST;

		return new PDO("mysql:host=".$server.";dbname=".$databasename, $user, $pass );
	}
}
?>