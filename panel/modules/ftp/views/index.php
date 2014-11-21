  <div class="pageheader">
    <h2><i class="fa fa-upload"></i>
    	FTP <span><?php echo Language::get('ftp.header.title'); ?> </span></h2>	
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



    <div class="col-md-12">
      <div class="panel panel-default">

        <div class="panel-heading">
          <h4 class="panel-title"><?php echo Language::get('ftp.overview.title'); ?></h4>
        </div><!-- panel-heading -->

         <div class="table-responsive" >
          <table class="table mb30">
            <thead>
              <tr>
                <th><?php echo Language::get('ftp.overview.username'); ?></th>
                <th><?php echo Language::get('ftp.overview.mountpoint'); ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <tr>
            <td>jurrian@test.loreji.com</td>
            <td>/ (root)</td>
            <td class="table-action">
                  <a href="#" class="delete-row btn btn-primary" style="color: #FFF;"><i class="fa fa-pencil"></i></a>
                  <a href="#" class="delete-row btn btn-danger removePopupLink" data-type="domain" data-name="#" data-id="1" data-action="" data-url="/domain/remove/{{id}}" rel="tooltip" data-original-title="" style="color: #FFF;"><i class="fa fa-trash-o"></i></a>
                </td>

            </tr>
                          </tbody>
          </table>
          </div><!-- table-responsive -->

        <div class="panel-footer">
         
          </div> <!-- row -->
        </div> <!-- panel-footer -->

      </div><!-- panel -->
    </div><!-- col-md-6 -->

<!-- ################################### -->

  </div><!-- controlpanel -->

  </div><!-- mainpanel -->