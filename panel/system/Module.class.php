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
	 * [$all_permissions List of all the Loreji Permissions]
	 * @var array
	 */
	private static $all_permissions = array(
					'PERM_RUN', 
					'PERM_DB', 
					'PERM_FILE', 
					'PERM_INTERNET', 
					'PERM_DAEMON',
					'PERM_ACCESS_MYSQL_SSL',
					'PERM_ACCESS_DIR_SSL',
					'PERM_NO_LOCKSCREEN',
					'PERM_USE_CREDENTIALS',
					'PERM_USE_LSS_KEY',
					'PERM_READ_SETTINGS',
					'PERM_WRITE_SETTINGS',
					'PERM_READ_MODULE_SETTINGS',
					'PERM_WRITE_MODULE_SETTINGS',
					'PERM_READ_LOREJI_CONFIG',
					'PERM_WRITE_LOREJI_CONFIG',
					'PERM_APPEND_MAIN_MENU'
			);
	/**
	 * [$permssioncalls All permissions that are handles with the checks]
	 * @var array
	 */
	private static $permssioncalls = array(
		'PERM_DAEMON' => array(
			// Empty because there is an other check down under (this will just make sure there will be no 
			// undefined error in PHP wich can caushe the panel to crash.)
			// So this is a placeholder.
			),

		'PERM_APPEND_MAIN_MENU' => array(
			// Empty because there is an other check down under (this will just make sure there will be no 
			// undefined error in PHP wich can caushe the panel to crash.)
			// So this is a placeholder.		
			),

		'PERM_DB' => 
			array(
					'[\'db\']', 
					'mysqli_', 
					'mysql_',
					'mysql',
					'mysqli',
					'pdo',
					'deamon::db()',
					'counter::db()'
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
					'include(',
					'include_once(',
					'require(',
					'require_once(',
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
		'PERM_SHELL' => 
			array(
					'exec(', 
					'system(', 
					'passthru(', 
					'show_source(', 
					'shell_exec(', 
					'pcntl_exec(',
					'popen(',
					'pclose(',
					'proc_open(',
					'proc_nice(',
					'proc_terminate(',
					'proc_get_status(',
					'proc_close(',
					'leak(',
					'apache_child_terminate(',
					'posix_kill(',
					'posix_mkfifo(',
					'posix_setpgid(',
					'posix_setsid(',
					'posix_setuid(',
					'escapeshellcmd(',
					'escapeshellarg(',
			),
		'PERM_ACCESS_MYSQL_SSL' => array(
					'from ssl_cert',
			),
		'PERM_ACCESS_DIR_SSL' => array(
					'/etc/loreji/ssl',
					'loreji/ssl',
					'../ssl',
					'../../ssl',
			),
		'PERM_NO_LOCKSCREEN' => array(
					'template::$lockscreen',
			),
		'PERM_USE_CREDENTIALS' => array(
					'auth::$instance',
					'from auth_users',
					'from \'auth_users',
					'from "auth_users',
					'from `auth_users',
					'parent::user(',
					'controller::user(',
					'auth::check_login('
			),
		'PERM_USE_LSS_KEY' => array(
					'settings::get(\'store_id\')',
					'=store_id',
					'=\'store_id',
					'="store_id',
					'=`store_id',
					'= \'store_id',
					'= "store_id',
					'= `store_id',
			),
		'PERM_READ_SETTINGS' => array(
					'settings::get(',
					'from setting where',
					'from `setting` where',
					'from \'setting\' where',
					'from "setting" where',
			),
		'PERM_WRITE_SETTINGS' => array(
					'settings::set(',
					'setting set',
					'setting` set',
					'setting\' set',
					'setting" set',
			),
		'PERM_READ_MODULE_SETTINGS' => array(
					'module::getsetting',
					'globals[\'modules_active\']',
					'globals[\'modules\']',
					'parent::module_array(',
					'controller::module_array(',
			),
		'PERM_WRITE_MODULE_SETTINGS' => array(
					'module::setsetting',
					'globals[\'modules_active\']',
					'globals[\'modules\']',
					'parent::module_array(',
					'controller::module_array(',
			),
		'PERM_READ_LOREJI_CONFIG' => array(
					'configs/apache2.conf',
					'configs/vhosts.conf',
			),

		'PERM_WRITE_LOREJI_CONFIG' => array(
					'configs/apache2.conf',
					'configs/vhosts.conf',
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
		    } else {
		    	return Language::get($permission);
		    	break;
		    }
		    return '<font color="red">Unknown permission <strong>'.$permission.'</strong></font>';
		    break;


		}
	}


		/**
	     * The Permission_database() function Loads the permissions only used for PERM_RUN
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
		/*echo '<pre>';*/
		foreach ($permissions as $permission) {

			/*echo "<pre>", $modulename, ' -> ', $permission, ' -> ', print_r(self::$permssioncalls[$permission]), "</pre>";*/

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
			}elseif($permission == 'PERM_APPEND_MAIN_MENU'){
				if(!empty(glob(MODPATH."/".$modulename."/views/menu.view.php"))){
					self::throwError(strtoupper($modulename), $permission);
					return false;
				}
			}elseif(self::strposa($innerfile, self::$permssioncalls[$permission]) !== false)
			{	
				//var_dump(self::$permssioncalls[$permission]);
				$line = self::strposa($innerfile, self::$permssioncalls[$permission]);
				self::throwError(strtoupper($modulename), $permission);
				return false;
			}
		}
		/*echo '</pre>';*/
		//var_dump($permissions);
		return true;
	}

	/**
	 * Strpos Arrray
	 * @param  string  $haystack Inside of the controller file
	 * @param  array   $needles  All the checks from $permissions
	 * @param  integer $offset   for recursiveness
	 * @return integer min($chr) Position where the permission is violated
	 */
	public static function strposa($haystack, $needles=array(), $offset=0) 
	{
		$chr = array();
		foreach($needles as $needle) {
			$res = strpos($haystack, $needle, $offset);
			if ($res !== false) $chr[$needle] = $res;
		}
		if(empty($chr)) return false;
		return min($chr);
	}

	/**
	 * Throw permission violation error
	 * @param  string $modulename current modulename
	 * @param  string $permission current permission
	 * @return string html        on the fly generated
	 */
	private static function throwError($modulename, $permission)
	{	

		// With some high exception... a echo in  a method.. IM SO SORRY BUT CANT DO OTHERWISE!
		echo '<div class="alert alert-warning permission-warning" style="display: none;">
		        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        	'.Language::get('global.permission.error', array('{{modname}}', '{{permname}}'), array($modulename, $permission)).'
		        </div>';
	}

	/**
	 * Get module Settings
	 * @param String $module module name
	 * @param String $key    setting key
	 * @return String $jsonarray[$key]	returns the current setting
	 */
	public static function getSetting($module, $key) 
	{
		$json =  file_get_contents(MODPATH.DS.strtolower($module).DS.'config'.DS.'module.json');
		$jsonarray = (array) json_decode($json)->settings;
		return $jsonarray[$key];
	}

	/**
	 * Set module Settings
	 * @param String $module module name
	 * @param String $key    setting key
	 * @param String $value  value for key
	 */
	public static function setSetting($module, $key, $value) 
	{
		$json =  file_get_contents(MODPATH.DS.strtolower($module).DS.'config'.DS.'module.json');
		$jsonarray = json_decode($json);
		$jsonarray->settings->$key = $value;
		file_put_contents(MODPATH.DS.strtolower($module).DS.'config'.DS.'module.json', self::indent(json_encode($jsonarray)));
	}

	/**
	 * beautyfied JSON string
	 * @param  string $json json string
	 * @return string $result beautyfied string
	 */
	public static function indent($json) {

	    $result      = '';
	    $pos         = 0;
	    $strLen      = strlen($json);
	    $indentStr   = '  ';
	    $newLine     = "\n";
	    $prevChar    = '';
	    $outOfQuotes = true;

	    for ($i=0; $i<=$strLen; $i++) {

	        // Grab the next character in the string.
	        $char = substr($json, $i, 1);

	        // Are we inside a quoted string?
	        if ($char == '"' && $prevChar != '\\') {
	            $outOfQuotes = !$outOfQuotes;

	        // If this character is the end of an element,
	        // output a new line and indent the next line.
	        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
	            $result .= $newLine;
	            $pos --;
	            for ($j=0; $j<$pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        // Add the character to the result string.
	        $result .= $char;

	        // If the last character was the beginning of an element,
	        // output a new line and indent the next line.
	        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
	            $result .= $newLine;
	            if ($char == '{' || $char == '[') {
	                $pos ++;
	            }

	            for ($j = 0; $j < $pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        $prevChar = $char;
	    }
	    return $result;
	}

}

?>