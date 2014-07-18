<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Route class
*
* The route class handles the behavour of Loreji's URI scheme
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Route 
{
	/**
     * The $defaut contains the "home" string
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static $default = '/home/index';

	/**
     * The $params contains the array after /controller/action
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static $params = array();

	/**
     * The factory() function starts the route
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $structure The structure is set in the index -> $Route = Route::factory('controller/action');
     * @return String Object with the values of the $structure 
     * @version 0.1.0
     * @package Core
     */
	public static function factory($structure = NULL)
	{
		if($structure === NULL)
		{
			$structure = '';
		}

		$params = urldecode($_SERVER['REQUEST_URI']);

		if($params === "/"){
			$params = self::$default;
		} 
		else
		{
			$params = rtrim($params, "/");
		}

		$params = substr($params, 1);
		$params = explode('?', $params);

		$params = ($params[0] === "")? '/' : $params[0];

		$params = explode('/', $params);

		$structure = explode('/', $structure);

		foreach ($structure as $key => $value) {
			$fixParam[$value] = @$params[$key];
			unset($params[$key]);
		}

		foreach ($params as $key => $value) {
			$fixParam['params'][] = $value;
		}

		self::$params = (object) $fixParam;
		return (object) $fixParam;
	}

	/**
     * The controller() calls controllers 
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $controller_name The controller must match as classname and action (Home::action_Index)
     * @version 0.1.0
     * @package Core
     */
	public static function controller($controller_name = NULL)
	{	
		if($controller_name === NULL){
			throw new Exception("Route::[] No controller name given", 1);
		}

		if($controller_name !== "::action_")
		{	
			//ob_start();
			$call = @call_user_func($controller_name);
			//print_r($call);
			//$output = ob_get_contents();
			//ob_end_clean();

			// So, getting rid of annoying error
			//unset($output);
		}	
	}

	/**
     * The make_controller() function starts the route
     * It transforms /controller/action to Controller::action_Index
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $classname The classname as string
     * @param String $function The function as string
     * @return String Formatted for the controller() function
     * @version 0.1.0
     * @package Core
     */
	public static function make_controller($classname = NULL, $function = NULL)
	{
		if($classname === NULL)
		{
			throw new Exception("Route::[] No classname given", 2);
		}
		if($function === NULL)
		{
			//throw new Exception("Route::[] No action given", 3);
			$function = 'index';
		}
		return ucfirst($classname).'::action_'.ucfirst($function);
	}

	/**
     * The redirect() function sends a header for redirection
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $url The url to redirect to
     * @version 0.1.0
     * @package Core
     */
	public static function redirect($url)
	{
		header('location: '.$url);
	}
}
?>