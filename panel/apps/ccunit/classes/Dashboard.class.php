<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
* Class dashboard for CC-Unit
* @author Ramon J. A. Smit <rsmit@loreji.com>
* @package ccunit
*/
class Dashboard extends Controller
{
	/**
	 * Loop trough loreji's logs
	 * @return String $loglost html build of the logs
	 */
	public static function loop_logs()
	{
		$query = CCunit::maindb()->prepare("SELECT * FROM ccunit_logs ORDER BY cl_date_in DESC LIMIT 10");
		$query->execute();
		$logs = $query->fetchAll();
		$loglist = '';
		foreach ($logs as $log) {
			$loglist .= '<a class="list-group-item">
	            <span class="badge">'.Counter::time_ago($log['cl_date_in']).'</span>
	            <i class="fa fa-fw '.$log['cl_fa-code_vc'].'"></i> '.Auth::get_user_from_id($log['cl_userid_in'])['au_fullname_vc'].' - <i>'.$log['cl_message_vc'].'</i>
	        </a>';
		}
		return $loglist;
	}

}