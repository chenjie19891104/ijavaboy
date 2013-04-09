/**
 * Woothemes Tumblog Functionality
 * JQuery
 *
 * @version 2.0.0
 *
 * @package WooFramework
 * @subpackage Tumblog
 */
 
// setup everything when document is ready
jQuery(document).ready(function(jQuery) 
	{
		jQuery.noConflict();	 
		jQuery('#ajax-loader').hide();

		
		
		//MEDIA UPLOAD CLICK EVENTS
		jQuery("#image-upload-button").click(function () 
		{
      		jQuery("#image-option-url").hide();
      		jQuery("#image-option-upload").show();
      	});

		jQuery("#image-url-button").click(function () 
		{
      		jQuery("#image-option-upload").hide();
      		jQuery("#image-option-url").show();
      	});
      	
      	jQuery("#audio-upload-button").click(function () 
		{
      		jQuery("#audio-option-url").hide();
      		jQuery("#audio-option-upload").show();
      	});

		jQuery("#audio-url-button").click(function () 
		{
      		jQuery("#audio-option-upload").hide();
      		jQuery("#audio-option-url").show();
      	});
      	
      	
		
	});
// clear response div 
jQuery('#test-response').empty();

function updateContent() {
	//var content = tinyMCE.activeEditor.getContent();
	var content = nicEditors.findEditor('test-content').getContent();
	jQuery('#tumblog-content').attr('value', content);
}
		
function resetTumblogQuickPress() {
	//Main Content
	//tinyMCE.activeEditor.setContent('');
	nicEditors.findEditor('test-content').setContent('');
	//Articles
	jQuery('#note-title').attr('value','');	
	//Video
	jQuery('#video-title').attr('value','');
	jQuery('#video-embed').attr('value','');
	//Images
	jQuery('#image-title').attr('value','');
	jQuery('#image-upload').attr('value','');
	jQuery('#image-url').attr('value','');
	jQuery('#image-id').attr('value','');
	//Links
	jQuery('#link-title').attr('value','');
	jQuery('#link-url').attr('value','');
	//Quotes
	jQuery('#quote-title').attr('value','');
	jQuery('#quote-copy').attr('value','');
	jQuery('#quote-url').attr('value','');
	jQuery('#quote-author').attr('value','');
	//Audio
	jQuery('#audio-title').attr('value','');
	jQuery('#audio-upload').attr('value','');
	jQuery('#audio-url').attr('value','');
	jQuery('#audio-id').attr('value','');
	//Tags
	jQuery('#tumblog-tags').attr('value','');
	//Multi Select Category Inputs
	jQuery('#additional-categories input').each(function(){
		//remove checked attribute
		jQuery(this).attr('checked', false);
	});
	
}

function validateInput() {
	updateContent();
	var actiontype = jQuery('#tumblog-type').attr('value');
	var success = false;
	switch (actiontype)
	{
		case 'article':
			if (validate_field('note-title')) {
				success = true;
			}
			else {
				jQuery('#test-response').html('<span class="error">'+'Please fill in a Title!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				jQuery('#note-title').focus();
				success = false;
			}
			if (success) {
				if (validate_field('tumblog-content')) {
					success = true;
				}
				else {
					jQuery('#test-response').html('<span class="error">'+'Please enter some content!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#note-title').focus();
					success = false;
				}
			}
	  		break;
		case 'image':
		  	if (validate_field('image-title')) {
				success = true;
			}
			else {
				jQuery('#test-response').html('<span class="error">'+'Please fill in a Title!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				jQuery('#image-title').focus();
				success = false;
			}
			if (success) {
				if (validate_URL('image-url')) {
					success = true;
				}
				else if (validate_field('image-id') && ((jQuery('#image-id').attr('value')) != '0')) {
					success = true;
				}
				else {
					jQuery('#test-response').html('<span class="error">'+'Please enter an image URL or Upload an Image!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#image-title').focus();
					success = false;
				}
			}
		  	break;
		case 'link':
		  	if (validate_field('link-title')) {
				success = true;
			}
			else {
				jQuery('#test-response').html('<span class="error">'+'Please fill in a Title!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				jQuery('#link-title').focus();
				success = false;
			}
			if (success) {
				if (validate_URL('link-url')) {
					success = true;
				}
				else {
					jQuery('#test-response').html('<span class="error">'+'Please enter a link URL!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#link-url').focus();
					success = false;
				}
			}
		  	break;
		case 'audio':
		  	if (validate_field('audio-title')) {
				success = true;
			}
			else {
				jQuery('#test-response').html('<span class="error">'+'Please fill in a Title!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				jQuery('#audio-title').focus();
				success = false;
			}
			if (success) {
				if (validate_URL('audio-url')) {
					success = true;
				}
				else if (validate_field('audio-id') && ((jQuery('#audio-id').attr('value')) != '0')) {
					success = true;
				}
				else {
					jQuery('#test-response').html('<span class="error">'+'Please enter an audio URL or Upload an Audio File!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#audio-title').focus();
					success = false;
				}
			}
		  	break;
		case 'video':
		  	if (validate_field('video-title')) {
				success = true;
			}
			else {
				jQuery('#test-response').html('<span class="error">'+'Please fill in a Title!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				jQuery('#video-title').focus();
				success = false;
			}
			if (success) {
				if (validate_field('video-embed')) {
					success = true;
				}
				else {
					jQuery('#test-response').html('<span class="error">'+'Please enter Video Embed Code!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#video-title').focus();
					success = false;
				}
			}
		  	break;
		case 'quote':
		  	if (validate_field('quote-title')) {
				success = true;
			}
			else {
				jQuery('#test-response').html('<span class="error">'+'Please fill in a Title!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
				jQuery('#quote-title').focus();
				success = false;
			}
			if (success) {
				if (validate_field('quote-copy')) {
					success = true;
				}
				else {
					jQuery('#test-response').html('<span class="error">'+'Please enter a Quote!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					jQuery('#quote-copy').focus();
					success = false;
				}
			}
		 	break;
		default:
			success = false; 
		}
		return success;
}

//Validate Field Input
function validate_field(field) {
	var input = jQuery('#' + field).attr('value');
	if (input != '') {
		return true;
	}
	else {
		return false;
	}
}

//Validate Field URL
function validate_URL(field) {
	var input = jQuery('#' + field).attr('value');
	//RegEx	
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(input);
}
