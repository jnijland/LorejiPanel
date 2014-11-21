<?php defined('SYSPATH') or die('No direct script access allowed.');

class Language extends Controller
{	

	// Class namespace 
	static $namespace = "com.daltcore.loreji\Language";

	static $languages = array();

	/* *
	*
		The get() function gets the language element for module
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	* @Depricated n/a
	* @Package Core
	* @subpackage String Text::widont String widont, no more widow words!
	*/
	public static function get($key, $find = array(), $replace = array())
	{	
		return str_replace($find, $replace, @self::$languages[$key]);
	}

	public static function Init_files(){

		$use_cache = Settings::get('use_lang_cache');
		
		if(isset(Auth::$instance['au_language_vc']))
		{
			$preffered_language = Auth::check_login()['au_language_vc'];
		} 
		else
		{
			$preffered_language = Settings::get('loreji_system_lang');
		}	

		if(!file_exists(CACHEPATH.'/languagecache'.$preffered_language.'.dat')){
			// Read all english language files from Loreji self
			$languages = array();


			// Always take the english as DEFAULT language
			include(SYSROOT."/language/EN.language.php");

			// Check if english is not the default language.
			if($preffered_language !== "EN"){
				@include(SYSROOT."/language/".$preffered_language.".language.php");
			}

			// Get all language langs for EN, because EN is default
			foreach (glob(MODPATH."/*/language/EN.language.php") as $filename) {
				//echo $filename."\n";
				include($filename);
			}

			// Check if english is not the default language.
			if($preffered_language !== "EN"){
				//echo "\nOverrule EN: \n";
				// Fetch all the language files for the selected language. 
				foreach (glob(MODPATH."/*/language/".$preffered_language.".language.php") as $filename) {
					//echo $filename."\n";
					include($filename);
				}
			}

			$_LANG['from_cache'] = 'FALSE';
			if($use_cache === "true"){
				file_put_contents(CACHEPATH.'/languagecache'.$preffered_language.'.dat', json_encode($_LANG));
			} else {
				if(file_exists(CACHEPATH.'/languagecache'.$preffered_language.'.dat')){
					unlink(CACHEPATH.'/languagecache'.$preffered_language.'.dat');
				}
			}
		} else {
			$json = @file_get_contents(CACHEPATH.'/languagecache'.$preffered_language.'.dat');

			if(empty($json)){
				if(@file_exists(CACHEPATH.'/languagecache'.$preffered_language.'.dat')){
					unlink(CACHEPATH.'/languagecache'.$preffered_language.'.dat');
				}
				self::Init_files();
			}

			$_LANG = json_decode($json, true);
			$_LANG['from_cache'] = 'TRUE';
		}
		self::$languages = $_LANG;
	}

}
?>