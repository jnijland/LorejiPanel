<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The URL Class
*
* The URL class handles the perfect handling of URL's for the loreji panel
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class File 
{

	/**
     * The delTree() rewrites to the correct url
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @param String $$dir
     * @return Recursive 
     */
	public static function delTree($dir) 
    { 
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
            if(!is_dir("$dir/$file"))
            {
                unlink("$dir/$file"); 
            }
        } 
    }
}
?>