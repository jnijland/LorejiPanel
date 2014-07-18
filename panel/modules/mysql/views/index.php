  <div class="pageheader">
    <h2><i class="fa icon-mysql size-36"></i> <?php echo Language::get('mysql.header.name'); ?> <span><?php echo Language::get('mysql.header.desc'); ?>...</span></h2>
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo Language::get('global.entry.youarehere'); ?>:</span>
      <ol class="breadcrumb">
        <li><a href="/home/index">Loreji</a></li>
        <li class="active"><?php echo Language::get('mysql.header.name'); ?></li>
      </ol>
    </div>
  </div>

  <div class="contentpanel">
    <!-- Add here your content -->


    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">

             <!-- TABLE INNERS -->
             <div class="col-md-12">


             <h5 class="subtitle mb5">List with all MySQL Databases</h5>
               <div class="table-responsive">
                <table class="table mb30">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Database name</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                  $count = 0;
                  $mysql_databases = Model::load('mysql', 'getMysqlDatabases');
                  foreach ($mysql_databases as $value) {
                    $count++;
                    echo '<tr>
                      <td>'.$count.'</td>
                      <td>'.$value['md_name_vc'].'</td>
                      <td class="table-action">
                        <a href="/domain/remove/25" class="delete-row"><i class="fa fa-trash-o"></i></a>
                      </td>
                    </tr> ';
                  }
                  ?>

                </tbody>

              </table>
            </div><!-- table-responsive -->


          </div><!-- col-md-6 -->

          <!-- col-sm-4 --> </div>
          <!-- row --> </div>
          <!-- panel-body --> </div>
          <!-- panel --> </div>
          <!-- row --> </div>


        </div>

  </div><!-- mainpanel -->