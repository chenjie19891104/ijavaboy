<?php
/*
Template Name: Contact
*/
?>

<?php get_header(); ?>

<section class="left">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
        <article>
        
			<?php ct_first_image_blog(); ?>

            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
            <div id="formwrap" class="left">
				<?php the_content(); ?>
                
                <form id="contactform" class="formular" method="post">
                    <fieldset>
                        <input type="text" name="name" id="name" class="validate[required,custom[onlyLetter]] text-input" value="Name" onfocus="if(this.value=='Name')this.value = '';" onblur="if(this.value=='')this.value = 'Name';" />
                        
                        <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" value="Email" onfocus="if(this.value=='Email')this.value = '';" onblur="if(this.value=='')this.value = 'Email';" />
                        
                        <textarea class="validate[required,length[2,500]] text-input" name="message" id="message" rows="5" cols="10"></textarea>
                        
                        <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo get_option("ct_your_email", $single = true); ?>" />
                        <input type="hidden" id="ctsubject" name="ctsubject" value="<?php echo get_option("ct_subject", $single = true); ?>" />
                        
                        <input type="submit" name="Submit" value="Submit" id="submit" class="btn" />  
                    </fieldset>
                </form>
            </div>
              
            <?php if(get_option("ct_gmap", $single = true) =="yes") { ?>
            <?php contact_us_map(); ?>
            <?php } ?>

        </article>
    
	<?php endwhile; endif; ?>

</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>