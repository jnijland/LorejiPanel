<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Controller class
*
* The controller class handles the module controllers
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Counter 
{	

	static $user_id;
	static $package_id;
	static $package_array;

	/**
     * The get_domains() function, gets the array for this element
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return Array $return array with requested values
     */
	public static function get_domains()
	{	
		$return = array();

		$query = self::db()->prepare("SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_type_en='1' AND vh_deleted_ts IS NULL");
		$query -> bindParam(':userid', self::$user_id);
		$query -> execute();

		$return['total'] = self::$package_array['pk_domain_in'];
		$return['used'] =  $query->rowCount();
		$return['avaliable'] = $return['total'] - $return['used'];
		$return['percentage'] = round($return['used'] / $return['total'] * 100, 1);

		return $return;
	}

	/**
     * The get_sub_domains() function, gets the array for this element
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return Array $return array with requested values
     */
	public static function get_sub_domains()
	{	
		$return = array();

		$query = self::db()->prepare("SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_type_en='2' AND vh_deleted_ts IS NULL");
		$query -> bindParam(':userid', self::$user_id);
		$query -> execute();

		$return['total'] = self::$package_array['pk_subdomain_in'];
		$return['used'] =  $query->rowCount();
		$return['avaliable'] = $return['total'] - $return['used'];
		$return['percentage'] = round($return['used'] / $return['total'] * 100, 1);

		return $return;
	}
	
	/**
     * The get_databases() function, gets the array for this element
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return Array $return array with requested values
     */
	public static function get_databases()
	{
		$return = array();

		$query = self::db()->prepare("SELECT * FROM mysql_databases WHERE au_id_in=:userid AND md_deleted_ts IS NULL");
		$query -> bindParam(':userid', self::$user_id);
		$query -> execute();

		$return['total'] = self::$package_array['pk_database_in'];
		$return['used'] =  $query->rowCount();
		$return['avaliable'] = $return['total'] - $return['used'];
		$return['percentage'] = round($return['used'] / $return['total'] * 100, 1);

		return $return;		
	}

	/**
     * The get_package_id() returns package id
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return Integer $row Int Package ID
     */
	public static function get_package_id()
	{
		$query = self::db()->prepare('SELECT * FROM auth_users WHERE au_id_in=:userid');
		$query -> bindParam(':userid', self::$user_id);
		$query -> execute();
		$row = $query -> fetch(PDO::FETCH_ASSOC);
		return $row['pk_id_in'];
	}

		/**
     * The get_package_id() returns package id
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return Integer $row Int Package ID
     */
	public static function get_package()
	{
		$query = self::db()->prepare('SELECT * FROM packages WHERE pk_id_in=:packid');
		$query -> bindParam(':packid', self::$package_id);
		$query -> execute();
	    $row = $query -> fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	/**
     * The init() function extends the sideload function for modules
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function init($user_id = 0)
	{
		if($user_id === 0)
		{
			throw new Exception("No user ID set.", 1);
		}

		self::$user_id = $user_id;
		self::$package_id = self::get_package_id();
		self::$package_array = self::get_package();
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
}
?>