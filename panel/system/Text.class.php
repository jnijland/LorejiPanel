<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The text class
*
* The text class handles the formatting of texts
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Text 
{	
	/**
	*
	*	The widont() function handles optional views of the template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	* @param String $str String to widont
	* @return String $str Nice formatted string
	*/
	public static function widont($str = '')
	{
	    $str = rtrim($str);
	    $space = strrpos($str, ' ');
	    if ($space !== false)
	    {
	        $str = substr($str, 0, $space).'&nbsp;'.substr($str, $space + 1);
	    }
	    return $str;
	}
}
?>