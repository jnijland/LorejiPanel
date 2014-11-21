<?php 
exit;
class AstMan {

  var $socket;
  var $error;
  
  function AstMan()
  {
    $this->socket = FALSE;
    $this->error = "";
  } 

  function Login($host="sip.daltcore.net", $username="admin", $password="derietgans"){
    
    $this->socket = @fsockopen($host,"5038", $errno, $errstr, 1); 
    if (!$this->socket) {
      $this->error =  "Could not connect - $errstr ($errno)";
      return FALSE;
    }else{
      stream_set_timeout($this->socket, 1); 
  
      $wrets = $this->Query("Action: Login\r\nUserName: $username\r\nSecret: $password\r\nEvents: off\r\n\r\n"); 

     	if (strpos($wrets, "Message: Authentication accepted") != FALSE){
        return true;
      }else{
  		  $this->error = "Could not login - Authentication failed";
        fclose($this->socket); 
        $this->socket = FALSE;
  		  return FALSE;
   	  }
    }
  }
  
  function Logout(){
    if ($this->socket){
      fputs($this->socket, "Action: Logoff\r\n\r\n"); 
      while (!feof($this->socket)) { 
        $wrets .= fread($this->socket, 8192); 
      } 
      fclose($this->socket); 
      $this->socket = "FALSE";
    }
  	return; 
  }
  
  function Query($query){
    $wrets = "";
    
    if ($this->socket === FALSE)
      return FALSE;
      
    fputs($this->socket, $query); 
    do
    {
      $line = fgets($this->socket, 4096);
      $wrets .= $line;
      $info = stream_get_meta_data($this->socket);
    }while ($line != "\r\n" && $info['timed_out'] == false );
    return $wrets;
  }
  
  function GetError(){
    return $this->error;
  }
  
  function GetDB($family, $key){
    $value = "";
  
    $wrets = $this->Query("Action: Command\r\nCommand: database get $family $key\r\n\r\n");
  
    if ($wrets){
      $value_start = strpos($wrets, "Value: ") + 7;
      $value_stop = strpos($wrets, "\n", $value_start);
    	if ($value_start > 8){
        $value = substr($wrets, $value_start, $value_stop - $value_start);
      }
  	}
   	return $value;
  }	
  
  function PutDB($family, $key, $value){
    $wrets = $this->Query("Action: Command\r\nCommand: database put $family $key $value\r\n\r\n");
  
  	if (strpos($wrets, "Updated database successfully") != FALSE){
  		return TRUE;
   	}
    $this->error =  "Could not updated database";
   	return FALSE;
  }	
  
  function DelDB($family, $key){
    $wrets = $this->Query("Action: Command\r\nCommand: database del $family $key\r\n\r\n");

  	if (strpos($wrets, "Database entry removed.") != FALSE){
  		return TRUE;
   	}
    $this->error =  "Database entry does not exist";
   	return FALSE;
  }	
  
  
  function GetFamilyDB($family){
    $wrets = $this->Query("Action: Command\r\nCommand: database show $family\r\n\r\n");
    if ($wrets){
      $value_start = strpos($wrets, "Response: Follows\r\n") + 19;
      $value_stop = strpos($wrets, "--END COMMAND--\r\n", $value_start);
    	if ($value_start > 18){
        $wrets = substr($wrets, $value_start, $value_stop - $value_start);
      }
      $lines = explode("\n", $wrets);
      foreach($lines as $line){
        if (strlen($line) > 4){
          $value_start = strpos($line, ": ") + 2;
          $value_stop = strpos($line, " ", $value_start);
        	$key = trim(substr($line, strlen($family) + 2, strpos($line, " ") - strlen($family) + 2));			
          $value[$key] = trim(substr($line, $value_start));
        }
      }
   	  return $value;
  	}
    return FALSE;
  }	  
}

$astman = new AstMan;
$astman->login();
// extract the Caller ID if present and call number
// if call number is old exit
$callernr = 'NA';
 //get the caller id name already set for this call using the PHP Asterisk Manager
 //first get a list of the active channels and return the first one that has a caller id value set.
 $value = $astman->Query("Action: Command\r\nCommand: core show channels concise\r\n\r\n");
 $chan_array = preg_split("/\n/",$value);
 
 foreach($chan_array as $val)
 {
  $this_chan_array = explode("!",$val);
  if(isset($this_chan_array[7]))
  {
    $value = $astman->Query("Action: Command\r\nCommand: core show channel $this_chan_array[0]\r\n\r\n");
    $this_array = preg_split("/\n/",$value);
    foreach($this_array as $val2)
    {
     //var_dump($val2);
     if(strpos($val2,'Caller ID Name: ') !== false)
     {
      $callerid = trim(str_replace('Caller ID Name: ','',$val2));
     }

     //      Caller ID: +31650423994
     if(strpos($val2,'Caller ID:') !== false)
     {
      $callernr = trim(str_replace('      Caller ID: ','',$val2));
     }
     // End CallerID

     if(strpos($val2,'Connected Line ID: ') !== false)
     {
      $rcvextn = trim(str_replace('Connected Line ID: ','',$val2));
      /*if ($rcvextn == $extn) break;
      else {$rcvextn = ''; $callerid = ''; }*/
     }
     
    }

    //break out if the value is set.
    if($callerid != '')
    {
     break;
    }
  }
 }
// build url with caller id
echo str_replace("+31", '0', $callernr);
?>