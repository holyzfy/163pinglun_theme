<div id="primary">
<?php
if (!dynamic_sidebar('archive')) {
	the_widget('WP_Widget_Recent_Posts', 'title=最新评论');
	the_widget('WP_Widget_Calendar');
}
?>
</div>