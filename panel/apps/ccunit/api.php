<?php
// Page not needed anymore
unset($_GET['page']);
try {
	$get = Request::get();
} catch (Exception $e) {
	
}


try {
	$post = Request::post();
} catch (Exception $e) {
	
}

if($_GET['action'] == 'ccunit_edit_user')
{
	echo '
	<form id="formuserdata" name="formuserdata" action="" method="POST">
		<div class="scrollable-table">
	  <table class="table">
	      <tr>
	        <th class="row-header">Full name</th>
	        <td><input type="text" name="fullname" autocomplete="off" class="form-control col-lg-2" value="'.$post->fullname.'" /></td>
	      </tr>
	      <tr>
	        <th class="row-header">Streetname</th>
	        <td><input type="text" name="streetname" autocomplete="off" class="form-control" style="width: 323px; display:inline-block;" value="'.$post->streetname.'" /> <input autocomplete="off" type="text" name="housenumber" class="form-control" style="width: 310px;  display:inline-block;" value="'.$post->housenumber.'" /></td>
	      </tr>
	      <tr>
	        <th class="row-header">Zipcode</th>
	        <td><input type="text" autocomplete="off" name="zipcode" value="'.$post->zipcode.'" class="form-control" style="width: 323px; display:inline-block;" /> <input type="text" autocomplete="off" name="city" value="'.$post->city.'" class="form-control" style="width: 310px;  display:inline-block;"/></td>
	      </tr>
	      <tr>
	        <th class="row-header">Phone</th>
	        <td><input type="text" autocomplete="off" name="phonenumber" value="'.$post->phone.'" class="form-control" /></td>
	      </tr>
	      <tr>
	        <th class="row-header">E-Mail</th>
	        <td><input type="text" autocomplete="off" name="email" value="'.$post->email.'" class="form-control" /></td>
	      </tr>
	      <tr>
	        <th class="row-header">Customer Code</th>
	        <td><input type="text" autocomplete="off" disabled value="'.$post->customercode.'" class="form-control" /></td>
	      </tr>
	      <tr>
	        <th class="row-header">Server</th>
	        <td><input type="text" autocomplete="off" disabled value="'.$post->server.'" class="form-control" /></td>
	      </tr>
	      <tr>
	        <th class="row-header">Status</th>
	        <td><select name="status" class="form-control">
			<option '.((strtolower(strip_tags($post->status)) == 'active')? 'selected' : '').' value="NULL">Activate</option>
			<option '.((strtolower(strip_tags($post->status)) != 'active')? 'selected' : '').' value="'.time().'">Deactivate</option>
	        </select></td>
	      </tr>
	      <tr>
	        <th class="row-header">Language</th>
	        <td><input type="text" autocomplete="off" name="language" value="'.$post->language.'" class="form-control" /></td>
	        <input type="hidden" name="action" value="saveuserdetailform" />
	      </tr>
	  </table>
	</div>
	</form>
    ';
}

if($_GET['action'] == 'daemon')
{	
	set_time_limit(0);
	echo 'Running Daemon on : '.$_GET['url'].' - '.date('d-m-Y H:i:s').'<br />';
	file_get_contents($_GET['url']);
	echo 'Daemon stop: '.$_GET['url'].' - '.date('d-m-Y H:i:s').'<br />';
}

?>