<?php defined('SYSPATH') or die('No direct script access allowed.');

class Auth extends Controller
{
	// Class namespace 
	static $namespace = "com.daltcore.loreji\Auth";

	static $instance = array();

	static $no_check = FALSE;

	/* *
	*
		The action_Login() function handles the init of the base tempalte
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Login()
	{	
		Template::$auto_render = FALSE;

		if(Request::method() === "POST")
		{	

			$app_login = Settings::get('login_with_app');
			if($app_login === '1')
			{
				// Make the app buzz
			}

			$post = Request::post();
			$auth = parent::db()->prepare('SELECT * FROM auth_users WHERE au_email_vc=:email');
			$auth->bindParam(':email', $post->username);
			$auth->execute();
			$row = $auth->fetch(PDO::FETCH_ASSOC);
			if($row)
			{
				$db_text_password = Encryption::decrypt($row['au_password_vc']);
				if(md5($post->password) === md5($db_text_password))
				{	

					$new_key = Encryption::random_string(50);
					$auth = parent::db()->prepare('UPDATE auth_users SET au_uid_vc=:unikey  WHERE au_email_vc=:email');
					$auth->bindParam(':email', $post->username);
					$auth->bindParam(':unikey', $new_key);
					$auth->execute();

					Cookie::set('uid', $new_key, 60 * 60);
					$_COOKIE['uid'] = $new_key;

					// Let me set a temporary ID
					self::$instance->au_id_in = $row['au_id_in'];

					// Check if we can login 
					//var_dump(Auth::has_role('login', $row['au_id_in']));
					
					if(Auth::has_role('login', $row['au_id_in']) == TRUE)
					{ 
						Route::redirect('/home/index');
					} 
					else
					{	
						//User has no permissions for login, Kill the UID, and send to login with message
						self::$instance->au_id_in = NULL;
						Cookie::set('uid', 'NULL');
						Route::redirect('/login?error=noperm');
					}
					die();

				} 
				else 
				{	
					// Mistyped password?
					Route::redirect('/login?error=passfail');
				}
			}
			else
			{	
				// That username does not exist!
				Route::redirect('/login?error=nouser');
			}
		}
	}

	/* *
	*
		The check_login() function handles the init of the base tempalte
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function check_login($login_as_shadow = TRUE, $no_twoway = FALSE)
	{	


		if(self::$no_check === 1)
		{
			return TRUE;
		}

		if($login_as_shadow == true)
		{
			$shadow = Cookie::get('shadow');
			$uid = ((!empty($shadow))? $shadow : Cookie::get('uid'));
		}
		else
		{	
			$shadow = '';
			$uid = Cookie::get('uid');
		}

		if( ! isset($uid) && $uid !== 'NULL')
		{
			return FALSE;
		}

		$auth = parent::db()->prepare('SELECT * FROM auth_users WHERE au_uid_vc=:uid');
		$auth->bindParam(':uid', $uid);
		$auth->execute();
		$row = $auth->fetch(PDO::FETCH_ASSOC);
		if($row)
		{	
			$gauth = Cookie::get('gauth');

			/*if($no_twoway === TRUE OR !empty($row['au_gasecret_vc']) AND $row['au_enablega_en'] === '1' AND empty($gauth))
			{
				try {
					self::$instance = (object) $row;
					if(@Route::$params->controller !== 'twoway')
					{
						Route::redirect('/twoway');
					}
					return $row;
				} catch (Exception $e) {
					
				}
			}
			else
			{*/
				self::$instance = (object) $row;
				// update the cookie time.
				Cookie::set('uid', Cookie::get('uid'), 60 * 60);

				if(!empty($row['au_gasecret_vc']) AND $row['au_enablega_en'] === '1' AND $login_as_shadow == FALSE)
				{
					Cookie::set('gauth', Request::post('vcode'), 60 * 60);
				}

				return $row;				
			//}

			
		}
		else
		{
			return FALSE;
		}
		
	}

	public static function check_shadow_admin()
	{
		$uid = Cookie::get('uid');
		$auth = parent::db()->prepare('SELECT * FROM auth_users WHERE au_uid_vc=:uid');
		$auth->bindParam(':uid', $uid);
		$auth->execute();
		$row = $auth->fetch(PDO::FETCH_ASSOC);
		if($row)
		{	
			return $row;
		}
		else
		{
			return FALSE;
		}
	}

	/* *
	*
		The action_Logout() function handles destroy of the cookie
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Logout()
	{	
		Cookie::set('uid', '', 0);
		Cookie::set('gauth', '', 0);
		Route::redirect('/login');
	}

	public static function action_Logoutshadow()
	{
		Cookie::set('shadow', '', 0);
		Route::redirect('/login');
	}

	/* *
	*
		The action_Delock() function handles the delock of user account
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Delock()
	{	
		Template::$auto_render = FALSE;
		if(Request::method() === "POST")
		{	

			$password = Request::post('password');

			if($password != "")
			{	
				if($password === Encryption::decrypt(Auth::check_login()['au_password_vc']))
				{	
					$uid = self::check_login()['au_id_in'];
					$auth = parent::db()->prepare('UPDATE auth_users SET au_actlocked_en=\'0\' WHERE au_id_in=:uid');
					$auth->bindParam(':uid', $uid);
					$auth->execute();
					Route::redirect('/home/index');
				} 
				else 
				{
					Route::redirect('/lock');
				}
			}
			else 
			{
				Route::redirect('/lock');
			}
		}
	}

	/* *
	*
		The action_Lock() function locks user account
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function action_Lock()
	{	

		$uid = self::check_login()['au_uid_vc'];
		if($uid === NULL)
		{
			Route::redirect('/login');
		}

		if(strpos($_SERVER['HTTP_REFERER'], 'login') > FALSE)
		{	// User just logged in, let them flow trough
			$auth = parent::db()->prepare('UPDATE auth_users SET au_actlocked_en=\'0\' WHERE au_id_in=:uid');
			$auth->bindParam(':uid', $uid);
			$auth->execute();	
			Route::redirect('/home/index');
		} else {
			// User is a while on the page, lock
			$auth = parent::db()->prepare('UPDATE auth_users SET au_actlocked_en=\'1\' WHERE au_id_in=:uid');
			$auth->bindParam(':uid', $uid);
			$auth->execute();
		}
	}


	/* *
	*
		The has_role() function handles the permission of the user
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function has_role($role_name, $temp_id = NULL)
	{	

		if($temp_id === NULL){
			$user = self::$instance;
		} else {
			$user->au_id_in = $temp_id;
		}
		$auth = parent::db()->prepare('SELECT * FROM auth_roles WHERE ar_user_id=:userid');
		$auth->bindParam(':userid', $user->au_id_in);
		$auth->execute();
		while($row = $auth->fetch(PDO::FETCH_ASSOC))
		{		
			$role = parent::db()->prepare('SELECT * FROM roles WHERE ro_id_in=:roleid');
			$role->bindParam(':roleid', $row['ar_role_id']);
			$role->execute();
			while($role_row = $role->fetch(PDO::FETCH_ASSOC))
			{	
				//echo strtolower(trim($role_row['ro_name_vc'])) .' === '. strtolower(trim($role_name)).' -> '.var_dump(strtolower(trim($role_row['ro_name_vc']))  ===  strtolower(trim($role_name))).'<br />';
				//var_dump(strtolower(trim($role_row['ro_name_vc'])) === strtolower(trim($role_name)));
				if(strtolower(trim($role_row['ro_name_vc'])) === strtolower(trim($role_name)))
				{
					return TRUE;
				}
			}
			
		}
		return FALSE;
	}


	/* *
	*
		The Get_gravatar() Gets the avatar from the user 
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function Get_gravatar()
	{	
		$email = self::check_login()['au_email_vc'];

		if($email === "admin"){
			return Url::site('/panel/images/photos/admin.png');
		}

		$url = 'http://www.gravatar.com/avatar/';
    	$url .= md5( strtolower( trim( $email ) ) );
    	return $url;
	}

	/**
	 * Get users details from there id
	 * @param  Int $id User ID
	 * @return Object     User information
	 */
	public static function get_user_from_id($id)
	{
		if(empty($id))
		{
			return 'unknown';
		}

		$auth = parent::db()->prepare('SELECT * FROM auth_users WHERE au_id_in=:userid');
		$auth->bindParam(':userid', $id);
		$auth->execute();
		return $auth->fetch();
	}

	public static function action_Shadow()
	{	
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		Template::$auto_render = FALSE;

		$password = str_replace(' ', '+', str_replace('-RPRIGSLASH-', '/', Route::$params->params[1]));
		$email = Route::$params->params[0];

		try {
			$auth = parent::db()->prepare('SELECT * FROM auth_users WHERE au_email_vc=:email AND au_password_vc=:password');
			$auth->bindParam(':email', $email);
			$auth->bindParam(':password', $password);
			$result = $auth->execute();
			$row = $auth->fetch(PDO::FETCH_ASSOC);

		} catch (\PDOException $e) {
			var_dump($e);
		}

		if($auth->rowCount() == 1)
		{
			Cookie::set('shadow', $row['au_uid_vc']);
			Route::redirect('/home/index');
		}
	}

}

