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
  <?php $looker = Request::post('panel_domain');  echo (isset($looker)) ? Template::alert(Language::get('managment.alert.settingsaved')) : ''; ?>

  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
       <div class="panel-btns">
        <a href="" class="panel-close">&times;</a>
        <a href="" class="minimize">&minus;</a>
      </div>
      <h4 class="panel-title">Loreji Settings</h4>
    </div>
    <div class="panel-body panel-body-nopadding">

      <form class="form-horizontal form-bordered" method="POST">
        <?php
        //var_dump($fields);
        foreach ($fields as $key => $value) {


          //print_r($value); 

          echo '<div class="form-group">
          <label class="col-sm-3 control-label">'.Language::get($value['se_key_vc']).': <span class="asterisk">*</span></label>
          <div class="col-sm-6">';

            if($value['se_type_vc'] === 'input')
            {
              echo "<input type='text' class='form-control' name='".$value['se_key_vc']."' value='".$value['se_value_vc']."' /> ";
            }
            if($value['se_type_vc'] === 'input-disabled')
            {
              echo "<input type='text' class='form-control' readonly name='".$value['se_key_vc']."' value='".$value['se_value_vc']."' /> ";
            }
            if($value['se_type_vc'] === 'toggle')
            {
              echo "<div class='toggle toggle-success' id='".$value['se_key_vc']."'></div>
              <input type='hidden' name='".$value['se_key_vc']."' id='hiddentoggle".$value['se_key_vc']."' value='' />";

            }
            echo '</div>
          </div>';



          if($value['se_key_vc'] === 'use_panel_ssl'){
            $sslquery = Controller::db()->prepare('SELECT * FROM ssl_cert');
            $sslquery -> execute();
            $ssls = $sslquery->fetchAll();
            echo '<div class="form-group" style="display:'.(($value['se_value_vc'] === 'true' OR $value['se_value_vc'] === '1' OR (int)$value['se_value_vc'] > 0)? 'block':'none').'" id="extrasettings'.$value['se_key_vc'].'">
            <label class="col-sm-3 control-label">'.Language::get('domain.form.ssl.choose').' <span class="asterisk">*</span></label>
            <div class="col-sm-6">
              <select class="form-control mb6" name="ssl_setting">
                ';

                foreach ($ssls as $ssl) {
                  echo '<option value="'.$ssl['sc_id_in'].'" '.($value['se_value_vc'] == $ssl['sc_id_in']? 'selected' : '').'>'.$ssl['sc_nick_vc'].'</option>';
                }

                echo'
              </select>
            </div>
          </div>';

          echo '<div class="form-group" style="display:'.(($value['se_value_vc'] === 'true' OR $value['se_value_vc'] === '1' OR (int)$value['se_value_vc'] > 0)? 'block':'none').'" id="forcessl">
          <label class="col-sm-3 control-label">'.Language::get('ssl.enforce.enabled').' <span class="asterisk">*</span></label>
          <div class="col-sm-6">
            <div class="toggle toggle-success" id="tglforcessl"></div>
            <input type="hidden" name="force_ssl" id="forcesslhidden" value="" />
          </div>
        </div>';

      }

      ?>
      <script type="text/javascript">
        $(document).ready( function(){

              // Variable toggles
              $('#hiddentoggle<?php echo $value['se_key_vc'];?>').val('<?php echo ($value['se_value_vc'] === 'true' OR $value['se_value_vc'] === '1' OR (int)$value['se_value_vc'] > 0)? 'true':'false';  ?>');
              $('#<?php echo $value['se_key_vc']?>').toggles({
                on: <?php echo ($value['se_value_vc'] === 'true' OR $value['se_value_vc'] === '1' OR (int)$value['se_value_vc'] > 0)? 'true':'false';  ?>
              });
              $('#<?php echo $value['se_key_vc']?>').on('toggle', function (e, active) {
                if (active) {
                // Verborgen element naar 'on' zetten
                $('#hiddentoggle<?php echo $value['se_key_vc']?>').val('true');
                $('#extrasettings<?php echo $value['se_key_vc']?>').slideDown(1000, 'easeInSine');
                <?php if($value['se_key_vc'] === 'use_panel_ssl'){ ?>
                $('#forcessl').slideDown(1000, 'easeInSine');
                <?php } ?>

              } else {
                // Verborgen element naar 'off' zetten
                $('#hiddentoggle<?php echo $value['se_key_vc']?>').val('false');
                $('#extrasettings<?php echo $value['se_key_vc']?>').slideUp(1000, 'easeInSine');
                <?php if($value['se_key_vc'] === 'use_panel_ssl'){ ?>
                $('#forcessl').slideUp(1000, 'easeInSine');
                <?php } ?>
              }

            });

              <?php if($value['se_key_vc'] === 'use_panel_ssl'){ ?>
              // Static Force SSL toggle
              $('#tglforcessl').toggles({
                on: <?php echo Settings::get('force_ssl'); ?>
              });
              $('#forcesslhidden').val('<?php echo Settings::get('force_ssl'); ?>');
              $('#tglforcessl').on('toggle', function (e, active) {
                if (active) {
                // Verborgen element naar 'on' zetten
                $('#forcesslhidden').val('true');
              } else {
                // Verborgen element naar 'off' zetten
                $('#forcesslhidden').val('false');
              }

            });
              <?php } ?>


            });
</script>
<?php
}

$loreji_ccunit_key = array(
  "ip" => System::Remote_ip(),
  "username" => MYSQL_USER,
  "password" => MYSQL_PASS,
  "key" => SEASALT
);
?>
<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo Language::get('ccunit.key'); ?></label>
  <div class="col-sm-6">
    <input type='text' class='form-control' name='loreji_ccunit_key' disabled="" value='<?php echo base64_encode(json_encode($loreji_ccunit_key));?>' />
    <p class="help-block"><?php echo Language::get('ccunit.key.about'); ?></p>
  </div>
</div>
</div>
<div class="panel-footer">
  <div class="row">
    <div class="col-sm-9 col-sm-offset-3">
      <button class="btn btn-primary pull-right"><?php echo Language::get('global.btn.save'); ?></button>
    </div>
  </div>
</div>
</form>
</div>

</div> <!-- row -->
<!-- contentpanel -->

</div>
<!-- mainpanel -->


<script type="text/javascript">
  $(document).ready( function(){

    setTimeout( function() {     
      $('.toggle-off').html('<?php echo strtoupper(Language::get("global.off")); ?>');
      $('.toggle-on').html('<?php echo strtoupper(Language::get("global.on")); ?>'); 
    }, 50);

  });
</script>