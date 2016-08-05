<?php get_header(); ?>

<div id="main" class="wrapper clearfix">
	<div id="container">
		<div id="content" class="post-list">
		<h1 class="entry-title">
		<?php if ( is_day() ) : ?>
			<?php printf( __( '日归档：<span>%s</span>', '' ), get_the_date('Y/m/j') ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( '月归档：<span>%s</span>', '' ), get_the_date( 'Y/m' ) ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( '年归档：<span>%s</span>', '' ), get_the_date( 'Y' ) ); ?>
		<?php elseif ( is_tag() ) : ?>
			<?php printf( __( '标签归档：<span>%s</span>', '' ), single_tag_title( '', false ) ); ?>
		<?php else : ?>
			<?php _e( '文章归档', '' ); ?>
		<?php endif; ?>
		</h1>
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<div class="post">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p class="entry-content">
						<span><?php
							$the_excerpt = mb_substr(get_the_excerpt(), 0, 400, 'utf-8');
							echo apply_filters('get_the_excerpt_zfy', $the_excerpt);
						?></span>
						<a class="continue" href="<?php the_permalink(); ?>">详细评论<span class="gt">&gt;&gt;</span></a>
					</p>
					<?php
						$comments = get_comments(array(
							'post_id' => get_the_ID(),
							'status' => 'approve'
						));
						if(count($comments)) {
							$lastest_comment = array_shift($comments);
							$comment_ID = $lastest_comment->comment_ID;
						}
					?>
					<div class="entry-meta">
						<span class="meta-prep">最后更新于</span><span class="entry-date"><?php comment_date('Y/m/j H:i', $comment_ID); ?></span> <span class="meta-prep">by</span> <span class="author"><?php comment_author($comment_ID); ?></span>，
						<span><span class="uv"><?php if(function_exists('the_views')) { the_views(); } ?></span>人浏览</span>
					</div>
					<a href="<?php the_permalink(); ?>"></a>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?> 
		</div>
	</div>
	
	<?php get_sidebar('archive'); ?>
</div>

<?php get_footer(); ?>