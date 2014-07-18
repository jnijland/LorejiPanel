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

  // Version check!
  $button['update'] = ($module['version'] !== $installed_module->version) ? '<button class="btn btn-warning pull-right">Update</button>' : '' ;

  // Version check!
  $button['install'] = (strtolower($installed_module->name) != strtolower($module['name'])) ? '<button class="btn btn-success pull-left">Install</button>' : '<button class="btn btn-danger pull-left">Remove</button>';

?>
<div class="col-md-4">
  <div class="panel panel-default">

    <div class="panel-heading">
      <h4 class="panel-title"><?php echo $module['name']; ?> </h4>
    </div><!-- panel-heading -->

    <div class="panel-body">
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
var_dump($GLOBALS['modules']);
?>
<!-- ################################### -->

  </div><!-- controlpanel -->

  </div><!-- mainpanel -->