<?php get_header(); ?>

<section class="left">

	<?php $tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
		'images'=> get_option('woo_images_term_id')
		);
    ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    
        <article>
            <?php if (function_exists('woo_tumblog_the_title')) {
				woo_tumblog_the_title("entry-title");
			} else { ?>
                <span class="post-icon article"></span>
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<?php } ?>
            
            
            <?php if (function_exists('woo_tumblog_content')) {
				woo_tumblog_content();
				the_content();;
			} else { ?>
                <p><?php the_content(); ?></p>
			<?php } ?>
            
            <p class="tags"><?php the_tags(); ?></p>
            
            <div class="meta">
				<span><?php if (function_exists('woo_tumblog_the_title')) {
                    echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' 以前';
                } else {
					the_time($GLOBALS['ctdate']);
                } ?></span>
                <span><a href="<?php comments_link(); ?>"><?php comments_number('0 条回复','1 条回复','% 条回复'); ?></a></span> <span> <a href="<?php bloginfo('url'); ?>/?p=<?php the_ID(); ?>"><?php if(function_exists('the_views')) { the_views(); } ?></a></span>
                <span><a href="<?php bloginfo('url'); ?>/?p=<?php the_ID(); ?>">阅读全文</a></span>
                    <div class="clear"></div>
            </div>
        </article>
    
	<?php endwhile; ?>
        <?php ct_pagination(); ?>
    <?php endif; ?>

</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>