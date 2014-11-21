<?php defined('SYSPATH') or die('No direct script access allowed.');

class LSS extends Controller
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

		if(strtolower(Module::getSetting('store', 'enable_lss')) === "false")
		{
			// Alrigth lets stop the autoload here.... 
			return true;
		}
		printf("Connecting to LSS for service upgrade");
		# Set post vars
		$data = array(
		    'server_os' => self::getLinuxDistro(),
		    'loreji_version' => Settings::get('loreji_version'),
		    'store_id' => Settings::get('store_id')
		);
		Http::post_response('https://loreji.com/api/lss', $data);
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