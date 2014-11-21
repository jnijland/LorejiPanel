<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Template class
*
* The template class handles the rendering and output of the templates/views and sideloads.
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Template 
{

	/**
     * Loads the basetemplate, set from the index
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $basetemplate = '';
     * @version 0.1.0
	 * @package Core
     */
	public static $basetemplate = '';

	/**
	*
	*	Variable that holds the view templates
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	* @deprecated 0.1.0 [31-07-2014] not used
	*/
	protected static $viewtemplate = '';

	/**
	*
	*	Variable that holds the template that needs to be rendered
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	private static $htmlview = '';

	/**
	*
	*	Variable that holds the boolean if need to render or not
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static $auto_render = TRUE;

	/**
	*
	*	A array variable to bind into the tempaltes!
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	private static $bind;

	/**
	*
	*	The factory() function handles the init of the base template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function factory()
	{
		// Load the base template
		//self::$bind = new stdClass();
		self::$htmlview = file_get_contents(self::$basetemplate);
	}

	/**
	*
	*	The bind() function handles the init of the base template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function bind($key, $value)
	{
		if(empty($key)) { throw new Exception("Enter a bind-able key!", 1); }

		try {
			self::$bind[$key] = $value;
		} catch (Exception $e) {
			
		}
	}

	/**
	*
	*	The sideload() function handles optional views of the template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	* @param String $find Search the document for the finder
	* @param String $view The view file to replace $find with
	*/
	public static function sideload($find, $view)
	{	
		if($view === ''){
			self::$htmlview = str_replace($find, $view, self::$htmlview);
			return;
		}

		$view = file_get_contents($view);
		self::$htmlview = str_replace($find, $view, self::$htmlview);
	}

	/**
	*
	*	The render() function the rendering of the complete template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function render()
	{	
		if(self::$auto_render === TRUE)
		{
			$template = self::$htmlview;
			ob_start();

			$powerbind = json_encode(self::$bind);
			$bind = (array) json_decode($powerbind, true);
			extract($bind); 
			$templatename = '/tmp/loreji_temp.'.rand(1,99999).time().rand(1,99999).'.tpl';
			file_put_contents($templatename, $template);
			include($templatename);
			//unlink($templatename);
			
			// Seems we found the above as work-around for eval! :)
			/*eval('$bind = (array) json_decode(\''.$powerbind.'\', true);
				// Here we will bind the binds to the template..
				extract($bind); 
			 ?> ' . $template . ' <?php ');*/

			$output = ob_get_contents();
			ob_end_clean();
			echo trim($output);
		}
	}


	/**
	*
	*	The alert() function handles optional views of the template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	* @param String $text text to show
	* @param String $style Bootstrap alert style
	* @return String with manipulated  HTML data
	* @deprecated [0.1.2[31-07-2014]] Moved to HTML system controller. 
	*/
	public static function alert($text, $style = 'success', $css = '')
	{
		return Html::set_flash_message($text, $style, $css);
	}

} ?>