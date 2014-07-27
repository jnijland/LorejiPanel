  <div class="pageheader">
    <h2><i class="fa fa-shopping-cart"></i> Store <span>Shop till you drop....</span></h2>
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo Language::get('global.entry.youarehere'); /* Pre-set global variable */ ?>:</span>
      <ol class="breadcrumb">
        <li><a href="/home/index">Loreji</a></li>
        <li class="active">Store</li>
      </ol>
    </div>
  </div>

  <div class="contentpanel">

<!-- ################################### -->
<?php
$lang = Settings::get('loreji_system_lang');
foreach (Store::load_inner_repos_to_array() as $repo) {
  foreach ($repo as  $module) {

  foreach ($GLOBALS['modules'] as $installed_module) {
    if(strtolower($installed_module->name) != strtolower($module['name']))
    { continue; } else { break; }
  }

  $permission_list = '';
  foreach ($module['permissions'] as $permission) {
    $permission_list .= '<li class="fa fa-long-arrow-right"><div class="permtext">'.Module::Permission_database($permission).'</div></li><br />';
  }

  $permission_list = base64_encode($permission_list);
  // Version check!
  $button['update'] = ($module['version'] !== $installed_module->version) ? '<button class="btn btn-warning pull-right PopupLinkUpdate" data-name="'.$module['name'].'" data-permlist="'.$permission_list.'" data-id="'.strtolower($module['name']).'">Update</button>' : '' ;

  // Version check!
  $button['install'] = (strtolower($installed_module->name) != strtolower($module['name'])) ? '<button class="btn btn-success pull-left PopupLinkInstall" data-name="'.$module['name'].'" data-permlist="'.$permission_list.'" data-id="'.strtolower($module['name']).'"> Install</button>' : '<button class="btn btn-danger pull-left removePopupLink" data-name="'.$module['name'].'" data-id="'.strtolower($module['name']).'">Remove</button>';

?>
<div class="col-md-4">
  <div class="panel panel-default">

    <div class="panel-heading">
      <h4 class="panel-title"><?php echo $module['name']; ?> </h4>
    </div><!-- panel-heading -->

    <div class="panel-body" data-url="/domain/remove/{{id}}">
    <?php echo (isset($module['desc'][$lang])) ? $module['desc'][$lang] : $module['desc']['EN']; ?>
    </div><!-- panel-body -->

    <div class="panel-footer">
      <div class="row">
        <div class="col-sm-12">
          <?php echo $button['install']; ?>
          <?php echo $button['update']; ?>
        </div> <!--col-sm-9 col-sm-offset-3 -->
      </div> <!-- row -->
    </div> <!-- panel-footer -->

  </div><!-- panel -->
</div><!-- col-md-6 -->
<?php
  }
}
//var_dump($GLOBALS['modules']);
?>
<!-- ################################### -->

  </div><!-- controlpanel -->

  </div><!-- mainpanel -->

  <script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#permissionClick').on('click', "#permissionClick", function() { alert("Hay!"); });
  });
  </script