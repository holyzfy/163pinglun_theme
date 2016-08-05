<?php
/*
Template Name: 一栏
*/
?>
<?php get_header(); ?>

<div id="main" class="wrapper clearfix">
	<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="post">
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?> 
</div>

<?php get_footer(); ?>