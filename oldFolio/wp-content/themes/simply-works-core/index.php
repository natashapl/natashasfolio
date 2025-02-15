<?php 
/*
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version: 1.5.8
Description: Primary Index Page for the core
 */
get_header(); 
?>
<div id="mainbody"> <!-- START mainbody ID -->
   <div class="wrapper"> <!-- START wrapper CLASS -->
	  <div id="contentarea"> <!-- START contentarea CLASS -->
	 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	   <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
		<?php // SINGLE //
		    if (is_single()) { ?>
			  <?php the_title('<h2 class="contenttitle">', '</h2>'); ?>
                   <?php // Attachment  -- show back link
				   if (is_attachment()) { ?>
						 <p class="attachmentnav">&larr; <?php esc_attr(_e("back to", "simplyworks"));?> <a href="<?php echo get_permalink($post->post_parent) ?>" title="<?php echo get_the_title($post->post_parent) ?>" rev="attachment"><?php echo get_the_title($post->post_parent) ?></a></p>
					<?php } else { ?>
                         <div class="postmeta"> <!-- START postmeta CLASS -->
 <?php  if(isset($swc_options['swc_author']) &&  ($swc_options['swc_author'] == "1")) {         
} else { ?>
	<span class="author"><?php _e("by: ", "simplyworks");?><?php the_author(); ?></span> - 
<?php } ?>
<?php  if(isset($swc_options['swc_date']) &&  ($swc_options['swc_date'] == "1")) {         
} else { ?>	
<?php the_time(__('F jS, Y', 'simplyworks'))?>&nbsp;&nbsp;
<?php } ?>
                        
<?php edit_post_link('Edit', '<span class="edit">', '</span>   '); ?> 
<?php  if ( isset ($swc_options['swc_comments']) &&  ($swc_options['swc_comments'] == "1") ) {         
} else {
	comments_popup_link('Add Comment', '1 Comment', '% Comments', 'comm', '');
}
?>
					    </div> <!-- END postmeta CLASS -->
                        <?php if(has_post_thumbnail()) { ?>
                          <div class="imgshadow"><?php the_post_thumbnail('single-post-thumbnail'); ?></div>
                        <?php } ?>
                 <?php } // END Attachemnt if/esle ?>
				<?php  ////  PAGE /////////////////////
				} elseif (is_page()) { ?>
					<?php the_title('<h2 class="contenttitle">', '</h2>'); ?>
                    <div class="postmeta">  <!-- START postmeta CLASS -->
                  <?php  if ( isset ($swc_options['swc_comments']) &&  ($swc_options['swc_comments'] == "1") ) {         
} else {
	comments_popup_link('Add Comment', '1 Comment', '% Comments', 'comm', '');
}
?>
					</div> <!-- END postmeta CLASS -->
                    <?php if(has_post_thumbnail()) { ?>
                    <div class="imgshadow"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(array(150,150), array('class' => 'imgshadowleft')); ?></a></div> 
                    <?php } ?>
				<?php 
				////////  CAT LISTING  /////////////////////
				} else { ?>
                    <h2 class="contenttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <div class="postmeta"> <!-- START postmeta CLASS -->
<?php  if(isset($swc_options['swc_author']) &&  ($swc_options['swc_author'] == "1")) {         
} else { ?>
	<span class="author"><?php _e("by: ", "simplyworks");?><?php the_author(); ?></span> - 
<?php } ?>
<?php  if(isset($swc_options['swc_date']) &&  ($swc_options['swc_date'] == "1")) {         
} else { ?>	
<?php the_time(__('F jS, Y', 'simplyworks'))?>&nbsp;&nbsp;
<?php } ?>
<?php  if(isset($swc_options['swc_filed']) &&  ($swc_options['swc_filed'] == "1")) {         
} else { ?>	
<?php  _e("Filed under: ", 'simplyworks'); ?> <?php the_category(', ') ?>  
<?php } ?>
<?php edit_post_link('Edit', '<span class="edit">', '</span>   '); ?> 
<?php  if ( isset ($swc_options['swc_comments']) &&  ($swc_options['swc_comments'] == "1") ) {         
} else {
	comments_popup_link('Add Comment', '1 Comment', '% Comments', 'comm', '');
}
?>               

					</div> <!-- END postmeta CLASS -->
					<?php if(has_post_thumbnail()) { ?>
                    <div class="imgshadow"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(array(150,150), array('class' => 'imgshadowleft')); ?></a></div> 
                    <?php } ?>
				<?php } ?>
                   <div class="entry">
                     <?php the_content(__(' Read More ', 'simplyworks')); ?>
				   </div>
                   <div class="clear"></div><!--  content may have floats we need to clear -->
                  <?php wp_link_pages('before=<div class="pagelinks">' . __('<strong>Pages: </strong>', 'simplyworks') .'&after=</div>'); ?>
                  
<?php  if(isset($swc_options['swc_tags']) &&  ($swc_options['swc_tags'] == "1")) {       
} else {  
the_tags('<div class="tags"><strong>Tags: </strong>', ', ', '</div>'); 
} ?>
                    
                  <?php if (is_single()) { // author information if is_single 
// If a user has filled out their description, show a bio on their entries.
if ( get_the_author_meta( 'description' ) ) : ?>
					<div id="author-bio">
						<div id="author-avatar">
							<?php  echo get_avatar( get_the_author_meta( 'user_email' ), '60' ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							 <h2 class="author-title"><?php printf( __( 'About: %s', 'simplyworks' ), "<a href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' >" . get_the_author() . "</a>" ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
						</div><!-- #author-description	-->
					</div><!-- #entry-author-info -->
                    <?php endif; ?>
                    <?php  } //  END if is_single  ?>
				<?php if (is_single()) {// requires plugin 
				       if ( function_exists( 'wp_related_posts' ) ) {
                           wp_related_posts(); ?>
					       <div class="clear"></div>
					  <?php  }  
				      }
                  ?>
			    </div>  <!-- END post varible-id  ID  -->
		<?php endwhile; ?> 
			<div id="lowernav"> <!-- START lowernav ID -->
            <?php if (is_attachment()) { ?>
				<div class="left nextlink"><?php next_image_link('', __('&lt;&lt; view previous', 'simplyworks')); ?></div>
				<div class="right nextlink"><?php previous_image_link('', __('view next &gt;&gt;', 'simplyworks')); ?></div>
			<?php } elseif (is_single()) { ?>
                <div class="left"><?php previous_post_link(__('&lt;&lt; %link', 'simplyworks')); ?></div>
				<div class="right"><?php next_post_link(__('%link &gt;&gt;', 'simplyworks')); ?></div> 				
			<?php } else { ?>
				<div class="left nextlink"><?php next_posts_link(__('&lt;&lt; previous entries', 'simplyworks')); ?></div>
				<div class="right nextlink"><?php previous_posts_link(__('recent entries &gt;&gt;', 'simplyworks')); ?></div>
			<?php } ?> 
              <div class="clear"></div>
			</div><!-- END lowernav ID -->
<?php  if ( isset ($swc_options['swc_comments']) &&  ($swc_options['swc_comments'] == "1") ) {      
} else {
	comments_template('', true);
}
?>
	<?php endif; ?>
	</div> <!-- END contentarea CLASS -->
<?php get_sidebar(); ?>
     <div class="clear"></div> 
   </div>  <!-- END wrapper CLASS -->
   <div class="clear"></div> 
</div> <!-- END mainbody ID -->
<?php get_footer(); ?>