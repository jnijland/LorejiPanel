<?php defined('SYSPATH') or die('No direct script access allowed.');

class Store extends Controller
{

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Store";

	/* *
	*
		The factory() function handles the init of the base tempalte

	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	*/
	public static function cli_addrepo($reponame)
	{	
		$repoarray = self::repolist_to_array();
		if(in_array($reponame, $repoarray))
		{
			printf("$reponame is already in the repo list.");
			exit();
		}
		self::add_to_repo_list($reponame);
		printf("Added repo $reponame to the Loreji Store Servcice\nPlease execute 'loreji store fetch' \n\n");
	}

	/**
	*
	*	The action_Index() function handles the store main template
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function action_Index()
	{	
		Parent::view('store_index');
	}

	public static function load_inner_repos_to_array()
	{
		$repoarray = self::repolist_to_array();
		$modulesarray = array();
		foreach ($repoarray as $value) {
			$modules = file_get_contents('http://'.$value.'/modules.php');
			$modulesarray[$value] = json_decode($modules, TRUE);
		}
		return $modulesarray;
		// echo '<pre>', print_r($modulesarray, true), '</pre>';
	}

	/**
	*
	*	repolist_to_array() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	private static function repolist_to_array()
	{
		$repolist = SYSROOT.DS.'modules'.DS.'store'.DS.'config'.DS.'repolist';
		$file_handle = fopen($repolist, "rb");
		$linearray = array();

		while (!feof($file_handle) ) {
			$line_of_text = fgets($file_handle);
			$line_of_text = trim(str_replace("\n", '', $line_of_text));
			$linearray[] = $line_of_text;
		}

		fclose($file_handle);
		return array_filter($linearray);
	}

	/**
	*
	*	cli_removerepo() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function cli_removerepo($reponame)
	{
		$repolist = SYSROOT.DS.'modules'.DS.'store'.DS.'config'.DS.'repolist';
		$file_handle = file_get_contents($repolist);
		$file_handle = str_replace($reponame, '', $file_handle);
		file_put_contents($repolist, $file_handle);
		printf("Removed repo $reponame from the repolist\nPlease execute 'loreji store fetch' \n\n");
	}

	/**
	*
	*	add_to_repo_list() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	private static function add_to_repo_list($repo)
	{
		$repolist = SYSROOT.DS.'modules'.DS.'store'.DS.'config'.DS.'repolist';
		file_put_contents($repolist, $repo."\n", FILE_APPEND);
	}

	/**
	*
	*	cli_lsrepo() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function cli_lsrepo()
	{	
		$repoarray = self::repolist_to_array();
		if(isset($repoarray[0]) && $repoarray[0] == "")
		{
			printf("No repo found! Please execute: 'loreji store addrepo repo.loreji.com'\n\n");
			exit();
		}

		printf("List Repo:\n");
		$list = "";
		foreach ($repoarray as $value) {
			printf("$value \n");
		}
		printf("\n");
	}

	/**
	*
	*	cli_fetch() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function cli_fetch()
	{	
		$repoarray = self::repolist_to_array();
		if(isset($repoarray[0]) && $repoarray[0] == "")
		{
			printf("No repo found! Please execute: 'loreji store addrepo repo.loreji.com'\n\n");
			exit();
		}

		printf("Fetch Repo:\n");
		printf("[repo name]    -  [status] [status code]\n");
		$list = "";
		foreach ($repoarray as $value) {
			$repolist = SYSROOT.DS.'modules'.DS.'store'.DS.'config'.DS.'repos';
			File::delTree($repolist);
			$thesaurus_search='http://'.$value;

			if($thesaurus_search == "http://"){ continue; }
			$result_thesaurus=@file_get_contents($thesaurus_search);
			$handle = curl_init($thesaurus_search);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($handle);

			/* Check for 404 (file not found). */
			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			if($httpCode == 200) {
			    file_put_contents($repolist.DS.$value.'.lor', $result_thesaurus);
			}

			curl_close($handle);

			$httpCode = ($httpCode == 0)? 'Repo ERROR ['.$httpCode.']' : 'Repo OK ['.$httpCode.']';

			printf("$value - $httpCode \n");
		}
		printf("\n");
	}

	/**
	*
	*	cli_modules() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function cli_modules()
	{	
		$modules = $GLOBALS['modules'];
		if(isset($modules)){
			foreach ($modules as $module) 
			{ $module = (array) $module;

				$handle = curl_init($module['update_url'].'index.php?installed_version='.$module['version']);
				curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
				$response = curl_exec($handle);
				$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
				curl_close($handle);

				$httpCode = ($httpCode !== 200)? " \033[00;31mRepo ERROR [".$httpCode.' - '.self::http_response_code($httpCode)."]\033[0m" : " \033[00;32mRepo [".$httpCode.' - '.self::http_response_code($httpCode)."]\033[0m";

				printf("#####\n Name: \033[00;36m{$module['name']}\033[0m\n Version: \033[00;36m{$module['version']}\033[0m\n Type: \033[00;36m{$module['type']}\033[0m\n Store URL: \033[00;36m{$module['update_url']}\033[0m\n Connection: {$httpCode}\n Response: {$response}\n\n");
			}
		}
	}

	/**
	*
	*	http_response_code() 
	*
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function http_response_code($code = NULL) {

        if ($code !== NULL) {

            switch ($code) {
            	case 0: $text = 'SSL not supported'; break;
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }
   		}
   		return $text;
    }




}