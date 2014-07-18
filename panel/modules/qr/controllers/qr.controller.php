<?php defined('SYSPATH') or die('No direct script access allowed.');

class Qr extends Controller
{	

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Qr";

	/* *
	*
		The action_Render() function renders QR, saves to server and presents to user
		$url/qr/render/$string
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Render()
	{	
		// We don't need login for this method
		Auth::$no_check = TRUE;

		// We don't need templating for this method 
		Template::$auto_render = FALSE;
		
		$action = Route::$params->params[0];
		header('content-type: image/png');
		echo file_get_contents("https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".urlencode($action)."&choe=UTF-8");
	}

}
?>