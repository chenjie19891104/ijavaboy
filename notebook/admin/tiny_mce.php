<?php

	// Initialize
	add_action('init', 'add_button');
	
	function add_button() {
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
	   {
		 add_filter('mce_external_plugins', 'add_plugin');
		 add_filter('mce_buttons_3', 'register_button');
	   }
	}
	
	//Register the button
	function register_button($buttons) {
	   array_push($buttons, "dropcap","dropcap2","highlight","button","info","warning","error","success","note","download","divider","singlecol","singlecol_last","onethirdcol","onethirdcol_last","twocol","twocol_last","twothirdcol","twothirdcol_last","threecol","threecol_last","fourcol");
	   return $buttons;
	}
	
	function add_plugin($plugin_array) {
	   $plugin_array['dropcap'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['dropcap2'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['highlight'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['button'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['info'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['warning'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['error'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['success'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['note'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['download'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['divider'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['singlecol'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['singlecol_last'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['onethirdcol'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['onethirdcol_last'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['twocol'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['twocol_last'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['twothirdcol'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['twothirdcol_last'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['threecol'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['threecol_last'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   $plugin_array['fourcol'] = get_bloginfo('template_url').'/admin/js/tinymce/tinymce.js';
	   return $plugin_array;
	}
 
?>