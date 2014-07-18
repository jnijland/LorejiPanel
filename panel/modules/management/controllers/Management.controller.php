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
	public static function action_Index()
	{	
		// MAGIC VARIABLE :3!!!
		//Template::$auto_render = FALSE;
		Parent::view('index');
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
			exit("Passwords does'nt match!\n");
		}

		$newpass = Encryption::encrypt($password);

		$query = Parent::db()->prepare("UPDATE auth_users SET au_password_vc=:newpass WHERE au_email_vc='admin'");
		$query -> bindParam(':newpass', $newpass);
		$query->execute();
		printf("New password is set!\n");
	}
}
?>