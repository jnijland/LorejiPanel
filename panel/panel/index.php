<?php
if(Auth::$instance->au_actlocked_en === '1')
{
  Route::redirect('/lock');
}
?><!DOCTYPE html>
<html lang="en" style="height: 100%;">
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
  <script src="<?php echo Url::site('/panel/js/jquery.easing.js');?>"></script>

  <link href="<?php echo Url::site('/panel/css/style.default.css'); ?>" rel="stylesheet">
  <link href="<?php echo Url::site('/panel/css/jquery.datatables.css'); ?>" rel="stylesheet">
  <link href="<?php echo Url::site('/panel/css/font-mfizz.css'); ?>" rel="stylesheet">
  <link href="<?php echo Url::site('/panel/css/jquery.circliful.css'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo Url::site('/panel/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />

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
          <h4 class="modal-title" id="myModalLabel"><?php echo Language::get('global.modal.remove.title', array('{{name}}'), array('{{name}}')); ?></h4>
        </div>
        <div class="modal-body" style="text-align: center;">
          <?php echo Language::get('global.modal.remove.body', array('{{name}}'), array('{{name}}')); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Language::get('global.no'); ?></button><a href="{{url}}" class="btn btn-danger"><?php echo Language::get('global.yes'); ?></a>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="template/modal-update" id="templates-modal-update">
  <div class="modal fade" id="popupModalUpdate" tabindex="-1" role="dialog" aria-labelledby="RoleModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><?php echo Language::get('global.modal.update.title', array('{{name}}'), array('{{name}}')); ?></h4>
        </div>
        <div class="modal-body">
          <?php echo Language::get('global.modal.update.body', array('{{name}}'), array('{{name}}')); ?>
          <div class="permissionwrap">

            <div class="permissionheader">
              <a><?php echo Language::get('global.permission.title.view'); ?>:</a>
            </div>

            <div class="permissionlist">
              <ul>
                {{permissionlist}}
              </ul>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Language::get('global.no'); ?></button><a href="{{url}}" class="btn btn-warning"><?php echo Language::get('global.yes'); ?></a>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="template/modal-install" id="templates-modal-install">
  <div class="modal fade" id="popupModalInstall" tabindex="-1" role="dialog" aria-labelledby="RoleModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><?php echo Language::get('global.modal.install.title', array('{{name}}'), array('{{name}}')); ?></h4>
        </div>
        <div class="modal-body">
          <?php echo Language::get('global.modal.install.body', array('{{name}}'), array('{{name}}')); ?>
          <div class="permissionwrap">

            <div class="permissionheader">
              <a><?php echo Language::get('global.permission.title.view'); ?>:</a>
            </div>

            <div class="permissionlist">
              <ul>
                {{permissionlist}}
              </ul>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Language::get('global.no'); ?></button><a href="{{url}}" class="btn btn-success"><?php echo Language::get('global.yes'); ?></a>
        </div>
      </div>
    </div>
  </div>
</script>

</head>
<?php
$isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.
                    '|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                    '|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
?>
<body class="<?php echo (Cookie::get('nav_collapse') === 'true' && $isMobile === false)? 'leftpanel-collapsed' : ''; ?>"  style="min-height: 100%;">

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
        
        <?php if(Cookie::get('shadow') != ''): ?>
        <div class="col-lg-12" style="background-color: #d9534f; z-index:1; color:#FFFFFF; text-align:center;margin-bottom: 10px;height: 27px;padding-top: 4px;">
          <span class="pull-left" rel="tooltip" data-original-title="Shadowing mode enables the support/administrator to manage the shadowed accounts.">[Shadowing Mode]</span>
          <?php echo Auth::check_shadow_admin()['au_fullname_vc']; ?> shadows <em><?php echo Auth::$instance->au_fullname_vc; ?></em>
          <span class="pull-right"  rel="tooltip" data-original-title="End this shadowing session."><a href="<?php echo URL::site('auth/logoutshadow'); ?>" style="color: #FFF;">[logout]</a></span>
        </div>
      <?php endif; ?>

        {{base::viewpanel}}

      </div><!-- mainpanel -->
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
    // console.log('CookieCheck(10_sec): ' + $.cookie("uid"));
    if($.cookie("uid") == undefined){
      $.removeCookie("uid");
      window.location = "<?php echo Url::site('/login'); ?>";
    }
    timeout_cookie(); 
  }, delay_cookie);
} timeout_cookie();


// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

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
  action = $link.data('action'),
  url  = $link.data('url');

  template = $.trim( $('#templates-modal-delete').html() );

  html = template.replace( /{{url}}/ig, url )
  .replace( /{{id}}/ig, id )
  .replace( /{{action}}/ig, action )
  .replace( /{{name}}/ig, name );
  $('body').append(html);

  $('#popupDeleteModal').modal();
});

$('.PopupLinkUpdate').on('click', function(e){
  e.preventDefault();

  if ($('#popupModalUpdate').length > 0)
  {
    $('#popupModalUpdate').remove();
  }

  $link = $(this);
  console.log($link);
  var id   = $link.data('id'),
  name = $link.data('name'),
  action = $link.data('action'),
  permlist = $link.data('permlist'),
  url  = $link.data('url');

  console.log(id);
  console.log(name);
  console.log(action);
  console.log(permlist);
  console.log(url);

  template = $.trim( $('#templates-modal-update').html() );

  html = template.replace( /{{url}}/ig, url )
  .replace( /{{id}}/ig, id )
  .replace( /{{permissionlist}}/ig, Base64.decode(permlist))
  .replace( /{{action}}/ig, action )
  .replace( /{{name}}/ig, name );
  $('body').append(html);

  console.log(html);

  $('#popupModalUpdate').modal();
});

$('.PopupLinkInstall').on('click', function(e){
  e.preventDefault();

  if ($('#popupModalInstall').length > 0)
  {
    $('#popupModalInstall').remove();
  }

  $link = $(this);

  var id   = $link.data('id'),
  name = $link.data('name'),
  action = $link.data('action'),
  permlist = $link.data('permlist'),
  url  = $link.data('url');

  template = $.trim( $('#templates-modal-install').html() );

  html = template.replace( /{{url}}/ig, url )
  .replace( /{{id}}/ig, id )
  .replace(/{{permissionlist}}/ig, Base64.decode(permlist))
  .replace( /{{action}}/ig, action )
  .replace( /{{name}}/ig, name );
  $('body').append(html);

  $('#popupModalInstall').modal();
});

setTimeout(function(){ $('.loreji-alert').slideDown( "slow", 'easeOutQuint' ); setTimeout(function(){ $('.loreji-alert').slideUp( 1500, 'easeOutQuint' ); }, 5000); }, 1000);
setTimeout(function(){ $('.permission-warning').slideDown("slow", 'easeOutQuint'); }, 1500);

/*console.log(screen.height);
console.log(screen.width);*/

$('.mainpanel').height($(document).height());
$('[rel=tooltip]').tooltip({
  placement:'bottom',
});

});
</script>
</body>
</html>