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

  <?php $looker = Request::get('error');  echo (isset($looker) && $looker == 1) ? Template::alert(Language::get('management.users.remove.1'), 'danger') : ''; ?>

  <div class="row">

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body" data-url="/management/users/remove/{{id}}">
            <div class="row">

             <!-- TABLE INNERS -->
             <div class="col-md-12">
              <h5 class="subtitle mb5"><?php echo Language::get('management.users.table.title'); ?></h5>
              <div class="table-responsive" >
                <table class="table mb30">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo Language::get('management.users.table.username'); ?></th>
                      <th><?php echo Language::get('management.users.table.email'); ?></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo Management::generate_user_list(); ?>
                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div><!-- col-md-12 -->

            <!-- col-sm-4 --> </div>
            <!-- row --> </div>
            <div class="panel-footer">
              <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-primary pull-right">New User</button>
                </div> <!--col-sm-9 col-sm-offset-3 -->
              </div> <!-- row -->
            </div> <!-- panel-footer -->
            <!-- panel-body --> </div>
            <!-- panel --> </div>
            <!-- row --> </div>
            <!-- row --> </div>

          </div>
          <!-- contentpanel -->

        </div>
<!-- mainpanel -->