<?php get_header(); ?>
<!--Beginning of Post Content-->
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
	
      <?php the_content('Read More...'); ?> 
	  <?php if (function_exists('sharethis_button')) { sharethis_button(); } ?>  <a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_su.gif" border="0" /> Stumble it!</a>
	  	  <script type="text/javascript">
digg_url = '<?php the_permalink() ?>';
digg_bgcolor = '#ffffff';
digg_skin = 'compact';
digg_window = 'new';
</script>
<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>

	 
	  <p><?php edit_post_link('Edit', '', ''); ?></p>
    </div>
  </div>
  <?php endwhile; ?>
  <?php else : ?>
  <div class="post">
  <div class="post_txt">
      <p>You seem to have found a mis-linked page or search query with no associated results. Please trying your search again. If you feel that you should be staring at something a little more concrete, feel free to email the author of this site or browse the archives.</p>
  </div>
  </div>
  <?php endif; ?>
</div>
<!--End of Post Content-->
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/third.php'); ?>
<?php get_footer(); ?>
