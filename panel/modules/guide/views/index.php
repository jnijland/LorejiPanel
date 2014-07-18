  <div class="pageheader">
      <h2><i class="fa fa-home"></i> Guide <span>a small travel trough Loreji</span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
          <li><a href="index.html">Loreji</a></li>
          <li class="active">Guide</li>
        </ol>
      </div>
    </div>
    
    <div class="contentpanel">
    <?php
	$Markdown = new Markdown();
	$mdfile = @Route::$params->params[0];
	if($mdfile === NULL){
		$mdfile = 'home';
	}
	$MD_file = file_get_contents(SYSROOT.DS.'modules'.DS.Route::$params->controller.DS.'views'.DS.'markdown'.DS.$mdfile.'.md');
	$MD =  $Markdown->text($MD_file); 
	echo nl2br($MD);
	?>
    </div>
    
  </div><!-- mainpanel -->