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
		                <i class="fa fa-align-justify"></i> Server
		            </li>
		            <li class="active">
		                <i class="fa fa-align-justify"></i> Edit Server
		            </li>
		        </ol>
		    </div>
		</div>
		<!-- /.row -->

    	<!-- Page Heading -->
    	<div class="row">
			<?php 
			$serverid = Request::get('serverid');

			if(Request::method() === "POST")
			{
				$serverid = Servers::edit_server();
			}

			//var_dump(Request::get());
			$query = CCunit::maindb()->prepare("SELECT * FROM ccunit_servers WHERE cs_id_in=:serverid");
			$query->bindParam(':serverid', $serverid);
			$query->execute();
			//var_dump($query);
			$serverinfo = $query->fetch(PDO::FETCH_ASSOC);
			//var_dump($serverinfo);
			?>
    		<!-- Userinfo -->
    		<div class="col-lg-12">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<h3 class="panel-title">User details</h3>
    				</div>
    				<div class="panel-body">
    					<form class="form-horizontal" method="POST">
    					<input type="hidden" name="serverid" value="<?php echo $serverid; ?>">
    					<input type="hidden" name="page" value="serveredit">
    					<fieldset>

    					<!-- Text input-->
    					<div class="control-group">
    					  <label class="control-label" for="textinput">Text Input</label>
    					  <div class="controls">
    					    <input id="textinput" name="cs_nickname_vc" type="text" value="<?php echo $serverinfo['cs_nickname_vc']; ?>" placeholder="placeholder" class="form-control input-xlarge">
    					    <p class="help-block">Servername like: LOR-WEB-01</p>
    					  </div>
    					</div>

    				</div>
    				<div class="panel-footer">
    					<!-- Button -->
    					<div class="control-group">
    					  <div class="controls">
    					    <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
    					  </div>
    					</div>

    					</fieldset>
    					</form>
    				</div>
    			</div>
    		</div>
    		<!-- /Userinfo -->
    		
    	</div>
    	<!-- /.row -->
       

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->