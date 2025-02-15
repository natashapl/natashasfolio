<?php
/*
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version 1.5.5
Description: 404 Template Page / Page Not Found = 404.php
 */
get_header();
?>
<div id="mainbody">
  <div class="wrapper">
   <div id="contentarea">
     <h2 class="contenttitle"><?php _e('Error 404 - Page Not Found', 'simplyworks') ?></h2>
        <?php _e('<p><strong>We\'re very sorry, but that page doesn\'t exist or has been moved.</strong><br />
Please make sure you have the right URL.</p>
<p>If you still can\'t find what you\'re looking for, try using the search form below.</p>', 'simplyworks') ?>
         <?php get_search_form(); ?>
   </div><!-- END contentarea -->
<?php get_sidebar(); ?>
     <div class="clear"></div>
    </div>  <!-- END wrapper class -->
   <div class="clear">&nbsp;</div> 
</div> <!-- END mainbody ID -->
<?php get_footer(); ?>