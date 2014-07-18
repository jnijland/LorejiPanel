<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Model_Test class
*
* The modal handles the interaction between the panel and database
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Model_Mysql extends Model
{	
     public static function getMysqlUsers()
     {    
     	  $uid = Auth::check_login()['au_id_in'];
          $query = Parent::db()->prepare('SELECT * FROM `mysql_users` WHERE au_id_in=:uid');
          $query->bindParam(':uid', $uid);
          $query->execute();
          return $query->fetchAll(PDO::FETCH_ASSOC);
     }

     public static function getMysqlDatabases()
     {    
     	  $uid = Auth::check_login()['au_id_in'];
          $query = Parent::db()->prepare('SELECT * FROM `mysql_databases` WHERE au_id_in=:uid');
          $query->bindParam(':uid', $uid);
          $query->execute();
          return $query->fetchAll(PDO::FETCH_ASSOC);
     }
}
?>