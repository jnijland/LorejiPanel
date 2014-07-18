<?php defined('SYSPATH') or die('No direct script access allowed.');

/**
* The Model_Test class
*
* The modal handles the interaction between the panel and database
* @author Ramon J. A. Smit <ramon@daltcore.com>
*/
class Model_Management extends Model
{	
     public function getSettings()
     {    
          $query = Parent::db()->prepare('SELECT * FROM settings');
          $query->execute();
          return $query->fetchAll(PDO::FETCH_ASSOC);
     }
}
?>