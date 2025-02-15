<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; <?php bloginfo('charset'); ?>" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<?php if(get_option('gridlock_disable_favicon') == 'false') { ?>
<link rel="shortcut icon" type="image/gif" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
<?php } ?>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" title="Gridlock Default" />

<?php if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') && get_option('gridlock_disable_ie6_warning') == 'false') { ?>
	<style type="text/css">
		#main_content { top: 157px; }
		#sidebar { top: 157px; }
	</style>
<?php } ?>

<!-- RSS Feeds -->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

<?php if(function_exists('delicious') && get_option('gridlock_delicious_username') != '') { ?>
<link rel="alternate" type="application/rss+xml" title="del.icio.us RSS" href="http://del.icio.us/rss/<?php get_option('gridlock_delicious_username'); ?>" />
<?php } ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- Archives -->
<?php wp_get_archives('type=monthly&format=link'); ?>

<!-- sIFR Implementation -->
<?php if(get_option('gridlock_disable_sifr') == 'false') { ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/sifr/sifr.js"></script>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
if(typeof sIFR == "function" && !sIFR.UA.bIsIEMac){
	sIFR.setup();
	sIFR.replaceElement(named({sSelector:"#sidebar ul li h2", sFlashSrc:"<?php bloginfo('stylesheet_directory'); ?>/sifr/helvneue.swf", sColor:"#333333", sLinkColor:"#333333", sBgColor:"#ffffff", sWmode:"transparent", sHoverColor:"#333333", nPaddingTop:2, nPaddingBottom:2, sFlashVars:"textalign=left&offsetTop=0"}));
	sIFR.replaceElement(named({sSelector:"#headline", sFlashSrc:"<?php bloginfo('stylesheet_directory'); ?>/sifr/helvneue.swf", sColor:"#333333", sLinkColor:"#333333", sBgColor:"#ffffff", sWmode:"transparent", sHoverColor:"#186FD0", nPaddingTop:0, nPaddingBottom:0, sFlashVars:"textalign=left&offsetTop=0"}));
	sIFR.replaceElement(named({sSelector:"h3.substory_head", sFlashSrc:"<?php bloginfo('stylesheet_directory'); ?>/sifr/helvneue.swf", sColor:"#333333", sLinkColor:"#333333", sBgColor:"#ffffff", sWmode:"transparent", sHoverColor:"#186FD0", nPaddingTop:0, nPaddingBottom:0, sFlashVars:"textalign=left&offsetTop=0"}));
	sIFR.replaceElement(named({sSelector:"h3.subhead", sFlashSrc:"<?php bloginfo('stylesheet_directory'); ?>/sifr/helvneue.swf", sColor:"#186FD0", sLinkColor:"#186FD0", sBgColor:"#ffffff", sWmode:"transparent", sHoverColor:"#186FD0", nPaddingTop:1, nPaddingBottom:1, sFlashVars:"textalign=left&offsetTop=0"}));
	sIFR.replaceElement(named({sSelector:"h3.substory_subhead", sFlashSrc:"<?php bloginfo('stylesheet_directory'); ?>/sifr/helvneue.swf", sColor:"#186FD0", sLinkColor:"#186FD0", sBgColor:"#ffffff", sWmode:"transparent", sHoverColor:"#186FD0", nPaddingTop:1, nPaddingBottom:1, sFlashVars:"textalign=left&offsetTop=0"}));
	sIFR.replaceElement(named({sSelector:".nav", sFlashSrc:"<?php bloginfo('stylesheet_directory'); ?>/sifr/helvneue.swf", sColor:"#EEEEEE", sLinkColor:"#EEEEEE", sBgColor:"#333333", sWmode:"transparent", sHoverColor:"#186FD0", nPaddingTop:3, nPaddingBottom:3, sFlashVars:"textalign=left&offsetTop=1"}));
}
//--><!]]>
</script>
<?php } ?>

<?php wp_head(); ?>

</head>

<body>

<?php if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') && get_option('gridlock_disable_ie6_warning') == 'false') { ?>
	
<div id="ie_warn">
It seems that you are using an obsolete version of Internet Explorer. It is highly recommended that you upgrade to 
<a href="http://www.microsoft.com/windows/ie/default.mspx" title="Internet Explorer 7">Internet Explorer 7</a> or 
<a href="http://www.mozilla.org/products/firefox/" title="Mozilla Firefox">Mozilla Firefox</a>.
</div>

<?php } ?>

<div id="masthead"> <h1 class="hidden"><?php bloginfo('title'); ?></h1> 
<?php if(get_option('gridlock_disable_logo') == 'false') { ?>
<a href="<?php echo get_settings('home'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.gif" alt="<?php bloginfo('title'); ?>" title="<?php bloginfo('title'); ?>" id="logo" /></a> 
<?php } ?>
</div>

<div id="upper"> 
	<!-- change these links to suit your site -->
	<div class="nav"><a href="<?php bloginfo('home'); ?>" title="home">home</a></div>
	
    <?php if(get_option('gridlock_photolocation') != '') { ?>
	<div class="nav" ><a href="<?php echo(get_option('gridlock_photolocation')); ?>" title="photos">photos</a></div>
	<?php } ?>
	
	<?php if(get_option('gridlock_about_slug') != '') { ?>
	<div class="nav"><a href="<?php bloginfo('url'); ?>/<?php echo(get_option('gridlock_about_slug')); ?>" title="about">about</a></div>
	<!-- /change these links to suit your site -->
	<?php } ?>
	
	<div class="nav_right"><a href="<?php bloginfo('rss2_url'); ?>" title="RSS 2.0 Feed"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/feed.gif" alt="Feed Icon" title="RSS 2.0 Feed" id="feedicon" /></a></div>
</div>