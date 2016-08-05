<?php get_header(); ?>

<div id="main" class="wrapper clearfix">
	<div id="container">
		<div id="content">
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?> 
		</div>
	</div>
</div>

<?php get_footer(); ?>
