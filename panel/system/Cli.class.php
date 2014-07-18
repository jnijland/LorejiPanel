<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The CLI class
*
* The controller class handles the module controllers
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class CLi 
{	
	/**
     * The input() function handles the user input
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $str a description for the user why there is input
     * @return String $line Userinput
     * @version 0.1.0
     * @package Core
     */
	public static function input($str = "user input:")
	{	
		echo $str." ";
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		return trim($line);
	}

	/**
     * The args() function handles the cli arguments
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $str a description for the user why there is input
     * @return String $line Userinput
     * @version 0.1.0
     * @package Core
     */
	public static function args()
	{	
		$returner = array();
		foreach ($GLOBALS['argv'] as $key => $value) {
			if($key != 0){
				$returner[] = $value; 
			}
		}
		return $returner;
	}

	/**
     * The remove_root_mail() function removes the root mail message
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function remove_root_mail()
	{
		exec('rm -rf /var/mail/root');
	}

	/**
     * The secure_input() function handles the user input
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $str a description for the user why there is input
     * @return String $password Userinput
     * @version 0.1.0
     * @package Core
     */
	public static function secure_input($str = "User input:")
	{
		echo $str." ";
		system('stty -echo');
		$password = trim(fgets(STDIN));
		system('stty echo');
		echo "\n";
		return $password;
	}
}
?>