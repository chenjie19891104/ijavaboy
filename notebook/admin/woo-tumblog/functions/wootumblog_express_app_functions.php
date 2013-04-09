<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- set_new_taxonomy_tag()
- express_version()
- express_getPostsWithOffset()
- express_uploadFile()
- express_woo_taxonomy()
- express_newPost()
- express_editPost()
- attach_express_methods()

-----------------------------------------------------------------------------------*/

/**
 * Set taxonomies for post
 *
 * @custom code since 2.8.4 added by Dheer Gupta http://webdisect.com
 *
 * @param int $post_id Post ID.
 * @param array $fields Taxonomy Fields
 * Enter Values as array
 * array ( 'tags' => '', 'taxonomy' => '' )
 */
function set_new_taxonomy_tag($post_id, $fields) {
	$post_id = (int) $post_id;

	foreach ( (array) $fields as $tax ) {
		if ( isset($tax['id']) ) {
			$tax['id'] = (int) $tax['id'];
			
			if ( isset($tax['taxonomy']) ) {
				wp_set_post_terms($tax['id'], $tax['tags'], $tax['taxonomy']);
			}
		}	
		elseif ($post_id != '') {
			if ( isset($tax['taxonomy']) ) {
				wp_set_post_terms($post_id, $tax['tags'], $tax['taxonomy']);
			}			
		}
	}
}


/*
 * Express version
 *
 * Returns the API version number for future compatibility consideration
 *
 */
	
function express_version() {
	return "1.0";
}


/*
 * Get Posts With Offset
 *
 * Returns in a specific range to enable paging.
 *
 */
	
function express_getPostsWithOffset($args){
	global $wpdb;
	global $wp_xmlrpc_server;

	$wp_xmlrpc_server->escape($args);

	$blog_ID	= (int) $args[0];
	$username	= $args[1];
	$password	= $args[2];
	$num_posts	= (int) $args[3];
	$offset		= (int) $args[4];
	$status		= $args[5];

	if ( !$user = $wp_xmlrpc_server->login($username, $password) )
		return $wp_xmlrpc_server->error;

	do_action('xmlrpc_call', 'metaWeblog.getRecentPosts');

	// -- Added code
	if ($status == '') $statuses = "'draft', 'publish', 'future', 'pending', 'private'";
	else {
		$status_array = explode(",", $status);
		$statuses = "'".implode("','",$status_array)."'";
	}

	$sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status IN ( $statuses ) ORDER BY post_date DESC LIMIT $offset,$num_posts";
	$result = $wpdb->get_results($sql, ARRAY_A);
	$posts_list =  $result ? $result : array();
	// End added code --

	if (!$posts_list) {
		return array( );
	}

	foreach ($posts_list as $entry) {
		if( !current_user_can( 'edit_post', $entry['ID'] ) )
			continue;

		$post_date = mysql2date('Ymd\TH:i:s', $entry['post_date'], false);
		$post_date_gmt = mysql2date('Ymd\TH:i:s', $entry['post_date_gmt'], false);

		// For drafts use the GMT version of the date
		if ( $entry['post_status'] == 'draft' ) {
			$post_date_gmt = get_gmt_from_date( mysql2date( 'Y-m-d H:i:s', $entry['post_date'] ), 'Ymd\TH:i:s' );
		}

		$categories = array();
		$catids = wp_get_post_categories($entry['ID']);
		foreach($catids as $catid) {
			$categories[] = get_cat_name($catid);
		}

		$tagnames = array();
		$tags = wp_get_post_tags( $entry['ID'] );
		if ( !empty( $tags ) ) {
			foreach ( $tags as $tag ) {
				$tagnames[] = $tag->name;
			}
			$tagnames = implode( ', ', $tagnames );
		} else {
			$tagnames = '';
		}

		$post = get_extended($entry['post_content']);
		$link = post_permalink($entry['ID']);

		// Get the post author info.
		$author = get_userdata($entry['post_author']);

		$allow_comments = ('open' == $entry['comment_status']) ? 1 : 0;
		$allow_pings = ('open' == $entry['ping_status']) ? 1 : 0;

		// Consider future posts as published
		if( $entry['post_status'] === 'future' ) {
			$entry['post_status'] = 'publish';
		}

		$struct[] = array(
			'dateCreated' => new IXR_Date($post_date),
			'userid' => $entry['post_author'],
			'postid' => $entry['ID'],
			'description' => $post['main'],
			'title' => $entry['post_title'],
			'link' => $link,
			'permaLink' => $link,
			// commented out because no other tool seems to use this
			// 'content' => $entry['post_content'],
			'categories' => $categories,
			'mt_excerpt' => $entry['post_excerpt'],
			'mt_text_more' => $post['extended'],
			'mt_allow_comments' => $allow_comments,
			'mt_allow_pings' => $allow_pings,
			'mt_keywords' => $tagnames,
			'wp_slug' => $entry['post_name'],
			'wp_password' => $entry['post_password'],
			'wp_author_id' => $author->ID,
			'wp_author_display_name' => $author->display_name,
			'date_created_gmt' => new IXR_Date($post_date_gmt),
			'post_status' => $entry['post_status'],
			'custom_fields' => $wp_xmlrpc_server->get_custom_fields($entry['ID'])
		);

	}

	$recent_posts = array();
	for ($j=0; $j<count($struct); $j++) {
		array_push($recent_posts, $struct[$j]);
	}

	return $recent_posts;
}


/*
 * Upload file
 *
 * Adds the post_id in the returned value
 *
 */
	
function express_uploadFile($args) {
	global $wpdb;
	global $wp_xmlrpc_server;

	$blog_ID     = (int) $args[0];
	$username  = $wpdb->escape($args[1]);
	$password   = $wpdb->escape($args[2]);
	$data        = $args[3];

	$name = sanitize_file_name( $data['name'] );
	$type = $data['type'];
	$bits = $data['bits'];

	logIO('O', '(MW) Received '.strlen($bits).' bytes');

	if ( !$user = $wp_xmlrpc_server->login($username, $password) )
		return $wp_xmlrpc_server->error;

	do_action('xmlrpc_call', 'metaWeblog.newMediaObject');

	if ( !current_user_can('upload_files') ) {
		logIO('O', '(MW) User does not have upload_files capability');
		return new IXR_Error(401, __('You are not allowed to upload files to this site.'));
	}

	if ( $upload_err = apply_filters( "pre_upload_error", false ) )
		return new IXR_Error(500, $upload_err);

	if(!empty($data["overwrite"]) && ($data["overwrite"] == true)) {
		// Get postmeta info on the object.
		$old_file = $wpdb->get_row("
			SELECT ID
			FROM {$wpdb->posts}
			WHERE post_title = '{$name}'
				AND post_type = 'attachment'
		");

		// Delete previous file.
		wp_delete_attachment($old_file->ID);

		// Make sure the new name is different by pre-pending the
		// previous post id.
		$filename = preg_replace("/^wpid\d+-/", "", $name);
		$name = "wpid{$old_file->ID}-{$filename}";
	}

	$upload = wp_upload_bits($name, $type, $bits);
	if ( ! empty($upload['error']) ) {
		$errorString = sprintf(__('Could not write file %1$s (%2$s)'), $name, $upload['error']);
		logIO('O', '(MW) ' . $errorString);
		return new IXR_Error(500, $errorString);
	}
	// Construct the attachment array
	// attach to post_id 0
	$post_id = 0;
	$attachment = array(
		'post_title' => $name,
		'post_content' => '',
		'post_type' => 'attachment',
		'post_parent' => $post_id,
		'post_mime_type' => $type,
		'guid' => $upload[ 'url' ]
	);

	// Save the data
	$id = wp_insert_attachment( $attachment, $upload[ 'file' ], $post_id );
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

	return apply_filters( 'wp_handle_upload', array( 'file' => $name, 'url' => $upload[ 'url' ], 'type' => $type , 'id' => $id ) );
}


/*
 * Woo taxonomy
 *
 * Set the proper taxonomy
 *
 */
	
function express_woo_taxonomy($args) {
	$content_struct = $args[3];

	// Re-assign the taxonomies so they are compatible with WooThemes themes
	$taxonomies = $content_struct['taxonomy'];
	if (is_array($taxonomies)) {
		$new_taxonomy = array();
		$woo_tags = array();
		foreach ($taxonomies as $taxonomy) {
			if ($taxonomy['taxonomy'] == 'tumblog') {
				foreach ($taxonomy['tags'] as $tag) {
					switch (strtolower($tag)) {
						case 'note':
							$woo_tags[] = get_option('woo_articles_term_id');
							break;
						case 'link':
							$woo_tags[] = get_option('woo_links_term_id');
							break;
						case 'quote':
							$woo_tags[] = get_option('woo_quotes_term_id');
							break;
						case 'image':
							$woo_tags[] = get_option('woo_images_term_id');
							break;
						default:
							$woo_tags[] = $tag;
							break;
					}	
				}
				$taxonomy['tags'] = implode(',', $woo_tags);
			}
			$new_taxonomy[] = $taxonomy;
		}
		$content_struct['taxonomy'] = $new_taxonomy;
		$args[3] = $content_struct;
	}
	
	return $args;
}


/*
 * New post
 *
 * Sets post attachements if specified
 * Sets post custom taxonomy
 *
 */
	
function express_newPost($args) {
	global $wp_xmlrpc_server;
	
	$args = express_woo_taxonomy($args);
	
	$result = $wp_xmlrpc_server->mw_newPost($args);
	$post_ID = intval($result);
	if ($post_ID == 0) return $result;

	$content_struct = $args[3];

	// Insert taxonomies
	if ( isset($content_struct['taxonomy']) ) {
		set_new_taxonomy_tag($post_ID, $content_struct['taxonomy']);
	}
	
	// Add new attachments
	$attachments = $content_struct['attachments'];
	if (is_array($attachments)) {
		foreach ($attachments as $attachment_ID) {
			$attachment_post = wp_get_single_post($attachment_ID,ARRAY_A);
			extract($attachment_post, EXTR_SKIP);
			$post_parent = $post_ID;
			$postdata = compact('ID', 'post_parent', 'post_content', 'post_title', 'post_category', 'post_status', 'post_excerpt');
			wp_update_post($postdata);
		}
	}

	return $result;
}


/*
 * Edit post
 *
 * Sets post attachements if specified
 * Sets post custom taxonomy
 *
 */
	
function express_editPost($args) {
	global $wp_xmlrpc_server;
	
	$args = express_woo_taxonomy($args);
	
	$result = $wp_xmlrpc_server->mw_editPost($args);
	if ($result == false) return false;

	// Insert taxonomies
	if ( isset($content_struct['taxonomy']) ) {
		set_new_taxonomy_tag($post_ID, $content_struct['taxonomy']);
	}
	
	// TODO: Remove old attachments
	

	// Add new attachments
	$post_ID = (int)$args[0];
	$content_struct = $args[3];
	$attachments = $content_struct['attachments'];
	if (is_array($attachments)) {
		foreach ($attachments as $attachment_ID) {
			$attachment_post = wp_get_single_post($attachment_ID,ARRAY_A);
			extract($attachment_post, EXTR_SKIP);
			$post_parent = $post_ID;
			$postdata = compact('ID', 'post_parent', 'post_content', 'post_title', 'post_category', 'post_status', 'post_excerpt');
			wp_update_post($postdata);
		}
	}

	return true;
}


add_filter('xmlrpc_methods', 'attach_express_methods');

function attach_express_methods($methods) {
	$methods['express.version'] = 'express_version';
	$methods['express.getPostsWithOffset'] = 'express_getPostsWithOffset';
	$methods['express.uploadFile'] = 'express_uploadFile';
	$methods['express.newPost'] = 'express_newPost';
	$methods['express.editPost'] = 'express_editPost';
	return $methods;
}

?>