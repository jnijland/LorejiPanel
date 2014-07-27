<?php defined('SYSPATH') or die('No direct script access allowed.');

class Management extends Controller
{	
	// Class namespace 
	static $namespace = "com.daltcore.loreji\Management";

	/**
	*
	*	The index() serves the main management Index
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function action_Loreji()
	{	
		if(Request::method() === "POST")
		{
			// Manipulate final data
			$settings = array(
				// se_key_vc => se_value_vc
				'use_panel_ssl' => (Request::post('use_panel_ssl') === 'true')? Request::post('ssl_setting') : '0',
				'use_lang_cache' => Request::post('use_lang_cache'),
				'loreji_system_lang' => strtoupper(Request::post('loreji_system_lang')),
				'login_with_app' => (Request::post('login_with_app') === 'true')? '1' : '0',
				'panel_domain' => Request::post('panel_domain'),
				'force_ssl' => Request::post('force_ssl'),
				);

			foreach ($settings as $se_key => $se_val) {
				$powerquery = ("UPDATE settings SET se_value_vc='".$se_val."' WHERE se_key_vc='".$se_key."'");
				$query = Parent::db()->prepare($powerquery);
				$query -> execute();
			}

		}
		Parent::view('index');
	}


	/**
	*
	*	The index() serves the main management Index
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function action_Users()
	{	
		// Remove the user
		if(Route::$params->params['0'] === "remove")
		{
			$user_id = Route::$params->params['1'];

			if($user_id == 1){
				// Bad....
				echo('You CANNOT remove the user <strong>"ADMIN"</strong> ');
				Route::redirect('/management/users?error=1');
				return;
			}

			$query = Parent::db()->prepare("DROP FROM auth_users WHERE au_id_in=:userid");
			$query->bindParam(':userid', $user_id);
			$query->execute();

			// Redirect after remove (prevent refresh problems)
			Route::redirect('/management/users');
			return;
		}

		// Casual viewing
		Parent::view('userlist');
	}

	/**
	*
	*	The generate_user_list() generates the userlist
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	* @return String $userlist
	*/
	public static function generate_user_list()
	{	
		$userlist = ''; $i=0;

		$query = Parent::db()->prepare("SELECT * FROM auth_users");
		$query->execute();
		$rows = $query->fetchAll();

		foreach ($rows as $value) { $i++;
			$userlist .= '<tr>
				<td>'.$i.'</td>
				<td>'.$value['au_username_vc'].'</td>
				<td>'.$value['au_email_vc'].'</td>
				<td class="table-action">
					<a href="/management/useredit/'.$value['au_id_in'].'" class="delete-row btn btn-primary" style="color: #FFF;"><i class="fa fa-pencil"></i></a>
					<a class="delete-row btn btn-danger removePopupLink" data-type="user" '. (($value['au_username_vc'] === 'admin')? 'disabled' : '') .' data-name="'.$value['au_username_vc'].'" data-id="'.$value['au_id_in'].'" rel="tooltip" data-original-title="'.Language::get('management.remove.user').'" style="color: #FFF;"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr>';
		}
		return $userlist;
	}


	/**
	*
	*	The cli_adminpass() resets the admin password
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function cli_adminpass()
	{
		$yesno = Cli::input("Do you really want to reset the admin password? [yes/no]:");
		if(strtolower($yesno) !== 'yes')
		{
			printf("Exit admin password reset!\n");
			exit;
		}

		$password = Cli::secure_input("Enter new password:");
		$password1 = Cli::secure_input("Re-enter new password:");

		if($password != $password1)
		{
			exit("Passwords doesn't match!\n");
		}

		$newpass = Encryption::encrypt($password);

		$query = Parent::db()->prepare("UPDATE auth_users SET au_password_vc=:newpass WHERE au_email_vc='admin'");
		$query -> bindParam(':newpass', $newpass);
		$query->execute();
		printf("New password is set!\n");
	}
}
?>