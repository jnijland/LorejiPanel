<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<title>Webpage</title>

<link rel="stylesheet" href="panel/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="panel/css/style.blue.css" type="text/css" />

<script type="text/javascript" src="panel/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="panel/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="panel/js/modernizr.min.js"></script>
<script type="text/javascript" src="panel/js/bootstrap.min.js"></script>
<script type="text/javascript" src="panel/js/jquery.dropdown.js"></script>
<script type="text/javascript" src="panel/js/custom.js"></script>

<script>
jQuery(document).ready(function(){
    var winHeight = jQuery(window).height();
    jQuery('#framedemo').height(winHeight - 65);
    
    jQuery('#cd-dropdown').dropdown( {
		  gutter : 5,
		  stack : false,
		  slidingIn : 100
	 });


});
</script>

</head>

<body>
<div class="headframe">
    <div class="row-fluid">
        <div class="span3"><a href="/login"><img src="panel/images/tp-logo.png" /></a></div>

    </div><!-- row-fluid -->
</div>

</body>
</html>