<div id="comments">
	<ol class="commentlist">
	<?php 
		wp_list_comments(array(
			'type' => 'comment',
			'style' => 'ol',
			'callback' => 'comment_from_163'
		));
	?>
	</ol>
</div>	
