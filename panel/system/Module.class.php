<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Settings class
*
* The settings classs handles the interaction between the settings table in the db and the Loreji application
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Module 
{	

	/**
     * The Permission_database() function Loads the permissions
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $permission The permission key
     * @return String callback code for the access
     * @version 0.1.0
     * @package Core
     */
	public static function Permission_database($permission = NULL)
	{
		switch ($permission) {
		    case NULL:
		        return NULL;
		        break;
		    case 'PERM_RUN':
		    	return 'include_ok';
		        break;
		    case 'PERM_ALL':
		        return 'perm_all_ok';
		        break;
		}
	}

	/**
     * The Check_illigal_Calls() function checks if any permission is forgotten to include
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $innerfile The inside of the controller file
     * @version 0.1.0
     * @package Core
     */
	public static function Check_illigal_Calls($innerfile)
	{
		$call_['PERM_INTERNET'] = array('curl');
		$call_['PERM_FILEIO'] = array('file_get_contents', 'file_put_contents');
	}
}

?>