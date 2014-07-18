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

		print_r(Request::post());

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

					Cookie::set('uid', $new_key);
					$_COOKIE['uid'] = $new_key;

					// // Let me set a temporary ID
					// self::$instance->au_id_in = $row['au_id_in'];
					// // Check if we can login 
					// if(Auth::has_role('login') === TRUE)
					// { 
					 	Route::redirect('/home/index');
					// } 
					// else
					// {	
					// 	//User has no permissions for login, Kill the UID, and send to login with message
					// 	self::$instance->au_id_in = NULL;
					// 	Cookie::set('uid', 'NULL');
					// 	Route::redirect('/login?error=noperm');
					// }
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
	public static function check_login()
	{	

		if(self::$no_check === TRUE)
		{
			return TRUE;
		}

		$uid = Cookie::get('uid');
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
			self::$instance = (object) $row;
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

			print_r(Request::post());
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

		$uid = self::check_login()['au_id_in'];
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
	public static function has_role($role_name)
	{	
		$user = self::$instance;
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
}

