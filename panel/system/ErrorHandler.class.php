<?php

	/**
     * The exception_handler() function handles the errors
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param STDObject $exception the error information
     * @return Echo string Pure HTML
     * @version 0.1.0
     * @package Core
     */
    function exception_handler($exception) {
     // echo "Uncaught exception: " , $exception->getMessage(), "\n";
      echo '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>An Exception Has Been Thrown: '.$exception->getMessage().'</title>
    </head>
    <body>
        <h1>Oops! An Exception Has Been Thrown</h1>
        <h4>Loreji: "<em>'.$exception->getMessage().'</em>"</h4>
    </body>
    </html>';
    }

	/**
     * The set_exception_handler() function handles the errors
     * 
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @param String $exception Function error handler
     * @return STDObject $exception the error information
     * @version 0.1.0
     * @package Core
     */
    set_exception_handler('exception_handler');

    /**
    * The ErrorHandler class
    *
    * The ErrorHandler class handles all errors
    *
    * @author Ramon J. A. Smit <ramon@daltcore.com>
     */
    class ErrorHandler {

        /**
         * The class name wehere this exception is called
         * @var String $class Current class name
         */
        public static $class = NULL;

        /**
         * Method set_error handles the general errors called from Loreji
         * @param String $errormessage A text description of error message
         */
        public static function set_error($errormessage)
        {
            throw new Exception($errormessage, time());
            exit(0);
        }

    }
?>