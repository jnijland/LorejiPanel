<?php
/**
* The index File
*
* The index file handles the Routing of Loreji
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/

/**
* Start the Init
*/
require('init.php');


/**
* Some kind of routing
*/

$Route = Route::factory('controller/action');

 Cookie::set('ref', ($Route->controller.'/'.$Route->action), time()+time());
 //echo Cookie::get('ref');

// Login
if($Route->controller === "login"){

	if(Auth::check_login()){
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

// Doing some logout
if($Route->controller === "logout"){
	Route::controller(Route::make_controller('auth', 'logout'));
	exit;
}

	
	if(Auth::check_login() !== FALSE){
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


	if(Auth::$no_check === FALSE && Auth::check_login() === FALSE){
		Route::redirect('/login');
	}

	if(Auth::check_login() !== FALSE){
		Template::render();
	}
	exit;

?>