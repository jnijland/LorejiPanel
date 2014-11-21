 <!-- 
   Please don't juge me on this mess.. It's a hard subject :(
   Todo: FIX
-->
<div class="pageheader">
	<h2> <i class="fa fa-globe"></i>
		<?php echo Language::get('management.header.name'); ?>
		<span><?php echo Language::get('management.header.desc'); ?></span>
	</h2>
	<div class="breadcrumb-wrapper">
		<span class="label"><?php echo Language::get('global.entry.youarehere'); ?>:</span>
		<ol class="breadcrumb">
			<li>
				<a href="/home/index">Loreji</a>
			</li>
			<li class="active"><?php echo Language::get('management.header.name'); ?></li>
		</ol>
	</div>
</div>

<div class="contentpanel">
	<?php 
		$looker = Cookie::get_once('savedok'); 
		echo (isset($looker)) ? Template::alert(Language::get('managment.alert.settingsaved')) : '';
	?>
	
	<div class="row">
	<?php 
	//var_dump($active_modules);
	foreach($active_modules as $module_key => $module_val){ 
		if(!isset($module_val['settings'])){ continue; }

		echo '
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-btns">
						<a href="" class="panel-close">&times;</a>
						<a href="" class="minimize">&minus;</a>
					</div>
					<h4 class="panel-title">Module Settings for '.ucfirst($module_val['name']).'</h4>
				</div>
				<div class="panel-body panel-body-nopadding">
					<form class="form-horizontal form-bordered" name="'.$module_val['name'].'" method="POST">
					<input type="hidden" name="module" value="'.$module_val['name'].'" />';

						foreach ($module_val['settings'] as $key => $value) 
						{
							echo '<div class="form-group">
							<label class="col-sm-3 control-label">'.$key.': <span class="asterisk">*</span></label>
							<div class="col-sm-6">';
								echo '<input type="text" class="form-control" value="'.$value.'" name="'.$key.'"/>';
								echo '</div>
							</div>';
						}

				echo '
				</div>
				<!-- .panel-body -->
				<div class="panel-footer">
				  <div class="row">
				    <div class="col-sm-9 col-sm-offset-3">
				      <button type="submit" class="btn btn-primary pull-right">'.Language::get('global.btn.save').'</button>
				      </form>
				    </div>
				  </div>
				</div>
			</div>';
					}
					?>

		</div> <!-- row -->
		<!-- contentpanel -->

	</div>
	<!-- mainpanel -->
