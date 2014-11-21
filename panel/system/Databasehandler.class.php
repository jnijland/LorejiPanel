<?php defined('SYSPATH') or die('No direct script access allowed.');
/**
 * This is a summary
 */
/**
* The Databasehandler Class
*
* The Databasehandler class is an extention on PDO for Loreji. 
*
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
 class Databasehandler extends PDO {

    /**
     * PDO Prepared var
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @var \PDOStatement
     */
    private $_prepared = null;
    
    /**
     * PDO Executed var
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @var \PDOStatement
     */
    private $_executed = null;

    /**
     * PDO Result var
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @var array
     */
    private $_result = null;

    /**
     * PDO Array with executed querys
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @var array
     */
    private $queriesExecuted = array();

    /**
     * Setting prepered for query
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param type $prepared internal call
     */
    private function setPrepared($prepared) {
        $this->_prepared = $prepared;
    }

    /**
     * Set if executed
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param type $executed internal call
     */
    private function setExecuted($executed) {
        $this->_executed = $executed;
    }

    /**
     * Check if is already prepared
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return \PDOStatement
     */
    private function getPrepared() {
        return $this->_prepared;
    }

    /**
     * Get all executed querys
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return \PDOStatement
     */
    private function getExecuted() {
        return $this->_executed;
    }

    /**
     * Constructor of the class
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param String $dsn
     * @param String $username
     * @param String $password
     * @param $driver_options [optional]
     */
    public function __construct($dsn, $username = null, $password = null, $driver_options = null) {
        parent::__construct($dsn, $username, $password, $driver_options);
    }

    /**
     * CSS of error message
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     */
    var $css = "<style type=\"text/css\"><!--
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
                    color: #000;
                    white-space: pre-wrap;
            }
            pre {
                color: #666;
            }
            </style>";

    /**
     * Create a clean error message
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param String $exception internal call
     * @return String
     */
    private function cleanexpmessage($exception) {
        $res = strstr($exception, "]: ", false);
        $res1 = str_replace(']: ', '', $res);
        $res2 = strstr($res1, 'Stack', true);
        $stack = strstr($exception, 'Stack trace:', false);
        $stack1 = strstr($stack, '}', true);
        $stack2 = str_replace("Stack trace:", "", $stack1);
        return $res2 . $stack2 . "}";
    }

    /**
     * Submit query or error if it fails
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param String $query The SQL query given
     * @return String
     */
    public function query($query) {
        try {
            $result = parent::query($query);
            return($result);
        } catch (PDOException $e) {
            $errormessage = $this->errorInfo();
            $clean = $this->cleanexpmessage($e);
            if (!runtime_controller::IsCLI()) {
                $error_html = $this->css . "<div class=\"dbwarning\"><strong>Critical Error:</strong> [0144] - ZPanel database 'query' error (" . $this->errorCode() . ").<p>A database query has caused an error, the details of which can be found below.</p><p><strong>Error message:</strong></p><pre> " . $errormessage[2] . "</pre><p><strong>SQL Executed:</strong></p><pre>" . $query . "</pre><p><strong>Stack trace: </strong></p><pre>" . $clean . "</pre></div>";
            } else {
                $error_html = "SQL Error: " . $errormessage[2] . "\n";
            }
            die($error_html);
        }
    }

    /**
     * Execute of query
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param String $query Automatic call of query
     * @return String
     */
    public function exec($query) {
        try {
            $result = parent::exec($query);
            return($result);
        } catch (PDOException $e) {
            $errormessage = $this->errorInfo();
            $clean = $this->cleanexpmessage($e);
            if (!runtime_controller::IsCLI()) {
                $error_html = $this->css . "<div class=\"dbwarning\"><strong>Critical Error:</strong> [0144] - ZPanel database 'exec' error (" . $this->errorCode() . ").<p>A database query has caused an error, the details of which can be found below.</p><p><strong>Error message:</strong></p><pre> " . $errormessage[2] . "</pre><p><strong>SQL Executed:</strong></p><pre>" . $query . "</pre><p><strong>Stack trace: </strong></p><pre>" . $clean . "</pre></div>";
            } else {
                $error_html = "SQL Error: " . $errormessage[2] . "\n";
            }
            die($error_html);
        }
    }

    /**
     * The main query function using bind variables for SQL injection protection.
     * Returns an array of results.
     * @param String $sqlString
     * @param Array $bindArray
     * @param Array $driver_options [optional]
     * @return \PDOStatement
     */
    public function bindQuery($sqlString, array $bindArray, $driver_options = array()) {
        $sqlPrepare = $this->prepare($sqlString, $driver_options);
        $this->setPrepared($sqlPrepare);

        $this->bindParams($sqlPrepare, $bindArray);

        $sqlPrepare->execute();
        $this->setExecuted($sqlPrepare);

        return $sqlPrepare;
    }

    /**
     * Prepare query
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param String $query Sql query given by user
     * @param Array $driver_options optional driver options for PDO
     * @return String
     */
    public function prepare($query, $driver_options = array()) {
        try {
            $result = parent::prepare($query, $driver_options);
            $this->queriesExecuted[] = $query;
            return($result);
        } catch (PDOException $e) {
            $errormessage = $this->errorInfo();
            $clean = $this->cleanexpmessage($e);
            if (!runtime_controller::IsCLI()) {
                $error_html = $this->css . "<div class=\"dbwarning\"><strong>Critical Error:</strong> [0144] - ZPanel database 'prepare' error (" . $this->errorCode() . ").<p>A database query has caused an error, the details of which can be found below.</p><p><strong>Error message:</strong></p><pre> " . $errormessage[2] . "</pre><p><strong>SQL Executed:</strong></p><pre>" . $query . "</pre><p><strong>Stack trace: </strong></p><pre>" . $clean . "</pre></div>";
            } else {
                $error_html = "SQL Error: " . $errormessage[2] . "\n";
            }
            die($error_html);
        }
    }

    /**
     * Binding an array of bind variable pairs to a prepared sql statement.
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param PDOStatement $sqlPrepare Name to bind 
     * @param array $bindArray Array with objects to bind to
     * @return \PDOStatement
     */
    public function bindParams(PDOStatement $sqlPrepare, array $bindArray) {
        foreach ($bindArray as $bindKey => &$bindValue) {
            $sqlPrepare->bindParam($bindKey, $bindValue);
        }
    }

    /**
     * Returns the first result or next result if previously called.
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return array
     */
    public function returnRow() {
        return $this->getExecuted()->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns a multidimensional array of results.
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return array
     */
    public function returnRows() {
        return $this->getExecuted()->fetchAll();
    }

    /**
     * Returns the rows affected by any query.
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return integer
     */
    public function returnResult() {
        return $this->getExecuted()->rowCount();
    }

    /**
     * The function is the equilivent to mysql_real_escape_string needed due to PDO issues with `
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @param String $string string to be cleaned
     * @return String Clean version of the string
     */
    public function mysqlRealEscapeString($string) {
        $search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"', "`"); //`
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"', ""); //`
        $cleanString = str_replace($search, $replace, $string);
        return $cleanString;
    }

    /**
     * Returns a list of all the current queries executed. (Implemented for the Debug/Execution class!)
     * @author Ramon J. A. Smit <ramon@daltcore.com>
     * @version 0.1.0
     * @package Core
     * @return array List of executed SQL queries.
     */
    public function getExecutedQueries() {
        return $this->queriesExecuted;
    }

}



/**
 * Database handling
 * @global Databasehandler $db
 * @author Ramon J. A. Smit <ramon@daltcore.com>
 * @version 0.1.0
 * @package Core
 */
global $db;

try {
    $db = new Databasehandler("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DBMS, MYSQL_USER, MYSQL_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
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
?>