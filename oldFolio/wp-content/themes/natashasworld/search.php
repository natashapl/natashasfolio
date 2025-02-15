<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>

		<h2 class="title">Search Results</h2>


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
      <span class="small">Posted in
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
					<?php the_excerpt(); ?>
</div>
  </div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/third.php'); ?>
<?php get_footer(); ?>
