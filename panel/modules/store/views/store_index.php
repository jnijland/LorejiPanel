  <div class="pageheader">
    <h2><i class="fa fa-shopping-cart"></i> <?php echo Language::get('store.header.title'); ?> <span><?php echo Language::get('store.header.desc'); ?></span></h2>
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo Language::get('global.entry.youarehere'); /* Pre-set global variable */ ?>:</span>
      <ol class="breadcrumb">
        <li><a href="/home/index">Loreji</a></li>
        <li class="active"><?php echo Language::get('store.header.title'); ?></li>
      </ol>
    </div>
  </div>

  <div class="contentpanel">
  
<?php
// Check if the method was executed!
$cookie = Cookie::get('remove'); Cookie::destroy('remove');
if(isset($cookie)){
  echo Template::alert('The module was deleted from your Loreji installation!');
}
?>

<?php
// Check if the method was executed!
$cookie = Cookie::get('upgrade'); Cookie::destroy('upgrade');
if(isset($cookie) && $cookie === 'true'){
  echo Template::alert('The module is upgraded to the latest version!');
}
?>

<?php
// Check if the method was executed!
$cookie = Cookie::get('remove'); Cookie::destroy('remove');
if(isset($cookie) && $cookie === 'false'){
  echo Template::alert('Failed to upgrade the module. Try again within a couple of minutes!', 'danger');
}
?>

<div class="debugWarning">
  <div class="row">
    <div class="col-md-2 col-md-offset-3">
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo Language::get('store.debug.warning'); ?>
      </div>
    </div>
  </div>
</div>

<!-- ################################### -->
<?php
$lang = Settings::get('loreji_system_lang');
foreach (Store::load_inner_repos_to_array() as $repo) {

  foreach ($repo as  $module) {
    $module = (array) $module;




  foreach ($GLOBALS['modules'] as $installed_module) {
    if(strtolower($installed_module->name) != strtolower($module['name']))
    { continue; } else { break; }
  }

  $module['desc'] = json_decode($module['desc'], true);

  $permission_list = '';
  $module['permissions'] = json_decode($module['permissions'], true);
  foreach ($module['permissions'] as $permission) {
    $permission_list .= '<li class="fa fa-long-arrow-right"><div class="permtext">'.Module::Permission_database($permission).'</div></li><br />';
  }

  $permission_list = base64_encode($permission_list);
  // Version check!
  echo "<!-- ", print_r($module['version'] .'!=='. $installed_module->version) , " -->";
  $button['update'] = ($module['version'] !== $installed_module->version && strtolower($installed_module->name) == strtolower($module['name'])) ? '<button class="btn btn-warning pull-right PopupLinkUpdate" data-url="/store/{{action}}/{{id}}" data-name="'.$module['name'].'" data-action="update" data-permlist="'.$permission_list.'" data-id="'.strtolower($module['name']).'" >'.Language::get('store.btn.update').'</button>' : '' ;

  // Installation check
  $button['install'] = (strtolower($installed_module->name) != strtolower($module['name'])) ? '<button class="btn btn-success pull-left PopupLinkInstall" data-url="/store/{{action}}/{{id}}" data-name="'.$module['name'].'" data-action="install" data-permlist="'.$permission_list.'" data-id="'.strtolower($module['name']).'">'.Language::get('store.btn.install').'</button>' : '<button class="btn btn-danger pull-left removePopupLink" data-url="/store/{{action}}/{{id}}" '.((in_array(strtolower($module['name']), Store::$unrm_mods))? 'disabled' : '').' data-permlist="" data-name="'.$module['name'].'" data-action="remove" data-id="'.strtolower($module['name']).'">'.Language::get('store.btn.remove').'</button>';
  
  // Last show/hide checks
  // 
  // I agree, looks a bit weird, but i dont know how to catch this :(!
  // 
  //var_dump($button['update'] != '' && $module['visible'] == '0' && $module['visible_on_update'] == '1');
  if($button['update'] != '' && $module['visible'] == '0' && $module['visible_on_update'] == '1')
  {
    // Show this mafackr
  } 
  elseif($module['visible'] == '0')
  {
    continue;
  }

?>
<div class="col-md-4">
  <div class="panel panel-default">

    <div class="panel-heading">
      <h4 class="panel-title"><?php echo $module['name']; ?> </h4>
      <span class="sub pull-right" style="margin-top: 1px; margin-right: -15px; font-size: 9px;"><?php echo Language::get('store.label.by'); ?>: <a href="<?php echo $module['author']['url']; ?>" target="_NEW"><?php echo $module['author']['name']; ?></a></span>
    </div><!-- panel-heading -->

    <div class="panel-body-store">
    <?php echo nl2br((isset($module['desc'][$lang])) ? $module['desc'][$lang] : $module['desc']['EN']); ?>
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

    $('.permissionheader').live('click', function(event) {
      event.preventDefault();
      if($('.permissionheader').text().trim() == '<?php echo Language::get('global.permission.title.view'); ?>:'){
        $('.permissionheader').html('<a><?php echo Language::get('global.permission.title.hide'); ?>:</a>');
        $('.permissionlist').show('fast');
      } else {
        $('.permissionheader').html('<a><?php echo Language::get('global.permission.title.view'); ?>:</a>');
        $('.permissionlist').hide('fast');
      }
    });

    var count = 0;
    $('.pageheader').on('dblclick', function(event) {
      event.preventDefault();
      count++;
      console.log(count);
      if(count == 1){
        console.log('clicked_page_header()->DEBUG_ON;');
        $('*').prop("disabled", false);
        $('.debugWarning').slideDown('fast');
        count = 0;
      }
    });

  });
  </script>