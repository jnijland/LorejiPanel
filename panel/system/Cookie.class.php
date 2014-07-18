<?php 

/**
* The Cookie class
*
* The Daemon classs handles the deamon and all usages
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Cookie
{
    /**
     * The set() function updates the setting in the cookie
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $key The cookie key
     * @param String $value The new value for the cookie
     * @param Integer $expire Expire seconds of cookie [default: 9999]
     * @param String $path Cookie path
     * @return Boolean true
     * @version 0.1.0
     * @package Core
     */
    public static function set($key, $value, $expire=9999,$path='/')
    {
        setcookie($key, encryption::encrypt($value), time()+$expire, $path);
	}
	
    /**
     * The get() function loads the sting from the cookie
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $key The cookie key
     * @return String with the cookie value
     * @version 0.1.0
     * @package Core
     */
    public static function get($key)
    {
    	if(isset($_COOKIE[$key])){
			return encryption::decrypt(@$_COOKIE[$key]);
		}
    }
}
?>