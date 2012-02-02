$(document).ready(function(){

	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		appendText: '(yy-mm-dd)',
		constrainInput: false
	});
	
	sortableImages();
});

function sortableImages(){
	
	$('#sortable-images').sortable({
		handle		: '.btn-move',
		update		: function(e, u){
			var order = $('#sortable-images').sortable('serialize'); 
      		$.get(_baseurl+'admin/galleries/sortImages?gallery_id='+$('#GalleryId').val()+'&'+order); 
		}
	});
	
	$('.cancelbtn').click(function(){
		var resp = confirm('Are you sure it is ok to delete this image?');
		if(resp){
			var pelm = $(this).parent().parent();
			var imgid = pelm.attr('id').replace('GImages-','');
			$.get(_baseurl+'admin/galleries/removeImage/'+imgid, function(html){
				if(html == 1){
					pelm.fadeOut('fast');
				}else{
					alert(html);
				}
			});
		}
		return false;
	});

}

function refreshGallery(){
	
	$.get(_baseurl+'admin/galleries/images/'+$('#GalleryId').val()+'&layout=none', function(html){
		$('#gallery-wrapper').html(html);
	});
	
}