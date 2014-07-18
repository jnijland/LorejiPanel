<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="panel/images/favicon.png" type="image/png">

  <title>Loreji Panel</title>

  <link href="panel/css/style.default.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="signin">

  <!-- Preloader -->
  <div id="preloader">
    <div id="status"> <i class="fa fa-spinner fa-spin"></i>
    </div>
  </div>

  <section>

    <div class="signinpanel">

      <div class="row">

        <div class="col-md-5 col-center-block">

           <?php $error = Request::get('error');
              if(isset($error))
              {
                if($error == "passfail")
                {
                  echo '<div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong>Oh snap!</strong> '.Language::get('auth.popup.passfail').'
                        </div>';
                }

                if($error == "nouser")
                {
                  echo '<div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong>Oh snap!</strong> '.Language::get('auth.popup.nouser').'
                        </div>';
                }

                if($error == "noperm")
                {
                  echo '<div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong>Oh snap!</strong> '.Language::get('auth.popup.noperm').'
                        </div>';
                }

              }
            ?>

          <form method="post" action="/auth/login">
            <h4 class="nomargin"><?php echo Language::get('auth.signin'); ?></h4>
            <p class="mt5 mb20"><?php echo Text::widont(Language::get('auth.signin.underline')); ?></p>

            <input type="text" name="username" class="form-control uname" placeholder="<?php echo Language::get('auth.username.placeholder'); ?>" />
            <input type="password" name="password" class="form-control pword" placeholder="<?php echo Language::get('auth.password.placeholder'); ?>" />
            <a href="#">
              <small><?php echo Language::get('auth.forgotpassword'); ?></small>
            </a>
            <button class="btn btn-success btn-block"><?php echo Language::get('auth.signin'); ?></button>

          </form>
        </div>
        <!-- col-sm-5 --> </div>
      <!-- row -->

      <div class="signup-footer">
        <div class="pull-left">
          Loreji Panel - <?php echo Settings::get("loreji_version"); ?>
        </div>
        <div class="pull-right">
          <?php echo Language::get('auth.createdby'); ?> <a href="http://loreji.com/team" target="_blank">Loreji Team</a>
        </div>
      </div>

    </div>
    <!-- signin --> </section>

  <script src="<?php echo Url::site('/panel/js/jquery-1.10.2.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/modernizr.min.js'); ?>"></script>
  <script src="<?php echo Url::site('/panel/js/retina.min.js'); ?>"></script>

  <script src="<?php echo Url::site('/panel/js/custom.js'); ?>"></script>

</body>
</html>