<?php

// Twitter Widget
function twitterWidget($args) {
	$settings = get_option("widget_twitterwidget");
	$tweetid = $settings['tweetid'];
	$tweetnum = $settings['tweetnum'];
	echo $args['before_widget'];
	echo $args['before_title'] .'Latest From Twitter'. $args['after_title']; 
	{
		class Twitter {
		  public $tweets = array();
		  public function __construct($user, $limit = 5) 
		  {
			$user = str_replace(' OR ', '%20OR%20', $user);
			$feed = curl_init('http://search.twitter.com/search.atom?q=from:'. $user .'&rpp='. $limit);
			curl_setopt($feed, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($feed, CURLOPT_HEADER, 0);
			$xml = curl_exec($feed);
			curl_close($feed);
			$result = new SimpleXMLElement($xml);
			foreach($result->entry as $entry) 
			{
				$tweet = new stdClass();
				$tweet->id = (string) $entry->id;
				$user = explode(' ', $entry->author->name);
				$tweet->user = (string) $user[0];
				$tweet->author = (string) substr($entry->author->name, strlen($user[0])+2, -1);
				$tweet->title = (string) $entry->title;
				$tweet->content = (string) $entry->content;
				$tweet->updated = (int) strtotime($entry->updated);
				$tweet->permalink = (string) $entry->link[0]->attributes()->href;
				$tweet->avatar = (string) $entry->link[1]->attributes()->href;
				array_push($this->tweets, $tweet);
			}
			unset($feed, $xml, $result, $tweet);
		  }
		  public function getTweets() { return $this->tweets; }
		}
		$feed = new Twitter($tweetid, $tweetnum);
		$tweets = $feed->getTweets();
		echo '<ul>';
		foreach($tweets as $tweet) 
		{
		  echo "<li>". $tweet->content ." by <a href='http://twitter.com/". $tweet->user ."'>". $tweet->author ."</a></li>";
		}
		echo "</ul>";
	}
	echo $args['after_widget'];
}

function twitterWidgetAdmin() {

	$settings = get_option("widget_twitterwidget");

	// check if anything's been sent
	if (isset($_POST['update_twitter'])) {
		$settings['tweetid'] = strip_tags(stripslashes($_POST['twitter_id']));
		$settings['tweetnum'] = strip_tags(stripslashes($_POST['twitter_num']));

		update_option("widget_twitterwidget",$settings);
	}

	echo '<p>
			<label for="twitter_id">Twitter ID:
			<input id="twitter_id" name="twitter_id" type="text" class="widefat" value="'.$settings['tweetid'].'" /></label></p>';
	echo '<p>
			<label for="twitter_num">Number of Tweets to Display:
			<input id="twitter_num" name="twitter_num" type="text" class="widefat" value="'.$settings['tweetnum'].'" /></label></p>';
	echo '<input type="hidden" id="update_twitter" name="update_twitter" value="1" />';

}

register_sidebar_widget('Twitter', 'twitterWidget');
register_widget_control('Twitter', 'twitterWidgetAdmin', 400, 200);

// Latest Widget
function latestWidget($args) {
	global $wpdb;
	$settings = get_option("widget_latestwidget");
	$title = $settings['title'];
	$number = $settings['number'];
	echo $args['before_widget'];
	echo $args['before_title'] .$title. $args['after_title']; 
	echo '<ul>';
	{ 
	query_posts( array(
			'posts_per_page' => $number )
		);	
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
			<li>
				<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
				<p class="description"><?php the_excerpt(); ?></p>
			</li>
		
		<?php endwhile; endif; ?>
	<?php wp_reset_query();
	}
	echo '</ul>';
	echo $args['after_widget'];
}

function latestWidgetAdmin() {

	$settings = get_option("widget_latestwidget");

	// check if anything's been sent
	if (isset($_POST['update_latest'])) {
		$settings['title'] = strip_tags(stripslashes($_POST['latest_title']));
		$settings['number'] = strip_tags(stripslashes($_POST['latest_number']));

		update_option("widget_latestwidget",$settings);
	}

	echo '<p>
			<label for="latest_title">Title:
			<input id="latest_title" name="latest_title" type="text" class="widefat" value="'.$settings['title'].'" /></label></p>';
	echo '<p>
			<label for="latest_number">Number of posts:
			<input id="latest_number" name="latest_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_latest" name="update_latest" value="1" />';

}

register_sidebar_widget('Latest Posts', 'latestWidget');
register_widget_control('Latest Posts', 'latestWidgetAdmin', 400, 200);

// Flickr Widget
function flickrWidget($args) {
	global $wpdb;
	$settings = get_option("widget_flickrwidget");
	$id = $settings['id'];
	$number = $settings['number'];
	
	echo $args['before_widget'];
	echo $args['before_title'] .'Latest On Flickr'. $args['after_title']; 

	{ ?>
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script> 
        <div class="clear"></div>

<?php }
	echo $args['after_widget'];
}

function flickrWidgetAdmin() {

	$settings = get_option("widget_flickrwidget");

	// check if anything's been sent
	if (isset($_POST['update_flickr'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['flickr_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['flickr_number']));

		update_option("widget_flickrwidget",$settings);
	}

	echo '<p>
			<label for="flickr_id">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="flickr_id" name="flickr_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="flickr_number">Number of photos:
			<input id="flickr_number" name="flickr_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_flickr" name="update_flickr" value="1" />';

}

register_sidebar_widget('Flickr', 'flickrWidget');
register_widget_control('Flickr', 'flickrWidgetAdmin', 400, 200);

// Ad widget
function adsWidget($args) {
	global $wpdb;
	echo $args['before_widget'];

	{ ?>

	<?php if(get_option("ct_custom_ad1_url", "ct_custom_ad1_imgurl", "ct_custom_ad1_alt", $single = true) !="") { ?>
        <a href="<?php echo get_option("ct_custom_ad1_url", $single = true); ?>"><img class="smsqad left" src="<?php echo get_option("ct_custom_ad1_imgurl", $single = true); ?>" height="100" width="180" alt="<?php echo get_option("ct_custom_ad1_alt", $single = true); ?>" /></a>
    <?php } ?>
    <?php if(get_option("ct_custom_ad2_url", "ct_custom_ad2_imgurl", "ct_custom_ad2_alt", $single = true) !="") { ?>
        <a href="<?php echo get_option("ct_custom_ad2_url", $single = true); ?>"><img class="smsqad left last" src="<?php echo get_option("ct_custom_ad2_imgurl", $single = true); ?>" height="100" width="180" alt="<?php echo get_option("ct_custom_ad2_alt", $single = true); ?>" /></a>
    <?php } ?>
    <?php if(get_option("ct_custom_ad3_url", "ct_custom_ad3_imgurl", "ct_custom_ad3_alt", $single = true) !="") { ?>
        <a href="<?php echo get_option("ct_custom_ad3_url", $single = true); ?>"><img class="smsqad left" src="<?php echo get_option("ct_custom_ad3_imgurl", $single = true); ?>" height="100" width="180" alt="<?php echo get_option("ct_custom_ad3_alt", $single = true); ?>" /></a>
    <?php } ?>
    <?php if(get_option("ct_custom_ad4_url", "ct_custom_ad4_imgurl", "ct_custom_ad4_alt", $single = true) !="") { ?>
        <a href="<?php echo get_option("ct_custom_ad4_url", $single = true); ?>"><img class="smsqad left last" src="<?php echo get_option("ct_custom_ad4_imgurl", $single = true); ?>" height="100" width="180" alt="<?php echo get_option("ct_custom_ad4_alt", $single = true); ?>" /></a>
    <?php } ?>
    <?php if(get_option("ct_custom_ad5_url", "ct_custom_ad5_imgurl", "ct_custom_ad5_alt", $single = true) !="") { ?>
        <a href="<?php echo get_option("ct_custom_ad5_url", $single = true); ?>"><img class="smsqad left" src="<?php echo get_option("ct_custom_ad5_imgurl", $single = true); ?>" height="100" width="180" alt="<?php echo get_option("ct_custom_ad5_alt", $single = true); ?>" /></a>
    <?php } ?>
    <?php if(get_option("ct_custom_ad6_url", "ct_custom_ad6_imgurl", "ct_custom_ad6_alt", $single = true) !="") { ?>
        <a href="<?php echo get_option("ct_custom_ad6_url", $single = true); ?>"><img class="smsqad left last" src="<?php echo get_option("ct_custom_ad6_imgurl", $single = true); ?>" height="100" width="180" alt="<?php echo get_option("ct_custom_ad6_alt", $single = true); ?>" /></a>
    <?php } ?>

        <div class="clear"></div>

    <?php if(get_option("ct_custom_advertise_url", $single = true) !="") { ?>
        <p id="advertise"><a href="<?php echo get_option("ct_custom_advertise_url", $single = true); ?>">Advertise Here</a></p>
    <?php } ?>

<?php }
	echo $args['after_widget'];
}
register_sidebar_widget('Ads', 'adsWidget');

function popWidget($args) {
	global $wpdb;
	$settings = get_option("widget_popWidget");
	$pop_num = $settings['popnumber'];
	$now = gmdate("Y-m-d H:i:s",time());
	$lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
	$popularposts = "SELECT ID, post_title, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT ".$pop_num;
	$posts = $wpdb->get_results($popularposts);
	$popular = '';
	
	echo $args['before_widget'];
	echo $args['before_title'] .'Popular Posts'. $args['after_title']; 

	if($posts){ ?>
		
<ul>
	<?php foreach($posts as $post){ 
			$post_title = stripslashes($post->post_title);
			$post_date = $post->post_date;
			$post_date = mysql2date('F j, Y', $post_date, false);
			$permalink = get_permalink($post->ID);
			?>
	<li><a href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>"><h6><?php echo $post_title; ?></h6><p class="meta"><?php echo $post_date; ?></p></a><div class="clear"></div></li>
		<?php } ?>
</ul>
	<?php }
	echo $args['after_widget'];
}

function popWidgetAdmin() {

	$settings = get_option("widget_popWidget");

	// check if anything's been sent
	if (isset($_POST['update_pop'])) {
		$settings['popnumber'] = strip_tags(stripslashes($_POST['pop_number']));

		update_option("widget_popWidget",$settings);
	}

	echo '<p>
			<label for="pop_number">Number of posts:
			<input id="pop_number" name="pop_number" type="text" class="widefat" value="'.$settings['popnumber'].'" /></label></p>';
	echo '<input type="hidden" id="update_pop" name="update_pop" value="1" />';

}

register_sidebar_widget('Popular Posts', 'popWidget');
register_widget_control('Popular Posts', 'popWidgetAdmin', 400, 200);

?>