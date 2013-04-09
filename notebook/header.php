<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php ct_title(); ?></title>
    
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php if(get_option("ct_feedburner", $single = true) !="") {  echo get_option("ct_feedburner", $single = true); } else { bloginfo('rss2_url');  } ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <?php wp_head(); ?>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?f1ceb4f4a2f33361ea6d02529c225a3e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>    

</head>

<body<?php ct_body_id(); ?>>

    <div id="container">
    
        <a name="top"></a>
        
        <header>
        
			<?php if(get_option("ct_custom_logo_url", "ct_custom_logo_alt", $single = true) !="") { ?>
                <a href="<?php bloginfo('url'); ?>"><img id="logo" class="left" src="<?php echo get_option("ct_custom_logo_url", $single = true); ?>" alt="<?php echo get_option("ct_custom_logo_alt", $single = true); ?>" /></a>
            <?php } else { ?>
                <a href="<?php bloginfo('url'); ?>"><img id="logo" src="<?php bloginfo('template_directory'); ?>/images/notebook_logo.png" height="50" width="209" alt="IJavaBoy" /></a>
            <?php } ?>
            
            <?php ct_nav(); ?>
        
        </header>
        
        <div id="toolbar">
            <p><?php bloginfo('description'); ?></p>
            <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
                <input type="text" value="站内查找..." name="s" id="s" class="right" onfocus="if(this.value=='站内查找...')this.value = '';" onblur="if(this.value=='')this.value = '站内查找...';" />
            </form>
        </div>
        
        <div class="clear"></div>