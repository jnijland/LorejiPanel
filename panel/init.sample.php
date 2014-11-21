<?php 
/**
* The init File
*
* The init file handles the initialization of Loreji Panel
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
error_reporting(E_ALL); ini_set('display_errors', 1);

// Define the system paths

/**
 * Define DS Directory seperator 
 */
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

/**
 * Define SYSROOT System root
 */
if(!defined('SYSROOT')) define('SYSROOT', '/etc/loreji/panel');

/**
 * Define SYSPATH System path
 */
if(!defined('SYSPATH')) define('SYSPATH', SYSROOT.DS.'system');

/**
 * Define MODPATH Modules path
 */
if(!defined('MODPATH')) define('MODPATH', SYSROOT.DS.'modules');

/**
 * Define MODPATH Modules path
 */
if(!defined('TMPPATH')) define('TMPPATH', SYSROOT.DS.'temp');

/**
 * Define CACHEPATH Cache path
 */
if(!defined('CACHEPATH')) define('CACHEPATH', SYSROOT.DS.'cache');

/**
 * Define SEASALT Salt for hashes
 */
if(!defined('SEASALT')) define('SEASALT', '{{INSTALL_SALT}}');

/**
 * Define MYSQL_HOST hostname for PDO 
 */
if(!defined('MYSQL_HOST')) define('MYSQL_HOST', 'localhost');

/**
 * Define MYSQL_USER username for PDO 
 */
if(!defined('MYSQL_USER')) define('MYSQL_USER', 'root');

/**
 * Define MYSQL_PASS password for PDO 
 */
if(!defined('MYSQL_PASS')) define('MYSQL_PASS', '{{INSTALL_MYSQLPASS}}');

/**
 * Define MYSQL_DBMS database for PDO 
 */
if(!defined('MYSQL_DBMS')) define('MYSQL_DBMS', 'loreji_core');

// Load every system controller
foreach (glob(SYSPATH.DS."*.class.php") as $filename) {
	require($filename);
}

require(MODPATH.DS.'auth'.DS.'controllers'.DS.'auth.controller.php');
require(MODPATH.DS.'language'.DS.'controllers'.DS.'language.controller.php');
// Lets do the language init
Language::Init_files();

// Read module.json files
$modules_json_array = array();
$GLOBALS['modules_active'] = NULL;
foreach (glob(MODPATH."/*/config/module.json") as $filename) {
	//require($filename);
	$inner_json = file_get_contents($filename);
	$json_array = json_decode($inner_json);
	$modules_json_array[] = $json_array;
	foreach ($json_array->permissions as $key => $value) {
		$perm = Module::Permission_system_database($value);
		if($perm === "PERM_RUN_OK")
		{
			// Load every module controller
			foreach (glob(MODPATH.DS.$json_array->name.DS."controllers".DS."*.controller.php") as $filename) {
				$innerfile = file_get_contents($filename);
				if(Module::Check_illigal_Calls($innerfile, $json_array->permissions, $json_array->name) === true){
					require_once($filename);
					$GLOBALS['modules_active'][] = $json_array;
				}	
			}
		}
	}
}	

// This contains all  the modules!
$GLOBALS['modules'] = $modules_json_array;

// This contains only the loaded modules! 
//print_r($GLOBALS['modules_active']);
?>