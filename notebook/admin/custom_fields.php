<?php
$new_meta_boxes = 
array(

"price" => array(
"name" => "price",
"type" => "input",
"std" => "",
"title" => "Price",
"description" => "Enter the price here."),

"sqft" => array(
"name" => "sqft",
"type" => "input",
"std" => "",
"title" => "Sq Ft",
"description" => "Enter the square footage here."),

"lotsize" => array(
"name" => "lotsize",
"type" => "input",
"std" => "",
"title" => "Lot Size",
"description" => "Enter the lot size here."),

"mls" => array(
"name" => "mls",
"type" => "input",
"std" => "",
"title" => "MLS #",
"description" => "Enter the MLS # here."),

"latlng" => array(
"name" => "latlng",
"type" => "input",
"std" => "",
"title" => "Latitude &amp; Longitude",
"description" => "<strong>OPTIONAL:</strong> Only use the latitude and longitude if the regular full address can't be found. (ex: 37.4419, -122.1419)"),
);

$new_meta_boxes_3 = 
array(
"video" => array(
"name" => "video",
"type" => "textarea",
"std" => "",
"title" => "Video Embed Code",
"description" => "Paste your video embed code here. Recommended video size - 625x352"),
);

function new_meta_boxes() {
global $post, $new_meta_boxes, $new_meta_boxes_3;
	
	foreach($new_meta_boxes as $meta_box) {
		
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		
		echo'<h2 style="margin-bottom: 5px; padding-bottom: 0;">'.$meta_box['title'].'</h2>';
		
		if( $meta_box['type'] == "input" ) { 
		
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
		
			if($meta_box_value == "")
				$meta_box_value = $meta_box['std'];
		
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" size="55" /><br />';
			
		} elseif ( $meta_box['type'] == "select" ) {
			
			echo'<select name="'.$meta_box['name'].'_value">';
			
			foreach ($meta_box['options'] as $option) {
                
				echo'<option';
				if ( get_post_meta($post->ID, $meta_box['name'].'_value', true) == $option ) { 
					echo ' selected="selected"'; 
				} elseif ( $option == $meta_box['std'] ) { 
					echo ' selected="selected"'; 
				} 
				echo'>'. $option .'</option>';
			
			}
			
			echo'</select>';
			
		}
		
		echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';
	}

}

function new_meta_boxes_3() {
global $post, $new_meta_boxes, $new_meta_boxes_3;
	
	foreach($new_meta_boxes_3 as $meta_box) {
		
		echo'<textarea style="display: none;" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename">'.wp_create_nonce( plugin_basename(__FILE__) ).'</textarea>';
		
		echo'<h2>'.$meta_box['title'].'</h2>';
		
		if( $meta_box['type'] == "textarea" ) { 
		
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
		
			if($meta_box_value == "")
				$meta_box_value = $meta_box['std'];
		
			echo stripslashes('<textarea name="'.$meta_box['name'].'_value" rows="5" cols="100">'.$meta_box_value.'</textarea><br />');
			
		} elseif ( $meta_box['type'] == "select" ) {
			
			echo'<select name="'.$meta_box['name'].'_value">';
			
			foreach ($meta_box['options'] as $option) {
                
				echo'<option';
				if ( get_post_meta($post->ID, $meta_box['name'].'_value', true) == $option ) { 
					echo ' selected="selected"'; 
				} elseif ( $option == $meta_box['std'] ) { 
					echo ' selected="selected"'; 
				} 
				echo'>'. $option .'</option>';
			
			}
			
			echo'</select>';
			
		}
		
		echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';
	}

}

function create_meta_box() {
global $theme_name, $new_meta_boxes, $new_meta_boxes_3;
	if (function_exists('add_meta_box') ) {
	add_meta_box( 'new-meta-boxes', 'More Info', 'new_meta_boxes', 'listings', 'normal', 'high' );
	add_meta_box( 'new-meta-boxes_3', 'Video', 'new_meta_boxes_3', 'post', 'normal', 'high' );
	}
}

function save_postdata( $post_id ) {
	global $post, $new_meta_boxes, $new_meta_boxes_3; 
	
	foreach($new_meta_boxes as $meta_box) {  
		
		// Verify  
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {  
		return $post_id;  
		}  
	
	if ( 'page' == $_POST['post_type'] ) {  
	if ( !current_user_can( 'edit_page', $post_id ))  
	return $post_id;  
	} else {  
	if ( !current_user_can( 'edit_post', $post_id ))  
	return $post_id;  
	}  
	
	$data = $_POST[$meta_box['name'].'_value'];  
	
	if(get_post_meta($post_id, $meta_box['name'].'_value') == "")  
	add_post_meta($post_id, $meta_box['name'].'_value', $data, true);  
	elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))  
	update_post_meta($post_id, $meta_box['name'].'_value', $data);  
	elseif($data == "")  
	delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));  
	}
	
	foreach($new_meta_boxes_3 as $meta_box) {  
		
		// Verify  
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {  
		return $post_id;  
		}  
	
	if ( 'page' == $_POST['post_type'] ) {  
	if ( !current_user_can( 'edit_page', $post_id ))  
	return $post_id;  
	} else {  
	if ( !current_user_can( 'edit_post', $post_id ))  
	return $post_id;  
	}  
	
	$data = $_POST[$meta_box['name'].'_value'];  
	
	if(get_post_meta($post_id, $meta_box['name'].'_value') == "")  
	add_post_meta($post_id, $meta_box['name'].'_value', $data, true);  
	elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))  
	update_post_meta($post_id, $meta_box['name'].'_value', $data);  
	elseif($data == "")  
	delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));  
	}
	
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
?>