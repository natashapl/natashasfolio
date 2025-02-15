<?php
/*
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version: 1.5.8
Description: Sidebar
 */
?>
<div id="sidebar">
<?php  // no sidebar widgets active on  default install - this allows for several flexible layout options //
if (is_active_sidebar('sidebar-top') || is_active_sidebar('sidebar-bottom-left') || is_active_sidebar('sidebar-bottom-right') || is_active_sidebar('sidebar-bottom')) : ?> 
	<?php // Top 330px wide widget area
	 if (is_active_sidebar('sidebar-top')) : ?>	
	    <ul>
	     <?php dynamic_sidebar('sidebar-top'); ?>
        </ul>	   
    <?php endif; ?>
	<?php  // Left Narrow 170px wide widget area
	 if (is_active_sidebar('sidebar-bottom-left')) : ?>	
      <div id="l_sidebar">
	    <ul>
	     <?php dynamic_sidebar('sidebar-bottom-left'); ?>
        </ul>
      </div>	   
    <?php endif; ?>
    <?php // Right Narrow 150px wide widget area
	if (is_active_sidebar('sidebar-bottom-right')) : ?>	
      <div id="r_sidebar">
	    <ul>
	     <?php dynamic_sidebar('sidebar-bottom-right'); ?>
        </ul>
       </div>	   
    <?php endif; ?>
   <?php  //NEW n ver. 1.4.7  Bottom 330px wide widget area
   if (is_active_sidebar('sidebar-bottom')) : ?>	
	    <ul>
	     <?php dynamic_sidebar('sidebar-bottom'); ?>
        </ul>	   
    <?php endif; ?>
<?php endif; ?>
</div><!-- END  Sidebar  -->