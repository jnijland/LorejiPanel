<?php
	ini_set('default_socket_timeout', 1);
	ini_get("default_socket_timeout");
	include('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php');

	// Connect with main CC-Unit server
	/**
	 * Database handling
	 * @global Databasehandler $db
	 * @author Ramon J. A. Smit <ramon@daltcore.com>
	 * @version 0.1.0
	 * @package CC-Unit
	 */
	global $cdb;

	try {
	    $cdb = new Databasehandler("mysql:host=localhost;dbname=loreji_ccunit", MYSQL_USER, MYSQL_PASS);
	    $cdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    $error_html = "<style type=\"text/css\"><!--
	            .dbwarning {
	                    font-family: Verdana, Geneva, sans-serif;
	                    font-size: 14px;
	                    color: #C00;
	                    background-color: #FCC;
	                    padding: 30px;
	                    border: 1px solid #C00;
	            }
	            p {
	                    font-size: 12px;
	                    color: #666;
	            }
	            </style>
	            <div class=\"dbwarning\"><strong>Critical Error:</strong> [0100] - Unable to connect or authenticate to the database (<em>".MYSQL_DBMS."</em>).<p>We advice that you contact the server administrator to ensure that the database server is online and that the correct connection parameter are being used.</p>"
	            . "             <p>or check /init.php </p></div>";

	    echo($error_html);
	}
	
	if(Auth::check_login(FALSE, TRUE) != FALSE && Auth::has_role('ccunit') == TRUE)
	{	

		// Load all the databases
		CCUnit::connect_servers();

		if(isset($_GET['page']) && $_GET['page'] == 'api')
		{
			include(getcwd().'/api.php');
			exit;
		}

		foreach (glob(APPPATH.DS."ccunit".DS."classes".DS."*.class.php") as $filename) {
			require_once($filename);
		}

		$page = ((isset($_REQUEST['page'])) ? strtolower($_REQUEST['page']) : 'index');
		if(empty($page) || $page == "index" || !file_exists(APPPATH.DS.'ccunit'.DS.'template'.DS.'pages'.DS.$page.'.php'))
		{
			$page = 'dashboard';
		}

		// Set the base template
		Template::$basetemplate = APPPATH.DS.'ccunit'.DS.'template'.DS.'index.php';

		// Build the base template and execute PHP
		Template::factory();

		// Load the minimum page information
		Template::sideload('{{navigation}}', (APPPATH.DS.'ccunit'.DS.'template'.DS.'inners'.DS.'navigation.php'));
		Template::sideload('{{header}}', (APPPATH.DS.'ccunit'.DS.'template'.DS.'inners'.DS.'header.php'));
		Template::sideload('{{javascripts}}', (APPPATH.DS.'ccunit'.DS.'template'.DS.'inners'.DS.'javascripts.php'));

		// Load the inner page
		Template::sideload('{{page}}', (APPPATH.DS.'ccunit'.DS.'template'.DS.'pages'.DS.$page.'.php'));

		Template::bind('page', $page);

		// Output of basetemplate 
		Template::render();	
	} 
	else
	{
		Route::redirect('/login');
	}
	//var_dump($GLOBALS['ccunit_servers']);
?>