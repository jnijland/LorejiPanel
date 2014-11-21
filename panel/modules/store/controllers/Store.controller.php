<?php defined('SYSPATH') or die('No direct script access allowed.');

class Store extends Controller
{

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Store";

	// Modules that just can't be uninstalled from the store!
	static $unrm_mods = array('api', 'domain', 'store', 'home', 'management', 'auth', 'language');

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

	public static function action_Remove()
	{
		Template::$auto_render = false;
		$packagename = strtolower(Route::$params->params[0]);
		
		$remove_sql = file_get_contents(MODPATH.DS.$packagename.DS.'config'.DS.'sql'.DS.'remove.sql');
		// Alrigth there is a valid SQL file in here :)
		if(!empty($remove_sql)){
			$query = Parent::db()->prepare($remove_sql);
			$query->execute();
		}

		// Removing the module!
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator(MODPATH.DS.$packagename, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path) {
		    $path->isDir() ? rmdir($path->getPathname()) : unlink($path->getPathname());
		}

		rmdir(MODPATH.DS.$packagename);
		Cookie::set('remove', 'true');
		Route::redirect('/store/index');
	}

	public static function action_Update()
	{
		Template::$auto_render = false;
		$packagename = strtolower(Route::$params->params[0]);
		echo $packagename;
		self::download('https://loreji.com/api/download/'.strtolower($packagename), TMPPATH.DS.strtolower($packagename).'.zip');

		$zip = new ZipArchive;
		if ($zip->open(TMPPATH.DS.strtolower($packagename).'.zip') === TRUE) {
		    $zip->extractTo(MODPATH);
		    $zip->close();
		   	unlink(TMPPATH.DS.strtolower($packagename).'.zip');
		   	Cookie::set('upgrade', 'true');
		   	Route::redirect('/store/index');
		} else {
		    unlink(TMPPATH.DS.strtolower($packagename).'.zip');
		    Cookie::set('upgrade', 'false');
		    Route::redirect('/store/index');
		}
	}


	public static function action_Install()
	{
		Template::$auto_render = false;
		$packagename = strtolower(Route::$params->params[0]);
		echo $packagename;
		self::download('https://loreji.com/api/download/'.strtolower($packagename), TMPPATH.DS.strtolower($packagename).'.zip');

		$zip = new ZipArchive;
		if ($zip->open(TMPPATH.DS.strtolower($packagename).'.zip') === TRUE) {
		    $zip->extractTo(MODPATH);
		    $zip->close();
		   	unlink(TMPPATH.DS.strtolower($packagename).'.zip');
		   	Cookie::set('install', 'true');
		   	Route::redirect('/store/index');
		} else {
		    unlink(TMPPATH.DS.strtolower($packagename).'.zip');
		    Cookie::set('install', 'false');
		    Route::redirect('/store/index');
		}
	}

	public static function load_inner_repos_to_array()
	{
		$repoarray = self::repolist_to_array();
		$modulesarray = array();
		foreach ($repoarray as $value) {
			$modules = Http::get_response($value);
			$modulesarray[$value] = json_decode($modules, TRUE);
		}
		return $modulesarray;
		// echo '<pre>', print_r($modulesarray, true), '</pre>';
	}

	public static function download($url, $destination) {
	    try {
	        $fp = fopen($destination, "w");
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_FILE, $fp);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	        $resp = curl_exec($ch);

	        // validate CURL status
	        if(curl_errno($ch))
	            throw new Exception(curl_error($ch), 500);

	        // validate HTTP status code (user/password credential issues)
	        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        if ($status_code != 200)
	            throw new Exception("Response with Status Code [" . $status_code . "].", 500);
	    }
	    catch(Exception $ex) {
	        if ($ch != null) curl_close($ch);
	        if ($fp != null) fclose($fp);
	        throw new Exception('Unable to properly download file from url=[' + $url + '] to path [' + $destination + '].', 500, $ex);
	    }
	    if ($ch != null) curl_close($ch);
	    if ($fp != null) fclose($fp);
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

}