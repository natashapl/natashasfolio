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
						<h1><?php the_title(); ?></h1>
						<p class="author"><?php edit_post_link('Edit', ' | ', ' | '); ?>&nbsp;&nbsp;&nbsp;Posted by: <?php the_author() ?>&nbsp;&nbsp;&nbsp;in <?php the_category(', ') ?></p>
					</div>
					<div class="entry">
					
						<?php the_content('Read the rest of this entry »'); ?>
						
					</div>
				</div>

    <?php endwhile; ?>

	<?php endif; ?>

			</div>
		</div></div></div></div>
	</div>
	
	<?php get_sidebar(); ?>
	
	<div class="clear"></div>
</div>

<?php get_footer(); ?>