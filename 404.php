<?php get_header(); ?>

<div id="main" class="wrapper clearfix">
	<h1 class="entry-title">额，你访问的页面好像不存在哦</h1>
	<div class="navigation">
		<div class="nav-previous"><a href="<?php bloginfo('url'); ?>">返回到首页</a></div>
	</div>
	<div style="margin-top:20px;" class="placeholder-wrap"><?php get_search_form(); ?></div>
</div>

<?php get_footer(); ?>