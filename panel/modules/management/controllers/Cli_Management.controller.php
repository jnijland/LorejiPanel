<?php defined('SYSPATH') or die('No direct script access allowed.');

class Cli_Management extends CLI
{	


	public function __construct($args)
	{
		//printf($args);
	}

	/**
	*
	*	The adminpass() resets the admin password
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function adminpass()
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

	public static function regen($method = NULL)
	{
		switch ($method) {
			case 'salt':
				$yesno = Cli::input("Do you really want to reset the salt?\nThis will affect CC-Unit in a negative way! [yes/no]:");
				if(strtolower($yesno) !== 'yes')
				{
					printf("Exit salt reset!\n");
					exit;
				}

				printf("New hash is set, Old hash is backed up.\n");
				printf("Revert: 'loreji management revert salt'\n");
				break;
			
			default:
				printf("New method '$method' is not supported\n");
				break;
		}
	}

	public static function fix($method = NULL)
	{
		if($method == NULL)
		{
			die("Please enter a fix method\n");
		}

		switch ($method) {
			case 'permissions':
				printf("Fixing permissions.\n");
				// Save the permissions :D
				$items = File::chmod_r('/etc/loreji');
				printf("Fixed files and directorys!\n");
				break;

			case 'vhosts':
				Daemon::Loop_vhosts(false);
				printf("VHosts file is fixed.\n");
				break;

			default:
				printf("Fix method '$method' is not supported\n");
				printf("Assumed: 'loreji management fix ".Inflector::plural($method)."'\n\n");

				break;
		}
	}

	public static function remove($method = NULL)
	{	
		if($method == NULL)
		{
			die("Please enter a fix method\n");
		}

		switch ($method) {
			case 'cache':
				File::delTree(CACHEPATH);
				printf("Removed all cache files!.\n");
				break;

			case 'temp':
				File::delTree(TMPPATH);
				printf("Removed all temp files!.\n");
				break;

			case 'twoway':
				$query = Controller::db()->prepare("UPDATE auth_users SET au_enablega_en='0' WHERE au_username_vc='admin'");
				$query->execute();
				printf("2-way authentication for 'admin' is disabled.\n");
				break;

			default:
				printf("Remove method '$method' is not supported\n");
				break;
		}
	}

	public static function show($params)
	{	
		$command = parent::arguments($params);

		if($command[0] == 'user')
		{
			$query = Controller::db()->prepare("SELECT * FROM auth_users WHERE au_email_vc=:email");
			$query->bindParam(':email', $command[1]);
			$query->execute();
			$fields = $query->fetch(PDO::FETCH_ASSOC);
			foreach ($fields as $column => $value) {

				$ignores = array('au_password_vc', 'au_uid_vc', 'pk_id_in');

				if(in_array($column, $ignores)){
					continue;
				}

				$column = explode('_', $column);
				$column = $column[1];
				printf("$column: $value\n");
			}
		}

		else
		{
			printf("Command '$params' is not found!\n");
		}
		// end if command

	}

}
?>