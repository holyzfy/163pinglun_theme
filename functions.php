<?php
function comment_from_163($comment, $args, $depth) {
	echo '<li id="comment-'. $comment->comment_ID .'">';		
	if ( $comment->comment_approved == '0') {
		echo '<span class="comment-awaiting-moderation">' . __('(正等待审核...)') . '</span>';
	}
	echo $comment->comment_content;
}

add_action('widgets_init', 'zfy_widgets_init');
function zfy_widgets_init() {
	register_sidebar(array(
		'name'          => 'home',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));

	register_sidebar(array(
		'name'          => 'archive',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));

	register_sidebar(array(
		'name'          => 'single',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
}

/*
*WP_Widget_Calendar里所有的链接增加nofollow，不让搜索引擎索引这些链接
*去掉WP_Widget_Calendar里头一个月和下一月链接里头的小箭头
*/
add_filter('get_calendar', 'get_calendar_fn');
if(!function_exists('get_calendar_fn')) {
	function get_calendar_fn($calendar_output) {
		$old = $calendar_output;
		$calendar_output = preg_replace('/(?=\s+href)/is', ' rel="nofollow"', $calendar_output);
		$calendar_output = preg_replace('/&laquo;\s+/is', '', $calendar_output);
		$calendar_output = preg_replace('/\s+&raquo;/is', '', $calendar_output);
		if(!$calendar_output) {
			$calendar_output = $old;
		}
		return $calendar_output;
	}
}

/*
*WP_Widget_Tag_Cloud里所有的链接增加nofollow，不让搜索引擎索引这些链接

add_filter('wp_generate_tag_cloud', 'wp_generate_tag_cloud_fn');
if(!function_exists('wp_generate_tag_cloud_fn')) {
	function wp_generate_tag_cloud_fn($tag_cloud_output){
		$old = $tag_cloud_output;
		$tag_cloud_output = preg_replace('/(?=\s+href)/is', ' rel="nofollow"', $tag_cloud_output);
		if(!$tag_cloud_output) {$tag_cloud_output = $old;}
		return $tag_cloud_output;
	}
}
*/

/*
* 根据当前文章的标签显示相关文章
*/
class WP_Widget_Related_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_related_entries', 'description' => __( "根据当前文章的标签显示相关文章") );
		parent::__construct('related-posts', __('相关评论'), $widget_ops);
	}

	function widget( $args, $instance ) {
		ob_start();
		extract($args);
		
		$post_id = $instance['post_id'];
		$title = apply_filters('widget_title', empty($instance['title']) ? __('相关评论') : $instance['title'], $instance, $this->id_base);
		if ( ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$tag_ids = wp_get_post_tags($post_id, array('fields' => 'ids'));
		$query = new WP_Query(array('tag__in' => $tag_ids, 'post__not_in' => array($post_id), 'posts_per_page' => $number, 'orderby' => 'rand'));	
		$my_posts = &$query->get_posts();
		
		if($query->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php global $post; ?>
		<?php foreach($my_posts as $post): setup_postdata($post); ?>
		<li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title(); ?></a></li>
		<?php endforeach; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
		
		endif;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		
		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 10;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
	
}

/**
 * 随机显示10条文章
 */
class WP_Widget_Random_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_random_entries', 'description' => __( "随机显示文章") );
		parent::__construct('random-posts', __('随便看看'), $widget_ops);
	}

	public function widget( $args, $instance ) {
		ob_start();
		extract($args);
		
		$title = apply_filters('widget_title', empty($instance['title']) ? __('随便看看') : $instance['title'], $instance, $this->id_base);
		if ( ! $number = absint( $instance['number'] ) )
 			$number = 10;

 		$posts = get_posts(array(
			'posts_per_page' => $number,
			'orderby' => 'rand',
			'post_type' => 'post',
			'post_status' => 'publish'
		));

?>
	<?php echo $before_widget; ?>
	<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	<ul>
		<?php global $post; ?>
		<?php foreach($posts as $post): setup_postdata($post); ?>
		<li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title(); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		
		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 10;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
	
}

function myplugin_register_widgets() {
	register_widget( 'WP_Widget_Related_Posts' );
	register_widget( 'WP_Widget_Random_Posts' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );

/*
* 删除截取$the_excerpt后，末尾未闭合的html标签
*/
add_filter('get_the_excerpt_zfy', 'remove_missing_html_tag');
function remove_missing_html_tag($the_excerpt) {
	$length = strlen($the_excerpt);
	$last_pos_of_lt = strripos($the_excerpt, '<');
	$last_pos_of_gt = strripos($the_excerpt, '>');
	if($last_pos_of_lt > $last_pos_of_gt)
		$the_excerpt = substr($the_excerpt, 0, $last_pos_of_lt - $length);
	return $the_excerpt;
}

automatic_feed_links(false); //Disable automatic feed links

add_action('send_headers', 'content_security_policy');
function content_security_policy() {
	header("Content-Security-Policy: script-src 'self' 'unsafe-inline' libs.baidu.com hm.baidu.com;");
}

?>
