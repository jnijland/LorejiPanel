<div class="pageheader">
  <h2> <i class="fa fa-globe"></i>
    <?php echo Language::get('domain.header.name'); ?> <span><?php echo Language::get('domain.header.desc'); ?></span>
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
    $cookie = Cookie::get_once('error');
    if($cookie == 'domainexist'){ echo Html::set_flash_message('This domain already exists!', 'danger'); } 
    if($cookie == 'tooshort'){ echo Html::set_flash_message('This domain is invalid.', 'danger'); }
    ?>

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">

             <!-- TABLE INNERS -->
             <div class="col-md-6">  
              <form id="form2" action="" method="post" class="form-horizontal form-bordered">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title"><?php echo Language::get('domain.form.adddomain'); ?></h4>
                  </div>
                  <div class="panel-body panel-body-nopadding">

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('domain.form.label.domain'); ?><span class="asterisk">*</span>:</label>
                      <div class="col-sm-8">
                        <input type="text" name="domain" class="form-control" placeholder="<?php echo Language::get('domain.form.placeholder.domain'); ?>" required />
                        <input type="hidden" name="type" value="1">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('domain.form.label.directory'); ?>:</label>
                      <div class="col-sm-8">
                         <select class="form-control input-sm mb15" name="directory">
                          <option value="NULL"><?php echo Language::get('domain.form.placeholder.newdir'); ?></option>
                          <?php
                          foreach (glob("/var/loreji/hostdata/".Auth::check_login()['au_username_vc']."/public_html/*") as $filename) {
                              $classname = array_reverse(explode('/', $filename));
                              echo "<option value='".$classname[0]."'>".$classname[0]."</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                  </div><!-- panel-body -->
                  <div class="panel-footer">
                    <button class="btn btn-primary pull-right"><?php echo Language::get('global.btn.save'); ?></button>
                  </div><!-- panel-footer -->
                </div><!-- panel-default -->
              </form>
            </div><!-- col-md-6 -->

            <div class="col-md-6">  
              <form id="form2" action="" method="post" class="form-horizontal form-bordered">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title"><?php echo Language::get('domain.form.addsubdomain'); ?></h4>
                  </div>
                  <div class="panel-body panel-body-nopadding">

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('domain.form.label.subdomain'); ?><span class="asterisk">*</span>:</label>
                      <div class="col-sm-4">
                        <input type="text"  name="domain" class="form-control" placeholder="<?php echo Language::get('domain.form.placeholder.subdomain'); ?>" required />
                        <input type="hidden" name="type" value="2">
                      </div>
                      <div class="col-sm-4">
                      <select class="form-control" name="rootdomain" required>
                        <?php
                        foreach ($domains as $value) {
                          echo '<option value=".'.$value['vh_domain_vc'].'">.'.$value['vh_domain_vc'].'</option>';
                        }
                        ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('domain.form.label.directory'); ?>:</label>
                      <div class="col-sm-8">
                        <select class="form-control input-sm mb15" name="directory">
                          <option value="NULL"><?php echo Language::get('domain.form.placeholder.newdir'); ?></option>
                          <?php
                          foreach (glob("/var/loreji/hostdata/".Auth::check_login()['au_username_vc']."/public_html/*") as $filename) {
                              $classname = array_reverse(explode('/', $filename));
                              echo "<option value='".$classname[0]."'>".$classname[0]."</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                  </div><!-- panel-body -->
                  <div class="panel-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo Language::get('global.btn.save'); ?></button>
                  </div><!-- panel-footer -->
                </div><!-- panel-default -->
              </form>
            </div><!-- col-md-6 -->


            <!-- col-sm-4 --> </div>
            <!-- row --> </div>
            <!-- panel-body --> </div>
            <!-- panel --> </div>
            <!-- row --> </div>


          </div>
          <!-- contentpanel -->

        </div>
<!-- mainpanel -->