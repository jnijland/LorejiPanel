<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Request class
*
* The request classs handles the interaction between the browser and the Loreji application
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Request 
{
	/**
     * The method() checks what request method is used. GET/POST/PUT/DELETE
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return String with uppercase request method
     * @version 0.1.0
     * @package Core
     */
	public static function method()
	{	
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

	/**
     * The post() function loads and parses the $_POST inputs
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $key The post key to get the value from
     * @param String $val Overrule the given key
     * @return STDObject full POST object | String return single $key selected value
     * @version 0.1.0
     * @package Core
     */
	public static function post($key = NULL, $val = NULL)
	{
		if(self::method() === "POST")
		{	

			if($val !== NULL){
				$value = $_POST[$key] = $val;
				return $value;
			}

			if($key != NULL)
			{
				return (isset($_POST[$key])) ? $_POST[$key] : '' ;
			} 
			else 
			{
				return (object) $_POST;
			}
		}
	}

	/**
     * The get() function loads and parses the $_GET inputs
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $key The get key to get the value from
     * @param String $val Overrule the given key
     * @return STDObject full GET object | String return single $key selected value
     * @version 0.1.0
     * @package Core
     */
	public static function get($key = NULL, $val = NULL)
	{
		if(self::method() === "GET")
		{	

			if($val !== NULL){
				$value = $_GET[$key] = $val;
				return $value;
			}

			if($key != NULL)
			{
				return (isset($_GET[$key])) ? $_GET[$key] : '' ;
			} 
			else 
			{
				return (object) $_GET;
			}
		}
	}
}
?>