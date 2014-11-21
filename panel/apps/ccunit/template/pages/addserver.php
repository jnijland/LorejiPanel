        <div class="container-fluid">
			

			<!-- Page Heading -->
			<div class="row">
			    <div class="col-lg-12">
			        <h1 class="page-header">
			            CC-Unit Server <small>Add servers</small>
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

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<h3 class="panel-title">Add Server</h3>
    				</div>
    				<div class="panel-body">
    				<?php if(!empty(Request::post('servernick'))){ Servers::add_server(Request::post()); } ?>
					<form autocomplete="off" action="<?php URL::site('/apps/ccunit/index.php?page=addserver');?>" role="form" method="post">
					<input type="hidden" name="page" value="addserver" />
                        <div class="form-group">
                            <label>Server Nickname:</label>
                            <input class="form-control" autocomplete="off" placeholder="Server Nickname"  name="servernick">
                            <p class="help-block">E.g. LOREJI-BLADE-1 or Server-1</p>
                        </div>
                        <div class="form-group">
                            <label>Server Key:</label>
                            <input class="form-control" autocomplete="off" placeholder="Server key"  name="serverkey">
                            <p class="help-block">Server key from: Loreji Panel > Management > Loreji Management > Loreji CC-Unit Key </p>
                        </div>
    				</div>
    				<div class="panel-footer">
    					<button type="submit" class="btn btn-success">Add server</button>
                    </form>
    				</div>
    			</div>
				</div>
			</div>
			<!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->