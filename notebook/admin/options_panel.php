<?php
function admin_top_level()
{
	global $top_level_basename;
	$top_level_basename = basename(__FILE__);
	$optionpage_top_level = get_current_theme()." Options";

	add_menu_page($optionpage_top_level, $optionpage_top_level, 7, basename(__FILE__), 'customize_theme_page');
}

add_action('admin_menu', 'admin_top_level');

function customize_theme_page() {

	if ($_POST['save_changes'] == "true") {
		
		// Font
		update_option("ct_font", $_POST['ct_font']);
		
		// Upload Custom Logo
		if ( !empty($_FILES['ct_custom_logo_file']['name']) ) {
				$filename = $_FILES['ct_custom_logo_file'];				
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				$uploaded = wp_handle_upload($filename,$override);
				update_option( "ct_custom_logo_url" , $uploaded['url'] );
				
				if( !empty($uploaded['error']) ) {
						echo 'Could not upload logo: ' . $uploaded['error']; 
				}        
		} else {				
				update_option("ct_custom_logo_url", $_POST['ct_custom_logo_url']);
		}
		// Upload Custom Header
		if ( !empty($_FILES['ct_custom_header_file']['name']) ) {
				$filename = $_FILES['ct_custom_header_file'];				
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				$uploaded = wp_handle_upload($filename,$override);
				update_option( "ct_custom_header_url" , $uploaded['url'] );
				
				if( !empty($uploaded['error']) ) {
						echo 'Could not upload header: ' . $uploaded['error']; 
				}        
		} else {				
				update_option("ct_custom_header_url", $_POST['ct_custom_header_url']);
		}
		// Upload Custom Favicon
		if ( !empty($_FILES['ct_custom_favicon_file']['name']) ) {
				$filename = $_FILES['ct_custom_favicon_file'];				
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				$uploaded = wp_handle_upload($filename,$override);
				update_option( "ct_custom_favicon_url" , $uploaded['url'] );
				
				if( !empty($uploaded['error']) ) {
						echo 'Could not upload logo: ' . $uploaded['error']; 
				}        
		} else {				
				update_option("ct_custom_favicon_url", $_POST['ct_custom_favicon_url']);
		}
		// Upload Custom Body Background Image
		if ( !empty($_FILES['ct_custom_bodybg_file']['name']) ) {
				$filename = $_FILES['ct_custom_bodybg_file'];				
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';
				$uploaded = wp_handle_upload($filename,$override);
				update_option( "ct_body_image" , $uploaded['url'] );
				
				if( !empty($uploaded['error']) ) {
						echo 'Could not upload image: ' . $uploaded['error']; 
				}        
		} else {				
				update_option("ct_body_image", $_POST['ct_body_image']);
		}
		update_option("ct_custom_logo_alt", $_POST['ct_custom_logo_alt']);
		// Header Color
		update_option("ct_custom_header_usecolor", $_POST['ct_custom_header_usecolor']);
		update_option("ct_custom_header_color", $_POST['ct_custom_header_color']);
		// Excerpt Length
		update_option("ct_excerpt_length", $_POST['ct_excerpt_length']);
		// Read More
		update_option("ct_readmore", $_POST['ct_readmore']);
		// Feedburner
		update_option("ct_feedburner", $_POST['ct_feedburner']);
		// Stylesheet
		update_option("ct_stylesheet", $_POST['ct_stylesheet']);
		update_option("ct_usestyles", $_POST['ct_usestyles']);
		update_option("ct_header_color", $_POST['ct_header_color']);
		update_option("ct_tagbar_tbrd_color", $_POST['ct_tagbar_tbrd_color']);
		update_option("ct_tagbar_color", $_POST['ct_tagbar_color']);
		update_option("ct_tagbar_btmbrd_color", $_POST['ct_tagbar_btmbrd_color']);
		update_option("ct_body_color", $_POST['ct_body_color']);
		update_option("ct_body_repeat", $_POST['ct_body_repeat']);
		update_option("ct_body_position", $_POST['ct_body_position']);
		update_option("ct_font_family", $_POST['ct_font_family']);
		update_option("ct_font_size", $_POST['ct_font_size']);
		update_option("ct_line_height", $_POST['ct_line_height']);
		update_option("ct_font_color", $_POST['ct_font_color']);
		update_option("ct_link_color", $_POST['ct_link_color']);
		update_option("ct_vlink_color", $_POST['ct_vlink_color']);
		update_option("ct_hlink_color", $_POST['ct_hlink_color']);
		update_option("ct_alink_color", $_POST['ct_alink_color']);
		update_option("ct_featured_bg_color", $_POST['ct_featured_bg_color']);
		update_option("ct_extrastyles", $_POST['ct_extrastyles']);
		// Single Post
		update_option("ct_dateformat", $_POST['ct_dateformat']);
		update_option("ct_authorinfo", $_POST['ct_authorinfo']);
		update_option("ct_social", $_POST['ct_social']);
		update_option("ct_socialtext", $_POST['ct_socialtext']);
		update_option("ct_facebook", $_POST['ct_facebook']);
		update_option("ct_facebooktext", $_POST['ct_facebooktext']);
		update_option("ct_tweet", $_POST['ct_tweet']);
		update_option("ct_tweettext", $_POST['ct_tweettext']);
		update_option("ct_related", $_POST['ct_related']);
		update_option("ct_comments", $_POST['ct_comments']);
		//Contact Form
		update_option("ct_your_email", $_POST['ct_your_email']);
		update_option("ct_subject", $_POST['ct_subject']);
		update_option("ct_success", $_POST['ct_success']);
		update_option("ct_companyinfo", $_POST['ct_companyinfo']);
		update_option("ct_gmap_key", $_POST['ct_gmap_key']);
		update_option("ct_gmap", $_POST['ct_gmap']);
		update_option("ct_address", $_POST['ct_address']);
		// Flickr Widget
		update_option("ct_custom_joinflickr_url", $_POST['ct_custom_joinflickr_url']);
		// Ads Widget
		update_option("ct_custom_ad1_url", $_POST['ct_custom_ad1_url']);
		update_option("ct_custom_ad1_imgurl", $_POST['ct_custom_ad1_imgurl']);
		update_option("ct_custom_ad1_alt", $_POST['ct_custom_ad1_alt']);
		update_option("ct_custom_ad2_url", $_POST['ct_custom_ad2_url']);
		update_option("ct_custom_ad2_imgurl", $_POST['ct_custom_ad2_imgurl']);
		update_option("ct_custom_ad2_alt", $_POST['ct_custom_ad2_alt']);
		update_option("ct_custom_ad3_url", $_POST['ct_custom_ad3_url']);
		update_option("ct_custom_ad3_imgurl", $_POST['ct_custom_ad3_imgurl']);
		update_option("ct_custom_ad3_alt", $_POST['ct_custom_ad3_alt']);
		update_option("ct_custom_ad4_url", $_POST['ct_custom_ad4_url']);
		update_option("ct_custom_ad4_imgurl", $_POST['ct_custom_ad4_imgurl']);
		update_option("ct_custom_ad4_alt", $_POST['ct_custom_ad4_alt']);
		update_option("ct_custom_ad5_url", $_POST['ct_custom_ad5_url']);
		update_option("ct_custom_ad5_imgurl", $_POST['ct_custom_ad5_imgurl']);
		update_option("ct_custom_ad5_alt", $_POST['ct_custom_ad5_alt']);
		update_option("ct_custom_ad6_url", $_POST['ct_custom_ad6_url']);
		update_option("ct_custom_ad6_imgurl", $_POST['ct_custom_ad6_imgurl']);
		update_option("ct_custom_ad6_alt", $_POST['ct_custom_ad6_alt']);
		update_option("ct_custom_advertise_url", $_POST['ct_custom_advertise_url']);
		// Footer
		update_option("ct_footer_text", $_POST['ct_footer_text']);
		update_option("ct_footer_widgets", $_POST['ct_footer_widgets']);
		// Google Analytics
		update_option("ct_google_analytics", $_POST['ct_google_analytics']);

	}
	
	// Font
	$ct_font = get_option("ct_font");	
	// Custom Logo
	$ct_custom_logo_url = get_option("ct_custom_logo_url");
	$ct_custom_logo_alt = get_option("ct_custom_logo_alt");
	// Custom Header
	$ct_custom_header_url = get_option("ct_custom_header_url");
	$ct_custom_header_usecolor = get_option("ct_custom_header_usecolor");
	$ct_custom_header_color = get_option("ct_custom_header_color");
	// Custom Favicon
	$ct_custom_favicon_url = get_option("ct_custom_favicon_url");
	// Excerpt Length
	$ct_excerpt_length = get_option("ct_excerpt_length");
	// Read More
	$ct_readmore = get_option("ct_readmore");
	// Feedburner
	$ct_feedburner = get_option("ct_feedburner");
	// Stylesheet
	$ct_stylesheet = get_option("ct_stylesheet");
	$ct_header_color = get_option("ct_header_color");
	$ct_tagbar_tbrd_color = get_option("ct_tagbar_tbrd_color");
	$ct_tagbar_color = get_option("ct_tagbar_color");
	$ct_tagbar_btmbrd_color = get_option("ct_tagbar_btmbrd_color");
	$ct_body_color = get_option("ct_body_color");
	$ct_body_image = get_option("ct_body_image");
	$ct_body_repeat = get_option("ct_body_repeat");
	$ct_body_position = get_option("ct_body_position");
	$ct_usestyles = get_option("ct_usestyles");
	$ct_font_family = get_option("ct_font_family");
	$ct_font_size = get_option("ct_font_size");
	$ct_line_height = get_option("ct_line_height");
	$ct_font_color = get_option("ct_font_color");
	$ct_link_color = get_option("ct_link_color");
	$ct_vlink_color = get_option("ct_vlink_color");
	$ct_hlink_color = get_option("ct_hlink_color");
	$ct_alink_color = get_option("ct_alink_color");
	$ct_featured_bg_color = get_option("ct_featured_bg_color");
	$ct_extrastyles = get_option("ct_extrastyles");
	//Single Post
	$ct_dateformat = get_option("ct_dateformat");
	$ct_authorinfo = get_option("ct_authorinfo");
	$ct_social = get_option("ct_social");
	$ct_socialtext = get_option("ct_socialtext");
	$ct_facebook = get_option("ct_facebook");
	$ct_facebooktext = get_option("ct_facebooktext");
	$ct_tweet = get_option("ct_tweet");
	$ct_tweettext = get_option("ct_tweettext");
	$ct_related = get_option("ct_related");
	$ct_comments = get_option("ct_comments");
	// Contact Form
	$ct_your_email = get_option("ct_your_email");
	$ct_subject = get_option("ct_subject");
	$ct_success = get_option("ct_success");
	$ct_companyinfo = get_option("ct_companyinfo");
	$ct_gmap_key = get_option("ct_gmap_key");
	$ct_gmap = get_option("ct_gmap");
	$ct_address = get_option("ct_address");
	// Flickr Widget
	$ct_custom_joinflickr_url = get_option("ct_custom_joinflickr_url");
	// Ads Widget
	$ct_custom_ad1_url = get_option("ct_custom_ad1_url");
	$ct_custom_ad1_imgurl = get_option("ct_custom_ad1_imgurl");
	$ct_custom_ad1_alt = get_option("ct_custom_ad1_alt");
	$ct_custom_ad2_url = get_option("ct_custom_ad2_url");
	$ct_custom_ad2_imgurl = get_option("ct_custom_ad2_imgurl");
	$ct_custom_ad2_alt = get_option("ct_custom_ad2_alt");
	$ct_custom_ad3_url = get_option("ct_custom_ad3_url");
	$ct_custom_ad3_imgurl = get_option("ct_custom_ad3_imgurl");
	$ct_custom_ad3_alt = get_option("ct_custom_ad3_alt");
	$ct_custom_ad4_url = get_option("ct_custom_ad4_url");
	$ct_custom_ad4_imgurl = get_option("ct_custom_ad4_imgurl");
	$ct_custom_ad4_alt = get_option("ct_custom_ad4_alt");
	$ct_custom_ad5_url = get_option("ct_custom_ad5_url");
	$ct_custom_ad5_imgurl = get_option("ct_custom_ad5_imgurl");
	$ct_custom_ad5_alt = get_option("ct_custom_ad5_alt");
	$ct_custom_ad6_url = get_option("ct_custom_ad6_url");
	$ct_custom_ad6_imgurl = get_option("ct_custom_ad6_imgurl");
	$ct_custom_ad6_alt = get_option("ct_custom_ad6_alt");
	$ct_custom_advertise_url = get_option("ct_custom_advertise_url");
	// Footer
	$ct_footer_text = get_option("ct_footer_text");
	$ct_footer_widgets = get_option("ct_footer_widgets");
	// Google Analytics
	$ct_google_analytics = get_option("ct_google_analytics");

	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';

?>
	
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/admin/css/styles.css" type="text/css" media="screen" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <link rel="stylesheet" media="screen" type="text/css" href="<?php bloginfo('template_directory'); ?>/admin/css/colorpicker.css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/admin/js/colorpicker.js"></script>
    
     <script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function(){
		jQuery('#colorpickerField1,#colorpickerField2,#colorpickerField3,#colorpickerField4,#colorpickerField5,#colorpickerField6,#colorpickerField7,#colorpickerField8,#colorpickerField9,#colorpickerField10,#colorpickerField11,#colorpickerField12').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				jQuery(el).val(hex);
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			jQuery(this).ColorPickerSetColor(this.value);
		});
		
		// Tabs
		jQuery('#optionswrap div.adminoptions').css('display','none');
		jQuery('#optionswrap div:first').css('display','block');
		jQuery('#optionswrap ul li:first').addClass('tabsactive');
		jQuery('#optionswrap ul li a.tab').click(function(){ 
		jQuery('#optionswrap ul li').removeClass('tabsactive');
		jQuery(this).parent().addClass('tabsactive'); 
		var currentTab = jQuery(this).attr('href'); 
		jQuery('#optionswrap div.adminoptions').css('display','none');
		jQuery(currentTab).show();
		return false;
		});
		// Inner Skin Tabs
		jQuery('#innergeneraloptionswrap div.inneradminoptions').css('display','none');
		jQuery('#innergeneraloptionswrap div:first').css('display','block');
		jQuery('#innergeneraloptionswrap ul li:first').addClass('tabsactive');
		jQuery('#innergeneraloptionswrap ul li a.innertab').click(function(){ 
		jQuery('#innergeneraloptionswrap ul li').removeClass('tabsactive');
		jQuery(this).parent().addClass('tabsactive'); 
		var currentTab = jQuery(this).attr('href'); 
		jQuery('#innergeneraloptionswrap div.inneradminoptions').css('display','none');
		jQuery(currentTab).show();
		return false;
		});
		// Inner Skin Tabs
		jQuery('#innerskinoptionswrap div.inneradminoptions').css('display','none');
		jQuery('#innerskinoptionswrap div:first').css('display','block');
		jQuery('#innerskinoptionswrap ul li:first').addClass('tabsactive');
		jQuery('#innerskinoptionswrap ul li a.innertab').click(function(){ 
		jQuery('#innerskinoptionswrap ul li').removeClass('tabsactive');
		jQuery(this).parent().addClass('tabsactive'); 
		var currentTab = jQuery(this).attr('href'); 
		jQuery('#innerskinoptionswrap div.inneradminoptions').css('display','none');
		jQuery(currentTab).show();
		return false;
		});	
		// Inner Single Tabs
		jQuery('#innersingleoptionswrap div.inneradminoptions').css('display','none');
		jQuery('#innersingleoptionswrap div:first').css('display','block');
		jQuery('#innersingleoptionswrap ul li:first').addClass('tabsactive');
		jQuery('#innersingleoptionswrap ul li a.innertab').click(function(){ 
		jQuery('#innersingleoptionswrap ul li').removeClass('tabsactive');
		jQuery(this).parent().addClass('tabsactive'); 
		var currentTab = jQuery(this).attr('href'); 
		jQuery('#innersingleoptionswrap div.inneradminoptions').css('display','none');
		jQuery(currentTab).show();
		return false;
		});
		// Inner Contact Tabs
		jQuery('#innercontactoptionswrap div.inneradminoptions').css('display','none');
		jQuery('#innercontactoptionswrap div:first').css('display','block');
		jQuery('#innercontactoptionswrap ul li:first').addClass('tabsactive');
		jQuery('#innercontactoptionswrap ul li a.innertab').click(function(){ 
		jQuery('#innercontactoptionswrap ul li').removeClass('tabsactive');
		jQuery(this).parent().addClass('tabsactive'); 
		var currentTab = jQuery(this).attr('href'); 
		jQuery('#innercontactoptionswrap div.inneradminoptions').css('display','none');
		jQuery(currentTab).show();
		return false;
		});
	});
	</script>

	<div class="wrap">

		<form name="frm_ct_options" method="post" action="" enctype="multipart/form-data">
        
        <div id="poststuff" class="ui-sortable">

			<div id="cpoptions" class="postbox">

				<h3>Notebook Theme Customization Options</h3>
                
                <div id="savesettings">
                    <input type="hidden" name="save_changes" value="true" />
					<input type="submit" name="Submit" value="Save All Changes" class="right" />
                    	<div class="clear"></div>
                </div>
                
                	<div class="clear"></div>
                    
                <div id="optionswrap">
                 
                    <ul id="optionsnav" class="left">
                        <li><a class="menu-top tab" href="#general">General Settings</a></li>
                        <li><a class="menu-top tab" href="#customskin">Create a Skin</a></li>
                        <li><a class="menu-top tab" href="#singlepost">Single Post</a></li>
                        <li><a class="menu-top tab" href="#contactform">Contact Page</a></li>
                        <li><a class="menu-top tab" href="#admgmt">Ad Management</a></li>
                        <li><a class="menu-top tab" href="#foot">Footer</a></li>
                    </ul>
    
                    <div id="general" class="adminoptions right">
                    
                    	<div id="innergeneraloptionswrap">
                         
                            <ul id="inneroptionsnav" class="left">
                                <li><a class="menu-top innertab" href="#generalsettings">General</a></li>
                                <li><a class="menu-top innertab" href="#moresettings">Favicon &amp; Feedburner</a></li>
                            </ul>	
                    		
                            <div id="generalsettings" class="inneradminoptions">
                    
                                <h2>Choose a font for the Navigation and Headings</h2>
                                <select name="ct_font">
                                	<option value="defaultstack" <?php if($ct_font == "defaultstack"){echo "selected";} ?>>Arial, Helvetica, san-serif (Default)</option>
                                    <option value="museosans" <?php if($ct_font == "museosans"){echo "selected";} ?>>Museo Sans</option>
                                    <option value="museoslab" <?php if($ct_font == "museoslab"){echo "selected";} ?>>Museo Slab</option>
                                    <option value="sansation" <?php if($ct_font == "sansation"){echo "selected";} ?>>Sansation</option>
                                    <option value="colaborate" <?php if($ct_font == "colaborate"){echo "selected";} ?>>Colaborate</option>
                                    <option value="titillium" <?php if($ct_font == "titillium"){echo "selected";} ?>>Titillium</option>
                                    <option value="quicksand" <?php if($ct_font == "quicksand"){echo "selected";} ?>>Quicksand</option>
                                </select>
                                <p><em>Choose from six great custom fonts.</em></p>
                            
                                <!--<h2>Choose a Skin</h2>
                                <select name="ct_stylesheet">				
                                    <option value="default" <?php if($ct_stylesheet == "default"){echo "selected";} ?>>Default</option>
                                    <option value="wine" <?php if($ct_stylesheet == "wine"){echo "selected";} ?>>Wine</option>
                                    <option value="dusk" <?php if($ct_stylesheet == "dusk"){echo "selected";} ?>>Dusk</option>
                                    <option value="smokey" <?php if($ct_stylesheet == "smokey"){echo "selected";} ?>>Smokey</option>
                                    <option value="bw" <?php if($ct_stylesheet == "bw"){echo "selected";} ?>>Black &amp; White</option>
                                    <option value="green" <?php if($ct_stylesheet == "green"){echo "selected";} ?>>Green</option>
                                    <option value="blue" <?php if($ct_stylesheet == "blue"){echo "selected";} ?>>Blue</option>
                                    <option value="purple" <?php if($ct_stylesheet == "purple"){echo "selected";} ?>>Purple</option>
                                    <option value="red" <?php if($ct_stylesheet == "red"){echo "selected";} ?>>Red</option>
                                    <option value="rustic" <?php if($ct_stylesheet == "rustic"){echo "selected";} ?>>Rustic</option>
                                </select>
                                <p><em>Choose a pre-built background style here, or make your own in the <strong>Create a Skin</strong> tab.</em></p>-->
                                
                                <h2>Upload a Custom Logo</h2>
                                <input name="ct_custom_logo_file" id="ct_custom_logo_file" type="file" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                                <p><em>Or paste the full URL (beginning with http://) in the field below.</em></p>
                                <input name="ct_custom_logo_url" type="text" size="100" value="<?php echo $ct_custom_logo_url ?>" />
                                        
                                <h2>Custom Logo Image ALT</h2>                    
                                <input name="ct_custom_logo_alt" type="text" size="100" value="<?php echo $ct_custom_logo_alt ?>" />
                                
                                <h2>Upload a Custom Header</h2>
                                <input name="ct_custom_header_file" id="ct_custom_header_file" type="file" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                                <p><em>Needs to be 945x241, or paste the full URL (beginning with http://) in the field below.</em></p>
                                <input name="ct_custom_header_url" type="text" size="100" value="<?php echo $ct_custom_header_url ?>" />
                                
                                <h2>Use Background Color for Header?</h2>
                                <select name="ct_custom_header_usecolor">
                                	<option value="no" <?php if($ct_custom_header_usecolor == "no"){echo "selected";} ?>>No (Default)</option>
                                    <option value="yes" <?php if($ct_custom_header_usecolor == "yes"){echo "selected";} ?>>Yes</option>
                                </select>
                                <p><em>Choose to use a background color instead of an image, applies gradient automatically.</em></p>
                                
                                <h2>Header Background Color</h2>
                                <input name="ct_custom_header_color" id="colorpickerField2" type="text" size="100" value="<?php echo $ct_custom_header_color ?>" />
                                <p><em>Select your header background color.</em></p>
                                
                         </div>
                         <div id="moresettings" class="inneradminoptions">
                         		<h2>Custom Favicon URL</h2>
                                <input name="ct_custom_favicon_file" id="ct_custom_favicon_file" type="file" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                                <p><em>Must be a .ico file. Don't have one? Create one <a href="http://tools.dynamicdrive.com/favicon/" target="_blank">here</a>.</em></p>
                                <input name="ct_custom_favicon_url" type="text" size="100" value="<?php echo $ct_custom_favicon_url ?>" />
                                
                                <h2>Feedburner RSS Feed URL</h2>                      
                                <input name="ct_feedburner" type="text" size="100" value="<?php echo $ct_feedburner ?>" /><br />
                                <p><em>Use Feedburner for your RSS? Enter your URL here.</em></p>
                        	</div>
						</div>
                    </div>
                    
                    <div id="customskin" class="adminoptions right">
                        
                        <div id="innerskinoptionswrap">
                         
                            <ul id="inneroptionsnav" class="left">
                                <li><a class="menu-top innertab" href="#generalskin">Header &amp; Body</a></li>
                                <li><a class="menu-top innertab" href="#typography">Typography</a></li>
                                <li><a class="menu-top innertab" href="#extrastyles">Extra Styles</a></li>
                            </ul>	
                    		
                            <div id="generalskin" class="inneradminoptions">
                                <h2>Use Custom Styles</h2>
                                <select name="ct_usestyles">				
                                    <option value="no" <?php if($ct_usestyles == "no"){echo "selected";} ?>>No</option>
                                    <option value="yes" <?php if($ct_usestyles == "yes"){echo "selected";} ?>>Yes</option>
                                </select>
                                <p><em>Select "Yes" from the dropdown if you would like to enable use of the custom style fields below.</em></p>
                                
                                <h2>Header Bar Color</h2>
                                <input name="ct_header_color" id="colorpickerField8" type="text" size="100" value="<?php echo $ct_header_color ?>" />
                                <p><em>Default color is #212121, this is the large full width bar that contains the logo and nav.</em></p>
                                
                                <h2>Tagline/Search Bar - Top Border Color</h2>
                                <input name="ct_tagbar_tbrd_color" id="colorpickerField10" type="text" size="100" value="<?php echo $ct_tagbar_tbrd_color ?>" />
                                <p><em>Default color is #ff7679, this is the large full width bar that contains the tagline and search.</em></p>
                                
                                <h2>Tagline/Search Bar - Background Color</h2>
                                <input name="ct_tagbar_color" id="colorpickerField9" type="text" size="100" value="<?php echo $ct_tagbar_color ?>" />
                                <p><em>Default color is #df151a, this is the large full width bar that contains the tagline and search.</em></p>
                                
                                <h2>Tagline/Search Bar - Bottom Border Color</h2>
                                <input name="ct_tagbar_btmbrd_color" id="colorpickerField11" type="text" size="100" value="<?php echo $ct_tagbar_btmbrd_color ?>" />
                                <p><em>Default color is #7e0509, this is the large full width bar that contains the tagline and search.</em></p>
                                
                                <h2>Body Background Color</h2>
                                <input name="ct_body_color" id="colorpickerField1" type="text" size="100" value="<?php echo $ct_body_color ?>" />
                                <p><em>Default color is #efefef</em></p>
                                
                                <h2>Upload a Body Background Image</h2>
                                <input name="ct_custom_bodybg_file" id="ct_custom_bodybg_file" type="file" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                                <p><em>Or paste the full URL (beginning with http://) in the field below.</em></p>
                                <input name="ct_body_image" type="text" size="100" value="<?php echo $ct_body_image ?>" />
                                
                                <h2>Body Background Position</h2>
                                <input name="ct_body_position" type="text" size="100" value="<?php echo $ct_body_position ?>" />
                                <p><em>Choose the position for your background image, examples: top left, top center, bottom left, x% y%, xpos ypos. Not sure, need some help? Take a look at the <a href="http://www.w3schools.com/css/pr_background-position.asp" target="_blank">W3C Schools Background Position Reference</a>.</em></p>
                                
                                <h2>Body Background Image Repeat</h2>
                                <select name="ct_body_repeat">				
                                      <option value="repeat" <?php if($ct_body_repeat == "repeat"){echo "selected";} ?>>Repeat</option>
                                      <option value="repeat-x" <?php if($ct_body_repeat == "repeat-x"){echo "selected";} ?>>Repeat-x</option>
                                      <option value="repeat-y" <?php if($ct_body_repeat == "repeat-y"){echo "selected";} ?>>Repeat-y</option>
                                      <option value="no-repeat" <?php if($ct_body_repeat == "no-repeat"){echo "selected";} ?>>No Repeat</option>
                                      <option value="inherit" <?php if($ct_body_repeat == "inherit"){echo "selected";} ?>>inherit</option>
                                </select>
                                <p><em>Choose to have your background image to repeat or not. Not sure, need some help? Take a look at the <a href="http://www.w3schools.com/css/pr_background-repeat.asp" target="_blank">W3C Schools Background Repeat Reference</a>.</em></p>

                            </div>
                            
                            <div id="typography" class="inneradminoptions">
                                <h2>Font Family</h2>
                                <input name="ct_font_family" type="text" size="100" value="<?php echo stripslashes($ct_font_family); ?>" />
                                <p><em>Default is Arial, Helvetica, sans-serif, some example stacks: Verdana, Geneva, sans-serif | Georgia, "Times New Roman", Times, serif</em></p>
                                
                                <h2>Font Size</h2>
                                <input name="ct_font_size" type="text" size="100" value="<?php echo $ct_font_size ?>" />
                                <p><em>Default size is 14px</em></p>
                                
                                <h2>Line Height</h2>
                                <input name="ct_line_height" type="text" size="100" value="<?php echo $ct_line_height ?>" />
                                <p><em>Default size is 20px</em></p>
                                
                                <h2>Font Color</h2>
                                <input name="ct_font_color" id="colorpickerField2" type="text" size="100" value="<?php echo $ct_font_color ?>" />
                                <p><em>Default color is #323232</em></p>
                                
                                <h2>Link Color</h2>
                                <input name="ct_link_color" id="colorpickerField3" type="text" size="100" value="<?php echo $ct_link_color ?>" />
                                <p><em>Default color is #5b8cd5</em></p>
                                
                                <h2>Visited Link Color</h2>
                                <input name="ct_vlink_color" id="colorpickerField4" type="text" size="100" value="<?php echo $ct_vlink_color ?>" />
                                <p><em>Default color is #5b8cd5</em></p>
                                
                                <h2>Hover Link Color</h2>
                                <input name="ct_hlink_color" id="colorpickerField5" type="text" size="100" value="<?php echo $ct_hlink_color ?>" />
                                <p><em>Default color is #2e466a</em></p>
                                
                                <h2>Active Link Color</h2>
                                <input name="ct_alink_color" id="colorpickerField6" type="text" size="100" value="<?php echo $ct_alink_color ?>" />
                                <p><em>Default color is #5b8cd5</em></p>
                            </div>
                            
                            <div id="extrastyles" class="inneradminoptions">
                                <h2>Extra Styles</h2>
                                <textarea name="ct_extrastyles" cols="64" rows="20"><?php echo stripslashes($ct_extrastyles); ?></textarea>
                                <p><em>Add as much extra CSS here as you like, do not include the <style></style> tags.</em></p>
							</div>
                    	</div>
                    </div>

                    <div id="singlepost" class="adminoptions right">
                    	
                        <div id="innersingleoptionswrap">
                         
                            <ul id="inneroptionsnav" class="left">
                                <li><a class="menu-top innertab" href="#generalsingle">General Settings</a></li>
                                <li><a class="menu-top innertab" href="#social">Social Buttons</a></li>
                            </ul>
                    		
                            <div id="generalsingle" class="inneradminoptions">
                                <h2>Date Format</h2>
                                <input name="ct_dateformat" type="text" size="100" value="<?php echo $ct_dateformat ?>" />
                                <p><em>PHP date format, default is F jS, Y - more information on formatting date and time <a href="http://php.net/manual/en/function.date.php" target="_blank">here</a>.</em></p>
                                
                                <h2>Display Author Information?</h2>
                                <select name="ct_authorinfo">				
                                    <option value="yes" <?php if($ct_authorinfo == "yes"){echo "selected";} ?>>Yes</option>
                                    <option value="no" <?php if($ct_authorinfo == "no"){echo "selected";} ?>>No</option>
                                </select>
                                <p><em>This block contains the authors avatar, full name and short bio, located at the end of the post content.</em></p>
                                
                                <h2>Display Social buttons?</h2>
                                <select name="ct_social">				
                                    <option value="yes" <?php if($ct_social == "yes"){echo "selected";} ?>>Yes</option>
                                    <option value="no" <?php if($ct_social == "no"){echo "selected";} ?>>No</option>
                                </select>
                                <p><em>Adds a block that contains the "Send to Facebook" &amp; "Tweet this!" buttons.</em></p>
                                
                                <h2>Display Comments?</h2>
                                <select name="ct_comments">				
                                    <option value="yes" <?php if($ct_comments == "yes"){echo "selected";} ?>>Yes</option>
                                    <option value="no" <?php if($ct_comments == "no"){echo "selected";} ?>>No</option>
                                </select>
                                <p><em>Choose to turn comments on/off globally for posts.</em></p>                         
                            </div>
                            
                            <div id="social" class="inneradminoptions">
                            	<h2>Lead Text</h2>
                                <input name="ct_socialtext" type="text" size="100" value="<?php if(get_option("ct_socialtext", $single = true) !="") { echo stripslashes($ct_socialtext); } else { echo stripslashes("Enjoyed this Post? Share it!"); } ?>" />
                                <p><em><strong>HTML OK</strong> - Text displayed before the buttons, default is "Enjoyed this Post? Share it!".</em></p>
                                
                                <h2>Display "Send to Facebook" button?</h2>
                                <select name="ct_facebook">				
                                    <option value="yes" <?php if($ct_facebook == "yes"){echo "selected";} ?>>Yes</option>
                                    <option value="no" <?php if($ct_facebook == "no"){echo "selected";} ?>>No</option>
                                </select>
                                <p><em>Adds a simple "Send to Facebook" button at the end of your posts.</em></p>
                                
                                <h2>Facebook button text</h2>
                                <input name="ct_facebooktext" type="text" size="100" value="<?php if(get_option("ct_facebooktext", $single = true) !="") { echo $ct_facebooktext; } else { echo "Share on Facebook"; } ?>" />
                                <p><em>Text displayed on the facebook button, default is "Share on Facebook".</em></p>
                                
                                <h2>Display "Tweet This!" button?</h2>
                                <select name="ct_tweet">				
                                    <option value="yes" <?php if($ct_tweet == "yes"){echo "selected";} ?>>Yes</option>
                                    <option value="no" <?php if($ct_tweet == "no"){echo "selected";} ?>>No</option>
                                </select>
                                <p><em>Adds a simple "Tweet This!" button at the end of your posts.</em></p>
                                
                                <h2>Tweet This button text</h2>
                                <input name="ct_tweettext" type="text" size="100" value="<?php if(get_option("ct_tweettext", $single = true) !="") { echo $ct_tweettext; } else { echo "Tweet This!"; } ?>" />
                                <p><em>Text displayed on the tweet this button, default is "Tweet This!".</em></p>
                    		</div>
                            
                        </div>
                        
                    </div>
                    
                    <div id="contactform" class="adminoptions right">
                    
                    	<div id="innercontactoptionswrap">
                    
                            <ul id="inneroptionsnav" class="left">
                                <li><a class="menu-top innertab" href="#contact">Contact Form</a></li>
                                <li><a class="menu-top innertab" href="#infomap">Info Block &amp; Map</a></li>
                            </ul>
                            
                            <div id="contact" class="inneradminoptions">                    
                                <h2>Your Email</h2>
                                <input name="ct_your_email" type="text" size="100" value="<?php echo $ct_your_email ?>" />
                                <p><em>The email address you would like your form submissions sent to (e.g. youremail@yourdomain.com).</em></p>
                                
                                <h2>Subject</h2>
                                <input name="ct_subject" type="text" size="100" value="<?php echo $ct_subject ?>" />
                                <p><em>Subject of the email sent by the contact form</em></p>
                                
                                <h2>Success Message</h2>
                                <textarea name="ct_success" cols="64" rows="10"><?php echo stripslashes($ct_success); ?></textarea>
                                <p><em><strong>HTML Ok</strong> - This is the text displayed if the form submission has been successful.</em></p>
                            </div>
                            
                            <div id="infomap" class="inneradminoptions">
                                <h2>Info Block</h2>
                                <textarea name="ct_companyinfo" cols="64" rows="10"><?php echo stripslashes($ct_companyinfo); ?></textarea>
                                <p><em><strong>HTML Ok</strong> - This is the text area displayed above the google map.</em></p>
                                
                                <h2>Display Google Map</h2>
                                <select name="ct_gmap">				
                                    <option value="yes" <?php if($ct_gmap == "yes"){echo "selected";} ?>>Yes</option>
                                    <option value="no" <?php if($ct_gmap == "no"){echo "selected";} ?>>No</option>
                                </select>
                                <p><em>Choose to turn the Google Map inside of Block Two on the homepage On/Off.</em></p>
                                
                                <h2>Your Company Address</h2>
                                <input name="ct_address" type="text" size="100" value="<?php echo $ct_address ?>" />
                                <p><em>The address of your company to be used in the Google Map, needs to be entered in this format: <strong>San Diego, CA 350 Camino De La Reina, 92108</strong></em></p>
                            </div>
                        </div>
                    </div>
                    
                    <div id="admgmt" class="adminoptions right">
                    	
                        <h2>Banner 1 Clickthrough URL</h2>
                        <input name="ct_custom_ad1_url" type="text" size="100" value="<?php echo $ct_custom_ad1_url ?>" />
                        
                        <h2>Banner 1 Image URL</h2>
                        <input name="ct_custom_ad1_imgurl" type="text" size="100" value="<?php echo $ct_custom_ad1_imgurl ?>" />
                        
                        <h2>Banner 1 Image ALT</h2>
                        <input name="ct_custom_ad1_alt" type="text" size="100" value="<?php echo $ct_custom_ad1_alt ?>" />
                        
                        <h2>Banner 2 Clickthrough URL</h2>
                        <input name="ct_custom_ad2_url" type="text" size="100" value="<?php echo $ct_custom_ad2_url ?>" />
                        
                        <h2>Banner 2 Image URL</h2>
                        <input name="ct_custom_ad2_imgurl" type="text" size="100" value="<?php echo $ct_custom_ad2_imgurl ?>" />
                        
                        <h2>Banner 2 Image ALT</h2>
                        <input name="ct_custom_ad2_alt" type="text" size="100" value="<?php echo $ct_custom_ad2_alt ?>" />
                        
                        <h2>Banner 3 Clickthrough URL</h2>
                        <input name="ct_custom_ad3_url" type="text" size="100" value="<?php echo $ct_custom_ad3_url ?>" />
                        
                        <h2>Banner 3 Image URL</h2>
                        <input name="ct_custom_ad3_imgurl" type="text" size="100" value="<?php echo $ct_custom_ad3_imgurl ?>" />
                        
                        <h2>Banner 3 Image ALT</h2>
                        <input name="ct_custom_ad3_alt" type="text" size="100" value="<?php echo $ct_custom_ad3_alt ?>" />
                        
                        <h2>Banner 4 Clickthrough URL</h2>
                        <input name="ct_custom_ad4_url" type="text" size="100" value="<?php echo $ct_custom_ad4_url ?>" />
                        
                        <h2>Banner 4 Image URL</h2>
                        <input name="ct_custom_ad4_imgurl" type="text" size="100" value="<?php echo $ct_custom_ad4_imgurl ?>" />
                        
                        <h2>Banner 4 Image ALT</h2>
                        <input name="ct_custom_ad4_alt" type="text" size="100" value="<?php echo $ct_custom_ad4_alt ?>" />
                        
                        <h2>Banner 5 Clickthrough URL</h2>
                        <input name="ct_custom_ad5_url" type="text" size="100" value="<?php echo $ct_custom_ad5_url ?>" />
                        
                        <h2>Banner 5 Image URL</h2>
                        <input name="ct_custom_ad5_imgurl" type="text" size="100" value="<?php echo $ct_custom_ad5_imgurl ?>" />
                        
                        <h2>Banner 5 Image ALT</h2>
                        <input name="ct_custom_ad5_alt" type="text" size="100" value="<?php echo $ct_custom_ad5_alt ?>" />
                        
                        <h2>Banner 6 Clickthrough URL</h2>
                        <input name="ct_custom_ad6_url" type="text" size="100" value="<?php echo $ct_custom_ad6_url ?>" />
                        
                        <h2>Banner 6 Image URL</h2>
                        <input name="ct_custom_ad6_imgurl" type="text" size="100" value="<?php echo $ct_custom_ad6_imgurl ?>" />
                        
                        <h2>Banner 6 Image ALT</h2>
                        <input name="ct_custom_ad6_alt" type="text" size="100" value="<?php echo $ct_custom_ad6_alt ?>" />
                        
                        <h2>Advertise Here URL</h2>
                        <input name="ct_custom_advertise_url" type="text" size="100" value="<?php echo $ct_custom_advertise_url ?>" />
                        
                    </div>
                    
                    <div id="foot" class="adminoptions right">

                    	<h2>Custom Footer Text</h2>
                        <textarea name="ct_footer_text" cols="64" rows="10"><?php echo stripslashes($ct_footer_text); ?></textarea>
                        <p><em><strong>HTML Ok</strong> - Replaces the standard footer copyright text.</em></p>
                        
                        <h2>Scripts</h2>
                        <textarea name="ct_google_analytics" cols="64" rows="10"><?php echo stripslashes($ct_google_analytics); ?></textarea>
                        <p><em>(e.g. Google Analytics)</em></p>

                    </div>
                
                        <div class="clear"></div>
                        
            	</div>

			</div>

		</div>
        
    </form>
        
	</div>
    
<?php } ?>