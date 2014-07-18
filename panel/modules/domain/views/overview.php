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

  <div class="row">

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body" data-url="/domain/remove/{{id}}">
            <div class="row">

             <!-- TABLE INNERS -->
             <div class="col-md-12">
          <h5 class="subtitle mb5"><?php echo Language::get('domain.table.title'); ?></h5>
          <div class="table-responsive" >
          <table class="table mb30">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo Language::get('domain.table.domainname'); ?></th>
                <th><?php echo Language::get('domain.table.directoryname'); ?></th>
                <th><?php echo Language::get('domain.table.status'); ?></th>
                <th><?php echo Language::get('domain.table.dns'); ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php echo Domain::Domain_list(); ?>
            </tbody>
          </table>
          </div><!-- table-responsive -->
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