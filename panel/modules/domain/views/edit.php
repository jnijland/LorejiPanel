<div class="pageheader">
  <h2> <i class="fa fa-globe"></i>
    <?php echo Language::get('domain.header.name'); ?>
    <span><?php echo Language::get('domain.header.desc'); ?></span>
  </h2>
  <div class="breadcrumb-wrapper">
    <span class="label"><?php echo Language::get('global.entry.youarehere'); ?>:</span>
    <ol class="breadcrumb">
      <li>
        <a href="/home/index">Loreji</a>
      </li>
      <li class="active"><?php echo Language::get('domain.header.name'); ?></li>
    </ol>
  </div>
</div>

<div class="contentpanel">

  <?php 
    $domain_info = Domain::get_domain_info();
  ?>

  <?php $ssl = Request::post('usessl');  echo (isset($ssl)) ? Template::alert(Language::get('domain.alert.saved', array('{{domainname}}'), array($domain_info['vh_domain_vc']))) : ''; ?>

  <div class="row">

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">

        <div class="col-md-12">
          <form id="basicForm2" action="" method="POST" class="form-horizontal">
          <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"><?php echo Language::get('domain.form.edit'); ?> "<strong><?php echo $domain_info['vh_domain_vc']; ?></strong>"</h4>
              </div>
              <div class="panel-body">
                <div class="error"></div>

                <div class="form-group">
                  <label class="col-sm-3 control-label"><?php echo Language::get('domain.form.label.domain'); ?> <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="<?php echo $domain_info['vh_domain_vc'];  ?>" placeholder="(sub.)domain.com" required />
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label"><?php echo Language::get('domain.form.ssl'); ?></label>
                  <div class="col-sm-7 control-label">
                    <div class="toggle toggle-success" id="ssltoggle"></div>
                    <input type="hidden" name="usessl" id="hiddentogglessl" value="false" />
                  </div>
                </div>

                <div class="form-group" style="display:none;" id="sslsettings">
                  <label class="col-sm-3 control-label"><?php echo Language::get('domain.form.ssl.choose'); ?> <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <select class="form-control mb15" name="ssl_setting">
                      <?php
                        foreach (Domain::get_user_ssl() as $ssl) {
                          echo "<option value='".$ssl['sc_id_in']."' ".(($ssl['sc_id_in'] == $domain_info['vh_usessl_in'])? 'selected="selected"' : '').">".$ssl['sc_nick_vc']."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label"><?php echo Language::get('domain.form.label.directory'); ?> <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <select class="form-control mb15" name="vhost_directory">
                      <?php
                        foreach (glob("/var/loreji/hostdata/".Auth::check_login()['au_username_vc']."/public_html/*") as $filename) {
                          $classname = array_reverse(explode('/', $filename));
                          echo "<option value='".$classname[0]."' ".(($classname[0] == $domain_info['vh_path_vc'])? 'selected="selected"' : '').">".$classname[0]."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>

              </div><!-- panel-body -->
              <div class="panel-footer">
                <div class="row">
                  <div class="col-sm-9 col-sm-offset-3">
                    <button class="btn btn-primary pull-right"><?php echo Language::get('global.btn.save'); ?></button>
                  </div>
                </div>
              </div>
          </div><!-- panel -->
          </form>
        </div><!-- col-md-6 -->


              <!-- col-sm-4 --> </div>
            <!-- row --> </div>
          <!-- panel-body --> </div>
        <!-- panel --> </div>
      <!-- row --> </div>
    <!-- row --> </div>

</div>
<!-- contentpanel -->

</div>
<!-- mainpanel -->

<!-- JS -->
<script type="text/javascript">
  $(document).ready( function(){

    // For the language.... Dirty hack, but it works tho :).
    setTimeout( function() 
    {
      $(document).blur(function(event) {
        console.log('test');
      });
      setTimeout( function() {     
        $('.toggle-off').html('<?php echo strtoupper(Language::get("global.off")); ?>');
        $('.toggle-on').html('<?php echo strtoupper(Language::get("global.on")); ?>'); 
      }, 10);

      <?php
      if($domain_info['vh_usessl_in'] > 0)
      {
      ?>
        $('#ssltoggle').toggles({
          on: true
        }); 
        $('#hiddentogglessl').val('true');
        $('#sslsettings').slideDown( 1000, 'easeOutQuint' );
      <?php
      } else {
      ?>
        $('#ssltoggle').toggles({
          on: false
        }); 
        $('#hiddentogglessl').val('false');
        $('#sslsettings').slideUp( 1000, 'easeOutQuint' );
      <?php
      }
      ?>
    }, 10);

    $('#ssltoggle').on('toggle', function (e, active) {
      if (active) {
        // Verborgen element naar 'on' zetten
        $('#hiddentogglessl').val('true');
        $('#sslsettings').slideDown( 1000, 'easeOutQuint' );
      } else {
        // Verborgen element naar 'off' zetten
        $('#hiddentogglessl').val('false');
        $('#sslsettings').slideUp( 1000, 'easeOutQuint' );
      }
    });

  });
</script>