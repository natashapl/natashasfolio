<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<?php
  if(is_home())
  {
  	echo'<title>';
  	bloginfo('name');
  	wp_title();
  	echo'</title>';
  }
  else
  {
  	echo'<title>';
  	the_title();
  	echo '</title>';
  }
?>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<meta name="title" content="Natasha's World - The Official Site of Natasha Pierre-Louis" /> 
<meta name="description" content="This site is undergoing some major revamping and a new one will launch this year. Stay tuned!" /> 
<link rel="image_src" href="http://natashasworld.com/nwlogosm.jpg" / >

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if IE]>
<style type="text/css">
body {
    font-size:16px;
}
</style>
<![endif]-->


<?php wp_head(); ?>

<script type="text/javascript" src="http://natashasworld.com/js/animatedcollapse.js">

/***********************************************
* Animated Collapsible DIV- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>

</head>
<body>
<script type='text/javascript' src='http://track3.mybloglog.com/js/jsserv.php?mblID=2007123101303707'></script>
<div id="mainContainer">

<!--Beginning of Header-->
  <div id="header">
    
	<div id="headerbanner">
      <h1><a href="<?php echo get_option('home'); ?>/" title="Natasha's World" ><img src="<?php bloginfo('stylesheet_directory'); ?>/images/nworld_hdr.jpg" alt="Natasha's World" width="671" height="180" border="0" /></a></h1>
    </div>
		
	<?php include (TEMPLATEPATH . '/menu.php'); ?>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
  </div>
    <!-- End of Header -->