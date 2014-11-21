<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Servers global class
 * @author  Ramon J. A. Smit <rsmit@loreji.com>
 * @package Loreji
 * @subpackage CCUnit\Core
 * @version  $Revision: 0.1.0 $
 * @access   public
 */
class Servers extends Controller {

	public static function add_server($post_info)
	{
		$post_info = (array) $post_info;

		if(empty($post_info['serverkey']) && empty($post_info['servernick'])){
			echo "Please add some values";
			exit(0);
		}

		$server_json =  base64_decode($post_info['serverkey']);
		$server_json_dec = json_decode($server_json, TRUE);
		$server_nick = $post_info['servernick'];

		$selectq = CCunit::maindb()->prepare("SELECT COUNT(*) FROM ccunit_servers WHERE cs_ip_in=:ip");
		$selectq->bindParam(':ip', $server_json_dec['ip']);
		$selectq->execute();
		if($selectq->fetch()['COUNT(*)'] >= 1)
		{
			echo Template::alert('<strong>Error: Could not add server.</strong> This IP address is already connected with CC-Unit', 'danger');
			return true;
		}

		// Let us secure the usernames and passwords
		$server_json_dec['username'] = Encryption::encrypt($server_json_dec['username']);
		$server_json_dec['password'] = Encryption::encrypt($server_json_dec['password']);
		$server_json_dec['key'] = Encryption::encrypt($server_json_dec['key']);

		$insertq = CCunit::maindb()->prepare("INSERT INTO ccunit_servers 
			(cs_ip_in, cs_nickname_vc, cs_rootuser_vc, cs_rootpass_vc, cs_key_vc) 
			VALUES 
			(:ip, :nick, :rootuser, :rootpass, :lorkey)");
		$insertq->bindParam(':ip', $server_json_dec['ip']);
		$insertq->bindParam(':nick', $post_info['servernick']);
		$insertq->bindParam(':rootuser', $server_json_dec['username']);
		$insertq->bindParam(':rootpass', $server_json_dec['password']);
		$insertq->bindParam(':lorkey', $server_json_dec['key']);
		$insertq->execute();
		CCunit::log(' added a server', 'fa-align-justify');
		echo Template::alert('<strong>Success: Server is added</strong> The server is added to CC-Unit', 'success');
		return true;
	}

	public static function list_servers()
	{
		$selectq = CCunit::maindb()->prepare("SELECT * FROM ccunit_servers WHERE loreji_ccunit.ccunit_servers.cs_removed_ts IS NULL ORDER BY cs_nickname_vc ASC");
		$selectq->execute();
		$serverhtmllist = "";
		foreach ($selectq->fetchAll(PDO::FETCH_ASSOC) as $server) {
			$serverhtmllist .= '<tr>
						<td>'.$server['cs_ip_in'].'</td>
						<td>'.$server['cs_nickname_vc'].'</td>
						<td>'.((CCunit::port_up($server['cs_ip_in'], 3306) && CCunit::query_server($server['cs_id_in']) !== FALSE)? '<span class="online">Online<span>' : '<span class="offline">Offline</span>').'</td>
						<td>
							<button class="btn btn-href btn-success" data-serverid="'.$server['cs_id_in'].'"><i class="fa fa-edit"></i></button>
							<button class="btn btn-danger removePopupLink" data-name="'.$server['cs_nickname_vc'].'" data-id="'.$server['cs_id_in'].'"><i class="fa fa-trash-o"></i></button>
						</td>
					</tr>';
		}
		return $serverhtmllist;
	}

	public static function remove_server($serverid)
	{
		$selectq = CCunit::maindb()->prepare("UPDATE ccunit_servers SET cs_removed_ts=:time WHERE cs_id_in=:serverid");
		$selectq->bindParam(':serverid', $serverid);
		$time = time();
		$selectq->bindParam(':time', $time);
		$selectq->execute();
		CCunit::log('removed a server', 'fa-align-justify');
		echo Template::alert('<strong>Success: Server is removed</strong> The server is removed from CC-Unit', 'success');
		return true;
	}

	public static function edit_server()
	{
		$servernick = Request::post('cs_nickname_vc');
		$serverid = Request::post('serverid');
		$uquery = CCunit::maindb()->prepare("UPDATE ccunit_servers SET cs_nickname_vc=:servernick  WHERE cs_id_in=:serverid");
		$uquery->bindParam(':serverid', $serverid);
		$uquery->bindParam(':servernick', $servernick);
		$uquery->execute();
		CCunit::log('editted a server', 'fa-align-justify');
		echo Template::alert('<strong>Success: Server is editted</strong> The server is editted in CC-Unit', 'success');
		return $serverid;
	}

} 