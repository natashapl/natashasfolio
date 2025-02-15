<?php 
/*
 * Template Name: Full Width, No Sidebar
 */
get_header(); 
?>
<div id="mainbody"> <!-- START mainbody ID -->
   <div class="wrapper"> <!-- START wrapper CLASS -->
	  <div id="contentarea" style="width:970px; border:0;"> <!-- START contentarea CLASS -->
	 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	   <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
                   <div class="entry">
                     <?php the_content(__(' Read More ', 'simplyworks')); ?>
				   </div>
                   <div class="clear"></div><!--  content may have floats we need to clear -->
                  <?php wp_link_pages('before=<div class="pagelinks">' . __('<strong>Pages: </strong>', 'simplyworks') .'&after=</div>'); ?>
<?php  if(isset($swc_options['swc_tags']) &&  ($swc_options['swc_tags'] == "1")) {       
} else {  
the_tags('<div class="tags"><strong>Tags: </strong>', ', ', '</div>'); 
} ?>
			    </div>  <!-- END post varible-id  ID  -->
		<?php endwhile; ?> 
			<div id="lowernav"> <!-- START lowernav ID -->
            <?php if (is_attachment()) { ?>
				<div class="left nextlink"><?php next_image_link('', __('&lt;&lt; view previous', 'simplyworks')); ?></div>
				<div class="right nextlink"><?php previous_image_link('', __('view next &gt;&gt;', 'simplyworks')); ?></div>
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
     <div class="clear"></div> 
   </div>  <!-- END wrapper CLASS -->
   <div class="clear"></div> 
</div> <!-- END mainbody ID -->
<?php get_footer(); ?>