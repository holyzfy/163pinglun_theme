<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, maximum-scale=1" />
<meta name="renderer" content="webkit" />
<title>
<?php
wp_title('-', true, 'right');
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
	echo " - $site_description";
?>

</title>

<?php
if(is_single() || is_page()) {
	$site_description = get_bloginfo( 'description', 'display' );
	$post_description = mb_substr(strip_tags($post->post_content), 0, 240, 'utf-8');
}
$keywords = $post->post_title;
if ( $site_description && ( is_home() || is_front_page() ) ) {
	$post_description = '163评论网是一个分享精彩网易评论的地方，热衷于收藏和分享网易新闻的经典跟帖。膜拜网易名人，细品才子吟诗，围观盖楼跟帖。';
	$keywords = '网易评论,网易跟帖,163评论';
} else if(is_single($post)) {
	//从wp_postmeta表中取到key='post_description'的值，如果不存在，则从wp_163pinglun表中根据字段content_json_data重新生成$post_description
	$post_description = get_post_meta($post->ID, 'post_description', true);
	if(empty($post_description)) {
		global $wpdb;
		$table = $wpdb->prefix . '163pinglun';
		$content_json_data = $wpdb->get_var($wpdb->prepare("SELECT content_json_data FROM $table WHERE post_id = %d ORDER BY comment_id ASC LIMIT 1", $post->ID));
		if($content_json_data) {
			$json = json_decode($content_json_data, true);
			if(json_last_error() == JSON_ERROR_NONE) {
				$comment_1st = $json[1]['f'] . $json[1]['b'];
				$post_description = mb_substr(strip_tags($comment_1st), 0, 240);
				update_post_meta($post->ID, 'post_description', $post_description);
			}
		}
	}
}

if(!empty($post_description) && !empty($keywords)):
?>
<meta name="description" content="<?php echo preg_replace(array('/&/', '/"/', "/'/", "/\r|\n/", '/</', '/>/', '/\s+/'), array('&amp;', '&quot;', '&#039;', ' ', '&lt;', '&gt;', ' '), $post_description) ?>" />
<meta name="keywords" content="<?php echo preg_replace(array('/&/', '/"/', "/'/", "/\r|\n/", '/</', '/>/', '/\s+/'), array('&amp;', '&quot;', '&#039;', ' ', '&lt;', '&gt;', ' '), $keywords) ?>" />
<?php
endif;
?>

<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=160810" type="text/css" />

<?php
if(is_search()) {
	$custom_css_file = 'search.css';
} elseif(is_page('result')) {
	$custom_css_file = 'result.css?ver=150425';
} elseif(is_single()) {
	echo '<style type="text/css">.entry-content {margin:12px 0 30px 0;} .entry-content p {margin-bottom:20px;}</style>';
}elseif(is_home()) {
	echo '<style type="text/css">#header {border-bottom:0; margin-bottom:0;}</style>';
}

if(isset($custom_css_file)):
?>
<link rel="stylesheet" href="<?php echo get_bloginfo( 'stylesheet_directory' ).'/'.$custom_css_file; ?>" type="text/css" />
<?php endif; ?>
<script type="text/javascript" src="http://libs.baidu.com/jquery/1.8.0/jquery.min.js"></script>
<link title="163评论网" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" rel="alternate" />
<link rel="apple-touch-icon" href="<?php echo get_bloginfo( 'stylesheet_directory' )?>/images/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_bloginfo( 'stylesheet_directory' )?>/images/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_bloginfo( 'stylesheet_directory' )?>/images/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_bloginfo( 'stylesheet_directory' )?>/images/touch-icon-ipad-retina.png">
<script>
function postviews(count) {
	$(function() {
		$('#content span.uv').text(count);
	});
}
</script>
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>
<body>
<div id="header">
	<div class="wrapper clearfix">
		<a id="site-title" class="left" href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="163评论网" width="152" height="68"></a>
		<div id="site-description" class="left"><?php bloginfo('description'); ?></div>
		<div class="right header-aside">
			<div class="widget_rss"><a href="<?php bloginfo('rss2_url'); ?>">订阅<em>RSS</em></a></div>
			<div class="widget_search"><?php get_search_form(); ?></div>
		</div>
	</div>
</div>
