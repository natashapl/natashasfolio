<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php if (is_home () ) { bloginfo('name'); } elseif ( is_category() ) {
single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {
single_post_title();
} elseif (is_search() ) {
bloginfo('name'); echo " search results: "; echo wp_specialchars($s);
} else { wp_title('',true); }
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/toggle.js"></script>
<?php wp_head(); ?>
</head>
<body>
	<div id="wrapper"><a name="top"></a>
	<div id="masthead" class="fix">
	<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div id="authorBlurb">
		<img src="<?php bloginfo('template_directory'); ?>/images/avatar.png" alt="Avatar" />
		<p id="authorIntro"><?php bloginfo('description'); ?></p>
		</div>
	</div>
	<ul class="nav fix">
		<li><a href="<?php echo get_settings('home'); ?>/" title="Return to the the frontpage">Home<br /><span>Frontpage</span></a></li>
		<li><a href="javascript:;" onmousedown="toggleDiv('archives');" title="View the archives">Archives<br /><span>Browse freely</span></a></li>
		<li><a href="#" title="Link title">Link<br /><span>Short Desc</span></a></li>
		<li><a href="#" title="Link title">Link<br /><span>Short Desc</span></a></li>
		<li><a href="#" title="Link title">Link<br /><span>Short Desc</span></a></li>
		<li><a href="" title="Subscribe to the main feed via RSS">RSS<br /><span>Syndicate</span></a></li>
		<li class="skip"><a href="#main" title="Skip to content">Main<br /><span>Skip to content</span></a></li>
	</ul>
	<div id="archives" class="fix" style="display: none;"> 
		<ul class="fix">
		<?php wp_list_cats('sort_column=name&optioncount=0&exclude=10, 15'); ?>
		</ul>
	</div>