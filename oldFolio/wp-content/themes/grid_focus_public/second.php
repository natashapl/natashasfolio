<div id="midCol">
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	<div class="middle_links">
		<h3>Your choice links</h3>
		<p>Your choice links. Let readers know what they should be reading on your site.</p>
		<ul>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
		</ul>
	</div>
	<div class="middle_links">
		<h3>Your choice links</h3>
		<p>Your choice links. Let readers know what they should be reading on your site.</p>
		<ul>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
			<li><a href="#">Link Title</a> - Link description (optional)</li>
		</ul>
	</div>
	<div class="middle_links">
		<h3>Subscribe</h3>
		<p>Stay updated on my meandering thoughts &amp; activities via RSS (Syndicate).</p>
		<ul>
			<li><a href="feed:<?php bloginfo('rss2_url'); ?>" title="Full content RSS feed">Content RSS</a> - Straight to your reader</li>
			<li><a href="feed:<?php bloginfo('comments_rss2_url'); ?>" title="Full comments RSS feed">Comments RSS</a> - Add to the discussion</li>
		</ul>
	</div>
	<div class="middle_links">
		<h3>Meta</h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
</div>