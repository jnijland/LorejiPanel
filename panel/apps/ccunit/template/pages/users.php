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
		            <li class="active">
		                <i class="fa fa-users"></i> Users
		            </li>
		        </ol>
		    </div>
		</div>
		<!-- /.row -->

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                   <div class="panel-heading">
                       <h3 class="panel-title">Seach Users</h3>
                   </div>
                   <div class="panel-body">
				<form role="form">
				<input type="hidden" name="page" value="users" />
                    <div class="form-group">
                        <label>Seach Users:</label>
                        <input class="form-control" id="innervalue" autocomplete="off" onfocus="this.select();" onmouseup="return false;" placeholder="Seach Query" value="<?php echo Request::get('search');?>" name="search">
                        <p class="help-block">Enter a username, email, postalcode, etc here.</p>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" id="clickable" class="btn btn-success">Search</button>
                    <span class="pull-right" style="margin-top: 7px;"><?php  $usercount = Users::count_all_users(); echo $usercount.' '.Inflector::pluralize('User', $usercount); ?> found.</span>
                </form>
                </div>
                </div>
			</div>
		</div>
		<!-- /.row -->
       <!-- Page Heading -->
       <div class="row">
          <div class="col-lg-12">
             <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Users</h3>
                </div>
                <div class="panel-body">
                <div class="scrollable-table table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Full name</th>
                                <th>Cusomercode</th>
                                <th>Package name</th>
                                <th>Server</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo Users::all_users(Request::get('search')); ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- /.row -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {

                $('button').click(function(){
                  var serverid = $(this).data('serverid');
                  var userid = $(this).data('userid');
                  window.location.href= "<?php echo URL::site('/apps/ccunit/index.php?page=userdetails'); ?>&serverid=" + serverid + "&userid=" + userid;
               });

               /* setInterval(function(){
                  $.get( "/apps/ccunit/plugins/asterisk_searcher.php", function( data ) {
                    if(data == "NA"){
                      
                    } else {
                      if($("#innervalue").val() == "")
                      {
                        $( "#innervalue" ).val( data );
                        window.location.href= "<?php echo URL::site('/apps/ccunit/index.php?page=users'); ?>&search=" + data;
                      } else {
                          var serverid = $( ".CallClikcer" ).attr("data-serverid");
                          var userid = $( ".CallClikcer" ).attr("data-userid");
                          window.location.href= "<?php echo URL::site('/apps/ccunit/index.php?page=userdetails'); ?>&serverid=" + serverid + "&userid=" + userid;
                          console.log("<?php echo URL::site('/apps/ccunit/index.php?page=userdetails'); ?>&serverid=" + serverid + "&userid=" + userid);
                      }
                    }
                  });
                }, 7000);*/

            });
        </script>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->