<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Model_Test class
*
* The modal handles the interaction between the panel and database
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Model_Test extends Model
{	
     public function getUsers()
     {    
          $query = Parent::db()->prepare('SELECT * FROM auth_users');
          $query->execute();
          return $query->fetch(PDO::FETCH_ASSOC);
     }
}
?>