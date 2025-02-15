<?php
/**
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version: 1.5.8
Description: Search Results page
 */
get_header(); ?>
<div id="mainbody">
 <div class="wrapper">
  <div id="contentarea">
	<?php if (have_posts()) : ?>
	   <h2 class="contenttitle">Search Results</h2>
		<?php while (have_posts()) : the_post(); ?>
           <h2 class="contenttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <div class="postmeta"> <!-- START postmeta CLASS -->
                   <span class="author"><?php _e("By: ", "simplyworks");?><?php the_author(); ?></span> - <?php the_time(__('F jS, Y', 'simplyworks'))?>&nbsp;&nbsp;
             <?php if(get_the_category()){ ?>
                <?php _e("Filed under: ", 'simplyworks'); ?> <?php the_category(', ') ?>  
		    <?php } ?>
				   <?php edit_post_link('Edit', '<span class="edit">', '</span>   '); ?>               </div> <!-- END postmeta CLASS -->

                 <div class="entry">
				   <?php the_excerpt(); ?>
			     </div>
                  <?php wp_link_pages('before=<div class="pagelinks">' . __('<strong>Pages: </strong>', 'simplyworks') .'&after=</div>'); ?>
                  <?php the_tags('<div class="tags"><strong>Tags: </strong>', ', ', '</div>'); ?>
                 <hr />
		<?php endwhile; ?>
                      <div class="left nextlink"><?php next_posts_link(__('&lt;&lt; previous entries', 'simplyworks')); ?></div>
		    <div class="right nextlink"><?php previous_posts_link(__('recent entries &gt;&gt;', 'simplyworks')); ?></div> 

	<?php else : ?>
	 <h2 class="contenttitle"><?php _e('No posts found. Try a different search?', 'simplyworks'); ?></h2>
		<?php get_search_form(); ?>
	<?php endif; ?>

   </div><!-- END contentarea -->
<?php get_sidebar(); ?>
    <div class="clear"></div>
    </div>  <!-- END wrapper class -->
  <div class="clear"></div> 
</div> <!-- END mainbody ID -->
<?php get_footer(); ?>