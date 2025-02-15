<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>

<div id="content">
	<div id="main">
		<div class="content"><div class="cont-r"><div class="cont-l"><div class="cont-bot">
			<div class="grad-hack"><div class="begin"></div>
				<div class="post1">
					<div class="entry">
						<h2>Links:</h2>
						<ul>
						<?php get_links_list(); ?>
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
