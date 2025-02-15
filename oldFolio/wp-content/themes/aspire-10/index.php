<?php get_header(); ?>

<div id="content">
	<div id="main">
		<div class="content"><div class="cont-r"><div class="cont-l"><div class="cont-bot">
			<div class="grad-hack"><div class="begin"></div>

	<?php if (have_posts()) : ?>
<?php $postnumber = '1' ?>
		<?php while (have_posts()) : the_post(); ?>

				<div class="post<?php if($postnumber == '1') echo $postnumber; $postnumber++; ?>" id="post-<?php the_ID(); ?>">
					<div class="title">
						<div class="date"><?php the_time('j') ?><div class="month"><?php the_time('M') ?></div></div>
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
						<p class="author"><?php edit_post_link('Edit', ' | ', ' | '); ?>&nbsp;&nbsp;&nbsp;Posted by: <?php the_author() ?>&nbsp;&nbsp;&nbsp;in <?php the_category(', ') ?></p>
					</div>
					<div class="entry">
					
						<?php if (function_exists('the_excerpt_reloaded')) 
							the_excerpt_reloaded(145, '<a><img>', 'excerpt', TRUE, 'Read the full post...');
						else
							the_content('Read the rest of this entry »');
						?>
						
					</div>
					<div class="postmetadata"><div class="comm-num-left"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div><div class="clear"></div></div>
				</div>

    <?php endwhile; ?>

	<?php else : ?>

				<div class="post1">
					<h2 class="center">Not Found</h2>
					<p class="center">Sorry, but you are looking for something that isn't here.</p>
				</div>
	
	<?php endif; ?>

			</div>
		</div></div></div></div>
    	
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
			<div class="wp-pagenavi2"><?php next_posts_link('Previous Entries') ?><?php previous_posts_link('Next Entries') ?></div>
		<?php } ?>

	</div>
	
	<?php get_sidebar(); ?>
	
	<div class="clear"></div>
</div>

<?php get_footer(); ?>