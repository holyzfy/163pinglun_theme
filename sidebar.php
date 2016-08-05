<div id="primary">
<?php
if (!dynamic_sidebar()) {
	the_widget('WP_Widget_Recent_Posts', 'title=最新评论');
}
?>
</div>