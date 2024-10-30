jQuery(document).ready(function() {
 jQuery('#igit_tw_upload_image_button').live('click', function () {
		formfield = jQuery('#igit_tw_upload_image').attr('name');
		uploadID = jQuery(this).prev('input'); 
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
    });
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 uploadID.val(imgurl); 
 uploadID.parent().next().empty().append('<img src='+imgurl+' />');
 tb_remove();
}

jQuery('#igit_tw_remove_image').live('click', function () {
		jQuery('#igit_tw_upload_image').val('');
		jQuery('#igit_tw_preview_fb').empty();
    });
});