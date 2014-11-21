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
     * @param String $dir
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

    /**
     * Recursive copying
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @param  string $src source directory
     * @param  string $dst destenation directory
     * @return none
     */
    public static function recurse_copy($src,$dst) 
    { 
        $dir = opendir($src); 
        @mkdir($dst); 
        $index = 0;
        while(false !== ( $file = readdir($dir)) ) { 
            $index++;
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    self::recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
        return $index;
    } 

    /**
     * Chmod recursive
     * @param  string $Path string of path
     * @return none
     */
    public static function chmod_r($Path)
    {   
        try {
            
        $dp = @opendir($Path);
        $index = 0;
         while($File = @readdir($dp)) { 
           if($File != "." AND $File != "..") {
             if(is_dir($File)){
                $index++;
                chmod($File, 0755);
                chown($File, 'www-data');
                self::chmod_r($Path."/".$File);
             }else{
                $index++;
                 chmod($Path."/".$File, 0755);
                 chown($Path."/".$File, 'www-data');
             }
           }
         }
       @closedir($dp);
       } catch (Exception $e) {
            
        }
        return $index;
    }
}
?>