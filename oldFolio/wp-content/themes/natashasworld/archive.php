<?php get_header(); ?>

	<div id="content">

		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="title">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="title">Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="title">Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h class="title"2>Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="title">Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="title">Blog Archives</h2>
 	  <?php } ?>

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
      <?php the_excerpt(); ?>
		</div>
  </div>


		<?php endwhile; ?>

		<div class="navigation">
			<div class="small"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="small"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/third.php'); ?>
<?php get_footer(); ?>
