<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Register Actions
-- woo_register_tumblog_dashboard_widget()
-- woo_load_tumblog_libraries()
-- woo_load_tumblog_css()
- AJAX Callback Functions
-- woo_tumblog_ajax_post()
-- woo_tumblog_publish()
-- woo_tumblog_file_upload()
- Dashboard Widget
-- woo_tumblog_dashboard_widget_output()

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Register Actions
/*-----------------------------------------------------------------------------------*/

//Register Actions
add_action('wp_ajax_woo_tumblog_media_upload', 'woo_tumblog_file_upload');
add_action('wp_ajax_woo_tumblog_post', 'woo_tumblog_ajax_post');
add_action('wp_ajax_nopriv_woo_tumblog_post', 'woo_tumblog_ajax_post');
//Load scripts and libraries
add_action('admin_print_scripts', 'woo_load_tumblog_libraries');
add_action('admin_print_styles', 'woo_load_tumblog_css',10,1);
// Hook into the 'wp_dashboard_setup' action to register Tumblog Dashboard Widget
add_action('wp_dashboard_setup', 'woo_register_tumblog_dashboard_widget' );

//Adds the Tumblog Dashboard Widget to the WP Dashboard
function woo_register_tumblog_dashboard_widget() {
	wp_add_dashboard_widget('woo_tumblog_dashboard_widget', 'Tumblog', 'woo_tumblog_dashboard_widget_output');	
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;
	// Get the regular dashboard widgets array 
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	// Backup and delete dashboard widget from the end of the array
	$woo_tumblog_widget_backup = array('woo_tumblog_dashboard_widget' => $normal_dashboard['woo_tumblog_dashboard_widget']);
	unset($normal_dashboard['woo_tumblog_dashboard_widget']);
	// Merge the two arrays together so tumblog widget is at the beginning
	$sorted_dashboard = array_merge($woo_tumblog_widget_backup, $normal_dashboard);
	// Save the sorted array back into the original metaboxes 
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
} 
	
//Loads Tumblog javascript and php js functions
function woo_load_tumblog_libraries() {
	wp_enqueue_script('newscript', get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'.'/functions/js/tumblog-ajax.js', array('jquery', 'jquery-form'));
	wp_enqueue_script('nicedit', get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'.'/functions/js/nicEdit.js');
 	wp_enqueue_script('phpjs', get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog' .'/functions/js/php.js');
 	wp_enqueue_script('datepicker', get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'.'/functions/js/ui.datepicker.js',array('jquery'));
}    
	
	
//Load Tumblog CSS
function woo_load_tumblog_css($hook) {
	if ($hook == 'post.php' OR $hook == 'post-new.php' OR $hook == 'page-new.php' OR $hook == 'page.php' OR $_REQUEST['page'] == 'woothemes_sbm') {
	}
	else {
		echo "<link rel='stylesheet' id='colors-tabs' href='".get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'."/functions/css/tumblog_admin_styles.css' type='text/css' media='all' />";
		echo "<link rel='stylesheet' id='colors-tabs' href='".get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'."/functions/css/jquery-ui-datepicker.css' type='text/css' media='all' />";
	}   
}
	
/*-----------------------------------------------------------------------------------*/
/* AJAX Callback Functions
/*-----------------------------------------------------------------------------------*/

//Handles AJAX Form Post from Woo QuickPress
function woo_tumblog_ajax_post() {
	//Publish Article							
	if ($_POST['tumblog-type'] == 'article') 
	{
		$data = $_POST;
		$type = 'note';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Video
	elseif ($_POST['tumblog-type'] == 'video') 
	{
		$data = $_POST;
		$type = 'video';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Image
	elseif ($_POST['tumblog-type'] == 'image') 
	{
		$data = $_POST;
		$type = 'image';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Link
	elseif ($_POST['tumblog-type'] == 'link') 
	{
		$data = $_POST;
		$type = 'link';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Quote
	elseif ($_POST['tumblog-type'] == 'quote') 
	{
		$data = $_POST;
		$type = 'quote';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Publish Audio
		elseif ($_POST['tumblog-type'] == 'audio') 
	{
		$data = $_POST;	
		$type = 'audio';
		woo_tumblog_publish($type, $data);
		die ( 'OK' );
	}
	//Default
	else {
		die ( 'OK' );
	}
}
	
//Publishes the Tumblog Item
function woo_tumblog_publish($type, $data) {
	global $current_user;
    //Gets the current user's info
    get_currentuserinfo();
    //Set custom fields
	$tumblog_custom_fields = array(	'video-embed' => 'video-embed',
								'quote-copy' => 'quote-copy',
								'quote-author' => 'quote-author',
								'quote-url' => 'quote-url',
								'link-url' => 'link-url',
								'image-url' => 'image',
								'audio-url' => 'audio'
								);
	//get term ids
	$tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
							'images' 	=> get_option('woo_images_term_id'),
							'audio' 	=> get_option('woo_audio_term_id'),
							'video' 	=> get_option('woo_video_term_id'),
							'quotes'	=> get_option('woo_quotes_term_id'),
							'links' 	=> get_option('woo_links_term_id')
							);
	//Set date formatting
	$php_formatting = "Y-m-d H:i:s";
	//default post settings
	$tumbl_note = array();
	$tumbl_note['post_status'] = 'publish';
		
	//Handle Tumblog Types
	switch ($type) 
	{
    	case 'note':
        	//Create post object
  			$tumbl_note['post_title'] = $data['note-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
  				if ($data['tumblog-status'] != '') {
  					$tumbl_note['post_status'] = $data['tumblog-status'];
  				}
  				//Hours and Mins
  				$original_hours = (int)$data['original-tumblog-hours'];
  				$original_mins = (int)$data['original-tumblog-mins'];
  				$original_date = strtotime($data['original-tumblog-date']);
  				$posted_date = strtotime($data['tumblog-date']);
  				$note_hours = (int)$data['tumblog-hours'];
  				if ($note_hours == 0) { $note_hours = 12; }
  				elseif ($note_hours >= 24) { $note_hours = 0; }
  				$note_mins = (int)$data['tumblog-mins'];
  				if ($note_mins == 0) { $note_mins = 0; }
  				elseif ($note_mins >= 60) { $note_mins = 0; }
  				//Convert to Y-m-d H:i:s
  				//if everything is unchanged
  				if ( ($note_hours == $original_hours) && ($note_mins == $original_mins) && ($posted_date == $original_date) ) {
  					$time_now_hours = date_i18n("H");
					$time_now_mins = date_i18n("i");
  					$date_raw = date("Y").'-'.date("m").'-'.date("d").' '.$time_now_hours.':'.$time_now_mins.':00';
  				} else {
  					$date_raw = date("Y",strtotime($data['tumblog-date'])).'-'.date("m",strtotime($data['tumblog-date'])).'-'.date("d",strtotime($data['tumblog-date'])).' '.$note_hours.':'.$note_mins.':00';
  				}
  				$date_formatted = date($php_formatting, strtotime($date_raw));
  				$tumbl_note['post_date'] = $date_formatted;
  			}
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			
  			//Get Category from Theme Options
  			if (get_option('tumblog_woo_tumblog_upgraded') != 'true') {
  				$category_id = get_cat_ID( get_option('woo_articles_category') );
  				$categories = array($category_id);
  			} else {
  				$categories = array();
  			}
  			$post_cat_array = $data['post_category'];
  			if(empty($post_cat_array)) 
  			{
  			  //Do nothing
  			} else {
  				$N = count($post_cat_array);
  				for($i=0; $i < $N; $i++) {
  					array_push($categories, $post_cat_array[$i]);
  			  }
  			}
  			$tumbl_note['post_category'] = $categories;
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
  			if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
  				//update posts taxonomies
  				$taxonomy_data = $data['tax_input'];
  				if ( !empty($taxonomy_data) ) {
				foreach ( $taxonomy_data as $taxonomy => $tags ) {
					$taxonomy_obj = get_taxonomy($taxonomy);
					if ( is_array($tags) ) // array = hierarchical, string = non-hierarchical.
						$tags = array_filter($tags);
					if ( current_user_can($taxonomy_obj->cap->assign_terms) )
						array_push($tags, $tumblog_items['articles']);
					}
				} else {
					$tags[0] = $tumblog_items['articles'];
				}
				wp_set_post_terms( $post_id, $tags, 'tumblog' );
			}
        	break;
    	case 'video':
    	    //Create post object
  			$tumbl_note['post_title'] = $data['video-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
  				if ($data['tumblog-status'] != '') {
  					$tumbl_note['post_status'] = $data['tumblog-status'];
  				}
  				//Hours and Mins
  				$original_hours = (int)$data['original-tumblog-hours'];
  				$original_mins = (int)$data['original-tumblog-mins'];
  				$original_date = strtotime($data['original-tumblog-date']);
  				$posted_date = strtotime($data['tumblog-date']);
  				$note_hours = (int)$data['tumblog-hours'];
  				if ($note_hours == 0) { $note_hours = 12; }
  				elseif ($note_hours >= 24) { $note_hours = 0; }
  				$note_mins = (int)$data['tumblog-mins'];
  				if ($note_mins == 0) { $note_mins = 0; }
  				elseif ($note_mins >= 60) { $note_mins = 0; }
  				//Convert to Y-m-d H:i:s
  				//if everything is unchanged
  				if ( ($note_hours == $original_hours) && ($note_mins == $original_mins) && ($posted_date == $original_date) ) {
  					$time_now_hours = date_i18n("H");
					$time_now_mins = date_i18n("i");
  					$date_raw = date("Y").'-'.date("m").'-'.date("d").' '.$time_now_hours.':'.$time_now_mins.':00';
  				} else {
  					$date_raw = date("Y",strtotime($data['tumblog-date'])).'-'.date("m",strtotime($data['tumblog-date'])).'-'.date("d",strtotime($data['tumblog-date'])).' '.$note_hours.':'.$note_mins.':00';
  				}
  				$date_formatted = date($php_formatting, strtotime($date_raw));
  				$tumbl_note['post_date'] = $date_formatted;
  			}
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			if (get_option('tumblog_woo_tumblog_upgraded') != 'true') {
  				$category_id = get_cat_ID( get_option('woo_videos_category') );
  				$categories = array($category_id);
  			} else {
  				$categories = array();
  			}
  			$post_cat_array = $data['post_category'];
  			if(empty($post_cat_array)) 
  			{
  			  //Do nothing
  			} else {
  				$N = count($post_cat_array);
  				for($i=0; $i < $N; $i++) {
  					array_push($categories, $post_cat_array[$i]);
  			  }
  			}
  			$tumbl_note['post_category'] = $categories;
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
  			//Add Custom Field Data to the Post
    	    add_post_meta($post_id, $tumblog_custom_fields['video-embed'], $data['video-embed'], true);
    	    if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
    	    	//update posts taxonomies
  				$taxonomy_data = $data['tax_input'];
  				if ( !empty($taxonomy_data) ) {
				foreach ( $taxonomy_data as $taxonomy => $tags ) {
					$taxonomy_obj = get_taxonomy($taxonomy);
					if ( is_array($tags) ) // array = hierarchical, string = non-hierarchical.
						$tags = array_filter($tags);
					if ( current_user_can($taxonomy_obj->cap->assign_terms) )
						array_push($tags, $tumblog_items['video']);
					}
				} else {
					$tags[0] = $tumblog_items['video'];
				}
				wp_set_post_terms( $post_id, $tags, 'tumblog' );
			}
    	    break;
    	case 'image':
    	    //Create post object
  			$tumbl_note['post_title'] = $data['image-title'];
  			$tumbl_note['post_content'] = $data['tumblog-content'];
  			if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
  				if ($data['tumblog-status'] != '') {
  					$tumbl_note['post_status'] = $data['tumblog-status'];
  				}
  				//Hours and Mins
  				$original_hours = (int)$data['original-tumblog-hours'];
  				$original_mins = (int)$data['original-tumblog-mins'];
  				$original_date = strtotime($data['original-tumblog-date']);
  				$posted_date = strtotime($data['tumblog-date']);
  				$note_hours = (int)$data['tumblog-hours'];
  				if ($note_hours == 0) { $note_hours = 12; }
  				elseif ($note_hours >= 24) { $note_hours = 0; }
  				$note_mins = (int)$data['tumblog-mins'];
  				if ($note_mins == 0) { $note_mins = 0; }
  				elseif ($note_mins >= 60) { $note_mins = 0; }
  				//Convert to Y-m-d H:i:s
  				//if everything is unchanged
  				if ( ($note_hours == $original_hours) && ($note_mins == $original_mins) && ($posted_date == $original_date) ) {
  					$time_now_hours = date_i18n("H");
					$time_now_mins = date_i18n("i");
  					$date_raw = date("Y").'-'.date("m").'-'.date("d").' '.$time_now_hours.':'.$time_now_mins.':00';
  				} else {
  					$date_raw = date("Y",strtotime($data['tumblog-date'])).'-'.date("m",strtotime($data['tumblog-date'])).'-'.date("d",strtotime($data['tumblog-date'])).' '.$note_hours.':'.$note_mins.':00';
  				}
  				$date_formatted = date($php_formatting, strtotime($date_raw));
  				$tumbl_note['post_date'] = $date_formatted;
  			}
  			$tumbl_note['post_author'] = $current_user->ID;
  			$tumbl_note['tags_input'] = $data['tumblog-tags'];
  			//Get Category from Theme Options
  			if (get_option('tumblog_woo_tumblog_upgraded') != 'true') {
  				$category_id = get_cat_ID( get_option('woo_images_category') );
  				$categories = array($category_id);
  			} else {
  				$categories = array();
  			}
  			$post_cat_array = $data['post_category'];
  			if(empty($post_cat_array)) 
  			{
  			  //Do nothing
  			} else {
  				$N = count($post_cat_array);
  				for($i=0; $i < $N; $i++) {
  					array_push($categories, $post_cat_array[$i]);
  			  }
  			}
  			$tumbl_note['post_category'] = $categories;
			//Insert the note into the database
  			$post_id = wp_insert_post($tumbl_note);
			//Add Custom Field Data to the Post  	        	    
    	    if ($data['image-id'] > 0) {
    	    	$my_post = array();
    	    	$my_post['ID'] = $data['image-id'];
	 		 	$my_post['post_parent'] = $post_id;
				//Update the post into the database
  				wp_update_post( $my_post );
  				add_post_meta($post_id, $tumblog_custom_fields['image-url'], $data['image-upload'], true);
    	    }
    	    else {
    	    	add_post_meta($post_id, $tumblog_custom_fields['image-url'], $data['image-url'], true);
    	    } 
    	    if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { 	
    	    	//update posts taxonomies
  				$taxonomy_data = $data['tax_input'];
  				if ( !empty($taxonomy_data) ) {
				foreach ( $taxonomy_data as $taxonomy => $tags ) {
					$taxonomy_obj = get_taxonomy($taxonomy);
					if ( is_array($tags) ) // array = hierarchical, string = non-hierarchical.
						$tags = array_filter($tags);
					if ( current_user_can($taxonomy_obj->cap->assign_terms) )
						array_push($tags, $tumblog_items['images']);
					}
				} else {
					$tags[0] = $tumblog_items['images'];
				}
				wp_set_post_terms( $post_id, $tags, 'tumblog' );    
			}
	   	    break;
	   	case 'link':
	   	    //Create post object
			$tumbl_note['post_title'] = $data['link-title'];
			$tumbl_note['post_content'] = $data['tumblog-content'];
			if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
				if ($data['tumblog-status'] != '') {
	  				$tumbl_note['post_status'] = $data['tumblog-status'];
	  			}
	  			//Hours and Mins
  				$original_hours = (int)$data['original-tumblog-hours'];
  				$original_mins = (int)$data['original-tumblog-mins'];
  				$original_date = strtotime($data['original-tumblog-date']);
  				$posted_date = strtotime($data['tumblog-date']);
	  			$note_hours = (int)$data['tumblog-hours'];
	  			if ($note_hours == 0) { $note_hours = 12; }
	  			elseif ($note_hours >= 24) { $note_hours = 0; }
	  			$note_mins = (int)$data['tumblog-mins'];
	  			if ($note_mins == 0) { $note_mins = 0; }
	  			elseif ($note_mins >= 60) { $note_mins = 0; }
	  			//Convert to Y-m-d H:i:s
	  			//if everything is unchanged
  				if ( ($note_hours == $original_hours) && ($note_mins == $original_mins) && ($posted_date == $original_date) ) {
  					$time_now_hours = date_i18n("H");
					$time_now_mins = date_i18n("i");
  					$date_raw = date("Y").'-'.date("m").'-'.date("d").' '.$time_now_hours.':'.$time_now_mins.':00';
  				} else {
  					$date_raw = date("Y",strtotime($data['tumblog-date'])).'-'.date("m",strtotime($data['tumblog-date'])).'-'.date("d",strtotime($data['tumblog-date'])).' '.$note_hours.':'.$note_mins.':00';
  				}
	  			$date_formatted = date($php_formatting, strtotime($date_raw));
	  			$tumbl_note['post_date'] = $date_formatted;
	  		}
	  		$tumbl_note['post_author'] = $current_user->ID;
	  		$tumbl_note['tags_input'] = $data['tumblog-tags'];
	  		//Get Category from Theme Options
	  		if (get_option('tumblog_woo_tumblog_upgraded') != 'true') {
	  			$category_id = get_cat_ID( get_option('woo_links_category') );
	  			$categories = array($category_id);
	  		} else {
	  			$categories = array();
	  		}
	  		$post_cat_array = $data['post_category'];
	  		if(empty($post_cat_array)) 
	  		{
	  		  //Do nothing
	  		} else {
	  			$N = count($post_cat_array);
	  			for($i=0; $i < $N; $i++) {
	  				array_push($categories, $post_cat_array[$i]);
	  		  }
	  		}
	  		$tumbl_note['post_category'] = $categories;
			//Insert the note into the database
	  		$post_id = wp_insert_post($tumbl_note);
	  		//Add Custom Field Data to the Post
	  		add_post_meta($post_id, $tumblog_custom_fields['link-url'], $data['link-url'], true);
	  		if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
	  			//update posts taxonomies
	  			$taxonomy_data = $data['tax_input'];
	  			if ( !empty($taxonomy_data) ) {
				foreach ( $taxonomy_data as $taxonomy => $tags ) {
					$taxonomy_obj = get_taxonomy($taxonomy);
					if ( is_array($tags) ) // array = hierarchical, string = non-hierarchical.
						$tags = array_filter($tags);
					if ( current_user_can($taxonomy_obj->cap->assign_terms) )
						array_push($tags, $tumblog_items['links']);
					}
				} else {
					$tags[0] = $tumblog_items['links'];
				}
				wp_set_post_terms( $post_id, $tags, 'tumblog' );
			}
	        break;
	    case 'quote':
	        //Create post object
	  		$tumbl_note['post_title'] = $data['quote-title'];
	  		$tumbl_note['post_content'] = $data['tumblog-content'];
	  		if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
	  			if ($data['tumblog-status'] != '') {
	  				$tumbl_note['post_status'] = $data['tumblog-status'];
	  			}
	  			//Hours and Mins
  				$original_hours = (int)$data['original-tumblog-hours'];
  				$original_mins = (int)$data['original-tumblog-mins'];
  				$original_date = strtotime($data['original-tumblog-date']);
  				$posted_date = strtotime($data['tumblog-date']);
	  			$note_hours = (int)$data['tumblog-hours'];
	  			if ($note_hours == 0) { $note_hours = 12; }
	  			elseif ($note_hours >= 24) { $note_hours = 0; }
	  			$note_mins = (int)$data['tumblog-mins'];
	  			if ($note_mins == 0) { $note_mins = 0; }
	  			elseif ($note_mins >= 60) { $note_mins = 0; }
	  			//Convert to Y-m-d H:i:s
	  			//if everything is unchanged
  				if ( ($note_hours == $original_hours) && ($note_mins == $original_mins) && ($posted_date == $original_date) ) {
  					$time_now_hours = date_i18n("H");
					$time_now_mins = date_i18n("i");
  					$date_raw = date("Y").'-'.date("m").'-'.date("d").' '.$time_now_hours.':'.$time_now_mins.':00';
  				} else {
  					$date_raw = date("Y",strtotime($data['tumblog-date'])).'-'.date("m",strtotime($data['tumblog-date'])).'-'.date("d",strtotime($data['tumblog-date'])).' '.$note_hours.':'.$note_mins.':00';
  				}
	  			$date_formatted = date($php_formatting, strtotime($date_raw));
	  			$tumbl_note['post_date'] = $date_formatted;
	  		}
	  		$tumbl_note['post_author'] = $current_user->ID;
	  		$tumbl_note['tags_input'] = $data['tumblog-tags'];
	  		//Get Category from Theme Options
	  		if (get_option('tumblog_woo_tumblog_upgraded') != 'true') {
	  			$category_id = get_cat_ID( get_option('woo_quotes_category') );
	  			$categories = array($category_id);
	  		} else {
	  			$categories = array();
	  		}
	  		$post_cat_array = $data['post_category'];
	  		if(empty($post_cat_array)) 
	  		{
	  		  //Do nothing
	  		} else {
	  			$N = count($post_cat_array);
	  			for($i=0; $i < $N; $i++) {
	  				array_push($categories, $post_cat_array[$i]);
	  		  }
	  		}
	  		$tumbl_note['post_category'] = $categories;
			//Insert the note into the database
	  		$post_id = wp_insert_post($tumbl_note);
	        //Add Custom Field Data to the Post
	        add_post_meta($post_id, $tumblog_custom_fields['quote-copy'], $data['quote-copy'], true);
	        add_post_meta($post_id, $tumblog_custom_fields['quote-author'], $data['quote-author'], true);
	        add_post_meta($post_id, $tumblog_custom_fields['quote-url'], $data['quote-url'], true);
	        if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
	        	//update posts taxonomies
	  			$taxonomy_data = $data['tax_input'];
	  			if ( !empty($taxonomy_data) ) {
				foreach ( $taxonomy_data as $taxonomy => $tags ) {
					$taxonomy_obj = get_taxonomy($taxonomy);
					if ( is_array($tags) ) // array = hierarchical, string = non-hierarchical.
						$tags = array_filter($tags);
					if ( current_user_can($taxonomy_obj->cap->assign_terms) )
						array_push($tags, $tumblog_items['quotes']);
					}
				} else {
					$tags[0] = $tumblog_items['quotes'];
				}
				wp_set_post_terms( $post_id, $tags, 'tumblog' );
			}
	        break;
	    case 'audio':
	        //Create post object
	  		$tumbl_note['post_title'] = $data['audio-title'];
	  		$tumbl_note['post_content'] = $data['tumblog-content'];
	  		if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
	  			if ($data['tumblog-status'] != '') {
	  				$tumbl_note['post_status'] = $data['tumblog-status'];
	  			}
	  			//Hours and Mins
  				$original_hours = (int)$data['original-tumblog-hours'];
  				$original_mins = (int)$data['original-tumblog-mins'];
  				$original_date = strtotime($data['original-tumblog-date']);
  				$posted_date = strtotime($data['tumblog-date']);
	  			$note_hours = (int)$data['tumblog-hours'];
	  			if ($note_hours == 0) { $note_hours = 12; }
	  			elseif ($note_hours >= 24) { $note_hours = 0; }
	  			$note_mins = (int)$data['tumblog-mins'];
	  			if ($note_mins == 0) { $note_mins = 0; }
	  			elseif ($note_mins >= 60) { $note_mins = 0; }
	  			//Convert to Y-m-d H:i:s
	  			//if everything is unchanged
  				if ( ($note_hours == $original_hours) && ($note_mins == $original_mins) && ($posted_date == $original_date) ) {
  					$time_now_hours = date_i18n("H");
					$time_now_mins = date_i18n("i");
  					$date_raw = date("Y").'-'.date("m").'-'.date("d").' '.$time_now_hours.':'.$time_now_mins.':00';
  				} else {
  					$date_raw = date("Y",strtotime($data['tumblog-date'])).'-'.date("m",strtotime($data['tumblog-date'])).'-'.date("d",strtotime($data['tumblog-date'])).' '.$note_hours.':'.$note_mins.':00';
  				}
	  			$date_formatted = date($php_formatting, strtotime($date_raw));
	  			$tumbl_note['post_date'] = $date_formatted;
	  		}
	  		$tumbl_note['post_author'] = $current_user->ID;
	  		$tumbl_note['tags_input'] = $data['tumblog-tags'];
	  		//Get Category from Theme Options
	  		if (get_option('tumblog_woo_tumblog_upgraded') != 'true') {
	  			$category_id = get_cat_ID( get_option('woo_audio_category') );
	  			$categories = array($category_id);
	  		} else {
	  			$categories = array();
	  		}
	  		$post_cat_array = $data['post_category'];
	  		if(empty($post_cat_array)) 
	  		{
	  		  //Do nothing
	  		} else {
	  			$N = count($post_cat_array);
	  			for($i=0; $i < $N; $i++) {
	  				array_push($categories, $post_cat_array[$i]);
	  		  }
	  		}
	  		$tumbl_note['post_category'] = $categories;
			//Insert the note into the database
	  		$post_id = wp_insert_post($tumbl_note);
	        //Add Custom Field Data to the Post
	        if ($data['audio-id'] > 0) {
	        	$my_post = array();
	        	$my_post['ID'] = $data['audio-id'];
			 	$my_post['post_parent'] = $post_id;
				//Update the post into the database
	  			wp_update_post( $my_post );
	  			add_post_meta($post_id, $tumblog_custom_fields['audio-url'], $data['audio-upload'], true);
	        }
	        else {
	        	add_post_meta($post_id, $tumblog_custom_fields['audio-url'], $data['audio-url'], true);
	    	}
	    	if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
	    	   	//update posts taxonomies
	  			$taxonomy_data = $data['tax_input'];
	  			if ( !empty($taxonomy_data) ) {
				foreach ( $taxonomy_data as $taxonomy => $tags ) {
					$taxonomy_obj = get_taxonomy($taxonomy);
					if ( is_array($tags) ) // array = hierarchical, string = non-hierarchical.
						$tags = array_filter($tags);
					if ( current_user_can($taxonomy_obj->cap->assign_terms) )
						array_push($tags, $tumblog_items['audio']);
					}
				} else {
					$tags[0] = $tumblog_items['audio'];
				}
				wp_set_post_terms( $post_id, $tags, 'tumblog' );
			}
	        break;
	    default:
	    	break;
	}
}
	
//Handles AJAX Post
function woo_tumblog_file_upload() {
	global $wpdb; 
	//Upload overrides
	$filename = $_FILES['userfile']; // [name] [tmp_name]
	$override['test_form'] = false;
	$override['action'] = 'wp_handle_upload';    
	//Handle Uploaded File	
	$uploaded_file = wp_handle_upload($filename, $override); // [file] [url] [type]
	//Create Attachment Object	
	$attachment['post_title'] = $filename['name']; //post_title, post_content (the value for this key should be the empty string), post_status and post_mime_type
	$attachment['post_content'] = '';
	$attachment['post_status'] = 'inherit';
	$attachment['post_mime_type'] = $uploaded_file['type'];
	$attachment['guid'] = $uploaded_file['url'];
	//Prepare file attachment
	$wud = wp_upload_dir(); // [path] [url] [subdir] [basedir] [baseurl] [error] 
	$filename_attach = $wud['basedir'].$uploaded_file['file'];
	//Insert Attachment
	$attach_id = wp_insert_attachment( $attachment, $filename_attach, 0 );
  	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename_attach );
  	wp_update_attachment_metadata( $attach_id,  $attach_data );
	//Handle Errors and Response
	if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
	else { echo $uploaded_file['url'].'|'.$attach_id.'|'; } // Is the Response
}
	
/*-----------------------------------------------------------------------------------*/
/* Dashboard Widget
/*-----------------------------------------------------------------------------------*/

// Tumblog Dashboard Widget Output
function woo_tumblog_dashboard_widget_output() {
	//security check
	if (current_user_can('publish_posts')) {
		$tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
								'images' 	=> get_option('woo_images_term_id'),
								'audio' 	=> get_option('woo_audio_term_id'),
								'video' 	=> get_option('woo_video_term_id'),
								'quotes'	=> get_option('woo_quotes_term_id'),
								'links' 	=> get_option('woo_links_term_id')
								);
		?>
		<script type="text/javascript" src="<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/js/ajaxupload.js"></script>
		<script type="text/javascript">
		//No Conflict Mode
		jQuery.noConflict();
		//AJAX Functions
		jQuery(document).ready(function(){
		
			 //JQUERY DATEPICKER
			jQuery('.date-picker').each(function (){
				jQuery('#' + jQuery(this).attr('id')).datepicker({showOn: 'button', buttonImage: '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog';?>/functions/images/calendar.gif', buttonImageOnly: true});
			});
			
			jQuery('#advanced-options-toggle').click(function () {
				jQuery('#meta-fields').toggle();
				if ( jQuery(this).text() == 'View Advanced Options' ) {
					jQuery(this).text('Hide Advanced Options');
				} else {
					jQuery(this).text('View Advanced Options');
				}
			});
			
			//MENU BUTTON CLICK EVENTS
			jQuery('#articles-menu-button').click(function ()
			{
				jQuery('#article-fields').removeAttr('class');
				jQuery('#image-fields').removeAttr('class');
				jQuery('#image-fields').attr('class','hide-fields');
				jQuery('#link-fields').removeAttr('class');
				jQuery('#link-fields').attr('class','hide-fields');
				jQuery('#audio-fields').removeAttr('class');
				jQuery('#audio-fields').attr('class','hide-fields');
				jQuery('#video-fields').removeAttr('class');
				jQuery('#video-fields').attr('class','hide-fields');
				jQuery('#quote-fields').removeAttr('class');
				jQuery('#quote-fields').attr('class','hide-fields');
				jQuery('#tumblog-submit-fields').removeAttr('class');
				jQuery('#tumblog-type').attr('value','article');
				jQuery('#content-fields').removeAttr('class');
				jQuery('#tag-fields').removeAttr('class');
				<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?>
				//Additional Tumblogs Checks
				jQuery('#additional-tumblogs input').each(function(){
					
					var elementid = jQuery(this).val();
					<?php $term_array = &get_term( $tumblog_items['articles'], 'tumblog'); ?>
					var catid = <?php echo $tumblog_items['articles']; ?>;
					
					if (elementid == catid) {
						//make invisible
						jQuery(this).addClass('hide-cat');
						jQuery(this).attr('checked', false);
					} else {
						//make visible
						jQuery(this).removeAttr('class');
						jQuery(this).attr('checked', false);	
					}
				});
				
				jQuery('#additional-tumblogs li').each(function(){
					
					var elementname = jQuery(this).text();
					var catname = '<?php echo $term_array->name; ?>';
					var elementnamesub = elementname.substring(1); 
					
					if (elementnamesub == catname) {
						//make invisible
						jQuery(this).addClass('hide-cat');
					} else {
						//make visible
						jQuery(this).removeAttr('class');
					}
				});
				<?php } ?>
				if (nicEditors.findEditor('test-content') == undefined) {
					myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
				} else {
					myNicEditor = nicEditors.findEditor('test-content');
				}	
				jQuery('#note-title').focus();	
				nicEditors.findEditor('test-content').setContent('');
				jQuery('#content-fields > div').addClass('editorwidth');		
			});
			jQuery('#images-menu-button').click(function ()
			{
				jQuery('#image-fields').removeAttr('class');
				jQuery('#article-fields').removeAttr('class');
				jQuery('#article-fields').attr('class','hide-fields');
				jQuery('#link-fields').removeAttr('class');
				jQuery('#link-fields').attr('class','hide-fields');
				jQuery('#audio-fields').removeAttr('class');
				jQuery('#audio-fields').attr('class','hide-fields');
				jQuery('#video-fields').removeAttr('class');
				jQuery('#video-fields').attr('class','hide-fields');
				jQuery('#quote-fields').removeAttr('class');
				jQuery('#quote-fields').attr('class','hide-fields');
				jQuery('#tumblog-submit-fields').removeAttr('class');
				jQuery('#tumblog-type').attr('value','image');
				jQuery('#content-fields').removeAttr('class');
				jQuery('#tag-fields').removeAttr('class');
				<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?>
				//Additional Tumblogs Checks
				jQuery('#additional-tumblogs input').each(function(){
					
					var elementid = jQuery(this).val();
					<?php $term_array = &get_term( $tumblog_items['images'], 'tumblog'); ?>
					var catid = <?php echo $tumblog_items['images']; ?>;
					
					if (elementid == catid) {
						//make invisible
						jQuery(this).addClass('hide-cat');
						jQuery(this).attr('checked', false);
					} else {
						//make visible
						jQuery(this).removeAttr('class');
						jQuery(this).attr('checked', false);	
					}
				});
				
				jQuery('#additional-tumblogs li').each(function(){
					
					var elementname = jQuery(this).text();
					var catname = '<?php echo $term_array->name; ?>';
					var elementnamesub = elementname.substring(1); 
					
					if (elementnamesub == catname) {
						//make invisible
						jQuery(this).addClass('hide-cat');
					} else {
						//make visible
						jQuery(this).removeAttr('class');
					}
				});
				<?php } ?>
				if (nicEditors.findEditor('test-content') == undefined) {
					myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
				} else {
					myNicEditor = nicEditors.findEditor('test-content');
				}	
				jQuery('#image-title').focus();	
				nicEditors.findEditor('test-content').setContent('');
				jQuery('#content-fields > div').addClass('editorwidth');
			});
			jQuery('#links-menu-button').click(function ()
			{
				jQuery('#link-fields').removeAttr('class');
				jQuery('#image-fields').removeAttr('class');
				jQuery('#image-fields').attr('class','hide-fields');
				jQuery('#article-fields').removeAttr('class');
				jQuery('#article-fields').attr('class','hide-fields');
				jQuery('#audio-fields').removeAttr('class');
				jQuery('#audio-fields').attr('class','hide-fields');
				jQuery('#video-fields').removeAttr('class');
				jQuery('#video-fields').attr('class','hide-fields');
				jQuery('#quote-fields').removeAttr('class');
				jQuery('#quote-fields').attr('class','hide-fields');
				jQuery('#tumblog-submit-fields').removeAttr('class');
				jQuery('#tumblog-type').attr('value','link');
				jQuery('#content-fields').removeAttr('class');
				jQuery('#tag-fields').removeAttr('class');
				<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?>
				//Additional Tumblogs Checks
				jQuery('#additional-tumblogs input').each(function(){
					
					var elementid = jQuery(this).val();
					<?php $term_array = &get_term( $tumblog_items['links'], 'tumblog'); ?>
					var catid = <?php echo $tumblog_items['links']; ?>;
					
					if (elementid == catid) {
						//make invisible
						jQuery(this).addClass('hide-cat');
						jQuery(this).attr('checked', false);
					} else {
						//make visible
						jQuery(this).removeAttr('class');
						jQuery(this).attr('checked', false);	
					}
				});
				
				jQuery('#additional-tumblogs li').each(function(){
					
					var elementname = jQuery(this).text();
					var catname = '<?php echo $term_array->name; ?>';
					var elementnamesub = elementname.substring(1); 
					
					if (elementnamesub == catname) {
						//make invisible
						jQuery(this).addClass('hide-cat');
					} else {
						//make visible
						jQuery(this).removeAttr('class');
					}
				});
				<?php } ?>
				if (nicEditors.findEditor('test-content') == undefined) {
					myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
				} else {
					myNicEditor = nicEditors.findEditor('test-content');
				}	
				jQuery('#link-title').focus();	
				nicEditors.findEditor('test-content').setContent('');
				jQuery('#content-fields > div').addClass('editorwidth');
			});
			jQuery('#audio-menu-button').click(function ()
			{
				jQuery('#audio-fields').removeAttr('class');
				jQuery('#image-fields').removeAttr('class');
				jQuery('#image-fields').attr('class','hide-fields');
				jQuery('#link-fields').removeAttr('class');
				jQuery('#link-fields').attr('class','hide-fields');
				jQuery('#article-fields').removeAttr('class');
				jQuery('#article-fields').attr('class','hide-fields');
				jQuery('#video-fields').removeAttr('class');
				jQuery('#video-fields').attr('class','hide-fields');
				jQuery('#quote-fields').removeAttr('class');
				jQuery('#quote-fields').attr('class','hide-fields');
				jQuery('#tumblog-submit-fields').removeAttr('class');
				jQuery('#tumblog-type').attr('value','audio');
				jQuery('#content-fields').removeAttr('class');
				jQuery('#tag-fields').removeAttr('class');
				<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?>
				//Additional Tumblogs Checks
				jQuery('#additional-tumblogs input').each(function(){
					
					var elementid = jQuery(this).val();
					<?php $term_array = &get_term( $tumblog_items['audio'], 'tumblog'); ?>
					var catid = <?php echo $tumblog_items['audio']; ?>;
					
					if (elementid == catid) {
						//make invisible
						jQuery(this).addClass('hide-cat');
						jQuery(this).attr('checked', false);
					} else {
						//make visible
						jQuery(this).removeAttr('class');
						jQuery(this).attr('checked', false);	
					}
				});
				
				jQuery('#additional-tumblogs li').each(function(){
					
					var elementname = jQuery(this).text();
					var catname = '<?php echo $term_array->name; ?>';
					var elementnamesub = elementname.substring(1); 
					
					if (elementnamesub == catname) {
						//make invisible
						jQuery(this).addClass('hide-cat');
					} else {
						//make visible
						jQuery(this).removeAttr('class');
					}
				});
				<?php } ?>
				if (nicEditors.findEditor('test-content') == undefined) {
					myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
				} else {
					myNicEditor = nicEditors.findEditor('test-content');
				}	
				jQuery('#audio-title').focus();	
				nicEditors.findEditor('test-content').setContent('');
				jQuery('#content-fields > div').addClass('editorwidth');
			});
			jQuery('#videos-menu-button').click(function ()
			{
				jQuery('#video-fields').removeAttr('class');
				jQuery('#image-fields').removeAttr('class');
				jQuery('#image-fields').attr('class','hide-fields');
				jQuery('#link-fields').removeAttr('class');
				jQuery('#link-fields').attr('class','hide-fields');
				jQuery('#audio-fields').removeAttr('class');
				jQuery('#audio-fields').attr('class','hide-fields');
				jQuery('#article-fields').removeAttr('class');
				jQuery('#article-fields').attr('class','hide-fields');
				jQuery('#quote-fields').removeAttr('class');
				jQuery('#quote-fields').attr('class','hide-fields');
				jQuery('#tumblog-submit-fields').removeAttr('class');
				jQuery('#tumblog-type').attr('value','video');
				jQuery('#content-fields').removeAttr('class');
				jQuery('#tag-fields').removeAttr('class');
				<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?>
				//Additional Tumblogs Checks
				jQuery('#additional-tumblogs input').each(function(){
					
					var elementid = jQuery(this).val();
					<?php $term_array = &get_term( $tumblog_items['video'], 'tumblog'); ?>
					var catid = <?php echo $tumblog_items['video']; ?>;
					
					if (elementid == catid) {
						//make invisible
						jQuery(this).addClass('hide-cat');
						jQuery(this).attr('checked', false);
					} else {
						//make visible
						jQuery(this).removeAttr('class');
						jQuery(this).attr('checked', false);	
					}
				});
				
				jQuery('#additional-tumblogs li').each(function(){
					
					var elementname = jQuery(this).text();
					var catname = '<?php echo $term_array->name; ?>';
					var elementnamesub = elementname.substring(1); 
					
					if (elementnamesub == catname) {
						//make invisible
						jQuery(this).addClass('hide-cat');
					} else {
						//make visible
						jQuery(this).removeAttr('class');
					}
				});
				<?php } ?>
				if (nicEditors.findEditor('test-content') == undefined) {
					myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
				} else {
					myNicEditor = nicEditors.findEditor('test-content');
				}	
				jQuery('#video-title').focus();	
				nicEditors.findEditor('test-content').setContent('');
				jQuery('#content-fields > div').addClass('editorwidth');
			});
			jQuery('#quotes-menu-button').click(function ()
			{
				jQuery('#quote-fields').removeAttr('class');
				jQuery('#image-fields').removeAttr('class');
				jQuery('#image-fields').attr('class','hide-fields');
				jQuery('#link-fields').removeAttr('class');
				jQuery('#link-fields').attr('class','hide-fields');
				jQuery('#audio-fields').removeAttr('class');
				jQuery('#audio-fields').attr('class','hide-fields');
				jQuery('#video-fields').removeAttr('class');
				jQuery('#video-fields').attr('class','hide-fields');
				jQuery('#article-fields').removeAttr('class');
				jQuery('#article-fields').attr('class','hide-fields');
				jQuery('#tumblog-submit-fields').removeAttr('class');
				jQuery('#tumblog-type').attr('value','quote');
				jQuery('#content-fields').removeAttr('class');
				jQuery('#tag-fields').removeAttr('class');
				<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?>
				//Additional Tumblogs Checks
				jQuery('#additional-tumblogs input').each(function(){
					
					var elementid = jQuery(this).val();
					<?php $term_array = &get_term( $tumblog_items['quotes'], 'tumblog'); ?>
					var catid = <?php echo $tumblog_items['quotes']; ?>;
					
					if (elementid == catid) {
						//make invisible
						jQuery(this).addClass('hide-cat');
						jQuery(this).attr('checked', false);
					} else {
						//make visible
						jQuery(this).removeAttr('class');
						jQuery(this).attr('checked', false);	
					}
				});
				
				jQuery('#additional-tumblogs li').each(function(){
					
					var elementname = jQuery(this).text();
					var catname = '<?php echo $term_array->name; ?>';
					var elementnamesub = elementname.substring(1); 
					
					if (elementnamesub == catname) {
						//make invisible
						jQuery(this).addClass('hide-cat');
					} else {
						//make visible
						jQuery(this).removeAttr('class');
					}
				});
				<?php } ?>
				if (nicEditors.findEditor('test-content') == undefined) {
					myNicEditor = new nicEditor({ buttonList : ['bold','italic','underline','ol','ul','left','center','right','justify','link','unlink','strikeThrough','xhtml','image'], iconsPath : '<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/nicEditorIcons.gif'}).panelInstance('test-content');
				} else {
					myNicEditor = nicEditors.findEditor('test-content');
				}	
				jQuery('#quote-title').focus();	
				nicEditors.findEditor('test-content').setContent('');
				jQuery('#content-fields > div').addClass('editorwidth');
			});
			
			
			//AJAX FORM POST
			jQuery('#tumblog-form').ajaxForm(
			{
	  			name: 'formpost',
	  			data: { // Additional data to send
							action: 'woo_tumblog_post',
							type: 'upload',
							data: 'formpost' },
				// handler function for success event 
				success: function(responseText, statusText) 
					{
						jQuery('#test-response').html('<span class="success">'+'Published!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
						jQuery('#ajax-loader').hide();
						resetTumblogQuickPress();
					},
				// handler function for errors 
				error: function(request) 
				{
					// parse it for WordPress error 
					if (request.responseText.search(/<title>WordPress &rsaquo; Error<\/title>/) != -1) 
					{
						var data = request.responseText.match(/<p>(.*)<\/p>/); 
						jQuery('#test-response').html('<span class="error">'+ data[1] +'</span>');
					} 
					else 
					{
						jQuery('#test-response').html('<span class="error">An error occurred, please notify the administrator.</span>');
					} 
				},
				beforeSubmit: function(formData, jqForm, options) 
				{
					jQuery('#ajax-loader').show();
				} 
			});
			//AJAX IMAGE UPLOAD
			new AjaxUpload('#image_upload_button', {
	  			action: '<?php echo admin_url("admin-ajax.php"); ?>',
	  			name: 'userfile',
	  			data: { // Additional data to send
							action: 'woo_tumblog_media_upload',
							type: 'upload',
							data: 'userfile' },
	  			onSubmit : function(file , ext){ 
	        	        if (! (ext && /^(jpg|png|jpeg|gif|bmp|tiff|tif|ico|jpe)$/.test(ext))){
	           	             // extension is not allowed
	           	             alert('Error: invalid file extension');
	           	             // cancel upload
	           	             return false;
	           	     	}
	           	     	else {
	           	     		jQuery('#test-response').html('<span class="success">'+'Image Uploading...'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000);
	           	     	}
	        	},
				onComplete: function(file, response) {
					jQuery('#test-response').html('<span class="success">'+'Image Uploaded!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					var splitResults = response.split('|');
					jQuery('#image-upload').attr('value',splitResults[0]);		
					jQuery('#image-id').attr('value',splitResults[1]);
				}
			});
			//AJAX AUDIO UPLOAD
			new AjaxUpload('#audio_upload_button', {
	  			action: '<?php echo admin_url("admin-ajax.php"); ?>',
	  			name: 'userfile',
	  			data: { // Additional data to send
							action: 'woo_tumblog_media_upload',
							type: 'upload',
							data: 'userfile' },
	  			onSubmit : function(file , ext){
	        	        if (! (ext && /^(mp3|mp4|ogg|wma|midi|mid|wav|wmx|wmv|avi|mov|qt|mpeg|mpg|asx|asf)$/.test(ext))){
	           	             // extension is not allowed
	           	             alert('Error: invalid file extension');
	           	             // cancel upload
	           	             return false;
	           	     	}
	           	     	else {
	           	     		jQuery('#test-response').html('<span class="success">'+'Audio Uploading...'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000);
	           	     	}
	        	},
				onComplete: function(file, response) {
					jQuery('#test-response').html('<span class="success">'+'Audio Uploaded!'+'</span>').fadeIn('3000').animate({ opacity: 1.0 },2000).fadeOut();
					var splitResults = response.split('|');
					jQuery('#audio-upload').attr('value',splitResults[0]);		
					jQuery('#audio-id').attr('value',splitResults[1]);
				}
			});
		});
		
		</script>
	<div id="tumblog-post">
	
		<form name="tumblog-form" onsubmit="updateContent();" id="tumblog-form" method="post" action="<?php echo admin_url("admin-ajax.php"); ?>">
	
		<img id="ajax-loader" src="<?php echo get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog'; ?>/functions/images/ajax-loader.gif" />
	
		<div id="test-response"></div>
	
		<div id="tumblog-menu">
			<a id="articles-menu-button" href="#" title="#">Article</a>
			<a id="images-menu-button" href="#" title="#">Image</a>
			<a id="links-menu-button" href="#" title="#">Link</a>
			<a id="audio-menu-button" href="#" title="#">Audio</a>
			<a id="videos-menu-button" href="#" title="#">Video</a>
			<a id="quotes-menu-button" href="#" title="#">Quote</a>
		</div>
	
		<div id="article-fields" class="hide-fields">
			<h4 id="quick-post-title"><label for="note-title">Title</label></h4>
			<div>
				<input name="note-title" id="note-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
			</div>
		</div>
	
		<div id="video-fields" class="hide-fields">
			<h4 id="quick-post-title"><label for="video-title">Title</label></h4>
			<div>
				<input name="video-title" id="video-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
			</div>
			<h4 id="quick-post-title"><label for="video-embed">Embed Video Code</label></h4>
			<textarea style="width:100%" id="video-embed" name="video-embed" tabindex="2"></textarea>
		</div>
		
		<div id="image-fields" class="hide-fields">
			<h4 id="quick-post-title"><label for="image-title">Title</label></h4>
			<div>
				<input name="image-title" id="image-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
			</div>
			<div id="image-option-upload" style="display:none;">
				<h4 id="quick-post-title"><label for="image-upload">Upload Image</label> | <label id="image-url-button">Image URL instead</label></h4>
				<div>
					<input name="image-upload" id="image-upload" tabindex="2" autocomplete="off" value="" type="text">
				</div>
				<input name="image_upload_button" type="button" id="image_upload_button" class="button" value="Upload Image" />
			</div>
			<div id="image-option-url">
				<h4 id="quick-post-title"><label for="image-url">Image URL</label> | <label id="image-upload-button">Upload Image instead</label></h4>
				<div>
					<input name="image-url" id="image-url" tabindex="2" autocomplete="off" value="" type="text">
				</div>
			</div>
			<input type="hidden" id="image-id" name="image-id" value="" />
		</div>
		
		<div id="link-fields" class="hide-fields">
			<h4 id="quick-post-title"><label for="link-title">Title</label></h4>
			<div>
				<input name="link-title" id="link-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
			</div>
			<h4 id="quick-post-title"><label for="link-url">Link URL</label></h4>
			<div>
				<input name="link-url" id="link-url" tabindex="2" autocomplete="off" value="" type="text">
			</div>
		</div>
		
		<div id="quote-fields" class="hide-fields">
			<h4 id="quick-post-title"><label for="quote-title">Title</label></h4>
			<div>
				<input name="quote-title" id="quote-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
			</div>
			<h4 id="quick-post-title"><label for="quote-copy">Quote</label></h4>
			<textarea style="width:100%" id="quote-copy" name="quote-copy" tabindex="2"></textarea>
			<h4 id="quick-post-title"><label for="quote-url">Quote URL</label></h4>
			<div>
				<input name="quote-url" id="quote-url" tabindex="3" autocomplete="off" value="" type="text">
			</div>
			<h4 id="quick-post-title"><label for="quote-quote">Quote Author</label></h4>
			<div>
				<input name="quote-author" id="quote-author" tabindex="4" autocomplete="off" value="" type="text">
			</div>
		</div>
		
		<div id="audio-fields" class="hide-fields">
			<h4 id="quick-post-title"><label for="audio-title">Title</label></h4>
			<div>
				<input name="audio-title" id="audio-title" tabindex="1" autocomplete="off" value="" type="text" class="tumblog-title">
			</div>
			<div id="audio-option-upload" style="display:none;">
				<h4 id="quick-post-title"><label for="audio-upload">Upload Audio</label> | <label id="audio-url-button">Audio URL instead</label></h4>
				<div>
					<input name="audio-upload" id="audio-upload" tabindex="2" autocomplete="off" value="" type="text">
				</div>
				<input name="audio_upload_button" type="button" id="audio_upload_button" class="button" value="Upload Audio" />
			</div>
			<div id="audio-option-url">
				<h4 id="quick-post-title"><label for="audio-url">Audio URL</label> | <label id="audio-upload-button">Upload Audio instead</label></h4>
				<div>
					<input name="audio-url" id="audio-url" tabindex="2" autocomplete="off" value="" type="text">
				</div>
			</div>
			<input type="hidden" id="audio-id" name="audio-id" value="" />
		</div>
		
		<div id="content-fields" class="hide-fields">
			<?php if ( current_user_can( 'upload_files' ) ) : ?>
				<?php //the_editor('', $id = 'content', $prev_id = 'title', $media_buttons = false, $tab_index = 5); ?>
				<textarea tabindex="5" id="test-content" style="width:100%;height:100px;"></textarea>
			<?php endif; ?>
			<input type="hidden" id="tumblog-content" name="tumblog-content" value="" />
			<input type="hidden" id="tumblog-type" name="tumblog-type" value="article" />
			<?php if (get_option('tumblog_woo_tumblog_upgraded') == 'true') { ?><p><a id="advanced-options-toggle" onclick="">View Advanced Options</a></p><?php } ?>
		</div>
		
		<div id="meta-fields" class="hide-fields">
			<p>
				<?php // START - POST STATUS AND DATE TIME ?>
				<strong><label for="tumblog-status">Post Status : </label></strong> <select style="margin-left:10px;" id="tumblog-status" name="tumblog-status" tabindex="6">
					<option value="publish">Published</option>
					<option value="draft">Draft</option>
				</select>
			</p>
			<p>
				<?php $date_formatted = date_i18n("m/d/Y"); ?>
				<?php $time_now_hours = date_i18n("H"); ?>
				<?php $time_now_mins = date_i18n("i"); ?>
				<?php $post_id = 0; ?>
				<strong><label for="tumblog-date">Post Date : </label></strong> <input name="tumblog-date" id="tumblog-date" tabindex="7" value="<?php echo $date_formatted; ?>" type="text" class="date-picker" style="width:100px;margin-left:20px;"> @ <input class="tumblog-time" name="tumblog-hours" id="tumblog-hours" maxlength="2" size="2" value="<?php echo $time_now_hours; ?>" type="text">:<input class="tumblog-time" name="tumblog-mins" id="tumblog-mins" maxlength="2" size="2" value="<?php echo $time_now_mins; ?>" type="text">
				<?php // END - POST STATUS AND DATE TIME ?>
			</p>
			<br />
			<div id="additional-categories" style="width:47%;float:left;">
				<strong><label for="post_category[]">Additional Categories : </label></strong> 
				<?php // START - MULTI CATEGORY DROP DOWN ?>
				<?php $taxonomy = 'category'; ?>
				<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel" style="height:100px;overflow:auto;border: 1px solid #CCCCCC;margin-top:6px;margin-bottom:6px;">
				<?php
	            $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
	            ?>
				<ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
					<?php if ( function_exists('wp_terms_checklist') ) { wp_terms_checklist($post_id, array( 'taxonomy' => $taxonomy ) ); ?>
					<?php } else { wp_category_checklist(); } ?>
				</ul>
				<?php // END - MULTI CATEGORY DROP DOWN ?>
				</div>
			</div>
			<div id="additional-tumblogs" style="width:47%;float:right;">
				<strong><label for="post_tumblog[]">Additional Tumblogs : </label></strong> 
				<?php // START - MULTI TUMBLOG DROP DOWN ?>
				<?php $taxonomy = 'tumblog'; ?>
				<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel" style="height:100px;overflow:auto;border: 1px solid #CCCCCC;margin-top:6px;margin-bottom:6px;">
				<?php
	            $name = ( $taxonomy == 'tumblog' ) ? 'post_tumblog' : 'tax_input[' . $taxonomy . ']';
	            ?>
				<ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
					<?php if ( function_exists('wp_terms_checklist') ) { wp_terms_checklist($post_id, array( 'taxonomy' => $taxonomy ) ); ?>
					<?php } else { wp_category_checklist(); } ?>
				</ul>
				<?php // END - MULTI TUMBLOG DROP DOWN ?>
				</div>
			</div>
		</div>
		
		<div id="tag-fields" class="hide-fields" style="clear:both;padding-top:10px;">
			<h4 id="tumblog-tags-title"><label for="tumblog-tags">Tags</label></h4>
			<div>
				<input name="tumblog-tags" id="tumblog-tags" tabindex="6" autocomplete="off" value="" type="text">
			</div>
		</div>
		
		<div id="tumblog-submit-fields" class="hide-fields">
			<input name="tumblogsubmit" type="submit" id="tumblogsubmit" class="button-primary" tabindex="7" value="Submit" onclick="return validateInput();" />
			<input name="tumblogreset" type="reset" id="tumblogreset" class="button" tabindex="8" value="Reset" />
		</div>
		
		</form>
		
	</div><div id="debug-tumblog"></div>
		
	<?php
	}
} 

?>
