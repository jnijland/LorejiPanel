<div class="pageheader">
  <h2> <i class="fa fa-sitemap"></i>
    Apache
    <span>Virtual Hosts</span>
  </h2>
  <div class="breadcrumb-wrapper">
    <span class="label">You are here:</span>
    <ol class="breadcrumb">
      <li>
        <a href="/home/index">Loreji</a>
      </li>
      <li>Apache Management</li>
      <li class="active">Virtual Hosts</li>
    </ol>
  </div>
</div>

<div class="contentpanel">

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

      <form class="form-horizontal form-bordered">
        <?php
        $query = Controller::db()->prepare("SELECT * FROM settings WHERE se_visible_en='1'");
        $query->execute();
        $fields = $query->fetchAll(PDO::FETCH_ASSOC);
              //var_dump($fields);
        foreach ($fields as $key => $value) {


          //print_r($value); 

          echo '<div class="form-group">
          <label class="col-sm-3 control-label">'.Language::get($value['se_key_vc']).' <span class="asterisk">*</span></label>
          <div class="col-sm-6">';

            if($value['se_type_vc'] === 'input')
            {
              echo "<input type='text' class='form-control' name='".$value['se_key_vc']."' value=".$value['se_value_vc']." /> ";
            }
            if($value['se_type_vc'] === 'input-disabled')
            {
              echo "<input type='text' class='form-control' readonly name='".$value['se_key_vc']."' value=".$value['se_value_vc']." /> ";
            }
            if($value['se_type_vc'] === 'toggle')
            {
              echo "<div class='toggle toggle-success' id='".$value['se_key_vc']."'></div>
              <input type='hidden' name='usessl' id='hiddentoggle".$value['se_key_vc']."' value='false' />";

            }
            echo '</div>
          </div>';



          if($value['se_key_vc'] === 'use_panel_ssl'){
            $sslquery = Controller::db()->prepare('SELECT * FROM ssl_cert');
            $sslquery -> execute();
            $ssls = $sslquery->fetchAll();
            echo '<div class="form-group" style="display:'.(($value['se_value_vc'] === 'true' OR $value['se_value_vc'] === '1' OR (int)$value['se_value_vc'] > 0)? 'block':'none').'" id="extrasettings'.$value['se_key_vc'].'">
                  <label class="col-sm-3 control-label">'.Language::get('domain.form.ssl.choose').' <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <select class="form-control mb15" name="ssl_setting">
                      ';

                      foreach ($ssls as $ssl) {
                        echo '<option value="'.$ssl['sc_id_in'].'" '.($value['se_value_vc'] == $ssl['sc_id_in']? 'selected' : '').'>'.$ssl['sc_nick_vc'].'</option>';
                      }

                      echo'
                    </select>
                  </div>
                </div>';
          }

          ?>
          <script type="text/javascript">
            $(document).ready( function(){
              $('#<?php echo $value['se_key_vc']?>').toggles({
                on: <?php echo ($value['se_value_vc'] === 'true' OR $value['se_value_vc'] === '1' OR (int)$value['se_value_vc'] > 0)? 'true':'false';  ?>
              });



              $('#<?php echo $value['se_key_vc']?>').on('toggle', function (e, active) {
                if (active) {
                // Verborgen element naar 'on' zetten
                $('#hiddentoggle<?php echo $value['se_key_vc']?>').val('true', 'linear');
                $('#extrasettings<?php echo $value['se_key_vc']?>').fadeIn('fast');

                } else {
                // Verborgen element naar 'off' zetten
                $('#hiddentoggle<?php echo $value['se_key_vc']?>').val('false');
                $('#extrasettings<?php echo $value['se_key_vc']?>').fadeOut('fast', 'linear');
                }

              });
            });
         </script>
         <?php


       }
       ?>

     </form>
   </div>
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