<?php
  if(Auth::check_login()['au_actlocked_en'] === '1')
  {
    Route::redirect('/lock');
  }
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link rel="shortcut icon" href="<?php echo Url::site('/panel/images/favicon.png'); ?>" type="image/png">

  <title>Loreji Panel</title>

  <script src="<?php echo Url::site('/panel/js/jquery-1.10.2.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/modernizr.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery.sparkline.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/toggles.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/retina.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery.cookies.js'); ?>"></script>

  <!-- <script src="<?php echo Url::site('/panel/js/flot/flot.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/flot/flot.resize.min.js'); ?>"></script> -->
  <script src="<?php echo Url::site('/panel/js/morris.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/raphael-2.1.0.min.js'); ?>"></script>

  <script src="<?php echo Url::site('/panel/js/jquery.datatables.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/chosen.jquery.min.js'); ?>"></script>

  <script src="<?php echo Url::site('/panel/js/custom.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/dashboard.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery.gritter.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery.cookie.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery.circliful.min.js'); ?>"></script>

  <link href="<?php echo Url::site('/panel/css/style.default.css'); ?>" rel="stylesheet">
  <link href="<?php echo Url::site('/panel/css/jquery.datatables.css'); ?>" rel="stylesheet">
  <link href="<?php echo Url::site('/panel/css/font-mfizz.css'); ?>" rel="stylesheet">
  <link href="<?php echo Url::site('/panel/css/jquery.circliful.css'); ?>" rel="stylesheet" type="text/css" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->

<script type="template/modal-delete" id="templates-modal-delete">
        <div class="modal fade" id="popupDeleteModal" tabindex="-1" role="dialog" aria-labelledby="removeRoleModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">{{name}} verwijderen?</h4>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        Weet u zeker dat u <strong>{{name}}</strong> wilt verwijderen?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button><a href="{{url}}" class="btn btn-danger">Ja</a>
                    </div>
                </div>
            </div>
        </div>
    </script>

  
</head>

<body class="<?php echo (Cookie::get('nav_collapse') === 'true')? 'leftpanel-collapsed' : ''; ?> stickyheader">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
  <div class="leftpanel">
    
    <div class="logopanel">
        <h1><span>[</span> Loreji Panel <span>]</span></h1>
    </div><!-- logopanel -->
        
    {{base::leftmenu}}

  <div class="mainpanel">
    {{base::topmenu}}

   {{base::viewpanel}}
  
  
</section>

<script type="text/javascript">
  $(document).ready( function(){

    // START MENU TOGGLE
    $('#menutoggle').click( function(){
      $.get( "<?php echo Url::site('/api/togglenav'); ?>", function( data ) {
        console.log( data );
      });
    });
    // END MENU TOGGLE


    <?php
      // All admin thingys
      if(Auth::has_role('admin') === TRUE)
      { ?>  
        // For /home/index, check for auto updater
        var delay_update = 1500;
        //setTimeout(function(){  jQuery('#updatemessage').slideToggle(600); }, delay_update);
<?php } ?>

    // Check if cookie is valid
    function timeout_cookie() {
      var delay_cookie = 10000;
      setTimeout(function(){
        console.log('CookieCheck(10_sec): ' + $.cookie("uid"));
        if($.cookie("uid") == undefined){
          $.removeCookie("uid");
          window.location = "<?php echo Url::site('/login'); ?>";
        }
        timeout_cookie(); 
      }, delay_cookie);
    } timeout_cookie();
    

    // Automatic to lock screen if inactive
    var delay_timeout = 1600000; //This is milliseconds for 10 minutes
    //var delay   = 300000; // This is milliseconds for 5 minutes
    //var delay = 10000; // This is milliseconds for 10 seconds
    //var delay = 5000; // This is milliseconds for 5 seconds
    var URL = "<?php echo Url::site('/lock'); ?>";
    setTimeout(function(){ window.location = URL; }, delay_timeout);


        $('#myStat').circliful();
        $('#myStat1').circliful();
        $('#myStat2').circliful();
        $('#myStat3').circliful();
        $('#myStat4').circliful();
        $('#myStat5').circliful();
        $('#myStat6').circliful();
        $('#myStat7').circliful();

$('.removePopupLink').on('click', function(e){
    e.preventDefault();

    if ($('#popupDeleteModal').length > 0)
    {
      $('#popupDeleteModal').remove();
    }

    $link = $(this);

    var id   = $link.data('id'),
      name = $link.data('name'),
      url  = $link.parents('.panel-body').data('url');

    template = $.trim( $('#templates-modal-delete').html() );

    html = template.replace( /{{url}}/ig, url )
          .replace( /{{id}}/ig, id )
          .replace( /{{name}}/ig, name );
    $('body').append(html);

    $('#popupDeleteModal').modal();
  });

    setTimeout(function(){ $('.loreji-alert').fadeIn( "fast", "linear" ); setTimeout(function(){ $('.loreji-alert').fadeOut( 1500, "linear" ); }, 5000); }, 1000);


    console.log(screen.height);
    console.log(screen.width);

  });
</script>
</body>
</html>