<?php

// with activate install options
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	
	// Font
	add_option("ct_font", $_POST['ct_font']);
	
	// Upload Custom Logo
	if ( !empty($_FILES['ct_custom_logo_file']['name']) ) {
			$filename = $_FILES['ct_custom_logo_file'];				
			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';
			$uploaded = wp_handle_upload($filename,$override);
			add_option( "ct_custom_logo_url" , $uploaded['url'] );
			
			if( !empty($uploaded['error']) ) {
					echo 'Could not upload logo: ' . $uploaded['error']; 
			}        
	} else {				
			add_option("ct_custom_logo_url", $_POST['ct_custom_logo_url']);
	}
	// Upload Custom Header
	if ( !empty($_FILES['ct_custom_header_file']['name']) ) {
			$filename = $_FILES['ct_custom_header_file'];				
			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';
			$uploaded = wp_handle_upload($filename,$override);
			add_option( "ct_custom_header_url" , $uploaded['url'] );
			
			if( !empty($uploaded['error']) ) {
					echo 'Could not upload header: ' . $uploaded['error']; 
			}        
	} else {				
			add_option("ct_custom_header_url", $_POST['ct_custom_header_url']);
	}
	// Upload Custom Favicon
	if ( !empty($_FILES['ct_custom_favicon_file']['name']) ) {
			$filename = $_FILES['ct_custom_favicon_file'];				
			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';
			$uploaded = wp_handle_upload($filename,$override);
			add_option( "ct_custom_favicon_url" , $uploaded['url'] );
			
			if( !empty($uploaded['error']) ) {
					echo 'Could not upload logo: ' . $uploaded['error']; 
			}        
	} else {				
			add_option("ct_custom_favicon_url", $_POST['ct_custom_favicon_url']);
	}
	// Upload Custom Body Background Image
	if ( !empty($_FILES['ct_custom_bodybg_file']['name']) ) {
			$filename = $_FILES['ct_custom_bodybg_file'];				
			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';
			$uploaded = wp_handle_upload($filename,$override);
			add_option( "ct_body_image" , $uploaded['url'] );
			
			if( !empty($uploaded['error']) ) {
					echo 'Could not upload image: ' . $uploaded['error']; 
			}        
	} else {				
			add_option("ct_body_image", $_POST['ct_body_image']);
	}
	add_option("ct_custom_logo_alt", $_POST['ct_custom_logo_alt']);
	add_option("ct_usetext", $_POST['ct_usetext']);
	// Excerpt Length
	add_option("ct_excerpt_length", $_POST['ct_excerpt_length']);
	// Read More
	add_option("ct_readmore", $_POST['ct_readmore']);
	// Feedburner
	add_option("ct_feedburner", $_POST['ct_feedburner']);
	// Stylesheet
	add_option("ct_stylesheet", $_POST['ct_stylesheet']);
	add_option("ct_usestyles", $_POST['ct_usestyles']);
	add_option("ct_header_color", $_POST['ct_header_color']);
	add_option("ct_tagbar_tbrd_color", $_POST['ct_tagbar_tbrd_color']);
	add_option("ct_tagbar_color", $_POST['ct_tagbar_color']);
	add_option("ct_tagbar_btmbrd_color", $_POST['ct_tagbar_btmbrd_color']);
	add_option("ct_body_color", $_POST['ct_body_color']);
	add_option("ct_body_repeat", $_POST['ct_body_repeat']);
	add_option("ct_body_position", $_POST['ct_body_position']);
	add_option("ct_font_family", $_POST['ct_font_family']);
	add_option("ct_font_size", $_POST['ct_font_size']);
	add_option("ct_line_height", $_POST['ct_line_height']);
	add_option("ct_font_color", $_POST['ct_font_color']);
	add_option("ct_link_color", $_POST['ct_link_color']);
	add_option("ct_vlink_color", $_POST['ct_vlink_color']);
	add_option("ct_hlink_color", $_POST['ct_hlink_color']);
	add_option("ct_alink_color", $_POST['ct_alink_color']);
	add_option("ct_featured_bg_color", $_POST['ct_featured_bg_color']);
	add_option("ct_extrastyles", $_POST['ct_extrastyles']);
	// Single Post
	add_option("ct_dateformat", $_POST['ct_dateformat']);
	add_option("ct_authorinfo", $_POST['ct_authorinfo']);
	add_option("ct_social", $_POST['ct_social']);
	add_option("ct_socialtext", $_POST['ct_socialtext']);
	add_option("ct_facebook", $_POST['ct_facebook']);
	add_option("ct_facebooktext", $_POST['ct_facebooktext']);
	add_option("ct_tweet", $_POST['ct_tweet']);
	add_option("ct_tweettext", $_POST['ct_tweettext']);
	add_option("ct_related", $_POST['ct_related']);
	add_option("ct_comments", $_POST['ct_comments']);
	//Contact Form
	add_option("ct_your_email", $_POST['ct_your_email']);
	add_option("ct_subject", $_POST['ct_subject']);
	add_option("ct_success", $_POST['ct_success']);
	add_option("ct_companyinfo", $_POST['ct_companyinfo']);
	add_option("ct_gmap_key", $_POST['ct_gmap_key']);
	add_option("ct_gmap", $_POST['ct_gmap']);
	add_option("ct_address", $_POST['ct_address']);
	// Flickr Widget
	add_option("ct_custom_joinflickr_url", $_POST['ct_custom_joinflickr_url']);
	// Ads Widget
	add_option("ct_custom_ad1_url", $_POST['ct_custom_ad1_url']);
	add_option("ct_custom_ad1_imgurl", $_POST['ct_custom_ad1_imgurl']);
	add_option("ct_custom_ad1_alt", $_POST['ct_custom_ad1_alt']);
	add_option("ct_custom_ad2_url", $_POST['ct_custom_ad2_url']);
	add_option("ct_custom_ad2_imgurl", $_POST['ct_custom_ad2_imgurl']);
	add_option("ct_custom_ad2_alt", $_POST['ct_custom_ad2_alt']);
	add_option("ct_custom_ad3_url", $_POST['ct_custom_ad3_url']);
	add_option("ct_custom_ad3_imgurl", $_POST['ct_custom_ad3_imgurl']);
	add_option("ct_custom_ad3_alt", $_POST['ct_custom_ad3_alt']);
	add_option("ct_custom_ad4_url", $_POST['ct_custom_ad4_url']);
	add_option("ct_custom_ad4_imgurl", $_POST['ct_custom_ad4_imgurl']);
	add_option("ct_custom_ad4_alt", $_POST['ct_custom_ad4_alt']);
	add_option("ct_custom_ad5_url", $_POST['ct_custom_ad5_url']);
	add_option("ct_custom_ad5_imgurl", $_POST['ct_custom_ad5_imgurl']);
	add_option("ct_custom_ad5_alt", $_POST['ct_custom_ad5_alt']);
	add_option("ct_custom_ad6_url", $_POST['ct_custom_ad6_url']);
	add_option("ct_custom_ad6_imgurl", $_POST['ct_custom_ad6_imgurl']);
	add_option("ct_custom_ad6_alt", $_POST['ct_custom_ad6_alt']);
	add_option("ct_custom_advertise_url", $_POST['ct_custom_advertise_url']);
	// Footer
	add_option("ct_footer_text", $_POST['ct_footer_text']);
	add_option("ct_footer_widgets", $_POST['ct_footer_widgets']);
	// Google Analytics
	add_option("ct_google_analytics", $_POST['ct_google_analytics']);

}

if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	add_action('admin_head','ct_option_setup');
	//Do redirect
	header( 'Location: '.admin_url().'admin.php?page=options_panel.php' ) ;
}

function contempo_admin_head() {
	?>
    <script type="text/javascript">
		jQuery(function(){
			var message = '<p>This theme comes with a <a href="<?php echo admin_url('admin.php?page=functions.php'); ?>">comprehensive options panel</a>. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
			jQuery('.themes-php #message2').html(message);
		});
    </script>
	<?php
}

// Body ID's
function ct_body_id() {

	if (is_home()) {

		echo ' id="home"';
	
	} elseif (is_singular('listings')) {

		echo ' id="listing"';

	} elseif (is_single()) {

		echo ' id="single"';

	} elseif (is_page()) {

		echo ' id="page"';

	} elseif (is_search()) {

		echo ' id="search"';
	
	} elseif (is_archive()) {

		echo ' id="archive"';
	
	}
}

// SEO Friendly Title Tags
function ct_title() {
	
	if (is_category()) {
		echo wp_title(''); echo ' - ';
	
	} elseif (function_exists('is_tag') && is_tag()) {
		single_tag_title('Tag Archive for &quot;'); echo '&quot; - ';
	
	} elseif (is_archive()) {
		wp_title(''); echo ' Archive - ';
	
	} elseif (is_page()) {
		echo wp_title(''); echo ' - ';
	
	} elseif (is_search()) {
		echo 'Search for &quot;'.wp_specialchars(get_query_var('s')).'&quot; - ';
	
	} elseif (!(is_404()) && (is_single()) || (is_page())) {
		wp_title(''); echo ' - ';
	
	} elseif (is_404()) {
		echo 'Not Found - ';
	
	} bloginfo('name');
	
}

//Add WordPress 3.0 Menu Support
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'notebook' ),
) );

add_theme_support( 'menus' );

function ct_nav() { ?>
	<nav class="right">
    	<?php wp_nav_menu( array( 'container_id' => 'nav', 'theme_location' => 'primary' ) ); ?>
    </nav>
<?php }

function contempo_wp_head() {
	
	if(get_option("ct_custom_favicon_url", $single = true) !="") { ?>
    <link rel="shortcut icon" href="<?php echo get_option("ct_custom_favicon_url", $single = true); ?>" />
    <?php } ?>
    
    <!-- jQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <!-- Equal Height Columns -->
    <script src="<?php bloginfo('template_directory'); ?>/js/jquery.equalcolumns.js"></script>
    
    <?php if(is_single()) { ?>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/comments.css" type="text/css" media="screen" />
    <?php } ?>
    
    <?php if(is_page_template('template_contact.php')) { ?>
    <!-- Contact Form Validation and Ajax Submit -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" /> 
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.validationEngine.js" type="text/javascript"></script>
    <script type="text/javascript">
    // Ajax Submit
    // Full documentation on this can be found at http://www.position-absolute.com/articles/jquery-form-validator-because-form-validation-is-a-mess/
	jQuery.noConflict();
    jQuery(document).ready(function() {
        jQuery("#contactform").validationEngine({
            ajaxSubmit: true,
                ajaxSubmitFile: "<?php bloginfo('template_directory'); ?>/includes/ajaxSubmit.php",
                ajaxSubmitMessage: "<?php echo stripslashes(get_option("ct_success", $single = true)); ?>",
            success :  false,
            failure : function() {}
        })
    });
	</script>
    <?php }
	
	//Inject Custom Header Image
	if(get_option("ct_custom_header_url", $single = true)) { ?>
    <style type="text/css">header { background: url(<?php echo get_option("ct_custom_header_url", $single = true); ?>) no-repeat;}</style>
    <?php } else { ?>
    <style type="text/css">header { background: url(<?php bloginfo('template_directory'); ?>/images/header_bg.jpg) no-repeat;}</style>
    <?php }
	
	//Custom Header Color
	if(get_option("ct_custom_header_usecolor", $single = true) =="yes") { ?>
    <style type="text/css">header { background: url(<?php bloginfo('template_directory'); ?>/images/header_gradient.png) no-repeat #<?php echo get_option("ct_custom_header_color", $single = true); ?>;}</style>
    <?php }
    
	//Inject Custom Stylesheet
    if(get_option("ct_usestyles", $single = true) =="yes") { ?>
	<?php include(TEMPLATEPATH . '/includes/custom_stylesheet.php'); ?>
    <?php }
	
	//Inject Custom Fonts
	if(get_option("ct_font", $single = true) =="museosans") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/fonts/museosans.css" type="text/css" media="screen" />
    <?php } elseif(get_option("ct_font", $single = true) =="museoslab") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/fonts/museoslab.css" type="text/css" media="screen" />
    <?php } elseif(get_option("ct_font", $single = true) =="sansation") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/fonts/sansation.css" type="text/css" media="screen" />
    <?php } elseif(get_option("ct_font", $single = true) =="colaborate") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/fonts/colaborate.css" type="text/css" media="screen" />
    <?php } elseif(get_option("ct_font", $single = true) =="titillium") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/fonts/titillium.css" type="text/css" media="screen" />
    <?php } elseif(get_option("ct_font", $single = true) =="quicksand") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/fonts/quicksand.css" type="text/css" media="screen" />
    <?php } elseif(get_option("ct_font", $single = true) =="defaultstack") {}
	
	// Date format
	$GLOBALS['ctdate'] = get_option('ct_dateformat');	
	if ( $GLOBALS['ctdate'] == "" )
		$GLOBALS['ctdate'] = "M j, Y";	

}

function contempo_wp_footer() { ?>
    <!-- Equal Height Columns -->
    <script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
        jQuery('section,#sidebar').equalHeight();
    });
	</script>	
<?php }

// Contact Us Map
function contact_us_map() {
	if(get_option("ct_gmap", $single = true) =="yes") { ?>    
		<script src="http://maps.google.com/maps/api/js?sensor=true"></script>		
		<script>
        function setMapAddress(address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode( { address : address }, function( results, status ) {
                if( status == google.maps.GeocoderStatus.OK ) {
                    var latlng = results[0].geometry.location;
                    var options = {
                        zoom: 15,
                        center: latlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP, 
                        streetViewControl: true
                    };
                    var mymap = new google.maps.Map( document.getElementById( 'map' ), options );   
                    var marker = new google.maps.Marker({
                    map: mymap, 
                    position: results[0].geometry.location
                });		
                }
            } );
        }
        setMapAddress( "<?php echo get_option("ct_address", $single = true); ?>" );
        </script>
        <div id="location" class="right last">
			<?php if(get_option("ct_companyinfo", $single = true) !="") { ?>
                <?php echo stripslashes(get_option("ct_companyinfo", $single = true)); ?>
            <?php } ?>
            <div id="map" class="right last">Loading...</div>
        </div>
    <?php }
}

//Required footer credit for Museo typeface
function footer_font_credit () {
	if(get_option("ct_font", $single = true) =="museosans") { ?>
	Museo Font by <a href="http://www.exljbris.com">Jos Buivenga</a>.
    <?php } elseif(get_option("ct_font", $single = true) =="museoslab") { ?>
	Museo Font by <a href="http://www.exljbris.com">Jos Buivenga</a>.
    <?php }	
}

//Excerpt Length
function new_excerpt_length($length) {
	return 100;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
	return '&hellip;';
}
add_filter('excerpt_more', 'new_excerpt_more');

//Remove <p> tags from the_excerpt
remove_filter('the_excerpt', 'wpautop');

//Allow Shortcodes to be used in widgets
add_filter('widget_text', 'do_shortcode');

//Remove WordPress version number for improved security
remove_action('wp_head', 'wp_generator');

// Pagination
function ct_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages) {
             $pages = 1;
         }
     }   

     if(1 != $pages) {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
		 echo "<div class='clear'></div>\n";
         echo "</div>\n";
     }
}

//Get all of the images attached to the current post
function ct_get_images($size = 'full') {
	global $post;
	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
	$results = array();
	if ($photos) {
		foreach ($photos as $photo) {
			// get the correct image html for the selected size
			$results[] = wp_get_attachment_url($photo->ID);
		}
	}
	return $results;
}

//Get the first image attached to the current post
function ct_get_post_image() {
	global $post;
	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
	if ($photos) {
		$photo = array_shift($photos);
		return wp_get_attachment_url($photo->ID);
	}
	return false;
}
$photo = ct_get_post_image();

//Display first image blog archive
function ct_first_image_blog() {
	$photo = ct_get_post_image();
	if ($photo) { ?>
	<div class="imgwrapblog">
		<a href="<?php the_permalink(); ?>"><img class="blog imgfade" src="<?php bloginfo('template_directory'); ?>/img_resize/timthumb.php?src=<?php echo ct_get_post_image() ?>&h=240&w=563&zc=1" /></a>
    </div>
    <?php }
} ?>