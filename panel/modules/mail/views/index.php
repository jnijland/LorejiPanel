  <div class="pageheader">
    <h2><i class="fa fa-envelope"></i> Mail <span><?php echo Language::get('mail.index.title'); ?></span></h2>
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo Language::get('global.entry.youarehere'); /* Pre-set global variable */ ?>:</span>
      <ol class="breadcrumb">
        <li><a href="/home/index">Loreji</a></li>
        <li class="active">Module Name</li>
      </ol>
    </div>
  </div>

  <div class="contentpanel">

<!-- ################################### -->

   <div class="row">

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
          <div class="panel-body" data-url="/domain/remove/{{id}}">
            <div class="row">

             <!-- TABLE INNERS -->
             <div class="col-md-12">
          <h5 class="subtitle mb5"><?php echo Language::get('mail.index.list'); ?></h5>
          <div class="table-responsive" >
          <table class="table mb30">
            <thead>
              <tr>
                <th><?php echo Language::get('mail.index.user'); ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>jnijland@loreji.com</td>
                <td class="table-action">
                  <a href="/domain/edit/22" class="delete-row btn btn-primary" style="color: #FFF;"><i class="fa fa-pencil"></i></a>
                  <a href="/domain/remove/22" class="delete-row btn btn-danger removePopupLink" data-type="domain" data-name="dikkevinger.nl" data-id="22" data-action=""  data-url="/domain/remove/{{id}}" rel="tooltip" data-original-title="Domein verwijderen" style="color: #FFF;"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>            </tbody>
          </table>
          </div><!-- table-responsive -->
        </div><!-- col-md-6 -->

              <!-- col-sm-4 --> </div>
            <!-- row --> </div>
          <!-- panel-body --> </div>
        <!-- panel --> </div>
      <!-- row --> </div>
    <!-- row --> </div>

<!-- ################################### -->

  </div><!-- controlpanel -->

  </div><!-- mainpanel -->