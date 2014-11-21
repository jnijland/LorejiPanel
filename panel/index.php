<?php
/**
* The index File
*
* The index file handles the Routing of Loreji
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/

/**
 * Neat Output Buffering
 */
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
* Start the Init
*/
require('init.php');

if(Settings::get('force_ssl') === "true" && !isset($_SERVER['HTTPS'])){
    $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
}

/**
* Some kind of routing
*/

$Route = Route::factory('controller/action');

 Cookie::set('ref', ($Route->controller.'/'.$Route->action), time()+time());
 //echo Cookie::get('ref');

// Login
if($Route->controller === "login"){

	if(Auth::check_login(TRUE)){
		Route::redirect('/home/index');
	}

	// Set the base template
	Template::$basetemplate = SYSROOT.DS.'panel'.DS.'signin.php';

	// Build the base template and execute PHP
	Template::factory();

	// Output of basetemplate 
	Template::render();	
	exit;
}

// Lock
if($Route->controller === "lock"){
	// Call the lock action
	Route::controller(Route::make_controller('auth', 'lock'));
	
	// Set the base template
	Template::$basetemplate = SYSROOT.DS.'panel'.DS.'locked.php';

	// Build the base template and execute PHP
	Template::factory();

	// Output of basetemplate 
	Template::render();	
	
	exit;
}

// Twoway authentication
if($Route->controller === "twoway"){
	Auth::$no_check = FALSE;
	$ga = new GoogleAuthenticator();
	Template::bind('qr', $ga->getQRCodeGoogleUrl('Loreji Panel: '.Auth::check_login()['au_username_vc'], Auth::check_login()['au_gasecret_vc']));
	/*$secret = 'SMBEY4M477S6AQRT';*/
	//$oneCode = $ga->getCode($secret);

	if(Request::method() === 'POST')
	{
		$checkResult = $ga->verifyCode(Auth::check_login()['au_gasecret_vc'], Request::post('vcode'), 4);    // 2 = 2*30sec clock tolerance

		if ($checkResult) {
			Cookie::set('gauth', Request::post('vcode'), 60 * 60);
		    Route::redirect('/home/index');
		} else {
			//Route::redirect('/twoway');
		}
	}

	
	// Set the base template
	Template::$basetemplate = SYSROOT.DS.'panel'.DS.'twoway.php';

	// Build the base template and execute PHP
	Template::factory();

	// Output of basetemplate 
	Template::render();	
	
	exit;
}

// Doing some logout
if($Route->controller === "logout"){
	Route::controller(Route::make_controller('auth', 'logout'));
	exit;
}

	
	if(Auth::check_login(TRUE) !== FALSE){
		/**
		* Load the base template
		*/
		// Set the base template
		Template::$basetemplate = SYSROOT.DS.'panel'.DS.'index.php';

		// Get the base template
		Template::factory();

		// Add the left menu
		Template::sideload('{{base::leftmenu}}', SYSROOT.DS.'panel'.DS.'inners'.DS.'leftmenu.php');

		// Add the top menu
		Template::sideload('{{base::topmenu}}', SYSROOT.DS.'panel'.DS.'inners'.DS.'topmenu.php');
	}


	Route::controller(Route::make_controller($Route->controller, $Route->action));


	if(Auth::$no_check === FALSE && Auth::check_login(TRUE) === FALSE){
		Route::redirect('/login');
	}

	if(Auth::check_login(TRUE) !== FALSE){
		Template::render();
	}
	exit;

?>