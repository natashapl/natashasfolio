<?php
/**
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version: 1.5.8
Description: Footer include file
 */
?>
<?php // Did the use add footer widgets? 
 if (is_active_sidebar('footer-left') || is_active_sidebar('footer-center') || is_active_sidebar('footer-right') ) :
?> 
<div class="clear"></div>
   <div id="footer"><!-- START footer ID -->
      <div class="wrapper"><!-- START wrapper CLASS -->
<?php // Widget area for user
if (is_active_sidebar('footer-left')) :	   
	   dynamic_sidebar('footer-left');
endif;
if (is_active_sidebar('footer-center')) :
	   dynamic_sidebar('footer-center');
endif;	   
if (is_active_sidebar('footer-right')) :	   
	   dynamic_sidebar('footer-right');
endif;	   
?>
         <div class="clear">&nbsp;</div>
        </div><!-- END wrapper CLASS -->
      </div><!-- END footer ID --> 
 <?php endif; ?>
<div class="clear"></div> 
 <div id="copyright"><!-- START copyright ID -->
     <div class="wrapper"><!-- START wrapper CLASS -->
        <div class="copycolumn">
	    	<p class="right"><?php _e("Built on", "simplyworks");?> <a href="http://www.simplyworkscore.com" title="Simply Works Core">Simply Works Core</a><br />
    	     Powered by <a href="http://wordpress.org" title="WordPress">WordPress</a></p>
       </div>
	    <div class="copycolumnwide">
	    	<p>Copyright &copy; <a href="<?php esc_url(bloginfo('url')); ?>"><?php esc_attr(strip_tags(bloginfo('name'))); ?></a><br /><em><?php esc_attr(strip_tags(bloginfo('description'))); ?></em></p>
	    </div>
       <div class="clear">&nbsp;</div>
	</div><!-- END wrapper CLASS -->
  </div><!-- END copyright ID -->  
</div><!-- END webpage ID -->
<?php wp_footer(); ?>
</body>
</html>