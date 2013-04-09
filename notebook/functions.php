<?php

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar Blog',
		'description' => 'Widgets in this area will be shown in the sidebar area for blog & archives.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left"><div class="widget-content"><div class="widget-inner">',
        'after_widget' => '</div></div></aside><div class="clear"></div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
	
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar Pages',
		'description' => 'Widgets in this area will be shown in the sidebar area for pages.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s left"><div class="widget-content"><div class="widget-inner">',
        'after_widget' => '</div></div></aside><div class="clear"></div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
	
$functions_path = TEMPLATEPATH . '/admin/';
$includes_path = TEMPLATEPATH . '/includes/';
$ct_resize = TEMPLATEPATH . '/img_resize/';

// Localization Support
$lang = TEMPLATE_PATH . '/lang';
load_theme_textdomain('theme_textdomain', $lang);

// Update Notifier
require_once ($functions_path . 'update_notifier.php');

// WooTumblog
require_once ($functions_path . 'woo-tumblog/woo_tumblog.php');

// Custom Write Post Panel Fields
require_once ($functions_path . 'custom_fields.php');

// Admin Options Panel
require_once ($functions_path . 'options_panel.php');

// Theme Functions
require_once ($functions_path . 'theme_functions.php');

// Custom Shortcodes
require_once ($functions_path . 'shortcodes.php');

// Custom Shortcodes TinyMCE
require_once ($functions_path . 'tiny_mce.php');

// Widgets
require_once ($includes_path . 'widgets.php');

add_action('wp_head', 'contempo_wp_head');
add_action('wp_footer', 'contempo_wp_footer');
add_action('admin_head', 'contempo_admin_head'); 

function add_editor_buttons($buttons) {

$buttons[] = 'fontselect';

$buttons[] = 'fontsizeselect';

$buttons[] = 'cleanup';

$buttons[] = 'styleselect';

$buttons[] = 'hr';

$buttons[] = 'del';

$buttons[] = 'sub';

$buttons[] = 'sup';

$buttons[] = 'copy';

$buttons[] = 'paste';

$buttons[] = 'cut';

$buttons[] = 'undo';

$buttons[] = 'image';

$buttons[] = 'anchor';

$buttons[] = 'backcolor';

$buttons[] = 'wp_page';

$buttons[] = 'charmap';

return $buttons;

}

add_filter("mce_buttons_4", "add_editor_buttons");

?>