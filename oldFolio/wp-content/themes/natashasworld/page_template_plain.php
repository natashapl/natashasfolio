<?php
/*
Template Name: Plain Page
*/
?>
<?php get_header(); ?>

<div id="searchContent">
  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post_plain" id="post-<?php the_ID(); ?>">
    <div class="post_search_txt">
      <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
      <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    </div>
  </div>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>

