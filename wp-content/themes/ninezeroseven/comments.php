<?php
/************************************************************************
* Comments Template
*************************************************************************/

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
	die ('This file can not be accessed directly!');
}

if(post_password_required()){
	return;
}

if(have_comments()): ?>

	<div class="heading" id="comments">
		<h5><?php comments_number(__("No Comments", "framework"),__("1 Comment", "framework"),__("% Comments", "framework"));?></h5>
	</div>

	<ul class="post-comments">
		<?php wp_list_comments('callback=custom_comments');?>
	</ul>
	
	<div class="navigation">
	  <?php paginate_comments_links(); ?> 
	</div>

<?php elseif(!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')): ?>

	<p>Comments are closed</p>

<?php endif;?>

<?php nzs_custom_comment_form();?>
