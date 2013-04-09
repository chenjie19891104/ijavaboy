<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'theme_textdomain'); ?></p>
	<?php
		return;
	}
?>

<div id="comments-template">

	<div class="comments-wrap">

		<div id="comments">

			<?php if ( have_comments() ) : ?>
				
				<h3 id="comments-number" class="comments-header"><?php comments_number(__('No Responses',theme_textdomain), __('1 条回复',theme_textdomain), __( '% 条回复',theme_textdomain) );?></h3>

				<ol class="comment-list">
					<?php wp_list_comments(); ?>
				</ol>

		<?php else : ?>

			<?php if ( pings_open() && !comments_open() ) : ?>

				<p class="comments-closed pings-open"><?php _e('Comments are closed, but', 'theme_textdomain'); ?> <a href="%1$s" title="<?php _e('Trackback URL for this post', 'theme_textdomain'); ?>"><?php _e('trackbacks', 'theme_textdomain'); ?></a> <?php _e('and pingbacks are open.', 'theme_textdomain'); ?></p>

			<?php elseif ( !comments_open() ) : ?>

				<p class="nocomments"><?php _e('Comments are closed.', 'theme_textdomain'); ?></p>

			<?php endif; ?>

		<?php endif; ?>

		</div>

		<?php comment_form(); ?>

	</div>

</div>