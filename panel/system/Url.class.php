<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The URL Class
*
* The URL class handles the perfect handling of URL's for the loreji panel
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Url 
{

	/**
     * The site() rewrites to the correct url
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @param String $dirtyurl
     * @return Clean formatted url
     */
	public static function site($dirtyurl)
	{	
        if (php_sapi_name() != 'cli') {
            if (substr($dirtyurl, 0, 1) !== '/') { $dirtyurl = '/'.$dirtyurl; }
            return sprintf("%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['HTTP_HOST'], $dirtyurl);
        }
	}

    /**
     * Convert a phrase to a URL-safe title.
     *
     *     echo Url::title('My Blog Post'); // "my-blog-post"
     *
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @param   string   $title       Phrase to convert
     * @param   string   $separator   Word separator (any single character)
     * @return  string
     */
    public static function title($title, $separator = '-')
    {
        // Remove all characters that are not the separator, a-z, 0-9, or whitespace
        $title = preg_replace('![^'.preg_quote($separator).'a-z0-9\s]+!', '', strtolower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        // Trim separators from the beginning and end
        return trim($title, $separator);
    }

    /**
     * Convert a phrase to a URL-safe title.
     *
     *     echo Url::Module_url('Home', 'Index'); // "/home/index"
     *
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @param   string   $controller  Controller name to render
     * @param   string   $action      Action name to render
     * @return  string
     * @uses self::site() generating full url string
     */
    public static function Module_url($controller, $action = 'index')
    {
        $controller = strtolower($controller);
        $action     = str_replace('action_', '', strtolower($action));
        return self::site('/'.$controller.'/'.$action);
    }
}
?>