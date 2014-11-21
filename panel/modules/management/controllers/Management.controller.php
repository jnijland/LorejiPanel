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

		$query = Controller::db()->prepare("SELECT * FROM settings WHERE se_visible_en='1' ORDER BY se_type_vc ASC");
		$query->execute();
		$fields = $query->fetchAll(PDO::FETCH_ASSOC);
		Template::bind('fields',$fields);
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

	public static function action_Modulesettings()
	{	
		if(Request::method() === "POST")
		{
			$post = (array) Request::post();
			$module = $post['module'];
			unset($post['module']);
			var_dump($post);
			foreach ($post as $key => $value) {
				Module::setSetting($module, htmlentities($key), htmlentities($value));
			}
			Cookie::set('savedok', time());
			Route::redirect('/management/modulesettings');
		}
		Template::bind('active_modules', $GLOBALS['modules_active']);
		Parent::view('modulesettings');
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

}
?>