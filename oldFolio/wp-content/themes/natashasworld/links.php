<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>

<div id="content">
  <div class="post">
    <div class="post_txt">
      <h2>Links:</h2>
      <ul>
        <?php get_links_list(); ?>
      </ul>
    </div>
  </div>
</div>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/third.php'); ?>
<?php get_footer(); ?>
