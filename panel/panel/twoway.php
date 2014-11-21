<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="<?php echo Url::site('/panel/images/favicon.png'); ?>" type="image/png">

  <title>[2 way authentication] - Loreji Panel</title>

  <link href="<?php echo Url::site('/panel/css/style.default.css'); ?>" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="notfound">

  <!-- Preloader -->
  <div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
  </div>

  <section>
    <div class="lockedpanel">
      <div class="locked">
        <i class="fa fa-lock"></i>
      </div>
      <div class="qrcode img-rounded" style="padding-top: 15px; padding-bottom: 15px; background-color: #FFF;">
        <img src="<?php echo $qr; ?>" alt="" height="200" width="200" style="padding: 10px;" />
      </div>
      <div class="logged">
        <h4><?php echo Auth::check_login()['au_email_vc']; ?></h4>
        <small class="text-muted">Enter your verification code!</small>
      </div>
      <form method="post" action="<?php echo Url::site('/twoway'); ?>">
        <input  type="password" name="vcode" id="txtpassword" class="form-control" placeholder="Enter Google Authentication code" />
        <button class="btn btn-success btn-block">Enter</button>
      </form>
    </div><!-- lockedpanel -->
    
  </section>


  <script src="<?php echo Url::site('/panel/js/jquery-1.10.2.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/modernizr.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/retina.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery.cookie.js'); ?>"></script>

  <script src="<?php echo Url::site('/panel/js/custom.js'); ?>"></script>

  <script type="text/javascript">
    window.onload = function() {
      document.getElementById("txtpassword").focus();

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

  };
</script>

</body>
</html>