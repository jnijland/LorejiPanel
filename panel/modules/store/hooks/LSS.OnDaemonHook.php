<?php defined('SYSPATH') or die('No direct script access allowed.');

class LSS extends controller
{	
	/**
	*
	*	The _DoAutoLoad() function handles the incomming daemon call
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function _DoAutoLoad()
	{
		printf("Connecting to LSS for service upgrade");
		# Set post vars
		$data = array(
		    'server_os' => self::getLinuxDistro(),
		    'loreji_version' => Settings::get('loreji_version'),
		    'store_id' => Settings::get('store_id')
		);

		# Create a connection
		$url = 'http://loreji.com/php/lss.php';
		$ch = curl_init($url);

		# Form data string
		$postString = http_build_query($data, '', '&');

		# Setting our options
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		# Get the response
		$response = curl_exec($ch);
		//var_dump($response);
		curl_close($ch);
	}

	public static function getLinuxDistro()
    {
        //declare Linux distros(extensible list).
        $distros = array(
                "Arch" => "arch-release",
                "Debian" => "debian_version",
                "Fedora" => "fedora-release",
                "Ubuntu" => "lsb-release",
                'Redhat' => 'redhat-release',
                'CentOS' => 'centos-release');
	    //Get everything from /etc directory.
	    $etcList = scandir('/etc');

	    //Loop through /etc results...
	    $OSDistro;
	    foreach ($etcList as $entry)
	    {
	        //Loop through list of distros..
	        foreach ($distros as $distroReleaseFile)
	        {
	            //Match was found.
	            if ($distroReleaseFile === $entry)
	            {
	                //Find distros array key(i.e. Distro name) by value(i.e. distro release file)
	                $OSDistro = array_search($distroReleaseFile, $distros);

	                break 2;//Break inner and outer loop.
	            }
	        }
	    }

	    return $OSDistro;
	}  

}

?>