<div id="primary">
<?php
if (!dynamic_sidebar('single')) {
	the_widget('WP_Widget_Recent_Posts', 'title=最新评论');
	the_widget('WP_Widget_Related_Posts', array('title' => '相关评论', 'post_id' => $post->ID), array('before_widget' => '<div id="widget_related_entries" class="widget widget_related_entries">',));	
}
?>
</div>