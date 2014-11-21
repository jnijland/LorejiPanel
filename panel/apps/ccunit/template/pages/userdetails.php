<div class="container-fluid">
		
		<!-- Page Heading -->
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">
		            CC-Unit Users <small>Users Overview</small>
		        </h1>
		        <ol class="breadcrumb">
		            <li>
		                <i class="fa fa-dashboard"></i> Dashboard
		            </li>
		            <li>
		                <i class="fa fa-users"></i> Users
		            </li>
		            <li class="active">
		                <i class="fa fa-user"></i> User Details
		            </li>
		        </ol>

                <ol class="breadcrumb pull-right">
                    <li>
                        <a href="#domains" class="btn btn-info btn-header" style="margin-top: 0px;">Domains</a>
                    </li>
                    <li>
                        <a href="#ftps" class="btn btn-info btn-header"  style="margin-top: 0px;">FTP</a>
                    </li>
                </ol>

		    </div>
		</div>
		<!-- /.row -->

		<?php 
        //var_dump(Request::post());
        if(isset($_POST['action']) && $_POST['action'] == "saveuserdetailform")
        {
            $save_form = Users::save_user_information($_GET['userid'], $_GET['serverid'], Request::post());
        }

		$loreji_details = Users::get_userinfo_and_lorejipackage($_GET['userid'], $_GET['serverid']);
		$vhost_usages = Users::get_latest_vhost_usage($_GET['userid'], $_GET['serverid']);
        $vhosts = Users::get_domains($_GET['userid'], $_GET['serverid']);
        $ftpusers = Users::get_ftp_users($_GET['userid'], $_GET['serverid']);
        $server = Ccunit::query_server($_GET['serverid']);
        $all_domain_vhost = Users::get_all_domain_usage($_GET['userid'],$_GET['serverid']);
		//var_dump($loreji_details);
		//var_dump($vhost_usages);
        //var_dump($vhosts);
        //var_dump($ftpusers);


        // Make  Shadow URL
        $query = $server->prepare("SELECT * FROM loreji_core.settings WHERE loreji_core.settings.se_key_vc='panel_domain'");
        $query->execute();
        $settings = $query->fetch(PDO::FETCH_ASSOC);
        $domain = $settings['se_value_vc'];

        $url = 'http://'.$domain.'/auth/shadow/'.$loreji_details['au_email_vc'].'/'.str_replace('/', '-RPRIGSLASH-', $loreji_details['au_password_vc']);
		?>

    	<!-- Page Heading -->
    	<div class="row">

    		<!-- Userinfo -->
    		<div class="col-lg-6">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<h3 class="panel-title">User details <div class="pull-right">
                        <a href="<?php echo $url; ?>" target="_NEW" class="btn btn-info btn-header">Shadow</a>
                        &nbsp;
                        <button class="btn btn-warning btn-header" id="edituserdetails">Edit</button>
                        <button class="btn btn-success btn-header" style="display:none;" onclick="$('#formuserdata').submit();" id="saveuserdetails">Save</button>
                        </div></h3>
    				</div>
    				<div class="panel-body" id="userdetailsbody">
    					<div class="scrollable-table">
    					  <table class="table">
    					      <tr>
    					        <th class="row-header">Full name</th>
    					        <td id="formfullname"><?php echo $loreji_details['au_fullname_vc']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Streetname</th>
    					        <td><span id="formstreetname"><?php echo $loreji_details['au_streetname_vc']; ?></span> <span id="formhousenumber"><?php echo $loreji_details['au_housenumber_in']; ?></span></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Zipcode</th>
    					        <td><span id="formzipcode"><?php echo $loreji_details['au_zipcode_vc']; ?></span> <span id="formcity"><?php echo $loreji_details['au_city_vc']; ?></span></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Phone</th>
    					        <td id="formphonenumber"><?php echo $loreji_details['au_phonenumber_vc']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">E-Mail</th>
    					        <td id="formemail"><?php echo $loreji_details['au_email_vc']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Customer Code</th>
    					        <td id="formcustomercode"><?php echo $loreji_details['au_customercode_vc']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Server</th>
    					        <td id="formserver"><?php echo CCunit::server_info_from_id($_GET['serverid'])['cs_nickname_vc']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Status</th>
    					        <td id="formstatus"><?php echo ($loreji_details['au_deleted_ts'] == NULL || $loreji_details['au_deleted_ts'] == 0)? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Deactivated</span>'; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Language</th>
    					        <td id="formlanguage"><?php echo $loreji_details['au_language_vc']; ?></td>
    					      </tr>
    					  </table>
    					</div>
    				</div>
    			</div>
    		</div>
    		<!-- /Userinfo -->

    		<!-- Packageinfo -->
    		<div class="col-lg-6">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<h3 name="hosting" class="panel-title">Hosting details 
                            <div class="pull-right">
                                <button title="Edit hosting package" class="btn btn-warning btn-header">Edit</button>
                                <!-- <button title="Run daemon" class="btn btn-warning btn-header popup" data-href="<?php echo URL::site('apps/ccunit/index.php?page=api&action=daemon&url='.urlencode('http://'.Ccunit::loreji_settings($_GET['serverid'], 'panel_domain')).'/api/daemon'); ?>">Run Daemon</button> -->
                                <!-- Not sure if im going to use this.... -->
                            </div>
                        </h3>
    				</div>
    				<div class="panel-body">
    					<div class="scrollable-table">
    					  <table class="table">
    					      <tr>
    					        <th class="row-header">Package Name</th>
    					        <td><?php echo $loreji_details['pk_name_vc']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Bandwidth</th>
    					        <td><?php echo Daemon::Format_bytes($all_domain_vhost['band']); ?> / <?php echo Daemon::Format_bytes($loreji_details['pk_maxbandwidth_in']); ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Diskspace</th>
    					        <td><?php echo Daemon::Format_bytes($all_domain_vhost['disk']); ?> / <?php echo Daemon::Format_bytes($loreji_details['pk_maxdiskspace_in']); ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Domains</th>
    					        <td><?php echo (($vhost_usages['vu_domain_in'] == null)? '0' : $vhost_usages['vu_domain_in']); ?> / <?php echo $loreji_details['pk_domain_in']; ?> </td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Subdomains</th>
    					        <td><?php echo (($vhost_usages['vu_subdomain_in'] == null)? '0' : $vhost_usages['vu_subdomain_in']); ?> / <?php echo $loreji_details['pk_subdomain_in']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Databases</th>
    					        <td><?php echo (($vhost_usages['vu_database_in'] == null)? '0' : $vhost_usages['vu_database_in']); ?> / <?php echo $loreji_details['pk_database_in']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Mailboxes</th>
    					        <td><?php echo (($vhost_usages['vu_mailbox_in'] == null)? '0' : $vhost_usages['vu_database_in']); ?> / <?php echo $loreji_details['pk_mailbox_in']; ?> </td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">Distribution lists</th>
    					        <td><?php echo (($vhost_usages['vu_distlist_in'] == null)? '0' : $vhost_usages['vu_database_in']); ?> / <?php echo $loreji_details['pk_distlist_in']; ?></td>
    					      </tr>
    					      <tr>
    					        <th class="row-header">FTP Accounts</th>
    					        <td><?php echo (($vhost_usages['vu_ftpacc_in'] == null)? '0' : $vhost_usages['vu_database_in']); ?> / <?php echo $loreji_details['pk_ftpacc_in']; ?></td>
    					      </tr>
    					  </table>
    					</div>
    				</div>
    			</div>
    		</div>
    		<!-- /Packageinfo -->


            <!-- Domain Information -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 id="domains" name="domains" class="panel-title">Domain details</h3>
                    </div>
                    <div class="panel-body" data-url="/apps/ccunit/userdetails/disabledomain/{{id}}">
                        <div class="scrollable-table table-responsive">
                          <table class="table">
                              <thead>
                                    <tr>
                                        <th>Domain Name</th>
                                        <th>Path</th>
                                        <th>Type</th>
                                        <th>Diskspace</th>
                                        <th>Bandwidth</th>
                                        <th>SSL</th>
                                        <th>Suhosin</th>
                                        <th>Open Basedir</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($vhosts as $vhost) {
                                    $vhost_du = Users::get_domain_vhost_usage($vhost['vh_id_in'], $_GET['serverid']);
                                    //var_dump($vhost_du);
                                ?>
                                <tr>
                                    <td><?php echo $vhost['vh_domain_vc']; ?></td>
                                    <td><?php echo $vhost['vh_path_vc']; ?></td>
                                    <td><?php echo (($vhost['vh_type_en'] == 1)? '<span class="label label-info" style="padding: 2px 15px 2px 15px;">Domain</span>' : '<span class="label label-warning">Subdomain</span>'); ?></td>
                                    <td><?php echo Daemon::Format_bytes($vhost_du['vu_domaindiskusage_in']); ?></td>
                                    <td><?php echo Daemon::Format_bytes($vhost_du['vu_bandwidthusage_in']); ?></td>
                                    <td><?php echo (($vhost['vh_usessl_in'] > 0)? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>'); ?></td>
                                    <td><?php echo (($vhost['vh_suhosinenable_en'] == 1)? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>'); ?></td>
                                    <td><?php echo (($vhost['vh_openbasedirenable_en'] == 1)? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>'); ?></td>
                                    <td>
                                        <a class="btn btn-href btn-success" href="/apps/ccunit/index.php?page=domain&serverid=<?php echo $_GET['serverid']; ?>&domainid=<?php echo $vhost['vh_id_in'];  ?>" data-serverid="'.$server['cs_id_in'].'"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-danger removePopupLink" data-name="<?php echo $vhost['vh_domain_vc']; ?>" data-id="<?php echo $vhost['vh_id_in']; ?>"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?> 
                                </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Domain Information -->

            <!-- FTP Users -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 id="ftps" name="ftps" class="panel-title">FTP details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="scrollable-table table-responsive">
                          <table class="table">
                              <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Directory</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($ftpusers as $ftpuser) {
                                ?>
                                <tr>
                                    <td><?php echo $ftpuser['userid']; ?></td>
                                    <td><?php echo $ftpuser['homedir']; ?></td>
                                    <td>
                                        <button class="btn btn-href btn-success" data-serverid="'.$server['cs_id_in'].'"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger removePopupLink" data-name="'.$server['cs_nickname_vc'].'" data-id="'.$server['cs_id_in'].'"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?> 
                                </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /FTP Users -->
    		
    	</div>
    	<!-- /.row -->
       

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->