<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="content">
	<div id="main">
		<div class="content"><div class="cont-r"><div class="cont-l"><div class="cont-bot">
			<div class="grad-hack"><div class="begin"></div>
				<div class="post1">
					<div class="entry">
			          <h2>Recent 20 Posts</h2>
			          <ul>
			            <?php wp_get_archives('type=postbypost&limit=20'); ?>
			          </ul>
			          <h2>by Category</h2>
			          <ul>
			            <?php wp_list_cats('optioncount=1');?>
			          </ul>
			          <h2>by Month</h2>
			          <ul>
			            <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
			          </ul>
					</div>
				</div>
			</div>
		</div></div></div></div>
	</div>
	<?php get_sidebar(); ?>
	<div class="clear"></div>
</div>

<?php get_footer(); ?>
