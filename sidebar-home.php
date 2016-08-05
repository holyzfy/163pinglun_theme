<div id="primary">
<?php
if (!dynamic_sidebar('home')) {
	the_widget('WP_Widget_Tag_Cloud');
	the_widget('WP_Widget_Random_Posts');
	the_widget('WP_Widget_Calendar');
}
?>
</div>