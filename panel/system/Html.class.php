<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Html class
*
* The html classs handles the generation of Bootstrap HTML items
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Html 
{
	/**
     * The set_flash_message() returns HTML flashmessage
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $text The innertext for an message
     * @param String $type The type of message (default: success)[sucsess/error/warning/info]
     * @return String Pure HTML
     * @version 0.1.0
     * @package Core
     */
	public static function set_flash_message($text, $type = 'success', $style = '')
	{	
      return '
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="alert alert-'.$type.' loreji-alert" style="display:block; '.$style.'">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    '.$text.'
                </div>
            </div>
        </div>';
	}
}
?>