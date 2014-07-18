<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The System class
*
* The system class handles the interaction between Loreji and the OS
* It retuns values like cpu load, ram load, disk space, IP addresses etc.
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class System 
{
	/**
     * The Avg_load() function return the average load on the CPU
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return Integer average CPU load
     * @version 0.1.0
     * @package Core
     */
	public static function Avg_load()
	{	
		$stat1 = file('/proc/stat'); 
		$info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0]));  
		$dif = array(); 
		$dif['sys'] = $info1[2] + $info1[0] + $info1[1]; 
		$dif['idle'] = $info1[3]; 
		$total = array_sum($dif); 
		$cpu = array(); 
		foreach($dif as $x=>$y) $cpu[$x] = round($y / $total * 100, 1);
		return $cpu;
	}

	/**
     * The Ram_usage() function return the average load on the RAM
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return Integer average RAM load
     * @version 0.1.0
     * @package Core
     */
	public static function Ram_usage()
	{
		$data = explode("\n", file_get_contents("/proc/meminfo"));
	    $meminfo = array();
	    foreach ($data as $line) {
	    	@list($key, $val) = explode(":", $line);
	    	$meminfo[$key] = str_replace(' kB', '', trim($val));
	    }
	    // ((list price - actual price) / (list price)) * 100%
	    $meminfo['percentage_1'] = round($meminfo['MemFree'] / $meminfo['MemTotal'] * 100, 1);
	    return $meminfo;
	}

	/**
     * The Disk_usage() function return percentage of diskspace used
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return Integer diskspace used
     * @version 0.1.0
     * @package Core
     */
	public static function Disk_usage()
	{
		$d['total'] = disk_total_space("/");
		$d['free'] = disk_free_space("/");
		$d['used'] = $d['total'] - $d['free'];
		$d['percentage'] = round($d['used'] / $d['total'] * 100);
		return $d;
	}

	/**
     * The System_uptime() function return the uptime of the system
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return String system uptime
     * @version 0.1.0
     * @package Core
     */
	public static function System_uptime()
	{
		$uptime = shell_exec("cut -d. -f1 /proc/uptime");
		$days = floor($uptime/60/60/24);
		$hours = $uptime/60/60%24;
		$mins = $uptime/60%60;
		$secs = $uptime%60;
		return "$days ".Language::get('class.system.uptime.days').", $hours ".Language::get('class.system.uptime.hours')." ".Language::get('class.system.uptime.and')." $mins ".Language::get('class.system.uptime.minutes');
	}

	/**
     * The Remote_ip() function returns the current server IP
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @return String server IP
     * @version 0.1.0
     * @package Core
     */
	public static function Remote_ip()
	{
		return file_get_contents("http://loreji.com/php/ip.php");
	}

	/**
     * The Check_process() function return the average load on the CPU
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $processName The name of process to check for activity
     * @return Boolean [true/false]
     * @version 0.1.0
     * @package Core
     */
	public static function Check_process($processName) 
	{
	    $exists = false;
	    exec("ps -A | grep -i $processName | grep -v grep", $pids);

	    if (count($pids) > 0) {
	        $exists = true;
	    }

	    return $exists;
	}
}
?>