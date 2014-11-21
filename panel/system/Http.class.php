<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The http class
*
* The http class handles all url data reletated information
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Http 
{   
	/**
     * Method get_response connects with a URL and tries to get the information
     * @param  String $url url with http:// or https://
     * @return String $result Awnser depends. May return false if awnser is not '200'
     * @author Ramon J.A. Smit <rsmit@loreji.com>
     * @package Core
     * @version 0.1.0s
     */
	public static function get_response($url = NULL)
	{	
        // Check if $url is null.
        if($url === NULL)
        {
            ErrorHandler::set_error("No URL given. Please check your URL");
            exit();
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_USERAGENT, self::useragent_builder());
        $result = curl_exec($ch);
        $header = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($header == 200 || $header == 302 || $header == 301)
        {   
            return $result;
        } 
        else
        {   
            return '{"NoUrl":"false", "header":{"Code":"'.$header.'","Message":"'.self::http_response_code($header).'"}}';
        }
    }

    public static function post_response($url = NULL, $fields = array())
    {
        $fields_string = "";
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT, self::useragent_builder());
        $result = curl_exec($ch);
        $header = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // Return the result!
        if($header == 200 || $header == 302 || $header == 301)
        {   
            return $result;
        } 
        else
        {   
            return '{"NoUrl":"false", "header":{"Code":"'.$header.'","Message":"'.self::http_response_code($header).'"}}';
        }
    }

    /**
     * HTTP_ERROR_CODE handles the errors for get_response
     * @param  String $code header code from curl
     * @return String $text string with error description
     * @author Ramon J.A. Smit <rsmit@loreji.com>
     * @package Core
     * @version 0.1.0
     */
    private static function http_response_code($code = NULL) {
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

    /**
     * Useragent builder for CURL
     * @return String Useragent string like: 'Text/LorejiPanel; Version/0.1.0; CURL-based; (+http://loreji.com/useragent)'
     * @author Ramon J.A. Smit <rsmit@loreji.com>
     * @package Core
     * @version 0.1.0
     */
    private static function useragent_builder()
    {
        $loreji_version = Settings::get('loreji_version');
        $useragent = 'Text/LorejiPanel; Version/'.$loreji_version.'; CURL-based; (+http://loreji.com/useragent)';
        return $useragent;
    }
}
?>