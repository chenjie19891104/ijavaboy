<div id="sidebar" class="right">
    <?php if (is_page()){ ?>
  	
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Pages') ) :else: endif; ?>
  	
	<?php } else { ?>
  	
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Blog') ) :else: endif; ?>
	
	<?php } ?>
</div>

    <div class="clear"></div>