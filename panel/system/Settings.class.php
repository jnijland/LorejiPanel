<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Settings class
*
* The settings classs handles the interaction between the settings table in the db and the Loreji application
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Settings
{
    /**
     * The set() function updates the setting in the database
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $key The database key
     * @param String $value The new value for the database
     * @return Boolean true
     * @version 0.1.0
     * @package Core
     */
    public static function set($key, $value)
    {
        $setting = $GLOBALS['db']->prepare("UPDATE settings SET se_value_vc=:value WHERE se_key_vc=:key");
        $setting->bindParam(':value', $value);
        $setting->bindParam(':key', $key);
        $setting->execute();
        return true;
    }
	
    /**
     * The get() function loads the sting from the database
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $key The database key
     * @return String with the database value
     * @version 0.1.0
     * @package Core
     */
    public static function get($key)
    {
    	$setting = $GLOBALS['db']->prepare('SELECT * FROM settings WHERE se_key_vc=:key');
        $setting->bindParam(':key', $key);
        $setting->execute();
        $row = $setting->fetch(PDO::FETCH_ASSOC);
        return $row['se_value_vc'];
    }
}
?>