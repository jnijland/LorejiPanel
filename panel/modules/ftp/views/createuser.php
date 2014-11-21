  <div class="pageheader">
    <h2><i class="fa fa-upload"></i>
    	FTP <span><?php echo Language::get('ftp.header.adduser'); ?> </span></h2>	
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo Language::get('global.entry.youarehere'); /* Pre-set global variable */ ?>:</span>
      <ol class="breadcrumb">
        <li><a href="/home/index">Loreji</a></li>
        <li class="active">FTP</li>
      </ol>
    </div>
  </div>

  <div class="contentpanel">

<!-- ################################### -->

<div class="row">
      <div class="col-sm-6 col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">

             <!-- TABLE INNERS --> 
              <form id="form2" action="" method="post" class="form-horizontal form-bordered">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title"><?php echo Language::get('ftp.createuser.newuser'); ?></h4>
                  </div>
                  <div class="panel-body panel-body-nopadding">

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('ftp.createuser.username'); ?><span class="asterisk">*</span>:</label>
                      <div class="col-sm-8">
                        <input type="text" name="domain" class="form-control" placeholder="mijndomein.nl" required />
                        <input type="hidden" name="type" value="1">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('ftp.createuser.password'); ?><span class="asterisk">*</span>:</label>
                      <div class="col-sm-8">
                        <input type="password" name="domain" class="form-control" placeholder="wachtwoord" required />
                        <input type="hidden" name="type" value="1">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('ftp.createuser.domain'); ?>: <span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                         <select class="form-control input-sm mb15" name="directory">
                          <option value='dikkevinger_nl'>dikkevinger_nl</option>                        </select>
                      </div>
                    </div>

                   <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo Language::get('ftp.createuser.folder'); ?>: <span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                         <select class="form-control input-sm mb15" name="directory">
                          <option value='dikkevinger_nl'>dikkevinger_nl</option>                        </select>
                      </div>
                    </div>

                  </div><!-- panel-body -->
                  <div class="panel-footer">
                    <button class="btn btn-primary pull-right">Opslaan</button>
                  </div><!-- panel-footer -->
                </div><!-- panel-default -->
              </form>
            <!-- col-sm-4 --> </div>
            <!-- panel-body --> </div>
            <!-- panel --> </div>
            <!-- row --> </div>

<!-- ################################### -->

  </div><!-- controlpanel -->

  </div><!-- mainpanel -->