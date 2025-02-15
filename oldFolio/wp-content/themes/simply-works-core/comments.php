<?php
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "simplyworks"); ?></p>
	<?php
		return;
	}
?>
<?php if ( have_comments() ) : ?>
	<h4 id="comments"><?php comments_number(__('No comments posted yet', 'simplyworks'), __('One single comment', 'simplyworks'), __('% comments', 'simplyworks') );?> <a name="comments"></a></h4>
	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>
    <div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>
   
<?php endif; ?>
<?php if ( comments_open() ) :
comment_form($swc_comment_defaults);
?>
<div class="clear">&nbsp;</div>
<?php endif;  ?>