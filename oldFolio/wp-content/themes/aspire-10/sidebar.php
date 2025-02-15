	<div id="sidebars">
		<div id="sidebar-left">
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>

			<?php if ( is_404() || is_category() || is_day() || is_month() ||
						is_year() || is_search() || is_paged() ) {
			?> 
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<ul>
						<li>
			
						<?php /* If this is a 404 page */ if (is_404()) { ?>
						<?php /* If this is a category archive */ } elseif (is_category()) { ?>
						<p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>
			
						<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
						<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for the day <?php the_time('l, F jS, Y'); ?>.</p>
			
						<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
						<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for <?php the_time('F, Y'); ?>.</p>
			
						<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
						<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for the year <?php the_time('Y'); ?>.</p>
			
						<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
						<p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>
			
						<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>
			
						<?php } ?>
			
						</li>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
			<?php }?>
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Categories</h2>
					<ul>
						<?php wp_list_categories('show_count=0&title_li=0&hierarchical=0&order=ASC'); ?>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Recent Posts</h2>
					<?php query_posts('showposts=6'); ?>
					<ul>
					<?php while (have_posts()) : the_post(); ?>
						<li><span>[<?php the_time('j.n.Y') ?>]</span>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; ?>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
			
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Adsense</h2>
					<div class="textwidget">
<script type="text/javascript"><!--
google_ad_client = "";
google_ad_width = 160;
google_ad_height = 600;
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
					</div>
				</div></div></div></div>
			</div></div></div></div>
			<?php if (function_exists('src_simple_recent_comments')) { ?>
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Recent comments</h2>
					
					<?php src_simple_recent_comments(4,60,'', ''); ?>
					
				</div></div></div></div>
			</div></div></div></div>
			<?php } ?>
		<?php endif; ?>
		</div>
		<div id="sidebar-right">
		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Pages</h2>
					<ul>
						<?php wp_list_pages('title_li='); ?>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Archives</h2>
					<ul>
						<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
			<?php if ( is_home() || is_page() ) { ?>
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Links</h2>
					<ul>
						<?php get_links('-1', '<li>', '</li>', '', FALSE, 'id', FALSE, FALSE, -1, FALSE); ?>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
			<?php } ?>
			
			<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left">
				<div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">
					<h2>Meta</h2>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<li><a href="http://www.wpthemesfree.com/" title="Wordpress Themes">Wordpress Themes</a></li>
						<?php wp_meta(); ?>
					</ul>
				</div></div></div></div>
			</div></div></div></div>
		<?php endif; ?>
		</div>
		<div class="clear"></div>
	</div>
