<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- WooTumblog Plugin Class
-- WooTumblog()
-- woo_tumblog_header_code()
-- woo_tumblog_menu()
-- woo_tumblog_contextual_help()
-- woo_tumblog_options()
-- woo_custom_tumblog_rss_output()
-- woothemes_tumblog_metabox_handle()
-- woothemes_tumblog_metabox_add()
-- woothemes_tumblog_metabox_create()
-- woothemes_tumblog_metabox_header()
-- woo_tumblog_custom_enqueue()

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* WooTumblog Plugin Class */
/*-----------------------------------------------------------------------------------*/
	
class WooTumblog {
	
	/*-----------------------------------------------------------------------------------*/
	/* Constructor */
	/*-----------------------------------------------------------------------------------*/
	
	function WooTumblog() {
		
		//Enable Tumblog Functionality and provide support for upgraded WooTheme functionality
		update_option('woo_needs_tumblog_upgrade', 'false');
		update_option('tumblog_woo_tumblog_upgraded', 'true');
		update_option('tumblog_woo_tumblog_upgraded_posts_done', 'true');
		update_option('woo_tumblog_version', '1.0.3');
		
		//Actions and filters - menus, header code, rss content filter, metabox creator, contextual help
		add_action('admin_menu', array(&$this, 'woo_tumblog_menu')); 
		add_action('wp_head', array(&$this, 'woo_tumblog_header_code'));
		add_filter('the_excerpt_rss', array(&$this, 'woo_custom_tumblog_rss_output'));
		add_filter('the_content_rss', array(&$this, 'woo_custom_tumblog_rss_output'));		
		add_action('admin_enqueue_scripts', array(&$this, 'woo_tumblog_custom_enqueue'),10,1);
		add_action('contextual_help', array(&$this, 'woo_tumblog_contextual_help'), 10, 3);
		add_action('admin_notices', array(&$this, 'woo_tumblog_plugin_install_notice'));
		add_action('admin_notices', array(&$this, 'woo_tumblog_plugin_options_notice'));
		
		// Woo Metabox Options
		$woo_metaboxes = array(
		
		        "image" => array (
		            "name" => "image",
		            "label" => "Image",
		            "type" => "upload",
		            "desc" => "Upload file here..."
		        ),
		        "video-embed" => array (
		            "name" => "video-embed",
		            "label" => "Embed Code (Videos)",
		            "type" => "textarea",
		            "desc" => "Add embed code for video services like Youtube or Vimeo"
		        ),
		        "quote-author" => array (
		            "name"  => "quote-author",
		            "std"  => "Unknown",
		            "label" => "Quote Author",
		            "type" => "text",
		            "desc" => "Enter the name of the Quote Author."
		        ),
		        "quote-url" => array (
		            "name"  => "quote-url",
		            "std"  => "http://",
		            "label" => "Link to Quote",
		            "type" => "text",
		            "desc" => "Enter the url/web address of the Quote if available."
		        ),
		        "quote-copy" => array (
		            "name"  => "quote-copy",
		            "std"  => "Unknown",
		            "label" => "Quote",
		            "type" => "textarea",
		            "desc" => "Enter the Quote."
		        ),
		        "audio" => array (
		            "name"  => "audio",
		            "std"  => "http://",
		            "label" => "Audio URL",
		            "type" => "text",
		            "desc" => "Enter the url/web address of the Audio file."
		        ),
		        "link-url" => array (
		            "name"  => "link-url",
		            "std"  => "http://",
		            "label" => "Link URL",
		            "type" => "text",
		            "desc" => "Enter the url/web address of the Link."
		        ),
			
		    );
		
		//add metabox options to the db    
		update_option('woo_custom_template',$woo_metaboxes);  
		
		//add actions for metabox handlers
		add_action('edit_post', array(&$this, 'woothemes_tumblog_metabox_handle'));
		add_action('admin_menu', array(&$this, 'woothemes_tumblog_metabox_add'));
					
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* Frontend Header Code */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_header_code() {
		//Plugin path
		$pluginpath = dirname( __FILE__ );
		//Audio Player
		echo '<script type="text/javascript" src="'. get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog/functions/swfobject.js"></script>';
		//Frontend styles
		echo '<link rel="stylesheet" type="text/css" media="all" href="'. get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog/functions/css/tumblog_frontend_styles.css" />';
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* WooTumblog Options Page Menu */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_menu() {
		global $tumblog_plugin_hook;
		//creat options page
		$tumblog_plugin_hook = add_posts_page('Tumblog Options', 'Tumblog Options', 'manage_options', 'tumblog', array(&$this, 'woo_tumblog_options'));
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* WooTumblog Options Page Contextual Help */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_contextual_help($contextual_help, $screen_id, $screen) {
		//options page object
		global $tumblog_plugin_hook;
		//Contextual Help output
		if ($screen_id == $tumblog_plugin_hook) {
			//Help HTML
			$contextual_help = '<p><h3><strong>'.__('How to add Tumblog functionality to your theme!').'</strong></h3></p>';
			//Template Tags
			$contextual_help .= '<p><strong>'.__('Included Template Tags:').'</strong></p>';
			$contextual_help .= '<p><ul>';
			$contextual_help .= '<li><p><strong>Tumblog Post Title</strong></p><p>To output the correct Tumblog Post Titles and the Tumblog Icon link, replace your usual <code>'.htmlentities('<h2><?php the_title(); ?></h2>').'</code> post header code with this tag :</p><p><code>'.htmlentities('<?php woo_tumblog_the_title($class= "title", $icon = true, $before = "", $after = "", $return = false, $outer_element = "h2") ?>').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$class - add your own class for the outer element of the header').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$icon - outputs an icon (when true) with a link to its relative tumblog taxonomy archive').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$before - add your own html before the outer element of the header').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$after - add your own html after the outer element of the header').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$return - returns the output as a variable when true').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$outer_element - specifiy the type of element you want the outer wrapper to be. Defaults to h2').'</code></p></li>';
			$contextual_help .= '<li><p><strong>Tumblog Post Content</strong></p><p>To output the Tumblog specific content, simply add this tag inside your query loop, it will determine which of the below output functions to use: </p><p><code>'.htmlentities('<?php woo_tumblog_content($return = false); ?>').'</code><p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('$return - returns the output as a variable when true').'</code></p></li>';
			$contextual_help .= '<li><p>If you prefer to specifically call each Tumblog output function individually, you can use these functions: </p><p>Article Tumblog Content - currently no custom output</p><p><code>'.htmlentities('<?php woo_tumblog_article_content($post_id); ?>').'</code></p>';
			$contextual_help .= '<p>Image Tumblog Content - Outputs the Image</p><p><code>'.htmlentities('<?php woo_tumblog_image_content($post_id); ?>').'</code></p>';
			$contextual_help .= '<p>Audio Tumblog Content - Outputs the Audio Player</p><p><code>'.htmlentities('<?php woo_tumblog_audio_content($post_id); ?>').'</code></p>';
			$contextual_help .= '<p>Video Tumblog Content - Outputs the Embedded Video</p><p><code>'.htmlentities('<?php woo_tumblog_video_content($post_id); ?>').'</code></p>';
			$contextual_help .= '<p>Quote Tumblog Content - Outputs the Quote, the Author, and the Author URL</p><p><code>'.htmlentities('<?php woo_tumblog_quote_content($post_id); ?>').'</code></p>';
			$contextual_help .= '<p>Link Tumblog Content - currently no custom output - the header tag outputs the link</p><p><code>'.htmlentities('<?php woo_tumblog_link_content($post_id); ?>').'</code></p></li>';
			$contextual_help .= '</ul></p>';
			//Example Code
			$contextual_help .= '<p><strong>'.__('Twenty Ten example implementation:').'</strong></p>';
			$contextual_help .= '<p><ul>';
			$contextual_help .= '<li><p><strong>loop.php</strong></p><p><strong>Lines 126 : </strong>Replace this line with this code: </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('<?php woo_tumblog_the_title("entry-title"); ?>').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('This will show the tumblog header with the tumblog icon that links to the taxonomy archive on the right').'</code></p><p><strong>Lines 134 and 139 : </strong>Add this line of code above <code>'.htmlentities('<?php the_excerpt(); ?>').'</code> and above <code>'.htmlentities('<?php the_content(); ?>').'</code>: </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('<?php woo_tumblog_content(); ?>').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('This will output the tumblog specific content above the excerpt and the content.  Eg. Image Tumblog Post will output an image.').'</code></p></li>';
			$contextual_help .= '<li><p><strong>single.php</strong></p><p><strong>Lines 23 : </strong>Replace this line with this code: </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('<?php woo_tumblog_the_title("entry-title"); ?>').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('This will show the tumblog header with the tumblog icon that links to the taxonomy archive on the right').'</code></p><p><strong>Line 30 : </strong>Add this line of code above <code>'.htmlentities('<?php the_content(); ?>').'</code>: </p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('<?php woo_tumblog_content(); ?>').'</code></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<code>'.htmlentities('This will output the tumblog specific content above the content.  Eg. Image Tumblog Post will output an image.').'</code></p></li>';
			$contextual_help .= '</ul></p>';
		}
		return $contextual_help;
	}

	/*-----------------------------------------------------------------------------------*/
	/* WooTumblog Options Page Output */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_plugin_install_notice() {
		if ($_REQUEST['activate']) {
			echo "
			<div id='woo-tumblog-warning' class='updated fade'><p><strong>".__('Woo Tumblog is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">configure your settings</a> for it to work.'), "edit.php?page=tumblog")."</p></div>
			";
		}
	}
	
	function woo_tumblog_plugin_options_notice() {
		if ($_REQUEST['taxonomy'] == 'tumblog') {
			echo "
			<div id='woo-tumblog-warning' class='updated fade'><p><strong>".__('NOTE	:')."</strong> ".__('You can add the custom tumblog output to your theme by following the instructions in ').sprintf(__('the contextual help in the <a href="%1$s">Tumblog Options</a> page.'), "edit.php?page=tumblog")."</p></div>
			";
		}
	}
	
	function woo_tumblog_options() {
		//Default Options
		$image_option_array = array( 	'post' 	=> 'The Post',
										'image' => 'The Image'			
									);
									
		$feed_option_array = array( 	'yes' 	=> 'Yes',
										'no' => 'No'			
									);
		//Plugin path
		$pluginpath = dirname( __FILE__ );
		//Audio Player
		$plugin_url = get_bloginfo('stylesheet_directory') . '/admin/woo-tumblog';
		
		//Check for permissions
		if (!current_user_can('manage_options'))  {
	   		wp_die( _e('You do not have sufficient permissions to access this page.') );
		}
		//Check if default is set
		$default_feed_option = get_option('woo_custom_rss');
		$default_image_link_option = get_option('woo_image_link_to'); 
		$default_image_width_option = get_option('woo_tumblog_width'); 
		//set defaults if blank
		if ($default_feed_option == '') {
			update_option('woo_custom_rss', 'yes');
		}
		if ($default_image_link_option == '') {
			update_option('woo_image_link_to', 'post');
		}
		if ($default_image_width_option == '') {
			update_option('woo_tumblog_width', '640');
		}
		//The Options Form	
		?>
		<script type="text/javascript">
		    jQuery(document).ready(function(){
		
		    	jQuery.noConflict();
	
		    	//Custom jQuery goes here
	    
	        });
		</script>
			
		<div id="woo_container" class="wrap">
				
			<div id="header">
            
            	<div class="logo">
                	<img alt="WooThemes" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/admin/woo-tumblog/functions/images/logo.png"/>
                </div><!-- /.logo -->
                
                <div class="theme-info">
                    <span class="theme"><?php _e('WooTumblog Plugin Options'); ?></span>
                    <span class="framework"><?php _e('Version'); ?> <?php echo get_option('woo_tumblog_version'); ?></span>
                </div><!-- /theme-info -->
                
                <div class="clear"></div>
                
            </div><!-- /#header -->
            
            <div id="support-links">
        
                <ul>
                    <li class="changelog"><a title="Plugin Changelog" href="<?php echo $plugin_url; ?>/../changelog.txt"><?php _e('View Changelog'); ?></a></li>
                    <li class="docs"><a title="Plugin Documentation" href="http://www.woothemes.com/support/wootumblog/"><?php _e('View Plugin Docs'); ?></a></li>
                    <li class="forum"><a href="http://wordpress.org/support/" target="_blank"><?php _e('Visit WordPress Forum'); ?></a></li>

                    <li class="right"><img style="display:none" src="<?php echo $plugin_url; ?>/../functions/images/loading-top.gif" class="ajax-loading-img ajax-loading-img-top" alt="Working..." /><a href="#" id="expand_options">[+]</a> <input onclick="jQuery('#tumblog-submit').click();" type="submit" value="Save All Changes" class="button submit-button" /></li>
                </ul>
        
            </div><!-- /#support-links -->
			
			<div id="main">
				<div id="content">
				
				<?php 
				$ok = false;
				//Admin messages
				echo "
					<div id='woo-tumblog-warning' class='updated fade'><p><strong>".__('NOTE	:')."</strong> ".__('Add the tumblog output to your theme by following the instructions in the contextual help menu above.')."</p></div>
					";
				//Check if submit
				if (isset($_REQUEST['submit'])) {
					if ($_REQUEST['woo_custom_rss']) {
						update_option('woo_custom_rss', $_REQUEST['woo_custom_rss']);
						$ok = true;		
					}
					if ($_REQUEST['woo_image_link_to']) {
						update_option('woo_image_link_to', $_REQUEST['woo_image_link_to']);
						$ok = true;		
					}
					if ($_REQUEST['woo_tumblog_width']) {
						update_option('woo_tumblog_width', $_REQUEST['woo_tumblog_width']);
						$ok = true;		
					}
					//Error messages
					if ($ok) {
						?>
						<div id="message" class="updated fade">
							<p><?php _e('Options saved'); ?>.</p>
						</div>
						<?php 
					} else {
						?>
						<div id="message" class="error fade">
							<p><?php _e('Failed to save options'); ?>.</p>
						</div>
						<?php 	
					}
				} 
				//The form
				$default_feed_option = get_option('woo_custom_rss');
				$default_image_link_option = get_option('woo_image_link_to'); 
				$default_image_width_option = get_option('woo_tumblog_width'); 
				?>
				
				<form method="post">
					
					<p>
				    	<label for="woo_custom_rss"><?php _e('Use Custom Tumblog RSS Feed'); ?>: </label>
				    	<select id="woo_custom_rss" name="woo_custom_rss">
				    		<?php 
				    		foreach ($feed_option_array as $key => $value) {
				    			if ($default_feed_option == $key) {
				    				$selected = 'selected="yes"';
				    			} else {
				    				$selected = '';
				    			}
				    			echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				    		}
				    		?>
				    	</select>
				    </p>
				    
				    <p>
				    	<label for="woo_image_link_to"><?php _e('Tumblog Image Posts Link to'); ?>: </label>
				    	<select id="woo_image_link_to" name="woo_image_link_to">
				    		<?php 
				    		foreach ($image_option_array as $key => $value) {
				    			if ($default_image_link_option == $key) {
				    				$selected = 'selected="yes"';
				    			} else {
				    				$selected = '';
				    			}
				    			echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				    		}
				    		?>
				    	</select>
				    </p>
				    
				    <p>
				    	<label for="woo_tumblog_width">
				    		<?php _e('Tumblog Image Width'); ?>:
				    	</label>
				    	<input class="" type="text" name="woo_tumblog_width" value="<?php echo $default_image_width_option; ?>" /><span class="px">px</span>
				    	<span class="secondary-label"><?php _e('Height is dynamically calculated'); ?></span>
				    </p>
				    
				    <input id="tumblog-submit" class="button button-highlighted button-highlighted" type="submit" name="submit" value="Save Changes" />
				    
				</form>
				
				</div><!-- /#content -->
			</div><!-- /#main -->
			
		</div><!-- /#woo_container -->
		
		<?php
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* WooTumblog Custom RSS Feed Output */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_custom_tumblog_rss_output($content) {
		global $post;
		$post_id = $post->ID;
		$default_feed_option = get_option('woo_custom_rss');
		if ($default_feed_option == 'yes') {
			//default content output to nothing
			$temp_content = $content;
			$content = '';
			//check if it is a tumblog post
			
			//check which tumblog
			$tumblog_list = get_the_term_list( $post_id, 'tumblog', '' , '|' , ''  );
			
			$tumblog_array = explode('|', $tumblog_list);
			
			$tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
									'images' 	=> get_option('woo_images_term_id'),
									'audio' 	=> get_option('woo_audio_term_id'),
									'video' 	=> get_option('woo_video_term_id'),
									'quotes'	=> get_option('woo_quotes_term_id'),
									'links' 	=> get_option('woo_links_term_id')
								);
			//switch between tumblog taxonomies
			$tumblog_list = strip_tags($tumblog_list);
			$tumblog_array = explode('|', $tumblog_list);
			$tumblog_results = '';
			$sentinel = false;
			foreach ($tumblog_array as $tumblog_item) {
			  	$tumblog_id = get_term_by( 'name', $tumblog_item, 'tumblog' );
			  	if ( $tumblog_items['articles'] == $tumblog_id->term_id && !$sentinel ) {
			  		$tumblog_results = 'article';
			  		$tumblog_name = $tumblog_id->name;
			  		$sentinel = true;
			   	} elseif ($tumblog_items['images'] == $tumblog_id->term_id && !$sentinel ) {
			   		$tumblog_results = 'image';
			   		$tumblog_name = $tumblog_id->name;
			   		$sentinel = true;
			   	} elseif ($tumblog_items['audio'] == $tumblog_id->term_id && !$sentinel) {
			   		$tumblog_results = 'audio';
			   		$tumblog_name = $tumblog_id->name;
			   		$sentinel = true;
			   	} elseif ($tumblog_items['video'] == $tumblog_id->term_id && !$sentinel) {
			   		$tumblog_results = 'video';
			   		$tumblog_name = $tumblog_id->name;
			   		$sentinel = true;
			   	} elseif ($tumblog_items['quotes'] == $tumblog_id->term_id && !$sentinel) {
			   		$tumblog_results = 'quote';
			   		$tumblog_name = $tumblog_id->name;
			   		$sentinel = true;
			   	} elseif ($tumblog_items['links'] == $tumblog_id->term_id && !$sentinel) {
			   		$tumblog_results = 'link';
			   		$tumblog_name = $tumblog_id->name;
			   		$sentinel = true;
			   	} else {
			   		$tumblog_results = 'default';
			   		$tumblog_name = 'Tumblog';
			   		$sentinel = false;
			  	}	    		
			} 
			
			$taxonomy_link = woo_tumblog_taxonomy_link($post_id, false);
			if ($tumblog_name != 'Tumblog') {
			    $content .= '<p>Posted in <a href="'.$taxonomy_link.'">'.$tumblog_name.'</a></p>';
			} else {
			    $content .= '<p>Posted in ';
			    foreach((get_the_category($post_id)) as $category) { 
    		    	$category_link = get_category_link( $category->cat_ID );
 			    	$content .= '<a href="'.$category_link.'" title="'.$category->cat_name.'">'.$category->cat_name.'</a>';
			    } 
			    $content .= '</p>';
			}
			
			switch ($tumblog_results) {
			
				case 'article':
					break;
				case 'image':
					if (get_option('woo_image_link_to') == 'image') {
  						$content .= '<p><a href="'.get_post_meta($post_id, "image", true).'" title="image" rel="lightbox"><img src="'.get_post_meta($post_id, "image", true).'" alt="image" width="'.get_option('woo_tumblog_width').'" /></a></p>';  
  					} else { 
    		    		$content .= '<p><a href="'.get_permalink($post_id).'" title="image"><img src="'.get_post_meta($post_id, "image", true).'" alt="image" width="'.get_option('woo_tumblog_width').'" /></a></p>';
					}
					break;
				case 'audio':
					//Post Args
					$args = array(
						'post_type' => 'attachment',
						'numberposts' => -1,
						'post_status' => null,
						'post_parent' => $post_id
					);
					//Get attachements 
					$attachments = get_posts($args);
					if ($attachments) {
						foreach ($attachments as $attachment) {
							$link_url= $attachment->guid;
						}
					}
					else {
						$link_url = get_post_meta($post_id,'audio',true);
					}
					if(!empty($link_url)) {
						$content .= '<p><a href="'.$link_url.'" rel="bookmark" title="'.get_the_title($post_id).'" target="_blank">'.__('Play Audio', 'woothemes').'</a></p>';
					}
					break;
				case 'video':
					$content .= '<p>'.get_post_meta($post_id,'video-embed',true).'</p>';
					break;
				case 'quote':
					$content .= '<p><cite>'.get_post_meta($post_id,'quote-copy',true).__(' ~ ', 'woothemes').'<a href="'.get_post_meta($post_id,'quote-url',true).'" title="'.get_the_title($post_id).'">'.get_post_meta($post_id,'quote-author',true).'</a></cite></p>';
					break;
				case 'link':
					$content .= '<p><a href="'.get_post_meta($post_id,'link-url',true).'" rel="bookmark" title="'.get_the_title($post_id).'" target="_blank">'.get_post_meta($post_id,'link-url',true).'</a></p>';
					break;
				default:
					break;
			}
				
			
			//add original content back
    		$content .= $temp_content;
		}
	    return $content;
	}
	
	/*-----------------------------------------------------------------------------------*/
	// WooTumblog Custom Metabox Handler
	/*-----------------------------------------------------------------------------------*/
	
	function woothemes_tumblog_metabox_handle(){   
	    
	    global $globals;
	    $woo_metaboxes = get_option('woo_custom_template');  
	    
	    $seo_metaboxes = get_option('woo_custom_seo_template');  
	    
	    if(!empty($seo_metaboxes) AND get_option('seo_woo_hide_fields') != 'true'){
	    	$woo_metaboxes = array_merge($woo_metaboxes,$seo_metaboxes);
	    }
	       
	    if(isset($_POST['post_ID']))
			$pID = $_POST['post_ID'];
	    $upload_tracking = array();
		
	    
	    if (isset($_POST['action']) && $_POST['action'] == 'editpost'){                                   
	        foreach ($woo_metaboxes as $woo_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
	            if($woo_metabox['type'] == 'text' 
				OR $woo_metabox['type'] == 'calendar' 
				OR $woo_metabox['type'] == 'time'
				OR $woo_metabox['type'] == 'select' 
				OR $woo_metabox['type'] == 'radio'
				OR $woo_metabox['type'] == 'checkbox' 
				OR $woo_metabox['type'] == 'textarea' 
				OR $woo_metabox['type'] == 'images' ) // Normal Type Things...
	                {
	                    $var = $woo_metabox["name"];
	                    if (isset($_POST[$var])) {            
	                        if( get_post_meta( $pID, $var ) == "" )
	                            add_post_meta($pID, $var, $_POST[$var], true );
	                        elseif($_POST[$var] != get_post_meta($pID, $var, true))
	                            update_post_meta($pID, $var, $_POST[$var]);
	                        elseif($_POST[$var] == "") {
	                           delete_post_meta($pID, $var, get_post_meta($pID, $var, true));
	                        }
	                    }
	                    elseif(!isset($_POST[$var]) && $woo_metabox['type'] == 'checkbox') { 
	                        update_post_meta($pID, $var, 'false'); 
	                    }      
	                    else {
	                          delete_post_meta($pID, $var, get_post_meta($pID, $var, true)); // Deletes check boxes OR no $_POST
	                    }    
	                }
	          
	            elseif($woo_metabox['type'] == 'upload') // So, the upload inputs will do this rather
	                {
	                $id = $woo_metabox['name'];
	                $override['action'] = 'editpost';
	                
	                    if(!empty($_FILES['attachement_'.$id]['name'])){ //New upload
	                    $_FILES['attachement_'.$id]['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $_FILES['attachement_'.$id]['name']); 
	                           $uploaded_file = wp_handle_upload($_FILES['attachement_' . $id ],$override); 
	                           $uploaded_file['option_name']  = $woo_metabox['label'];
	                           $upload_tracking[] = $uploaded_file;
	                           update_post_meta($pID, $id, $uploaded_file['url']);
	                    }
	                    elseif(empty( $_FILES['attachement_'.$id]['name']) && isset($_POST[ $id ])){
	                        update_post_meta($pID, $id, $_POST[ $id ]); 
	                    }
	                    elseif($_POST[ $id ] == '')  { delete_post_meta($pID, $id, get_post_meta($pID, $id, true));
	                    }
	                }
	               // Error Tracking - File upload was not an Image
	               update_option('woo_custom_upload_tracking', $upload_tracking);
	            }
	            
	        }
	}
	
	/*-----------------------------------------------------------------------------------*/
	// WooTumblog Add Metaboxes
	/*-----------------------------------------------------------------------------------*/
	
	function woothemes_tumblog_metabox_add() {
	    if ( function_exists('add_meta_box') ) {
	    
	    	if ( function_exists('get_post_types') ) {
	    		$custom_post_list = get_post_types();
				foreach ($custom_post_list as $type){
					add_meta_box('woothemes-settings', 'Tumblog Custom Settings',array(&$this, 'woothemes_tumblog_metabox_create'),$type,'normal');
				}
	    	} else {
	    		add_meta_box('woothemes-settings', 'Tumblog Custom Settings',array(&$this, 'woothemes_tumblog_metabox_create'),'post','normal');
	        	add_meta_box('woothemes-settings', 'Tumblog Custom Settings',array(&$this, 'woothemes_tumblog_metabox_create'),'page','normal');
	    	}
			
	    }
	}
	
	/*-----------------------------------------------------------------------------------*/
	// Custom fields for WP write panel
	// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/
	/*-----------------------------------------------------------------------------------*/
	
	function woothemes_tumblog_metabox_create() {
	    global $post;
	    $woo_metaboxes = get_option('woo_custom_template');
	    
	    $seo_metaboxes = get_option('woo_custom_seo_template');  
	    
	    if(!empty($seo_metaboxes) AND get_option('seo_woo_hide_fields') != 'true'){
	    	$woo_metaboxes = array_merge($woo_metaboxes,$seo_metaboxes);
	    }
	
	    $output = '';
	    $output .= '<table class="woo_metaboxes_table">'."\n";
	    foreach ($woo_metaboxes as $woo_metabox) {
	    $woo_id = "woothemes_" . $woo_metabox["name"];
	    $woo_name = $woo_metabox["name"];
	    if(        
	                $woo_metabox['type'] == 'text' 
			OR      $woo_metabox['type'] == 'select' 
			OR      $woo_metabox['type'] == 'checkbox' 
			OR      $woo_metabox['type'] == 'textarea'
			OR      $woo_metabox['type'] == 'calendar'
			OR      $woo_metabox['type'] == 'time'
			OR      $woo_metabox['type'] == 'radio'
			OR      $woo_metabox['type'] == 'images') {
	            $woo_metaboxvalue = get_post_meta($post->ID,$woo_name,true);
				}
	            
	            if (empty($woo_metaboxvalue) && isset($woo_metabox['std'])) {
	                $woo_metaboxvalue = $woo_metabox['std'];
	            }
				
	            if($woo_metabox['type'] == 'text'){
	            
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td><input class="woo_input_text" type="'.$woo_metabox['type'].'" value="'.$woo_metaboxvalue.'" name="'.$woo_name.'" id="'.$woo_id.'"/>';
	                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
	                $output .= "\t".'<td></td></tr>'."\n";  
	                              
	            }
	            
	            elseif ($woo_metabox['type'] == 'textarea'){
	            
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_metabox.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td><textarea class="woo_input_textarea" name="'.$woo_name.'" id="'.$woo_id.'">' . $woo_metaboxvalue . '</textarea>';
	                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
	                $output .= "\t".'<td></td></tr>'."\n";  
	                              
	            }
	            
	            elseif ($woo_metabox['type'] == 'calendar'){
	            	
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_metabox.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td><input class="woo_input_calendar" type="text" name="'.$woo_name.'" id="'.$woo_id.'" value="'.$woo_metaboxvalue.'">';
	                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
	                $output .= "\t".'<td></td></tr>'."\n";  
	                              
	            }
	            
	            elseif ($woo_metabox['type'] == 'time'){
	            	
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td><input class="woo_input_time" type="'.$woo_metabox['type'].'" value="'.$woo_metaboxvalue.'" name="'.$woo_name.'" id="'.$woo_id.'"/>';
	                $output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td>'."\n";
	                $output .= "\t".'<td></td></tr>'."\n"; 
	                              
	            }
	
	            elseif ($woo_metabox['type'] == 'select'){
	                       
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td><select class="woo_input_select" id="'.$woo_id.'" name="'. $woo_name .'">';
	                $output .= '<option value="">Select to return to default</option>';
	                
	                $array = $woo_metabox['options'];
	                
	                if($array){
	                
	                    foreach ( $array as $id => $option ) {
	                        $selected = '';
	                       
	                        if(isset($woo_metabox['default']))  {                            
								if($woo_metabox['default'] == $option && empty($woo_metaboxvalue)){$selected = 'selected="selected"';} 
								else  {$selected = '';}
							}
	                        
	                        if($woo_metaboxvalue == $option){$selected = 'selected="selected"';}
	                        else  {$selected = '';}  
	                        
	                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
	                    }
	                }
	                
	                $output .= '</select><span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td></td><td></td>'."\n";
	                $output .= "\t".'</tr>'."\n";
	            }
	            
	            elseif ($woo_metabox['type'] == 'checkbox'){
	            
	                if($woo_metaboxvalue == 'true') { $checked = ' checked="checked"';} else {$checked='';}
	
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td><input type="checkbox" '.$checked.' class="woo_input_checkbox" value="true"  id="'.$woo_id.'" name="'. $woo_name .'" />';
	                $output .= '<span class="woo_metabox_desc" style="display:inline">'.$woo_metabox['desc'].'</span></td></td><td></td>'."\n";
	                $output .= "\t".'</tr>'."\n";
	            }
	            
	            elseif ($woo_metabox['type'] == 'radio'){
	            
	            $array = $woo_metabox['options'];
	            
	            if($array){
	            
	            $output .= "\t".'<tr>';
	            $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
	            $output .= "\t\t".'<td>';
	            
	                foreach ( $array as $id => $option ) {
	
	                    if($woo_metaboxvalue == $id) { $checked = ' checked';} else {$checked='';}
	
	                        $output .= '<input type="radio" '.$checked.' value="' . $id . '" class="woo_input_radio"  name="'. $woo_name .'" />';
	                        $output .= '<span class="woo_input_radio_desc" style="display:inline">'. $option .'</span><div class="woo_spacer"></div>';
	                    }
	                    $output .=  '</td></td><td></td>'."\n";
	                    $output .= "\t".'</tr>'."\n";    
	                 }
	            }
				elseif ($woo_metabox['type'] == 'images')
				{
				
				$i = 0;
				$select_value = '';
				$layout = '';
	
				foreach ($woo_metabox['options'] as $key => $option) 
					 { 
					 $i++;
					 
					 $checked = '';
					 $selected = '';
					 if($woo_metaboxvalue != '') {
					 	if ($woo_metaboxvalue == $key) { $checked = ' checked'; $selected = 'woo-meta-radio-img-selected'; }
					 } 
					 else {
					 	if ($option['std'] == $key) { $checked = ' checked'; } 
						elseif ($i == 1) { $checked = ' checked'; $selected = 'woo-meta-radio-img-selected'; }
						else { $checked=''; }
						
					 }
						
						$layout .= '<div class="woo-meta-radio-img-label">';			
						$layout .= '<input type="radio" id="woo-meta-radio-img-' . $woo_name . $i . '" class="checkbox woo-meta-radio-img-radio" value="'.$key.'" name="'. $woo_name.'" '.$checked.' />';
						$layout .= '&nbsp;' . $key .'<div class="woo_spacer"></div></div>';
						$layout .= '<img src="'.$option.'" alt="" class="woo-meta-radio-img-img '. $selected .'" onClick="document.getElementById(\'woo-meta-radio-img-'. $woo_metabox["name"] . $i.'\').checked = true;" />';
					}
				
				$output .= "\t".'<tr>';
				$output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
				$output .= "\t\t".'<td class="woo_metabox_fields">';
				$output .= $layout;
				$output .= '<span class="woo_metabox_desc">'.$woo_metabox['desc'].'</span></td></td><td></td>'."\n";
				$output .= '</td>'."\n";
				$output .= "\t".'</tr>'."\n";
							
				}
	            
	            elseif($woo_metabox['type'] == 'upload')
	            {
					if(isset($woo_metabox["default"])) $default = $woo_metabox["default"];
					else $default = '';
	            
	                $output .= "\t".'<tr>';
	                $output .= "\t\t".'<th class="woo_metabox_names"><label for="'.$woo_id.'">'.$woo_metabox['label'].'</label></th>'."\n";
	                $output .= "\t\t".'<td class="woo_metabox_fields">'. woothemes_tumblog_uploader_custom_fields($post->ID,$woo_name,$default,$woo_metabox["desc"]);
	                $output .= '</td>'."\n";
	                $output .= "\t".'</tr>'."\n";
	                
	            }
	        }
	    
	    $output .= '</table>'."\n\n";
	    echo $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	// WooTumblog Custom Metabox Header Code
	/*-----------------------------------------------------------------------------------*/
	
	function woothemes_tumblog_metabox_header(){
	?>
	<script type="text/javascript">
	
	    jQuery(document).ready(function(){
			
	        jQuery('form#post').attr('enctype','multipart/form-data');
	        jQuery('form#post').attr('encoding','multipart/form-data');
	        
	        jQuery('.woo_metaboxes_table th:last, .woo_metaboxes_table td:last').css('border','0');
	        var val = jQuery('input#title').attr('value');
	        if(val == ''){ 
	        jQuery('.woo_metabox_fields .button-highlighted').after("<em class='woo_red_note'>Please add a Title before uploading a file</em>");
	        };
			jQuery('.woo-meta-radio-img-img').click(function(){
					jQuery(this).parent().find('.woo-meta-radio-img-img').removeClass('woo-meta-radio-img-selected');
					jQuery(this).addClass('woo-meta-radio-img-selected');
					
				});
				jQuery('.woo-meta-radio-img-label').hide();
				jQuery('.woo-meta-radio-img-img').show();
				jQuery('.woo-meta-radio-img-radio').hide();
	        <?php //Errors
	        $error_occurred = false;
	        $upload_tracking = get_option('woo_custom_upload_tracking');
	        if(!empty($upload_tracking)){
	        $output = '<div style="clear:both;height:20px;"></div><div class="errors"><ul>' . "\n";
	            $error_shown == false;
	            foreach($upload_tracking as $array )
	            {
	                 if(array_key_exists('error', $array)){
	                        $error_occurred = true;
	                        ?>
	                        jQuery('form#post').before('<div class="updated fade"><p>WooThemes Upload Error: <strong><?php echo $array['option_name'] ?></strong> - <?php echo $array['error'] ?></p></div>');
	                        <?php
	                }
	            }
	        }
			
	        delete_option('woo_upload_custom_errors');
	        ?>
	    });
	
	</script>
	<style type="text/css">
	.woo_input_text { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:80%; font-size:11px; padding: 5px;}
	.woo_input_select { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:60%; font-size:11px; padding: 5px;}
	.woo_input_checkbox { margin:0 10px 0 0; }
	.woo_input_radio { margin:0 10px 0 0; }
	.woo_input_radio_desc { font-size: 12px; color: #666 ; }
	.woo_spacer { display: block; height:5px}
	.woo_metabox_desc { font-size:10px; color:#aaa; display:block}
	.woo_metaboxes_table{ border-collapse:collapse; width:100%}
	.woo_metaboxes_table tr:hover th,
	.woo_metaboxes_table tr:hover td { background:#f8f8f8}
	.woo_metaboxes_table th,
	.woo_metaboxes_table td{ border-bottom:1px solid #ddd; padding:10px 10px;text-align: left; vertical-align:top}
	.woo_metabox_names { width:20%}
	.woo_metabox_fields { width:70%}
	.woo_metabox_image { text-align: right;}
	.woo_red_note { margin-left: 5px; color: #c77; font-size: 10px;}
	.woo_input_textarea { width:80%; height:120px;margin:0 0 10px 0; background:#f0f0f0; color:#444;font-size:11px;padding: 5px;}
	.woo-meta-radio-img-img { border:3px solid #fff; margin:0 5px 10px 0; display:none; cursor:pointer;}
	.woo-meta-radio-img-selected { border:3px solid #ccc}
	.woo-meta-radio-img-label { font-size:12px}
	.woo-meta-radio-img-img:hover {opacity:.8; }
	</style>
	<?php
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* WooTumblog Custom Metabox action */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_custom_enqueue($hook) {
	  	if ($hook == 'post.php' OR $hook == 'post-new.php' OR $hook == 'page-new.php' OR $hook == 'page.php') {
			add_action('admin_head', array(&$this, 'woothemes_tumblog_metabox_header'));
		}
	}
		
}

?>