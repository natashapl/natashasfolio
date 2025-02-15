<?php get_header(); ?>

<div id="content">
	<div id="main">
		<div class="content"><div class="cont-r"><div class="cont-l"><div class="cont-bot">
			<div class="grad-hack"><div class="begin"></div>

	<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle">Archive for the ‘<?php single_cat_title(); ?>’ Category</h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle">Posts Tagged ‘<?php single_tag_title(); ?>’</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>
 	  <?php } ?>
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

				<div class="post">
					<h2 class="center">Not Found</h2>
					<p class="center">Sorry, but you are looking for something that isn't here.</p>
				</div>
	
	<?php endif; ?>

			</div>
		</div></div></div></div>
    	
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>

	</div>
	
	<?php get_sidebar(); ?>
	
	<div class="clear"></div>
</div>

<?php get_footer(); ?>