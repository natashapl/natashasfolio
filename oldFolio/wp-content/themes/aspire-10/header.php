<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> » Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>
<body>
<div class="left-bg"><div class="script"></div></div>
<div class="right-bg"></div>
<div id="head">
	<div class="crack"></div>
	<div class="header">
		<div id="menu">
			<ul>
				<li <?php if(is_home()){echo 'class="current_page_item"';}?>><a href="<?php echo get_option('home'); ?>/" title="Home">Home</a></li>
	   	 		<?php wp_list_pages('title_li=&depth=1&sort_column=menu_order');?>
			</ul>
		</div>
		<div class="logo"><h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1></div>
	</div>
	<div class="shadow-right"></div>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>
