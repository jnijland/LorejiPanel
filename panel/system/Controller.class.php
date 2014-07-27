<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Controller class
*
* The controller class handles the module controllers
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Controller 
{
	/**
     * The view() function extends the sideload function for modules
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $view The name of the view file
     * @version 0.1.0
     * @package Core
     */
	public static function view($view)
	{	
		if(file_exists(SYSROOT.DS.'modules'.DS.Route::$params->controller.DS.'views'.DS.$view.'.php')){
			Template::sideload('{{base::viewpanel}}', SYSROOT.DS.'modules'.DS.Route::$params->controller.DS.'views'.DS.$view.'.php');
		} 
		else 
		{
			throw new Exception("Parent::view('".$view."'); cannot be loaded. ", 4);
		}
	}

	/**
     * The model() function extends the sideload function for modules
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $view The name of the view file
     * @version 0.1.0
     * @package Core
     */
	public static function model($model, $method, $value = NULL)
	{	
		return Model::load($model, $method, $value);
	}

	/**
     * The db() function extends the DB for the modules
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
	 * @return STDObject DB from global  
     * @version 0.1.0
     * @package Core
     */
	public static function db()
	{
		return $GLOBALS['db'];
	}

	/**
     * The module_array() function extends the DB for the modules
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
	 * @return Array object with module list 
     * @version 0.1.0
     * @package Core
     */
	public static function module_array()
	{
		return $GLOBALS['modules'];
	}

	/**
     * The user() function extends the DB for the modules
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $name The row to get from the user option
	 * @return STDObject user from Auth
     * @version 0.1.0
     * @package Core
     */
	public static function User($name)
	{
		$user = Auth::check_login();
		return $user[$name];
	}


	public static function anti_injection($sql) {
	    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|*|--|\)/"),"",$sql);
	    $sql = trim($sql);
	    $sql = strip_tags($sql);
	    $sql = addslashes($sql);
	    return $sql;
	}
}
?>