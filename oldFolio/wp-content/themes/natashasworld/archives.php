<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="content">
  <div class="post">
    <div class="post_txt">
	<h1>Natasha's World Archives</h1>
	<br clear="all" />
	<?php wp_smart_archives(); ?>
	<br clear="all" />
      <h2>Recent 20 Posts</h2>
      <ul>
        <?php wp_get_archives('type=postbypost&limit=20'); ?>
      </ul>
      <h2>Monthly Archives</h2>
      <ul>
        <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
      </ul>
    </div>
  </div>
</div>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/third.php'); ?>
<?php get_footer(); ?>
