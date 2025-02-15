<?php get_header(); ?>

<div id="content">
	<div id="main">
		<div class="content"><div class="cont-r"><div class="cont-l"><div class="cont-bot">
			<div class="grad-hack"><div class="begin"></div>

	<?php if (have_posts()) : ?>
<?php $postnumber = '1' ?>
		<?php while (have_posts()) : the_post(); ?>

				<div class="post<?php if($postnumber == '1') echo $postnumber; $postnumber++; ?>" id="post-<?php the_ID(); ?>">
					<div class="title">
						<div class="date"><?php the_time('j') ?><div class="month"><?php the_time('M') ?></div></div>
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
						<p class="author"><?php edit_post_link('Edit', ' | ', ' | '); ?>&nbsp;&nbsp;&nbsp;Posted by: <?php the_author() ?>&nbsp;&nbsp;&nbsp;in <?php the_category(', ') ?></p>
					</div>
					<div class="entry">
					
						<?php the_content('Read the rest of this entry »'); ?>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
					</div>
					<div class="ping-track">
						This entry was posted
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.
						You can follow any responses to this entry through the <?php comments_rss_link('RSS 2.0'); ?> feed.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							/* Both Comments and Pings are open*/ ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							/* Only Pings are Open*/ ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							/* Comments are open, Pings are not*/ ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							/* Neither Comments, nor Pings are open */ ?>
							Both comments and pings are currently closed.
						<?php } ?>
					</div>
				</div>

				<?php comments_template(); ?>

    <?php endwhile; ?>

	<?php else : ?>

				<div class="post">
					<h2 class="center">Not Found</h2>
					<p class="center">Sorry, but you are looking for something that isn't here.</p>
				</div>
	
	<?php endif; ?>

			</div>
		</div></div></div></div>
	</div>
	
	<?php get_sidebar(); ?>
	
	<div class="clear"></div>
</div>

<?php get_footer(); ?>