{{header}}
{{javascripts}}
<body>

<!-- jQuery Templating Start -->
<script type="template/modal-delete" id="templates-modal-delete">
	<div class="modal fade" id="popupDeleteModal" tabindex="-1" role="dialog" aria-labelledby="removeRoleModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Remove {{name}}?</h4>
				</div>
				<div class="modal-body" style="text-align: center;">
					Are you sure you want to remove <strong>{{name}}</strong>?</div>
					<div class="modal-footer">
						<a href="{{url}}" class="btn btn-danger">Yes</a>
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					</div>
				</div>
			</div>
		</div>
</script>


<script type="text/javascript">
	jQuery(document).ready(function($) {

		// REMOVE MODAL START
		$('.removePopupLink').on('click', function(e){
		  e.preventDefault();

		  if ($('#popupDeleteModal').length > 0)
		  {
		    $('#popupDeleteModal').remove();
		  }

		  $link = $(this);
		  console.log($link);

		  var id   = $link.data('id'),
		  name = $link.data('name'),
		  action = $link.data('action'),
		  url  = $link.parents('.panel-body').data('url');

		  template = $.trim( $('#templates-modal-delete').html() );

		  html = template.replace( /{{url}}/ig, url )
		  .replace( /{{id}}/ig, id )
		  .replace( /{{name}}/ig, name );
		  $('body').append(html);

		  $('#popupDeleteModal').modal();
		});
		// REMOVE MODAL STOP

		$('#page-wrapper').height($(document).height());

		$('.popup').click(function(event) {
		    event.preventDefault();
		    console.log($(this).attr("data-href"));
		    window.open($(this).attr("data-href"), "popupWindow", "width=600,height=600,scrollbars=yes");
		});
		
	});
</script>
<!-- jQuery Templating Stop  -->

    <div id="wrapper">
     {{navigation}}
     <div id="page-wrapper">
        {{page}}
    </div>
</body>
</html>