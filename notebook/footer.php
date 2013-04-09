        <footer>
			<?php if(get_option("ct_footer_text", $single = true) !="") { ?>
                <p class="left"><?php echo stripslashes(get_option("ct_footer_text", $single = true)); ?> <?php footer_font_credit(); ?>.</p>
            <?php } else { ?>
                <p class="left">&copy <?php echo date('Y'); ?> <?php bloginfo('name'); ?>, All Rights Reserved. <?php footer_font_credit(); ?></p>
            <?php } ?>
            
            <p class="right"><a href="#top">Back to top</a></p>
            
                <div class="clear"></div>

        </footer>
        
 


        <?php wp_footer(); ?>
        
        <?php if(get_option("ct_google_analytics", $single = true) !="") { ?>
        <?php echo stripslashes(get_option("ct_google_analytics", $single = true)); ?>
        <?php } ?>
    
    </div>


		
      
</body>