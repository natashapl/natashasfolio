<?php
/**
* Plugin Name: SKT Skill Bar
* Description: Skill Bar plugin to show skill bar or progress bar or circular bar or vertical bar or half circular bars using fancy animated jquery.
* Plugin URI:  https://www.sktthemes.org
* Author:      SKT Themes
* Author URI:  https://www.sktthemes.org
* Version:     1.7
*/
define('SB_VER','1.7');
add_action('wp_print_scripts', 'sbar_register_scripts');
add_action('wp_print_styles', 'sbar_register_styles');

function sbar_register_scripts() {
	if ( !is_admin() ) {
		wp_enqueue_script('jquery');
		
		wp_register_script('bar_script', plugins_url('skill_bar/bar/jquery.appear.js', __FILE__));
		wp_enqueue_script('bar_script');

		wp_register_script('circle_script', plugins_url('skill_bar/circle/jquery.easy-pie-chart.js', __FILE__),'',SB_VER,true);
		wp_enqueue_script('circle_script');

		wp_register_script('circle_custom_script', plugins_url('skill_bar/circle/custom.js', __FILE__),'',SB_VER,true);
		wp_enqueue_script('circle_custom_script');
		
		wp_register_script('gage_script', plugins_url('skill_bar/gage/justgage.js', __FILE__),'',SB_VER,true);
		wp_enqueue_script('gage_script');

		wp_register_script('gage_raphael_script', plugins_url('skill_bar/gage/raphael-2.1.4.min.js', __FILE__),'',SB_VER,true);
		wp_enqueue_script('gage_raphael_script');

	}
}

function sbar_register_styles() {
	wp_register_style('bar_styles', plugins_url('skill_bar/bar/sbar.css', __FILE__));	// register
	wp_enqueue_style('bar_styles');	// enqueue

	wp_register_style('circle_styles', plugins_url('skill_bar/circle/jquery.easy-pie-chart.css', __FILE__));	// register
	wp_enqueue_style('circle_styles');	// enqueue

	wp_register_style('skt_verticleline_css', plugins_url('skill_bar/css/custom.css', __FILE__));	// register
	wp_enqueue_style('skt_verticleline_css');	// enqueue

	
}


//	[skillwrapper type="circle" track_color="#dddddd" chart_color="#333333" chart_size="150"][/skillwrapper]
function skillwrapper_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'bar',
		'track_color' => '#dddddd',
		'chart_color' => '#333333',
		'chart_size' => '150',
		'align' => 'center',
		'chart_fontsize' =>'',
		'chart_headingfontsize' =>'',
		'bar_titlefontsize' =>'',
		'bar_titlecolor' =>'',
		'bar_percentfontszie' => '',
		'bar_percentcolor' => '',
	), $atts ) );
	switch ( $type ){

		case 'bar':
			$wrapCode = '<div id="skillbar_straight" style="padding:10px 0;">'.str_replace('<br />', "\n", do_shortcode($content))."\n".'<div style="clear:both;"></div>'."\n".'</div>'."\n".'<div style="clear:both; height:10px; overflow:hidden;"></div>'."\n";
			$wrapCode .= '<style type="text/css">.skillbar-title{font-size:'.$bar_titlefontsize.'px;color:'.$bar_titlecolor.';}.skill-bar-percent{font-size:'.$bar_percentfontszie.'px;color:'.$bar_percentcolor.';}</style>';
			$wrapCode .= '<script>
				function sbar(){
					jQuery(".skillbar").each(function(){
						jQuery(this).find(".skillbar-bar").animate({
							width:jQuery(this).attr("data-percent")
						},3000);
					});	
				}
				if ( jQuery("#skillbar_straight").next().is(":appeared") ){
					sbar();
				} else {
					jQuery( window ).scroll(function() {
						if ( jQuery("#skillbar_straight").next().is(":appeared") ){
							sbar();
						}
					});
				}
				</script>';
			break;

		case 'gage':
			$wrapCode = '';
			$content = strip_tags($content);
			$start = strpos($content, '[');
			$end = strrpos($content, '"]');
			$len =  strlen($content);
			$diff = $end - $len;
			$content = substr( $content, $start, $diff);
			$content = str_replace(array('[skill ', '"]', '" ]', '" ', '="' ), array('', '', '', ':', '='), $content);
			$cntStrAr = explode( "\n", $content );
			$numAr = array();
			foreach($cntStrAr as $cntk => $cntv){
				if($cntv != ''){
					$cnStr = str_replace( array('bar_foreground=', 'bar_background=', 'percent=', 'title='), array('','','',''), trim($cntv) );
					$numAr[] = explode(':', $cnStr);
				}
			}
			//$numAr = $cntAr;

			$wrapCode = '<style type="text/css">';
			$cssVar = '';
			foreach($numAr as $n => $b){ 
				$n++; 
				$cssVar .= (count($numAr) == $n) ? '#g'.$n : '#g'.$n.', ';  
			}
			$wrapCode .= $cssVar.'{ width:200px; height:160px; display: inline-block; margin: 1em; }
				#gage_chart{text-align:'.$align.';}';
			$wrapCode .= '</style>';
			$wrapCode .= '<script>';
			$sbIds = '';
			foreach($numAr as $n => $b){ 
				$n++; 
				$sbIds .= (count($numAr) == $n) ? 'g'.$n : 'g'.$n.', ';  
			}
			$wrapCode .= 'var '.$sbIds.';'."\n";
			$wrapCode .= 'function anup(){';
				foreach($numAr as $n => $v){ 
					$n++; 
					$wrapCode .= 'var g'.$n.' = new JustGage({
						  id: "g'.$n.'", 
						  value: '.$v[0].',
						  title: "'.$v[1].'",
						  valueFontColor: "'.$v[2].'",
						  levelColors : ["'.$v[2].'"],
						  titleFontColor : "'.$v[2].'",
						  labelFontColor : "'.$v[2].'",
						  gaugeColor : "'.$v[3].'",
						  min: 0,
						  max: 100,
						  label: "%",
						  levelColorsGradient: false,
						  showMinMax :"hide",
						  shadowOpacity :"0.2",		
						  shadowSize : "5",  
						  startAnimationType : "easein",
					});'."\n";
				}
			$wrapCode .= '};'."\n";

			$wrapCode .= 'jQuery(document).ready( function(){
				if ( jQuery("#gage_chart").next().is(":appeared") ){
					if (  ! jQuery("#gage_chart").hasClass("gc_active") ) {
						anup();
						jQuery("#gage_chart").addClass("gc_active");
					}
				} else {
					jQuery( window ).scroll(function() {
						if ( jQuery("#gage_chart").next().is(":appeared") ){
							if (  ! jQuery("#gage_chart").hasClass("gc_active") ) {
								anup();
								jQuery("#gage_chart").addClass("gc_active");
							}
						}
					});
				}
			});
			</script>';
			$wrapCode .= '<div id="gage_chart">';
			foreach($numAr as $n => $b){ 
				$n++;
				$wrapCode .= '<div id="g'.$n.'"></div>';
			} 
			$wrapCode .= '</div>';
			$wrapCode .= '<div style="clear:both; height:10px; overflow:hidden;"></div>';
			break;

		case 'circle':
			$wrapCode = '<div class="vertical-page">
					<article class="cvpage " id="resume">
						<div class="charts clearfix">
							<div>
								<ul class="car hideme">'.str_replace('<br />', '', do_shortcode($content)).'</ul>
								<div style="clear:both"></div>
							</div>
						</div>
					</article>
				</div>
				<div style="clear:both; height:10px; overflow:hidden;""></div>
				<style type="text/css">
				.chart{color:'.$track_color.'; margin-bottom:5px;font-size:'.$chart_fontsize.'px;}
				.chartbox p{color:'.$chart_color.';font-size:'.$chart_headingfontsize.'px;} 
				.car, .skills ul{text-align:'.$align.';}
				</style>
				<script type="text/javascript">
				jQuery(".chartbox p").each( function(){
					if( jQuery(this).html() == "" ){
						jQuery(this).remove();
					}
				});
				var pixflow_js_opt = {"pie_chart_color":"'.$chart_color.'","pie_track_color":"'.$track_color.'","pie_chart_size":"'.$chart_size.'"};
				</script>';
			break;

			case 'skt_verticalgraph':
				$wrapCode = '';
				$content = strip_tags($content);
				$start = strpos($content, '[');
				$end = strrpos($content, '"]');
				$len =  strlen($content);
				$diff = $end - $len;
				$content = substr( $content, $start, $diff);
				$content = str_replace(array('[skill ', '"]', '" ]', '" ', '="' ), array('', '', '', ':', '='), $content);
				$cntStrAr = explode( "\n", $content );
				$numAr = array();
				foreach($cntStrAr as $cntk => $cntv){
					if($cntv != ''){
						$cnStr = str_replace( array( 'percent=', 'title=', 'verticalgraph_background=', 'verticalgraph_titlecolor='), array('','','',''), trim($cntv) );
						$numAr[] = explode(':', $cnStr);
					}
				}

				$cssVar = '';
				foreach($numAr as $n => $b){ 
					$n++; 
					$cssVar .= (count($numAr) == $n) ? '#g'.$n : '#g'.$n.', ';  
				}
				$sbIds = '';
				foreach($numAr as $n => $b){ 
					$n++; 
					$sbIds .= (count($numAr) == $n) ? 'g'.$n : 'g'.$n.', ';  
				}

				$wrapCode .= '<div id="skillbarstraight">';
$wrapCode .= '<ul class="chart_line">';
        foreach($numAr as $n => $v){ 
         $wrapCode .= '<li class="skillbar_ver">
            <span class="chartline" data-height="'.$v[0].'%;" style="height:'.$v[0].'%;background:'.$v[2].';color:'.$v[3].';" title="'.$v[1].'"></span>
          </li>';
         }
$wrapCode .= '</ul></div>';
				$wrapCode .= '<script>
				jQuery(document).on("scroll", function() {
    				if( jQuery(this).scrollTop() >= jQuery("#skillbarstraight").position().top ){
         					jQuery(".chartline").addClass("sktvaertical");    
         				}
				});
				</script>';
			break;
	}
	return $wrapCode;
}
add_shortcode( 'skillwrapper', 'skillwrapper_func' );


//[skill title_background="#f7a53b" bar_foreground="#f7a53b" bar_background="#eeeeee" percent="90" title="CSS3"]
function skilldata_func( $atts ) {
	extract( shortcode_atts( array(
		'title_background' => '',
		'bar_foreground' => '',
		'bar_background' => '',
		'percent' => '0',
		'title' => '',
	), $atts ) );


	if( $title_background != '' ){
		$skillHtml = '<div class="skillbar clearfix" data-percent="'.$percent.'%" style="background: '.$bar_background.';">
				<div class="skillbar-title" style="background: '.$title_background.';"><span>'.$title.'</span></div>
				<div class="skillbar-bar" style="background: '.$bar_foreground.';"></div>
				<div class="skill-bar-percent">'.$percent.'%</div>
			</div>';
	}elseif( $title_background == '' && $bar_foreground != '' && $bar_background != '' ){
		$skillHtml = '<div class="skillbar clearfix " data-percent="'.$percent.'%" style="background: '.$bar_background.';">
				<div class="skillbar-title" style="background: '.$title_background.';"><span>'.$title.'</span></div>
				<div class="skillbar-bar" style="background: '.$bar_foreground.';"></div>
				<div class="skill-bar-percent">'.$percent.'%</div>
			</div>';
	}elseif( $title_background == '' && $bar_foreground == '' && $bar_background == '' ){
		$skillHtml = '<li>
				<div class="chartbox">
					<div class="chart" data-percent="'.$percent.'">
						<span>'.$percent.'%</span>
					</div>
					<p>'.strip_tags($title).'</p>
				</div>
			</li>';
	}

	return $skillHtml;
}
add_shortcode( 'skill', 'skilldata_func' );


// create skt skillbar option page
function sbar_admin() {  
    include('sktskillbar_option.php');  
}
function sbar_admin_actions() {
	add_options_page('SKT Skill Bar', 'SKT Skill Bar', 'manage_options', 'sktskillbar_admin', 'sbar_admin');
}
add_action('admin_menu', 'sbar_admin_actions');

function sktskillbar_admin_action_links($links, $file) {
    static $tb_plugin;
    if (!$tb_plugin) {
        $tb_plugin = plugin_basename(__FILE__);
    }
    if ($file == $tb_plugin) {
        $settings_link = '<a href="options-general.php?page=sktskillbar_admin">Settings</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}
add_filter('plugin_action_links', 'sktskillbar_admin_action_links', 10, 2);
?>