<?php get_header(); ?>
<div id="main" class="wrapper clearfix">
	<div id="container">
		<?php
		global $wp_query;
		$total_results = $wp_query->found_posts;
		?>
		<h1 class="entry-title"><?php printf('搜索“<span class="highlight">%s</span>”共找到%d条结果', $s,  $total_results); ?></h1>
		<div id="content" class="post-list">
			<?php if ( have_posts() ) : ?>
				<?php while(have_posts()) : the_post(); ?>
					<div class="post">
						<?php
							$title = get_the_title();
							$keys= explode(" ", $s);
							$title = preg_replace('/('.implode('|', $keys) .')/iu', '<span class="highlight">\0</span>', $title);
						?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $title ?></a></h2>
						<div class="entry-content">
							<span><?php
								$the_excerpt = mb_substr(get_the_excerpt(), 0, 400, 'utf-8');
								echo apply_filters('get_the_excerpt_zfy', $the_excerpt);
							?></span>
							<a class="continue" href="<?php the_permalink(); ?>">详细评论<span class="gt">&gt;&gt;</span></a>
						</div>
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
			<?php else : ?>
				<div class="post no-results not-found">
					<div class="entry-content"><?php _e( '抱歉，没有找到相关内容，请尝试其他的查询词', '' ); ?></div>
				</div>
			<?php endif; ?>
		
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?> 
		</div>
	</div>
	
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>