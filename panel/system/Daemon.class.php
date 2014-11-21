<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Daemon class
*
* The Daemon classs handles the deamon and all usages
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Daemon 
{	

	/**
     * $vhost has the full vhost string text
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static $vhost;

    /**
     * The Get_directory_size() function calculates the directory sizes
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $directory path to the directory
     * @return Integer Directory size in bytes
     * @version 0.1.0
     * @package Core
     */
	public static function Get_directory_size($directory) {
	    $size = 0;
	    if (substr($directory, -1) == '/') {
	        $directory = substr($directory, 0, -1);
	    }
	    if (!file_exists($directory) || !is_dir($directory) || !is_readable($directory)) {
	        return -1;
	    }
	    if ($handle = opendir($directory)) {
	        while (($file = readdir($handle)) !== false) {
	            $path = $directory . '/' . $file;
	            if ($file != '.' && $file != '..') {
	                if (is_file($path)) {
	                    $size += filesize($path);
	                } elseif (is_dir($path)) {
	                    $handlesize = self::Get_directory_size($path);
	                    if ($handlesize >= 0) {
	                        $size += $handlesize;
	                    } else {
	                        return -1;
	                    }
	                }
	            }
	        }
	        closedir($handle);
	    }
	    return $size;
	}

	/**
     * The Calculate_bandwidth() function calculates the bandwith usage & turncate every month.
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $f_logs path to the log directory
     * @param String $f_username The username of the user
     * @param String $f_site The domain of the users
     * @return Integer bandwith usage in bytes
     * @version 0.1.0
     * @package Core
     */
	public static function Calculate_bandwidth($f_logs, $f_username, $f_site) {

		// We don't record for 1 hour. I'm sorry!
		// Here we turncate the logfile. 
		if(date('dh') == '0101'){	
			file_put_contents($f_logs . DS . $f_username . DS . $f_site . '-bandwidth.log', '');
			file_put_contents($f_logs . DS . $f_username . DS . $f_site . '-access.log', '');
			file_put_contents($f_logs . DS . $f_username . DS . $f_site . '-error.log', '');
			printf('Turncate apache logs'."\n");
		}
	    // Path to Apache's log file
	    $ac_arr = @file($f_logs . DS . $f_username . DS . $f_site . '-bandwidth.log');
	    // Splitting IP from the rest of the record
	    $astring = @join("", $ac_arr);
	    $astring = preg_replace("/(\n|\r|\t)/", "\n", $astring);
	    $records = preg_split("/([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $astring, -1, PREG_SPLIT_DELIM_CAPTURE);
	    $sizerecs = sizeof($records);
	    // Now split into records
	    $j = 0;
	    $i = 1;
	    $arb = array();
	    $each_rec = 0;
	    $cur_month = date("/M/Y");
	    while ($i < $sizerecs) {
	        $ip = $records[$i];
	        $all = @$records[$i + 1];
	        // Parse other fields
	        preg_match("/\[(.+)\]/", $all, $match);
	        $access_time = @$match[1];
	        $all = @str_replace($match[1], "", $all);
	        preg_match("/\"GET (.[^\"]+)/", $all, $match);
	        $http = @$match[1];
	        $link = explode(" ", $http);
	        $all = @str_replace("\"GET $match[1]\"", "", $all);
	        preg_match("/([0-9]{3})/", $all, $match);
	        $success_code = @$match[1];
	        $all = @str_replace($match[1], "", $all);
	        preg_match("/\"(.[^\"]+)/", $all, $match);
	        $ref = @$match[1];
	        $all = @str_replace("\"$match[1]\"", "", $all);
	        preg_match("/\"(.[^\"]+)/", $all, $match);
	        $browser = @$match[1];
	        $all = @str_replace("\"$match[1]\"", "", $all);
	        preg_match("/([0-9]+\b)/", $all, $match);
	        $bytes = @$match[1];
	        $all = @str_replace($match[1], "", $all);
	        // The following code is to collect bandwidth usage per user and assign each usage to the user,
	        // Successful match, now we need to check if the access date matches the current month.
	        // If yes, we'll sum all the sizes from access pages only from the current month
	        // and put in database... 
	        $arb[$j] = @$arb[$j] + $bytes;
	        // Advance to next record
	        $i = $i + 1;
	        $each_rec++;
	    }
	    return @$arb[$j];
	}

	/**
     * The Format_bytes() function calculates the b to MB/GB
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param Integer $bytes Integer from functions
     * @param Integer $precision Integer set on 0
     * @return String Neat formatted string
     * @version 0.1.0
     * @package Core
     */
	public static function Format_bytes($bytes, $precision = 0) { 
	    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

	    $bytes = max($bytes, 0); 
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	    $pow = min($pow, count($units) - 1); 

	    // Uncomment one of the following alternatives
	    // $bytes /= pow(1024, $pow);
	     $bytes /= (1 << (10 * $pow)); 

	    return round($bytes, $precision) . ' ' . $units[$pow]; 
	}

	/**
     * The Cli_init() function disables errors
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function Cli_init()
	{
		// Stop errors
		error_reporting (E_ALL ^ E_STRICT);
		ini_set('display_errors', 0);
	}

	/**
     * The Cli_header() function shows header in cli
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @return String Header text
     * @package Core
     */
	public static function Cli_Header()
	{	
		//echo "\033[00;32m";
		printf(
		"
		#######################################
		#                                     #
		#           Loreji Daemon             #
		#  Last run: ".date('Y-m-d h:i:s A', Settings::get('last_daemon_run'))."   #
		#  Current:  ".date('Y-m-d h:i:s A')."   #
		#                                     #
		#######################################\n\n"
		);
		//echo "\033[0m";
	}

	/**
     * The On_daemon_hooks() function runs all the hooks for in the daemon
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @return String information about files
     * @package Core
     */
	public static function On_daemon_hooks() { 
		echo "\n\033[01;31m##### ON DAEMON HOOKS\033[0m\n";
		foreach (glob(MODPATH."/*/hooks/*.OnDaemonHook.php") as $filename) {
			require($filename);
			$classname = array_reverse(explode('/', $filename));
			$classname = (explode('.', $classname[0]));
			$classname = $classname[0];
			call_user_func($classname."::_DoAutoLoad");
		}
		echo "\n\033[01;31m##### END ON DAEMON HOOKS\033[0m\n\n";
	} 

	/**
     * The Before_daemon_hooks() function runs all the hooks for in the daemon
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @return String information about files
     * @package Core
     */
	public static function Before_daemon_hooks() { 
		echo "\n\033[01;31m##### BEFORE DAEMON HOOKS\033[0m\n";
		foreach (glob(MODPATH."/*/hooks/*.BeforeDaemonHook.php") as $filename) {
			require($filename);
			$classname = array_reverse(explode('/', $filename));
			$classname = (explode('.', $classname[0]));
			$classname = $classname[0];
			call_user_func($classname."::_DoAutoLoad");
		}
		echo "\n\033[01;31m##### END BEFORE DAEMON HOOKS\033[0m\n\n";
	} 

	/**
     * The After_daemon_hooks() function runs all the hooks for in the daemon
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @return String information about files
     * @package Core
     */
	public static function After_daemon_hooks() {
		echo "\n\n\033[01;31m##### AFTER DAEMON HOOKS\033[0m\n";
		 // Escape_Colors::bg_color("", ""); 
		foreach (glob(MODPATH."/*/hooks/*.AfterDaemonHook.php") as $filename) {
			require($filename);
			$classname = array_reverse(explode('/', $filename));
			$classname = (explode('.', $classname[0]));
			$classname = $classname[0];
			call_user_func($classname."::_DoAutoLoad");
		}
		echo "\n\033[01;31m##### END AFTER DAEMON HOOKS\033[0m\n";
	} 

	/**
     * The db() function inits the DB for the daemon
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @return STDObject with DB information
     * @package Core
     */
	public static function db()
	{
		try {
			$db = new Databasehandler("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DBMS, MYSQL_USER, MYSQL_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		} catch (PDOException $e) {
			echo('NO DB...');
			exit;
		}
	}


	/**
     * The Dir_exist_create() function will create a directory if it doesnt exist
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $directory The directory to create (recursive)
     * @version 0.1.0
     * @package Core
     */
	public static function Dir_exist_create($directory)
	{
		if(!file_exists($directory))
		{
			mkdir($directory, 0777, TRUE);
		}
	}

	/**
     * The Cli_clear() function will clear the CLI screen
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function Cli_clear()
	{
		passthru('clear');
	}

	public static function Calculate_domains($userid)
	{
		$query = Daemon::db()->prepare('SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_deleted_ts IS NULL');
		$query -> bindParam(':userid', $userid);
		$query -> execute();
		return $query->rowCount();
	}


	public static function Calculate_main_domains($userid)
	{
		$query = Daemon::db()->prepare("SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_deleted_ts IS NULL AND vh_type_en='1'");
		$query -> bindParam(':userid', $userid);
		$query -> execute();
		return $query->rowCount();
	}


	public static function Calculate_sub_domains($userid)
	{
		$query = Daemon::db()->prepare("SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_deleted_ts IS NULL AND vh_type_en='2'");
		$query -> bindParam(':userid', $userid);
		$query -> execute();
		return $query->rowCount();
	}

	/**
     * The Check_dirs() function check if system dirs exist, if not then create new
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function Check_dirs()
	{
		Self::Dir_exist_create(Settings::get('loreji_logs'));
		Self::Dir_exist_create(Settings::get('loreji_vhost_directory'));
	}


	/**
     * The Loop_vhosts() function will loop trouth the Database vhost table and
     * creates new entrys for the vhost file
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function Loop_vhosts($calculate_usage = TRUE)
	{
		// Get client information
		$userquery = Daemon::db()->prepare('SELECT * FROM auth_users WHERE au_deleted_ts IS NULL');
		$userquery->execute();

		while($row = $userquery->fetch(PDO::FETCH_ASSOC))
		{	
			// Get all vhosts, skip the deleted ones
			$vhostquery = Daemon::db()->prepare('SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_deleted_ts IS NULL');
			$vhostquery->bindParam(':userid', $row['au_id_in']);
			$vhostquery->execute();

			// Loop trough the domains
			// use global keyword
			$vhostrow = array();
			while ($vhostrow = $vhostquery->fetch(PDO::FETCH_ASSOC)) {
				$vhost = $vhostrow['vh_domain_vc'];
				$log_dir = Settings::get('loreji_logs');

				printf("########## \033[00;36m$vhost\033[0m\n");

				$packagequery = Daemon::db()->prepare("SELECT * FROM packages WHERE pk_id_in=:packageid");
				$packagequery->bindParam(':packageid', $row['pk_id_in']);
				$packagequery->execute();
				$packagerow = $packagequery->fetch(PDO::FETCH_ASSOC);

				if($vhostrow['vh_live_ts'] === NULL)
				{	
					$vhost_directory = Settings::get('loreji_vhost_directory').DS.$row['au_email_vc'].DS.'public_html'.DS.$vhostrow['vh_path_vc'];
					Daemon::Dir_exist_create($vhost_directory);
					File::recurse_copy(STATICPATH.DS.'hostingready', $vhost_directory);
					$vhostinsert = Daemon::db()->prepare("UPDATE vhosts SET vh_live_ts='".time()."' WHERE vh_id_in='".$vhostrow['vh_id_in']."'");
					$vhostinsert->execute();
				}
				else
				{	

					if($calculate_usage == TRUE)
					{
						// Calculate Diskspace, bandwidth & MySQL Size
						$month_year = date('mY');

						$vhostusage = Daemon::db()->prepare("SELECT * FROM vhost_usages WHERE vu_month_ts='".$month_year."' AND vh_id_in='".$vhostrow['vh_id_in']."'");
						$vhostusage->execute();
						$checkrow = $vhostusage->fetch(PDO::FETCH_ASSOC);

						$databasequery = Daemon::db()->prepare("SELECT * FROM `databases` WHERE `au_id_in` = :userid AND `db_deleted_ts` IS NULL");
						$databasequery->bindParam(':userid', $vhostrow['au_id_in']);
						$databasequery->execute();

						$db_size = 0; 
						while($databaserow = $databasequery->fetch(PDO::FETCH_ASSOC))
						{
							$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, $databaserow['db_name_vc']) or print("Error " . mysqli_error($link));
							$query = "SHOW TABLE STATUS" or print("Error in the consult.." . mysqli_error($link));
							$result = $link->query($query);
							while($rowz = mysqli_fetch_array($result)) {
							  $db_size += $rowz["Data_length"] + $rowz["Index_length"];
							}
						}
						printf("Database size: \033[00;36m".Daemon::Format_bytes($db_size)."\033[0m (overall) \n");

						if($checkrow['vu_id_in'] > 0)
						{	
					 		$vhostusage = Daemon::db()->prepare("UPDATE vhost_usages SET 
							    vu_bandwidthusage_in='".Daemon::Calculate_bandwidth($log_dir, $row['au_email_vc'], $vhostrow['vh_domain_vc'])."'
							    ,
							    vu_diskspaceusage_in='".(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc']) + $db_size)."'
							    ,
							    vu_domaindiskusage_in='".(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc'].DS.'public_html'.DS.$vhostrow['vh_path_vc']))."'
							    ,
							    vu_domain_in='".Daemon::Calculate_main_domains($vhostrow['au_id_in'])."'
							    ,
							    vu_subdomain_in='".Daemon::Calculate_sub_domains($vhostrow['au_id_in'])."'
							    ,
							    vu_lastupdate_in='".time()."'
							    WHERE vu_month_ts='".$month_year."' AND vh_id_in='".$vhostrow['vh_id_in']."'");
							$vhostusage->execute();
						} else {
							$vhostusage = Daemon::db()->prepare("INSERT INTO vhost_usages (vh_id_in, vu_month_ts, vu_bandwidthusage_in, vu_diskspaceusage_in, vu_domaindiskusage_in, vu_domain_in, vu_subdomain_in, vu_lastupdate_in)
							      VALUES ('".$vhostrow['vh_id_in']."', '".$month_year."', '".Daemon::Calculate_bandwidth($log_dir, $row['au_email_vc'], $vhostrow['vh_domain_vc'])."', 
							      	'".(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc']) + $db_size)."', 
							      	'".(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc'].DS.'public_html'.DS.$vhostrow['vh_path_vc']))."', 
							      	'".Daemon::Calculate_main_domains($vhostrow['au_id_in'])."', '".Daemon::Calculate_sub_domains($vhostrow['au_id_in'])."', '".time()."') ");
							$vhostusage->execute();
						}

						printf("Bandwidth used: \033[00;36m".
							Daemon::Format_bytes(Daemon::Calculate_bandwidth($log_dir, $row['au_email_vc'], $vhostrow['vh_domain_vc'])).
							"\033[0m / \033[00;36m".
							Daemon::Format_bytes($packagerow['pk_maxbandwidth_in']).
							"\033[0m (per-vhost) \n");
						printf("Diskspace used: \033[00;36m".
							Daemon::Format_bytes(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc'])).
							"\033[0m / \033[00;36m".
							Daemon::Format_bytes($packagerow['pk_maxdiskspace_in']).
							"\033[0m (overall) \n");
						printf("Diskspace used: \033[00;36m".
							Daemon::Format_bytes(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc'].DS.'public_html'.DS.$vhostrow['vh_path_vc'])).
							"\033[0m / \033[00;36m".
							Daemon::Format_bytes($packagerow['pk_maxdiskspace_in']).
							"\033[0m (domain) \n");
						// (Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc']) + $db_size)
						printf("Total Diskspace used: \033[00;36m".
							Daemon::Format_bytes((Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc']) + $db_size)).
							"\033[0m / \033[00;36m".
							Daemon::Format_bytes($packagerow['pk_maxdiskspace_in']).
							"\033[0m (overall) \n");
					}

				}

				if($calculate_usage == TRUE)
				{
					// User is over bandwidth
					if(Daemon::Calculate_bandwidth($log_dir, $row['au_email_vc'], $vhostrow['vh_domain_vc']) > $packagerow['pk_maxbandwidth_in'])
					{	
						printf("\033[01;31mUser is overbandwidth! Setting vhost to static page\033[0m\n");
						$vhostrow['vh_path_vc'] = "/etc/loreji/static/overbandwidth";
					}

					// User is over diskspace
					if(Daemon::Get_directory_size(Settings::get('loreji_vhost_directory').DS.$row['au_email_vc']) > $packagerow['pk_maxdiskspace_in'])
					{	
						printf("\033[01;31mUser is overdiskspace! Setting vhost to static page\033[0m\n");
						$vhostrow['vh_path_vc'] = "/etc/loreji/static/overdiskspace";
					}
				}

				Daemon::Build_vhost_entry($row, $vhostrow);
				printf("########## \033[00;36m$vhost\033[0m\n\n");
			} // end of vhost loop
		} // en of user loop
	}

	/**
     * The Build_panel_entry() will build the vhost entry for the panel self
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
	public static function Build_panel_entry()
	{	
		self::Dir_exist_create(Settings::get('loreji_logs').'/admin/');

		$domain = Settings::get('panel_domain');
		$panel_entry = 
'################################################################
# Apache VHOST configuration file
# Automatically generated by Loreji '.Settings::get('loreji_version').'
# Generated on: '.date('Y-m-d h:i:s A').'
################################################################

# Configuration for Loreji control panel.
<VirtualHost '.$domain.':80>
ServerAdmin admin@localhost
DocumentRoot "'.Settings::get('loreji_root').'"
ServerName '.$domain.'
ServerAlias *.'.$domain.'
AddType application/x-httpd-php .php
ErrorLog "'.Settings::get('loreji_logs').'/admin/'.$domain.'-error.log" 
CustomLog "'.Settings::get('loreji_logs').'/admin/'.$domain.'-access.log" combined
CustomLog "'.Settings::get('loreji_logs').'/admin/'.$domain.'-bandwidth.log" common
<Directory "'.Settings::get('loreji_root').'">
# Custom Directory settings are loaded below this line (if any exist)
'.Settings::get('vhost_globaldir_entry').'
Options +FollowSymLinks
	AllowOverride All
	Order allow,deny
	Allow from all
</Directory>
# Custom settings are loaded below this line (if any exist)
'.Settings::get('vhost_global_entry').'
</VirtualHost>
##################### END OF PANEL ENTRY #########################';

if(Settings::get('use_panel_ssl') > 0){
			$panel_entry .= 
'################################################################
# SSL VERSION FOR PANEL
################################################################

# Configuration for Loreji control panel.
<VirtualHost '.$domain.':443>
ServerAdmin admin@localhost
DocumentRoot "'.Settings::get('loreji_root').'"
ServerName '.$domain.'
ServerAlias *.'.$domain.'
AddType application/x-httpd-php .php
ErrorLog "'.Settings::get('loreji_logs').'/admin/'.$domain.'-error.log" 
CustomLog "'.Settings::get('loreji_logs').'/admin/'.$domain.'-access.log" combined
CustomLog "'.Settings::get('loreji_logs').'/admin/'.$domain.'-bandwidth.log" common
<Directory "'.Settings::get('loreji_root').'">
# Custom Directory settings are loaded below this line (if any exist)
'.Settings::get('vhost_globaldir_entry').'
Options +FollowSymLinks
	AllowOverride All
	Order allow,deny
	Allow from all
</Directory>

'.self::build_ssl_entry(Settings::get('use_panel_ssl')).'

# Custom settings are loaded below this line (if any exist)
'.Settings::get('vhost_global_entry').'
</VirtualHost>
##################### END OF PANEL ENTRY #########################';
}

		self::$vhost = $panel_entry;
	}

	/**
     * The Build_vhost_entry() will build the vhost entry for the domains
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $account The username of the user
     * @param String $vhost The domain of the user
     * @version 0.1.0
     * @package Core
     */
	public static function Build_vhost_entry($account, $vhost)
	{	


		// If is over bandwidth/diskspace
		if(strpos($vhost['vh_path_vc'], '/etc/loreji') === FALSE)
		{
			$vhost_dir = Settings::get('loreji_vhost_directory').DS.$account['au_email_vc'].DS.'public_html'.DS.$vhost['vh_path_vc'];
			self::Dir_exist_create($vhost_dir);
		} else {
			printf("vhost directory is changed\n");
			$vhost_dir = $vhost['vh_path_vc'];
		}

		printf("vhost directory: \033[0;32m$vhost_dir\033[0m\n");
		// Check if OPENBASEDIR is accepted
		if($vhost['vh_openbasedirenable_en'] === '1')
		{
			$OPENBASEDIR = 'php_admin_value open_basedir "'.$vhost['vh_openbasedir_vc'].$vhost_dir.'"';
		}

		// Check if SUHOSIN is accepted 
		if($vhost['vh_suhosinenable_en'] === '1')
		{
			$SUHOSIN = 'php_admin_value suhosin.executor.func.blacklist "'.$vhost['vh_suhosin_vc'].'"';
		}

		$vhost_entry = 
			'

################################################################
# DOMAIN: '.$vhost['vh_domain_vc'].'
<virtualhost '.$vhost['vh_domain_vc'].':80>
ServerName '.$vhost['vh_domain_vc'].'
ServerAlias '.$vhost['vh_domain_vc'].' www.'.$vhost['vh_domain_vc'].'
ServerAdmin '.$account['au_email_vc'].'
DocumentRoot "'.$vhost_dir.'"
'.((isset($OPENBASEDIR))? $OPENBASEDIR : '').'
'.((isset($SUHOSIN))? $SUHOSIN : '').'
ErrorLog "'.Settings::get('loreji_logs').DS.$account['au_email_vc'].DS.$vhost['vh_domain_vc'].'-error.log" 
CustomLog "'.Settings::get('loreji_logs').DS.$account['au_email_vc'].DS.$vhost['vh_domain_vc'].'-access.log" combined
CustomLog "'.Settings::get('loreji_logs').DS.$account['au_email_vc'].DS.$vhost['vh_domain_vc'].'-bandwidth.log" common
<Directory />
# Custom directory settings (if exist)
'.$vhost['vh_direntries_lt'].'
# Global directory settings (if exist)
'.Settings::get('vhost_globaldir_entry').'
Options +Indexes +FollowSymLinks -MultiViews
AllowOverride All
Order Allow,Deny
Allow from all
</Directory>
AddType application/x-httpd-php .php
ScriptAlias /cgi-bin/ "/_cgi-bin/"
<location /cgi-bin>
AddHandler cgi-script .cgi .pl
Options +ExecCGI +Indexes
</location>
ErrorDocument 500 /_errorpages/500.html
ErrorDocument 510 /_errorpages/510.html
ErrorDocument 403 /_errorpages/403.html
ErrorDocument 404 /_errorpages/404.html
DirectoryIndex index.html index.htm index.php index.asp index.aspx index.jsp index.jspa index.shtml index.shtm
# Custom Global Settings (if any exist)
'.Settings::get('vhost_global_entry').'
# Custom VH settings (if any exist)
'.$vhost['vh_overrule_lt'].'
</virtualhost>
# END DOMAIN: '.$vhost['vh_domain_vc'].'
################################################################
';			
		echo (($vhost['vh_usessl_in'] > 0)? 'SSL Enabled'."\n" : '');

		if($vhost['vh_usessl_in'] > 0)
		{
					$vhost_entry .= 
			'
################################################################
# DOMAIN: '.$vhost['vh_domain_vc'].'
<virtualhost '.$vhost['vh_domain_vc'].':443>
ServerName '.$vhost['vh_domain_vc'].'
ServerAlias '.$vhost['vh_domain_vc'].' www.'.$vhost['vh_domain_vc'].'
ServerAdmin '.$account['au_email_vc'].'
DocumentRoot "'.$vhost_dir.'"
'.((isset($OPENBASEDIR))? $OPENBASEDIR : '').'
'.((isset($SUHOSIN))? $SUHOSIN : '').'
ErrorLog "'.Settings::get('loreji_logs').DS.$account['au_email_vc'].DS.$vhost['vh_domain_vc'].'-error.log" 
CustomLog "'.Settings::get('loreji_logs').DS.$account['au_email_vc'].DS.$vhost['vh_domain_vc'].'-access.log" combined
CustomLog "'.Settings::get('loreji_logs').DS.$account['au_email_vc'].DS.$vhost['vh_domain_vc'].'-bandwidth.log" common
<Directory />
# Custom directory settings (if exist)
'.$vhost['vh_direntries_lt'].'
# Global directory settings (if exist)
'.Settings::get('vhost_globaldir_entry').'
Options +Indexes +FollowSymLinks -MultiViews
AllowOverride All
Order Allow,Deny
Allow from all
</Directory>
AddType application/x-httpd-php .php
ScriptAlias /cgi-bin/ "/_cgi-bin/"
<location /cgi-bin>
AddHandler cgi-script .cgi .pl
Options ExecCGI Indexes
</location>
ErrorDocument 500 /_errorpages/500.html
ErrorDocument 510 /_errorpages/510.html
ErrorDocument 403 /_errorpages/403.html
ErrorDocument 404 /_errorpages/404.html
DirectoryIndex index.html index.htm index.php index.asp index.aspx index.jsp index.jspa index.shtml index.shtm
# Custom Global Settings (if any exist)
'.Settings::get('vhost_global_entry').'
# Custom VH settings (if any exist)
'.$vhost['vh_overrule_lt'].'
# SSL (if any exist)
'.(($vhost['vh_usessl_in'] > 0)? self::build_ssl_entry($vhost['vh_usessl_in']) : '').'
</virtualhost>
# END DOMAIN: '.$vhost['vh_domain_vc'].'
################################################################
';	
		}

		self::$vhost = self::$vhost . $vhost_entry;
	}

	/**
     * The build_ssl_entry() will build the ssl entry for the domain
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $ssl_id The ssl id for this domain
     * @return String $line the SSL information for the vhost
     * @version 0.1.0
     * @package Core
     */
	public static function build_ssl_entry($ssl_id)
	{
		$sslquery = Daemon::db()->prepare("SELECT * FROM ssl_cert WHERE sc_id_in=:certid");
		$sslquery->bindParam(':certid', $ssl_id);
		$sslquery->execute();
		$sslrow = $sslquery->fetch(PDO::FETCH_ASSOC);
		$line = '# SSL Certificate '.$sslrow['sc_nick_vc']."\n";
		$line .= 'SSLEngine on'."\n";
		$line .= (($sslrow['sc_cert_vc'] === NULL)? '' : 'SSLCertificateFile '.$sslrow['sc_cert_vc']."\n");
		$line .= (($sslrow['sc_key_vc'] === NULL)? '' : 'SSLCertificateKeyFile '.$sslrow['sc_key_vc']."\n");
		$line .= (($sslrow['sc_ca_vc'] === NULL)? '' : 'SSLCertificateChainFile '.$sslrow['sc_ca_vc']."\n");
		return $line;
	}

}
?>