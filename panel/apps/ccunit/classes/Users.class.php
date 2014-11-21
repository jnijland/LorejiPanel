<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Users class
 * @author  Ramon J. A. Smit <rsmit@loreji.com>
 * @package Loreji
 * @subpackage CCUnit\Core
 * @version  $Revision: 0.1.0 $
 * @access   public
 */
class Users extends Controller {

	/**
	 * List all users from every connected server
	 * @return String $userlist HTML userlist
	 */
	public static function all_users($search_keyword)
	{	
		$userlist = "";
		if(isset($search_keyword))
		{
			foreach (CCunit::query_server() as $server_id => $server) 
			{	
				$query = CCunit::query_server($server_id)->prepare("SELECT
					loreji_core.auth_users.*,
					loreji_core.packages.*
					FROM
					loreji_core.auth_users,
					loreji_core.packages WHERE loreji_core.packages.pk_id_in = loreji_core.auth_users.pk_id_in LIMIT 2");

				$query->execute();
				$userinfos = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach ($userinfos as $userinfo) {

					if(is_array($userinfo)){
						$externserver = CCunit::server_info_from_id($server_id);
		    $userlist .= '<tr>
		  				<td>'.$userinfo['au_fullname_vc'].'</td>
		  				<td>'.$userinfo['au_customercode_vc'].'</td>
		  				<td>'.$userinfo['pk_name_vc'].'</td>
		  				<td>'.$externserver['cs_nickname_vc'].'</td>
		  				<td><button class="btn btn-success" data-serverid="'.$server_id.'" data-userid="'.$userinfo['au_id_in'].'"><i class="fa fa-edit"></i></button></td>
		  			</tr>';
					}// end array check

				}// end userinfo foreach

			} // end foreach
		} // End if empty $search_keyword
		else 
		{	

			foreach (CCunit::query_server() as $server_id => $server) {
				$query = CCunit::query_server($server_id)->prepare("SELECT
					loreji_core.auth_users.*,
					loreji_core.packages.*
					FROM
					loreji_core.auth_users,
					loreji_core.packages WHERE 

					loreji_core.auth_users.au_id_in LIKE '%".addslashes($search_keyword)."%' OR
					loreji_core.auth_users.au_fullname_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_username_vc LIKE '%".addslashes($search_keyword)."%' OR  
					loreji_core.auth_users.au_customercode_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_fullname_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_streetname_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_housenumber_in LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_zipcode_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_city_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_phonenumber_vc LIKE '%".addslashes($search_keyword)."%' OR 
					loreji_core.auth_users.au_email_vc LIKE '%".addslashes($search_keyword)."%'

					AND loreji_core.packages.pk_id_in = loreji_core.auth_users.pk_id_in");

					$query->execute();
					$userinfos = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($userinfos as $userinfo) {
						$counter = 0;
						if(is_array($userinfo)){
							$counter++;
							$externserver = CCunit::server_info_from_id($server_id);
							  $userlist .= '<tr>
											<td>'.$userinfo['au_fullname_vc'].'</td>
											<td>'.$userinfo['au_customercode_vc'].'</td>
											<td>'.$userinfo['pk_name_vc'].'</td>
											<td>'.$externserver['cs_nickname_vc'].'</td>
											<td>
												<button class="btn btn-success CallClikcer" id="#choice'.$counter.'" data-serverid="'.$server_id.'" data-userid="'.$userinfo['au_id_in'].'">
													<i class="fa fa-edit"></i>
												</button>
											</td>
										</tr>';
					}
				}// end userinfo foreach
			} // end foreach
		} // end if else
		return $userlist;

	}


	public static function get_assigned_extra_packages($userid)
	{
		$query1 = CCunit::maindb()->prepare("Select
		loreji_ccunit.ccunit_extrapackages.ce_id_in,
		loreji_ccunit.ccunit_assigned_extrapackages.*,
		loreji_ccunit.ccunit_extrapackages.*
		From
		loreji_ccunit.ccunit_assigned_extrapackages Inner Join
		loreji_ccunit.ccunit_extrapackages
		On loreji_ccunit.ccunit_extrapackages.ce_id_in =
		loreji_ccunit.ccunit_assigned_extrapackages.ce_id_in
		Where loreji_ccunit.ccunit_assigned_extrapackages.cu_userid_in=:assigned_packageid");
		$query1->bindParam(':assigned_packageid', $userid);
		$query1->execute();
		return $query1->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function get_userinfo_and_lorejipackage($userid, $serverid)
	{
		$query = CCunit::query_server($serverid)->prepare("Select
		loreji_core.auth_users.*,
		loreji_core.packages.*
		From
		loreji_core.auth_users Inner Join
		loreji_core.packages On loreji_core.auth_users.pk_id_in =
		loreji_core.packages.pk_id_in
		Where
		loreji_core.auth_users.au_id_in='".$userid."'
		Limit 1");
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public static function get_latest_vhost_usage($userid, $serverid)
	{	
		$query = CCunit::query_server($serverid)->prepare("Select
		loreji_core.vhost_usages.*,
		loreji_core.auth_users.au_id_in,
		loreji_core.vhosts.vh_deleted_ts As vh_deleted_ts1,
		loreji_core.vhost_usages.*,
		loreji_core.vhosts.au_id_in As au_id_in1,
		loreji_core.vhosts.vh_id_in As vh_id_in1
		From
		loreji_core.vhosts Inner Join
		loreji_core.auth_users On loreji_core.auth_users.au_id_in = loreji_core.vhosts.au_id_in Inner Join
		loreji_core.vhost_usages On loreji_core.vhosts.vh_id_in = loreji_core.vhost_usages.vh_id_in
		Where
		loreji_core.auth_users.au_id_in='".$userid."' And
		loreji_core.vhosts.vh_deleted_ts IS NULL
		Order By
		loreji_core.vhost_usages.vu_id_in DESC
		Limit 1");
		$query->execute();
		//var_dump($query->fetch(PDO::FETCH_ASSOC));
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public static function get_domain_vhost_usage($vhostid, $serverid)
	{	
		$query = CCunit::query_server($serverid)->prepare("Select
		loreji_core.vhost_usages.*
		From
			loreji_core.vhost_usages
		Where
			loreji_core.vhost_usages.vh_id_in='".$vhostid."'
		Order By
			loreji_core.vhost_usages.vu_id_in DESC
		Limit 1");
		$query->execute();
		//var_dump($query->fetch(PDO::FETCH_ASSOC));
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public static function get_all_domain_usage($userid, $serverid)
	{	
		$month_year = date('mY'); 
		$query = CCunit::query_server($serverid)->prepare("Select
			loreji_core.vhosts.*,
			loreji_core.vhost_usages.*
		From
			loreji_core.vhosts Inner Join
			loreji_core.vhost_usages On loreji_core.vhost_usages.vh_id_in = loreji_core.vhosts.vh_id_in
		Where
			loreji_core.vhost_usages.vu_month_ts='".$month_year."'
		And
			loreji_core.vhosts.au_id_in='".$userid."'
		And 
			loreji_core.vhosts.vh_deleted_ts IS NULL");
		$query->execute();
		//var_dump($query->fetchAll(PDO::FETCH_ASSOC));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$diskspace = ((isset($result[0]['vu_diskspaceusage_in']))? $result[0]['vu_diskspaceusage_in'] : 0);
		$band      = 0;
		foreach ($result as $item) {
			//var_dump($item);
			$band += $item['vu_bandwidthusage_in'];
		}
		return array(
			'disk' => $diskspace,
			'band' => $band,
		);
	}

	public static function get_domains($userid, $serverid)
	{
		$query = CCunit::query_server($serverid)->prepare("Select
		loreji_core.vhosts.*
		From
		loreji_core.vhosts
		Where
		loreji_core.vhosts.au_id_in = '".$userid."' And loreji_core.vhosts.vh_deleted_ts IS NULL");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function get_domain($domainid, $serverid)
	{
		$query = CCunit::query_server($serverid)->prepare("Select
		loreji_core.vhosts.*
		From
		loreji_core.vhosts
		Where
		loreji_core.vhosts.vh_id_in = '".$domainid."' And loreji_core.vhosts.vh_deleted_ts IS NULL");
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public static function get_ftp_users($userid, $serverid)
	{
		$query = CCunit::query_server($serverid)->prepare("Select
		loreji_core.ftp_users.*
		From
		loreji_core.ftp_users
		Where
		loreji_core.ftp_users.au_id_in = '".$userid."'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function save_user_information($userid, $serverid, $post)
	{	
		$query = CCunit::query_server($serverid)->prepare("Update
		loreji_core.auth_users
		Set
		loreji_core.auth_users.au_email_vc = '".$post->email."',
		loreji_core.auth_users.au_language_vc = '".$post->language."',
		loreji_core.auth_users.au_fullname_vc = '".$post->fullname."',
		loreji_core.auth_users.au_streetname_vc = '".$post->streetname."',
		loreji_core.auth_users.au_housenumber_in = '".$post->housenumber."',
		loreji_core.auth_users.au_zipcode_vc = '".$post->zipcode."',
		loreji_core.auth_users.au_city_vc = '".$post->city."',
		loreji_core.auth_users.au_phonenumber_vc = '".$post->phonenumber."',
		loreji_core.auth_users.au_deleted_ts = ".(($post->status == 'NULL')? 'NULL' : "'".time()."'")."
		Where
		loreji_core.auth_users.au_id_in = '".$userid."'");

		$query->execute();
		return true;
	}

	public static function get_all_user_ssl($userid, $serverid)
	{
		$query = CCunit::query_server($serverid)->prepare("
		SELECT * FROM ssl_cert WHERE au_id_in='".$userid."'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function save_domain($post, $serverid, $domainid)
	{
		$query = CCunit::query_server($serverid)->prepare("
		UPDATE loreji_core.vhosts SET 
		vh_domain_vc 			= :domainname,
		vh_path_vc   			= :domainpath,
		vh_type_en   			= :domaintype,
		vh_usessl_in 			= :domainssl,
		vh_suhosin_vc			= :domainsuhosin,
		vh_suhosinenable_en 	= :domainsuhosinenable,
		vh_openbasedir_vc		= :domainopenbasedir,
		vh_openbasedirenable_en = :domainopenbasedirenable,
		vh_direntries_lt		= :domaindirentry,
		vh_overrule_lt			= :globalentry
		WHERE vh_id_in			= :domainid
		");
		
		$suhosinenable = ((isset($post['suhosinenable']))? '1' : '0');
		$openbasedirenable = ((isset($post['openbasedirenable']))? '1' : '0');

		$query->bindParam(':domainname', $post['domain']);
		$query->bindParam(':domainpath', $post['directory']);
		$query->bindParam(':domaintype', $post['type']);
		$query->bindParam(':domainssl', $post['ssl']);
		$query->bindParam(':domainsuhosin', $post['suhosin']);
		$query->bindParam(':domainsuhosinenable', $suhosinenable);
		$query->bindParam(':domainopenbasedir', $post['openbasedir']);
		$query->bindParam(':domainopenbasedirenable', $openbasedirenable);
		$query->bindParam(':domaindirentry', $post['customdirectory']);
		$query->bindParam(':globalentry', $post['customvhostsetting']);
		$query->bindParam(':domainid', $domainid);
		$query->execute();
		echo Template::alert('<strong>Success: Domain is saved</strong> The domain information is saved and should be avalible ad next daemon run!', 'success');
		return TRUE;
	}

	public static function count_all_users()
	{
		$servers = CCunit::query_server();
		$count = 0;
		foreach ($servers as $node) {
			$query = $node->prepare("Select
			loreji_core.auth_users.au_id_in
			From
			loreji_core.auth_users");
			$query->execute();
			$count = $count + $query->rowCount();
		}
		return $count;
	}

}