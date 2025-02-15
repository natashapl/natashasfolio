<?php get_header(); ?>
<div id="mid" class="fix">
	<div id="mainCol" class="fix"><a name="main"></a>
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="postMeta"><span class="date"><?php the_time('M j, Y') ?></span><span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span></div>
			<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></h2>
			<div class="entry">
			<p><?php the_content_rss('', FALSE, '', 68); ?></p>
			</div>
		</div>
		<?php endwhile; ?>
		<?php else : ?>
		<div class="post">
			<div class="postMeta"><span class="date">No Matches</span></div>
		<h2>No matching results</h2>
			<div class="entry">
			<p>You seem to have found a mis-linked page or search query with no associated results. Please trying your search again. If you feel that you should be staring at something a little more concrete, feel free to email the author of this site or browse the archives.</p>
			</div>
		</div>
		<?php endif; ?>
		<div id="more_reading">
		<p><?php next_posts_link('Next') ?>, <?php previous_posts_link('Previous') ?></p>
		</div>
	</div>
	<?php include (TEMPLATEPATH . '/second.php'); ?>
	<?php include (TEMPLATEPATH . '/third.php'); ?>
</div>
<?php get_footer(); ?>