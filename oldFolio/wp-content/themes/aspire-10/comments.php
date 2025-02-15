<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

				<div id="comments" class="post">
<?php if ($comments) : ?>
					<h4><?php comments_number('', 'One comment', '% comments so far' );?></h4>

	<?php $commentnumber = 1?>
	<?php foreach ($comments as $comment) : ?>
					<div id="comment-<?php comment_ID() ?>" class="<?php if ($comment->comment_author_email == get_the_author_email()) echo 'author'; else echo $oddcomment; ?> message-bottom"><div class="message-top"><div class="message-right"><div class="message-left">
						<div class="mes-br"><div class="mes-bl"><div class="mes-tr"><div class="mes-tl">
							<div class="message-by"><?php comment_author_link() ?></div>
							<div class="message-count"><span><b class="count-l">&nbsp;</b><a href="#comment-<?php comment_ID() ?>"><?php echo $commentnumber; $commentnumber++;?></a><?php edit_comment_link('edit',' | ',''); ?><b class="count-r">&nbsp;</b></span></div>
							<div class="message-entry">
								<?php if ($comment->comment_approved == '0') : ?>
								<em>Your comment is awaiting moderation.</em>
								<?php endif; ?>

								<?php comment_text() ?>
								
								<div class="message-time"><span><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></span></div>
							</div>
						</div></div></div></div>
					</div></div></div></div>
	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

 <?php else : /* this is displayed if there are no comments so far */ ?>

  <?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : /* comments are closed */ ?>
		<!-- If comments are closed. -->
					<p class="nocomments">Comments are closed at this time.</p>
				</div>
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
					<div id="response">
						<h4 id="respond">Leave a reply</h4>
						<div class="form">
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
							<form  action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
								<div class="inputs">
<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout »</a></p>

<?php else : ?>

									<div class="input">Name (<b>*</b>)</div>
									<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
									<div class="input">Mail (will not be published) (<b>*</b>)</div>
									<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
									<div class="input">URI</div>
									<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<?php endif; ?>
								</div>
								<div class="message">
<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
									<div class="input">Comment</div>
									<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
								</div>
								<div class="clear"></div>
								<div class="submit"><input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/send.gif" name="submit" id="submit" tabindex="5" alt="Submit Comment" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>
								<?php do_action('comment_form', $post->ID); ?>
							</form>
<?php endif; /* if registration required and not logged in */ ?>
						</div>	
					</div>
				</div>
				
<?php endif; /* if you delete this the sky will fall on your head */ ?>

