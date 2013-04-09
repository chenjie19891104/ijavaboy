<?php get_header(); ?>

<section class="left">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
        <article>
        
			<?php ct_first_image_blog(); ?>

            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
            <?php the_content(); ?>

        </article>
    	<?php if ( comments_open() ) comments_template(); ?>
	<?php endwhile; endif; ?>


</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>