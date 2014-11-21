<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Domain <small>Manage Domain</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
                <li>
                    <i class="fa fa-users"></i> Users
                </li>
                <li class="">
                    <i class="fa fa-user"></i> User Details
                </li>
                <li class="active">
                    <i class="fa fa-globe"></i> Domain
                </li>
            </ol>

        </div>
    </div>
    <!-- /.row -->

      <!-- Page Heading -->
      <div class="row">
            <?php
            if(isset($_POST) AND !empty($_POST))
            {
              Users::save_domain($_POST, $_GET['serverid'], $_GET['domainid']);
            }

            $domain = Users::get_domain($_GET['domainid'], $_GET['serverid']);
            ?>
            <!-- Domain Information -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 id="domains" name="domains" class="panel-title">Domain details</h3>
                    </div>

                    <form action="" method="post">
                    <div class="panel-body">
                        <div class="scrollable-table">
                          <table class="table">
                              <tr>
                                <th class="row-header">Domain</th>
                                <td><input type="text" name="domain" value="<?php echo $domain['vh_domain_vc']; ?>" class="form-control" /></td>
                              </tr>

                              <tr>
                                <th class="row-header">Directory</th>
                                <td><input type="text" name="directory" value="<?php echo $domain['vh_path_vc']; ?>" class="form-control" /></td>
                              </tr>

                              <tr>
                                <th class="row-header">Type</th>
                                <td>
                                  <select name="type" class="form-control">
                                    <?php $types = array('1' => 'Domain', '2' => 'Subdomain');
                                    foreach ($types as $key => $value) {
                                      echo "<option value=\"".$key."\" ".(($key == $domain['vh_type_en'])? 'selected' : '').">".$value."</option>";
                                    }
                                    ?>
                                  </select>
                                </td>
                              </tr>

                              <tr>
                                <th class="row-header">SSL</th>
                                <td>
                                  <select name="ssl" class="form-control">
                                    <?php

                                    $ssls = Users::get_all_user_ssl($domain['au_id_in'], $_GET['serverid']);
                                    echo "<option value=\"0\" ".((0 == $domain['vh_usessl_in'])? 'selected' : '').">None</option>";
                                    foreach ($ssls as $key => $value) {
                                       echo "<option value=\"".$value['sc_id_in']."\" ".(($value['sc_id_in'] == $domain['vh_usessl_in'])? 'selected' : '').">".$value['sc_nick_vc']."</option>";
                                    }
                                    ?>
                                  </select>
                                </td>
                              </tr>
                              
                              <tr>
                                <th class="row-header">Suhosin Enabled</th>
                                <td><input type="checkbox" name="suhosinenable" value="1" <?php echo (($domain['vh_suhosinenable_en'] == 1)? 'checked': '');?>></td>
                              </tr>

                              <tr>
                                <th class="row-header">Suhosin</th>
                                <td><textarea name="suhosin" class="form-control"><?php echo $domain['vh_suhosin_vc']; ?></textarea></td>
                              </tr>

                              <tr>
                                <th class="row-header">Open Basedir Enabled</th>
                                <td><input type="checkbox" name="openbasedirenable" value="1" <?php echo (($domain['vh_openbasedirenable_en'] == 1)? 'checked': '');?>></td>
                              </tr>

                              <tr>
                                <th class="row-header">Open Basedir</th>
                                <td><textarea name="openbasedir" class="form-control"><?php echo $domain['vh_openbasedir_vc']; ?></textarea></td>
                              </tr>

                              <tr>
                                <th class="row-header">Custom directory settings</th>
                                <td><textarea name="customdirectory" class="form-control"><?php echo $domain['vh_direntries_lt']; ?></textarea></td>
                              </tr>

                              <tr>
                                <th class="row-header">Custom vhost settings</th>
                                <td><textarea name="customvhostsetting" class="form-control"><?php echo $domain['vh_overrule_lt']; ?></textarea></td>
                              </tr>

                          </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                      <button class="btn btn-success">Save</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- /Domain Information -->
        
      </div>
      <!-- /.row -->
       

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->