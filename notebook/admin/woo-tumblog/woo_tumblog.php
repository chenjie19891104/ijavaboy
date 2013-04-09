<?php
/*
Plugin Name: WooTumblog
Plugin URI: http://wordpress.org/extend/plugins/woo-tumblog/
Description: Create a tumblr style blog using this plugin.
Version: 1.0.3
Author: Jeffikus of WooThemes
Author URI: http://www.woothemes.com
License: GPL2
*/

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Include Classes and Functions
- Initiate the plugin
-- WooTumblogInit()

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Include Classes and Functions */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('WooTumblogInit')) {

	// Main Tumblog Plugin Class
	require_once( 'classes/wootumblog.class.php' );
	// Tumblog Custom Taxonomy Class
	require_once( 'classes/wootumblog_taxonomy.class.php' );
	// Dashboard Widget Output Functions
	require_once( 'functions/wootumblog_dashboard_functions.php' );
	// Express iPhone app Functions
	require_once( 'functions/wootumblog_express_app_functions.php' );
	// Woo Helper Functions
	require_once( 'functions/wootumblog_helper_functions.php' );
	// Template Output Functions
	require_once( 'functions/wootumblog_template_functions.php' );

	/*-----------------------------------------------------------------------------------*/
	/* Initiate the plugin */
	/*-----------------------------------------------------------------------------------*/

	add_action("init", "WooTumblogInit");
	function WooTumblogInit() { 
	    
		$pluginpath = dirname( __FILE__ );
		$pluginurl = get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog';
	 		
		//Main Tumblog Object
		global $woo_tumblog; 
		$woo_tumblog = new WooTumblog(); 
		//Tumblog Custom Taxonomy
		global $woo_tumblog_taxonomy; 
		$woo_tumblog_taxonomy = new WooTumblogTaxonomy(); 
		$woo_tumblog_taxonomy->woo_tumblog_create_initial_taxonomy_terms();
	
	}
}

?>