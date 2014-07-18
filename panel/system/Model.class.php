<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Model class
*
* The controller class handles the database features
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Model 
{	

	/**
     * The __construct() function handles the init of the modal
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public function __construct()
	{

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
     * The load() function includes the modal for the called object
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
	 * @return STDObject DB from global  
     * @version 0.1.0
     * @package Core
     */
	public static function load($model, $method, $value = NULL)
	{	
		if(strpos($model, '/') !== FALSE)
		{
			$args = explode('/', $model);
			$MODEL_root = SYSROOT.DS.'modules'.DS.$args[0].DS.'models';
			$model = $args[1];
		}	
		else
		{
			$MODEL_root = SYSROOT.DS.'modules'.DS.Route::$params->controller.DS.'models';
		}
		require_once($MODEL_root.DS.ucfirst($model).'.php');
		if(class_exists('Model_'.ucfirst($model))){
			if($value === NULL)
			{
				return call_user_func_array(array('Model_'.ucfirst($model), $method), array(NULL));
			}
			else
			{
				return call_user_func_array(array('Model_'.ucfirst($model), $method), array($value));
			}
		}
	}

}
?>