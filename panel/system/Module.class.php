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


	public static $all_permissions = array('PERM_RUN', 'PERM_DB', 'PERM_FILE', 'PERM_INTERNET', 'PERM_DAEMON');
	public static $permssioncalls = array(
		'PERM_DB' => 
			array(
					'[\'db\']', 
					'mysqli_', 
					'mysql_',
					'mysql',
					'mysqli',
					'pdo',
			),

		'PERM_FILE' => 
			array(
					'file_put_contents(', 
					'file_get_contents(', 
					'file_exists(', 
					'fopen(', 
					'fwrite(', 
					'fread(', 
					'fclose(',
					'basename(',
					'chgrp(',
					'chmod(',
					'chown(',
					'copy(',
					'delete(',
					'feof(',
					'glob(',
					'is_dir(',
					'is_executable(',
					'is_file(',
					'is_readable(',
					'is_uploaded_file(',
					'is_writable(',
					'is_writeable(',
					'lchgrp(',
					'lchown(',
					'link(',
					'mkdir(',
					'move_uploaded_file(',
					'parse_ini_file(',
					'popen(',
					'readfile(',
					'readlink(',
					'realpath(',
					'rename(',
					'rewind(',
					'rmdir(',
					'symlink(',
					'tempnam(',
					'touch(',
					'umask(',
			),
		'PERM_INTERNET' => 
			array(
					'file_get_contents(', 
					'curl_init(', 
					'checkdnsrr(', 
					'dns_check_record(', 
					'dns_get_mx(', 
					'dns_get_record(',
					'dns_get_record(',
					'fsockopen(',
					'gethostbyaddr(',
					'gethostbyname(',
					'gethostbynamel(',
					'gethostname(',
					'getmxrr(',
					'openlog(',
					'pfsockopen(',
			),
	);


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
		    case 'PERM_RUN': // is checked @ init
			    return 'Activating the module.';
			    break;
		    case 'PERM_DB':
			    return 'May read/write the database';
			    break;
		    case 'PERM_FILE':
			    return 'May read/write the filesystem';
			    break;
			case 'PERM_INTERNET':
				return 'May create a internet socket';
				break;
			case 'PERM_DAEMON':
				return 'May run with daemon';
				break;
		    default:
		    if(strpos($permission, 'MODULE::') !== FALSE){
		    	$permission = str_replace('MODULE::', '', $permission);

		   			// STORE/STORE/INDEX
		    	$permission = explode('/', $permission);
		   			// Check if the dir "STORE" exists
		    	if(file_exists(MODPATH.DS.$permission[0])){
		   				// Sotre dir exists, check if the class will be existing

		   				// Check if the controller STORE exists
		    		if(file_exists(MODPATH.DS.$permission[0].DS.'controllers'.DS.ucfirst($permission[1]).'.controller.php')){
		   					// File does exist
		    			if(method_exists($permission[1],$permission[2])){
		    				return "This module will connect with module <strong>".ucfirst("{$permission[0]}")."</strong>";
		    			} else {
		    				return "<font color='red'>This module could not find method <i><strong>{$permission[2]}</strong></i> in controller <i><strong>{$permission[1]}</strong></i> from module <i><strong>{$permission[0]}</strong></i></font>";
		    			}
		    		} else {
		    			return "<font color='red'>This module could not find controller <i><strong>{$permission[1]}</strong></i> from module <i><strong>{$permission[0]}</strong></i></font> - ";
		    		}
		    	} else {
		    		return "<font color='red'>This module could not find module <i><strong>{$permission[0]}</strong></i></font>";
		    	}
		    }
		    return '<font color="red">Unknown permission <strong>'.$permission.'</strong></font>';
		    break;


		}
	}


		/**
	     * The Permission_database() function Loads the permissions
	     * 
	     * @author Ramon J. A. Smit <ramon@daltcore.com>
	     * @param String $permission The permission key
	     * @return String callback code for the access
	     * @version 0.1.0
	     * @package Core
	     */
		public static function Permission_system_database($permission = NULL)
		{
			switch ($permission) {
				case NULL:
				return NULL;
				break;
				case 'PERM_RUN':
				return 'PERM_RUN_OK';
				break;
				case 'PERM_ALL':
				return 'PERM_ALL_OK';
				break;
				default:
				return 'PERM_UNKNOWN';
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
	public static function Check_illigal_Calls($innerfile, $permissions, $modulename)
	{	$permissions = (array) $permissions;
		//var_dump($permissions);
		//var_dump(self::$all_permissions);
		//$permissions = array_merge($permissions, self::$all_permissions);
		
		//  Removes multi-line comments and does not create
		//  a blank line, also treats white spaces/tabs 
		$innerfile = preg_replace('!/\*.*?\*/!s', '', strtolower($innerfile));

		//  Removes single line '//' comments, treats blank characters
		$innerfile = preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $innerfile);

		//  Strip blank lines
		$innerfile = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $innerfile);

		$cleaned_permissions = array();
		foreach (self::$all_permissions as $key => $value) {
			if(!in_array($value, $permissions)){
				$cleaned_permissions[] = $value;
			}
		}

		unset($permissions);
		$permissions = $cleaned_permissions;
		//echo "Permission Check for module <strong>".strtoupper($modulename)."</strong>";
		//var_dump($permissions);

		foreach ($permissions as $permission) {

			if($permission == 'PERM_DAEMON')
			{
				if(!empty(glob(MODPATH."/".$modulename."/hooks/*.BeforeDaemonHook.php"))){
					self::throwError(strtoupper($modulename), $permission);
					return false;
				}
				if(!empty(glob(MODPATH."/".$modulename."/hooks/*.OnDaemonHook.php"))){
					self::throwError(strtoupper($modulename), $permission);
					return false;
				}
				if(!empty(glob(MODPATH."/".$modulename."/hooks/*.AfterDaemonHook.php"))){
					self::throwError(strtoupper($modulename), $permission);
					return false;
				}
			}elseif(self::strposa($innerfile, self::$permssioncalls[$permission]) !== false)
			{	
				$line = self::strposa($innerfile, self::$permssioncalls[$permission]);
				self::throwError(strtoupper($modulename), $permission);
				return false;
			}
		}

		//var_dump($permissions);
		return true;
	}

	public static function strposa($haystack, $needles=array(), $offset=0) {
		$chr = array();
		foreach($needles as $needle) {
			$res = strpos($haystack, $needle, $offset);
			if ($res !== false) $chr[$needle] = $res;
		}
		if(empty($chr)) return false;
		return min($chr);
	}

	public static function throwError($modulename, $permission)
	{	

		// With some high exception... a echo in  a method.. IM SO SORRY BUT CANT DO OTHERWISE!
		echo '<div class="alert alert-warning permission-warning" style="display: none;">
		        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        	'.Language::get('global.permission.error', array('{{modname}}', '{{permname}}'), array($modulename, $permission)).'
		        </div>';
	}

}

?>