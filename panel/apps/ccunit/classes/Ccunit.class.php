<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CC-Unit global class
 * @author  Ramon J. A. Smit <rsmit@loreji.com>
 * @package Loreji
 * @subpackage CCUnit\Core
 * @version  $Revision: 0.1.0 $
 * @access   public
 */
class CCunit extends Controller {



	/**
	 * Log system for Loreji/CC-Unit
	 * @param  String $text    Just some text
	 * @param  String $fa_icon Font Awesome icon
	 * @return Boolean          Always true
	 */
	public static function log($text, $fa_icon = 'fa-align-justify'){
		if($fa_icon == NULL){
			$fa_icon = 'fa-align-justify';
		}
		$curruser = Auth::$instance->au_id_in;
		$currtime = time();
		$query = self::maindb()->prepare("INSERT INTO ccunit_logs (`cl_userid_in`, `cl_fa-code_vc`, `cl_message_vc`, `cl_date_in`) 
			VALUES 
			(:userid, :facode, :message, :timestamp)");
		$query->bindParam(':userid', $curruser);
		$query->bindParam(':facode', $fa_icon);
		$query->bindParam(':message', $text);
		$query->bindParam(':timestamp', $currtime);
		$query->execute();
	}

	/**
	 * CCUnit main DB connection
	 * @return Object PDO Object
	 */
	public static function maindb(){
		return $GLOBALS['cdb'];
	}

	/**
	 * Sets every coupled server in a collection array
	 * @return None
	 */
	public static function connect_servers()
	{
		$GLOBALS['ccunit_servers'] = array();
		$query = self::maindb()->prepare("SELECT loreji_ccunit.ccunit_servers.* FROM loreji_ccunit.ccunit_servers WHERE loreji_ccunit.ccunit_servers.cs_removed_ts IS NULL");
		$query->execute();
		foreach ($query->fetchAll() as $server) {
			try {
			    $GLOBALS['ccunit_servers'][$server['cs_id_in']] = new Databasehandler("mysql:host=".$server['cs_ip_in'].";dbname=loreji_core", Encryption::decrypt($server['cs_rootuser_vc']), Encryption::decrypt($server['cs_rootpass_vc']));
		   		$GLOBALS['ccunit_servers'][$server['cs_id_in']]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
			    self::log('Could not connect to server: '.$server['cs_nickname_vc'].'<br />'.$e->getMessage());
			}
		}
	}

	/**
	 * Gets DB object from specefic server
	 * @param  Integer $server_id Server ID
	 * @return Object            PDO Object
	 */
	public static function query_server($server_id = NULL)
	{	
		if($server_id == NULL)
		{
			return $GLOBALS['ccunit_servers'];
		}
		else
		{
			if(!isset($GLOBALS['ccunit_servers'][$server_id]))
			{
				throw new Exception("Unknown Server ID [".$server_id."]", 1);
			}
			else
			{
				return $GLOBALS['ccunit_servers'][$server_id];
			}
		}
	}

	/**
	 * Next server for a user to register
	 * @return Integer Server ID
	 */
	public static function next_server()
	{

	}

	/**
	 * Check if a server port is open
	 * @param  String $host Server IP or Domainname
	 * @param  Integer $port Port to check
	 * @return Boolean       True = port open & False = port closed
	 */
	public static function port_up($host, $port)
	{
		$connection = @fsockopen($host, $port);
		if (is_resource($connection))
		{
		    return TRUE;
		    fclose($connection);
		}
		else
		{
		    return FALSE;
		}
	}

	public static function server_info_from_id($id)
	{
		$query = self::maindb()->prepare("SELECT loreji_ccunit.ccunit_servers.* FROM loreji_ccunit.ccunit_servers WHERE 
			loreji_ccunit.ccunit_servers.cs_id_in=:id ");
		$query->bindParam(':id', $id);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public static function loreji_settings($serverid, $key)
	{
		$query = self::query_server($serverid)->prepare("SELECT
			  loreji_core.settings.*
			FROM
			  loreji_core.settings
			WHERE
				loreji_core.settings.se_key_vc = '".$key."'
		");
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result['se_value_vc'];
	}

} 