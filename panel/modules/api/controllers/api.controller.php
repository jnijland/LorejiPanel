<?php defined('SYSPATH') or die('No direct script access allowed.');

class Api extends Controller
{	
	// Class namespace 
	static $namespace = "com.daltcore.loreji\Api";

	public static function action_Index()
	{	
		Auth::$no_check = TRUE;
		Template::$auto_render = FALSE;
		header('Content-Type: application/json');
		echo json_encode(array('auth' => 'false', 'error' => array('code' => '403', 'desc' => 'User didn\'t login')));
	}

	/* *
	*
		The action_Togglenav() function handles the init of the base tempalte
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Togglenav()
	{	
		Template::$auto_render = FALSE;
		if(Request::method() === "GET")
		{
			if(Cookie::get('nav_collapse') === 'true')
			{	
				echo '{"nav_collapsed":"false"}';
				Cookie::set('nav_collapse', 'false', (3600 * 24 * 5000));
				$_COOKIE['nav_collapse'] = 'false';
			}
			else
			{	
				echo '{"nav_collapsed":"true"}';
				Cookie::set('nav_collapse', 'true', (3600 * 24 * 5000));
				$_COOKIE['nav_collapse'] = 'true';
			}
		}
	}

	public static function action_update()
	{	

		self::check_api_key();

		// We don't need login for this method
		Auth::$no_check = TRUE;

		// We don't need templating for this method 
		Template::$auto_render = FALSE;
		
		if(Request::method() === "GET")
		{	
			echo '<pre>', print_r(Route::$params, true), '</pre>';
		}
	}

	public static function check_api_key()
	{
		return true;
	}
}

