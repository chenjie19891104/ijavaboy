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
            
            <?php if(get_post_meta($post->ID, "video_value", $single = true)) { ?>
                <div class="videoplayer">
                    <?php echo stripslashes(get_post_meta($post->ID, "video_value", $single = true)); ?>
                </div>       
            <?php } ?>
            
            <?php if (function_exists('woo_tumblog_content')) {
				woo_tumblog_content();
				the_content();
			} else { ?>
                <?php the_content(); ?>
			<?php } ?>
            
            <p class="tags"><?php the_tags(); ?></p>
            <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
            <div class="meta">
				<span><?php if (function_exists('woo_tumblog_the_title')) {
                    echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' 以前';
                } else {
					the_time($GLOBALS['ctdate']);
                } ?></span>
                <span><a href="<?php comments_link(); ?>"><?php comments_number('0 条回复','1 条回复','% 条回复'); ?></a></span> <span> <a href="<?php bloginfo('url'); ?>/?p=<?php the_ID(); ?>"><?php if(function_exists('the_views')) { the_views(); } ?></a></span>
                <span><a href="<?php bloginfo('url'); ?>/?p=<?php the_ID(); ?>">全文阅读</a></span>
                    <div class="clear"></div>
            </div>
            
            <?php if(get_option("ct_authorinfo", $single = true) =="yes") { ?>
            <div id="authorinfo">
                <a href="<?php the_author_url(); ?>"><?php echo get_avatar( get_the_author_email(), '80' ); ?></a>
                <h3>作者: <a href="<?php the_author_url(); ?>"><?php the_author(); ?></a></h3>
                <p><?php the_author_description(); ?></p>
            </div>
                <div class="clear"></div>
            <?php } ?>
            
            <?php if(get_option("ct_social", $single = true) =="yes") { ?>
            <div id="social">
                <?php if(get_option("ct_facebook", $single = true) =="yes") { ?>
                <p class="left"><?php echo stripslashes(get_option("ct_socialtext", $single = true)); ?></p>
                <?php } elseif(get_option("ct_tweet", $single = true) =="yes") { ?>
                <p class="left"><?php echo stripslashes(get_option("ct_socialtext", $single = true)); ?></p>
                <?php } ?>
                
                <?php if(get_option("ct_facebook", $single = true) =="yes") { ?>
                <a id="sendfacebook" class="btn right" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" target="blank"><?php echo get_option("ct_facebooktext", $single = true); ?></a>
                <?php } ?>
                
                <?php if(get_option("ct_tweet", $single = true) =="yes") { ?>
                <a id="tweetit" class="btn right" href="http://twitter.com/home?status=Currently reading <?php the_permalink(); ?>" title="Click to send this page to Twitter!" target="_blank"><?php echo get_option("ct_tweettext", $single = true); ?></a>
                <?php } ?>
                    <div class="clear"></div>
            </div>
            <?php } ?>
            
            <?php if(get_option("ct_comments", $single = true) =="yes") { ?>
            <?php comments_template( '/comments.php', true ); ?>
            <?php } ?>
            
        </article>
    
	<?php endwhile; endif; ?>

</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>