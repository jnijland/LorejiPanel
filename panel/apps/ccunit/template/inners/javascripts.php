<!-- jQuery Version 1.11.0 -->
<script src="<?php echo URL::site('/apps/ccunit/template/js/jquery-1.11.0.js');?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo URL::site('/apps/ccunit/template/js/bootstrap.min.js');?>"></script>

<!-- jeditable.mini.js -->
<script src="<?php echo URL::site('/apps/ccunit/template/js/jquery.jeditable.mini.js'); ?>"></script>

<script type="text/javascript">
$('a').click(function(event){
	event.preventdefault();
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top
    }, 500);
    return false;
});

$(document).ready(function(){
console.log('jQuery ready..');

$('#edituserdetails').on('click', function(){
	console.log('edituserdetails is clicked :)');
	$(this).hide();
	$('#saveuserdetails').show();
	$('#userdetailsbody').load("/apps/ccunit/index.php?page=api&action=ccunit_edit_user", {
		"fullname":$('#formfullname').html(),
		"streetname":$('#formstreetname').html(),
		"housenumber":$('#formhousenumber').html(),
		"zipcode":$('#formzipcode').html(),
		"city":$('#formcity').html(),
		"phone":$('#formphonenumber').html(),
		"email":$('#formemail').html(),
		"customercode":$('#formcustomercode').html(),
		"server":$('#formserver').html(),
		"status":$('#formstatus').html(),
		"language":$('#formlanguage').html()
	});
});

});

 
</script>