<?php get_header(); ?>

	<div id="content">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
    <div class="post_date"> <span class="day">
      <?php the_time('j') ?>
      </span><br />
      <span class="month">
      <?php the_time('M') ?>
      </span><br />
      <span class="year">
      <?php the_time('y') ?>
      </span></div>
    <div class="post_info">
      <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
        <?php the_title(); ?>
        </a></h2>
      Posted in
      <?php the_category(', ') ?>
      @
      <?php the_time('g:i a'); ?>
      by
      <?php the_author() ?>
      <br />
      <?php comments_popup_link('No comments yet', '1 comment so far', '% comments'); ?>
    </div>
    <br clear="all" />
    <div class="post_txt">
	
      <?php the_content('Read more...'); ?>
	  <?php if (function_exists('sharethis_button')) { sharethis_button(); } ?>  <a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_su.gif" border="0" /> Stumble it!</a>
	  <script type="text/javascript">
digg_url = '<?php the_permalink() ?>';
digg_bgcolor = '#ffffff';
digg_skin = 'compact';
digg_window = 'new';
</script>
<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>

						<p><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry.','',''); ?>
				</p>

	<?php comments_template(); ?>
	
	</div>
  </div>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/third.php'); ?>
<?php get_footer(); ?>