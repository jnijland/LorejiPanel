<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Encryption class
*
* The encryption class handles the chippers for Loreji
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Encryption
{   

    /**
     * Chipper type MCRYPT_RIJNDAEL_256
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
    const CYPHER = MCRYPT_RIJNDAEL_256;

    /**
     * Mode MCRYPT_MODE_CBC
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
    const MODE   = MCRYPT_MODE_CBC;

    /**
     * KEY = SEASALT from config file
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
    const KEY    = SEASALT;


    /**
     * The encrypt() encodes string
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $plaintext Standard string as input
     * @return String encoded string with salt
     * @version 0.1.0
     * @package Core
     */
    public static function encrypt($plaintext)
    {   
        $td = mcrypt_module_open(self::CYPHER, '', self::MODE, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, self::KEY, $iv);
        $crypttext = @mcrypt_generic($td, $plaintext);
        mcrypt_generic_deinit($td);
        return base64_encode($iv.$crypttext);
    }

    /**
     * The decrypt() decodes string
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $crypttext Encoded text
     * @return String decoded string
     * @version 0.1.0
     * @package Core
     */
    public static function decrypt($crypttext)
    {
        $crypttext = base64_decode($crypttext);
        $plaintext = '';
        $td        = mcrypt_module_open(self::CYPHER, '', self::MODE, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
        $iv        = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        if ($iv)
        {
            mcrypt_generic_init($td, self::KEY, $iv);
            $plaintext = @mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);
    }
	
    /**
     * The salt() function generated a md5 based of time and rand
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return String 32char MD5 string based on unixtime and rand
     * @version 0.1.0
     * @package Core
     */
	public static function salt(){
		return md5(self::encrypt(time().rand(1,9)));
	}

    /**
     * The random_string() function generated a random string
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param Integer $length The length of the string
     * @return String based on $length
     * @version 0.1.0
     * @package Core
     */
    public static function random_string($length = 32) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'Z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }
}
?>