<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

<section id="fullwidth" class="left">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
        <article>

            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
            <?php the_content(); ?>

        </article>
    
	<?php endwhile; endif; ?>

</section>

    <div class="clear"></div>

<?php get_footer(); ?>