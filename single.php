<?php get_header(); ?>

<div id="main" class="wrapper clearfix">
	<div id="container">
		<div id="content">
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<div class="post">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="right single-uv"><span class="uv"><?php if(function_exists('the_views')) { the_views(); } ?></span> 人浏览</div>
					<div class="entry-content"><?php the_content(); ?></div>
					<?php comments_template(); ?>
				</div>
				
				<div class="navigation clearfix">
					<div class="left nav-previous"><?php previous_post_link('%link'); ?></div>
					<div class="right nav-next"><?php next_post_link('%link'); ?></div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
	</div>
	
	<?php get_sidebar('single'); ?>
</div>

<?php get_footer(); ?>