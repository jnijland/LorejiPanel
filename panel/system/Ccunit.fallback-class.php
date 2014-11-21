<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CC-Unit fallback class if /apps/ccunit doest not exist (for example test servers or stand alones)
 * @author  Ramon J. A. Smit <rsmit@loreji.com>
 * @package Loreji
 * @subpackage App\CCUnit
 * @version  $Revision: 0.1.0 $
 * @access   public
 */
class CCunit {

	/**
	 * Function that is being called if /apps/ccunit does not exist.
	 * @param  String 	$method 	Method name
	 * @param  Array 	$args 		Aguments for the called function
	 * @return Boolean				Always returns true
	 */
	static public function __callStatic($method, $args) 
	{
		return true;
	}

	/**
	 * Function that is being called if /apps/ccunit does not exist.
	 * @param  String 	$method 	Method name
	 * @param  Array 	$args 		Aguments for the called function
	 * @return Boolean				Always returns true
	 */
	public function __call($method, $args) {
		return true;
	}

}
