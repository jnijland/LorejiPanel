        <div class="container-fluid">

			<!-- Page Heading -->
			<div class="row">
			    <div class="col-lg-12">
			        <h1 class="page-header">
			            CC-Unit Server <small>Servers Overview</small>
			        </h1>
			        <ol class="breadcrumb">
			            <li>
			                <i class="fa fa-dashboard"></i> Dashboard
			            </li>
			            <li class="active">
			                <i class="fa fa-align-justify"></i> Servers
			            </li>
			        </ol>
			    </div>
			</div>
			<!-- /.row -->

            <?php
            $serverid = Request::get('remove'); 
            if(!empty($serverid))
            {
                Servers::remove_server($serverid);
            }
            ?>

        	<!-- Page Heading -->
        	<div class="row">
        		<div class="col-lg-12">
        			<div class="panel panel-default">
                       <div class="panel-heading">
                           <h3 class="panel-title">Servers</h3>
                       </div>
                    <div class="panel-body" data-url="<?php echo URL::site('/apps/ccunit/index.php?page=serverlist&remove={{id}}'); ?>">
        			<div class="table-responsive">
        				<table class="table table-bordered table-hover table-striped">
        					<thead>
        						<tr>
        							<th>IP</th>
        							<th>Nickname</th>
        							<th>Status</th>
        							<th>Actions</th>
        						</tr>
        					</thead>
        					<tbody>
        					<?php echo Servers::list_servers(); ?>
        					</tbody>
        				</table>
        			</div>
                    </div>
                    <div class="panel-footer">
                    <a href="<?php echo URL::site('/apps/ccunit/index.php?page=addserver'); ?>"><button class="btn btn-success">Add Server</button></a>
                    </div>
        		</div>
        	</div>
        	<!-- /.row -->

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('.btn-href').click(function(){
                      var serverid = $(this).data('serverid');
                      window.location.href= "<?php echo URL::site('/apps/ccunit/index.php?page=serveredit'); ?>&serverid=" + serverid;
                   });
                });
            </script>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->