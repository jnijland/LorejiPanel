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
	*/
	public static $viewtemplate = '';

	/**
	*
	*	Variable that holds the template that needs to be rendered
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static $htmlview = '';

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
	*	The factory() function handles the init of the base template
	*
	* @author Ramon Smit  <ramon@daltcore.com>
	* @version 0.1.0
	* @package Core
	*/
	public static function factory()
	{
		// Load the base template
		self::$htmlview = file_get_contents(self::$basetemplate);
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
			str_replace($find, $view, self::$htmlview);
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
			eval(' ?> ' . $template . ' <?php ');
			$output = ob_get_contents();
			ob_end_clean();
			echo trim($output);
		}
	}

	public static function alert($text, $style = 'success')
	{
		return '
		<div class="row">
			<div class="col-md-2 col-md-offset-3">
				<div class="alert alert-'.$style.' loreji-alert" style="display:block;">
		        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        	'.$text.'
		        </div>
		    </div>
        </div>';
	}

} ?>