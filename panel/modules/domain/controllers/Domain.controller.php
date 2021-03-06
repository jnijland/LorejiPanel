<?php defined('SYSPATH') or die('No direct script access allowed.');

class Domain extends Controller
{	

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Domain";
	/* *
	*
		The action_Index() function Loads the main view
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Index()
	{	
		parent::view('overview');
	}

	/* *
	*
		The action_Domains() function Loads the main view
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Domains()
	{	
		if(Request::method() === "POST")
		{	
			//print_r(Request::post());
			self::Add_domain(Request::post('domain'), Request::post('type'), Request::post('directory'), Request::post('rootdomain'));
			Route::redirect('/domain/index');
		}
		$userid = parent::User('au_id_in');
		$domainquery = parent::db()->prepare("SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_type_en='1' AND vh_deleted_ts IS NULL");
		$domainquery->bindParam(':userid', $userid);
		$domainquery->execute();
		$domains = $domainquery->fetchAll();
		Template::bind('domains', $domains);
		parent::view('add_domain');
	}

	/* *
	*
		The action_Remove() function soft-removes the vhost
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Remove()
	{
		Template::$auto_render = FALSE;
		$vhid = Route::$params->params[0];
		if(Request::method() === "GET")	
		{	
			$userid = parent::User('au_id_in');
			$domainquery = parent::db()->prepare("UPDATE vhosts SET vh_deleted_ts=:time, vh_live_ts = NULL WHERE au_id_in=:userid AND vh_id_in=:vhid");
			$domainquery->bindParam(':userid', $userid);
			$domainquery->bindParam(':vhid', $vhid);
			$domainquery->bindParam(':time', time());
			$domainquery->execute();
			Route::redirect('/domain/index');
		}	
	}

	/* *
	*
		The Domain_list() function Loads active vhosts (and pending tho.)
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function Domain_list()
	{	
		$userid = parent::User('au_id_in');
		$domainquery = parent::db()->prepare("SELECT * FROM vhosts WHERE au_id_in=:userid AND vh_deleted_ts IS NULL");
		$domainquery->bindParam(':userid', $userid);
		$domainquery->execute();

		$server_ip = Http::get_response('https://loreji.com/api/ip');
		$domainlist = "";
		$i=0;
		while($row = $domainquery->fetch(PDO::FETCH_ASSOC))
			{ $i++; 

			$row['vh_live_ts'] = ($row['vh_live_ts'] != null)? '<font color="green">'.Language::get('domain.table.status.live').'</font>' : '<div title="" data-placement="left" data-toggle="tooltip" class="tooltips" data-original-title="'.Language::get('domain.table.pending').'"><font color="orange">'.Language::get('domain.table.status.pending').'</font></div>';
			$row['vh_dns_tmp'] = ((gethostbyname($row['vh_domain_vc']) == $server_ip)? '<font color="green">'.Language::get('domain.table.dns.label.ok').'</font>' : '<div title="" data-placement="left" data-toggle="tooltip" class="tooltips" data-original-title="'.Language::get('domain.table.dns.error').'"><font color="orange">'.Language::get('domain.table.dns.label.error').'</font></div>');

			$domainlist .= '<tr>
                <td>'.$i.'</td>
                <td>'.$row['vh_domain_vc'].'</td>
                <td>'.$row['vh_path_vc'].'</td>
                <td>'.$row['vh_live_ts'].'</td>
                <td>'.$row['vh_dns_tmp'].'</td>
                <td class="table-action">
                  <a href="/domain/edit/'.$row['vh_id_in'].'" class="delete-row btn btn-primary" style="color: #FFF;"><i class="fa fa-pencil"></i></a>
                  <a href="/domain/remove/'.$row['vh_id_in'].'" class="delete-row btn btn-danger removePopupLink" data-type="domain" data-name="'.$row['vh_domain_vc'].'" data-id="'.$row['vh_id_in'].'" data-action=""  data-url="/domain/remove/{{id}}" rel="tooltip" data-original-title="Domein verwijderen" style="color: #FFF;"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>';
		}

		return $domainlist;
	}


	/**
	 * Add domain to database (domains and subdomains)
	 * 
	 * @author Ramon Smit  <ramon@daltcore.com>
	 * @version 0.1.0
	 * @param string  $domain
	 * @param integer $type
	 * @param string  $path
	 * @param string  $rootdomain
	 */
	public static function Add_domain($domain, $type=1, $path = 'NULL', $rootdomain = NULL)
	{

		if($rootdomain != NULL)
		{
			$domain = $domain.$rootdomain;
		}	

		if($path == 'NULL')
		{
			$vhostname  = str_replace('.', '_', $domain);
		}
		else
		{
			$vhostname = $path;
		}


		$domainquery = parent::db()->prepare("SELECT * FROM vhosts WHERE vh_deleted_ts IS NULL");
		$domainquery->execute();
		$domains = $domainquery->fetchAll();
		if(self::in_array_r($domain, $domains))
		{
			Cookie::set('error', 'domainexist');
			Route::redirect('/domain/domains');
			exit;
		}

		if(strlen($domain) < 3)
		{
			Cookie::set('error', 'tooshort');
			Route::redirect('/domain/domains');
			exit;
		}

		$time = time();

		$userid = parent::User('au_id_in');
		$globalSuhosin = Settings::get('global_suhosin');
		$openBasedir = Settings::get('global_openbasedir');

		$domainquery = parent::db()->prepare("INSERT INTO vhosts (au_id_in, vh_domain_vc, vh_path_vc, vh_type_en, vh_suhosin_vc, vh_openbasedir_vc, vh_added_ts) 
		VALUES 
		(:userid, :domainname, :vhostname, :domaintype, :suhosin, :openbasedir, :timestamp)");
		$domainquery->bindParam(':userid', 		$userid);
		$domainquery->bindParam(':domainname', 	$domain);
		$domainquery->bindParam(':vhostname',	$vhostname);
		$domainquery->bindParam(':domaintype', 	$type);
		$domainquery->bindParam(':suhosin', $globalSuhosin);
		$domainquery->bindParam(':openbasedir', $openBasedir);
		$domainquery->bindParam(':timestamp', 	$time);
		$domainquery->execute();
	}

	/* *
	*
		The action_Edit() function calls and handles the edit view
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Edit()
	{
		if(Request::method() ===  "POST" )
		{
			$post = Request::post();
			if($post->usessl === "true")
			{
				$ssl = $post->ssl_setting;
			} 
			else
			{
				$ssl = 0;
			}

			$domain_id = Route::$params->params{0};
			$userid = parent::User('au_id_in');

			$domain_query = Parent::db()->prepare("UPDATE vhosts SET vh_domain_vc=:domainname, vh_path_vc=:domaindir, vh_usessl_in=:sslint, vh_live_ts=NULL WHERE vh_id_in=:domainid AND au_id_in=:userid");
			$domain_query->bindParam(':domainid', $domain_id);
			$domain_query->bindParam(':userid', $userid);
			$domain_query->bindParam(':domainname', $post->name);
			$domain_query->bindParam(':domaindir', $post->vhost_directory);
			$domain_query->bindParam(':sslint', $ssl);
			$domain_query->execute();

		}
		Parent::view('edit');
	}

	public static function get_domain_info()
	{	
		$domain_id = Route::$params->params{0};
		$userid = parent::User('au_id_in');
		$domain_query = Parent::db()->prepare("SELECT * FROM vhosts WHERE vh_id_in=:domainid AND au_id_in=:userid");
		$domain_query->bindParam(':domainid', $domain_id);
		$domain_query->bindParam(':userid', $userid);
		$domain_query->execute();
		return $domain_query->fetch(PDO::FETCH_ASSOC);
	}

	public static function get_user_ssl()
	{	
		$userid = parent::User('au_id_in');
		$domain_query = Parent::db()->prepare("SELECT * FROM ssl_cert WHERE au_id_in=:userid");
		$domain_query->bindParam(':userid', $userid);
		$domain_query->execute();
		return $domain_query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
}

?>