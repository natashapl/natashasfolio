<?php
if ( function_exists('register_sidebar') )
    register_sidebars(2, array(
        'before_widget' => '<div class="sb-bot"><div class="sb-top"><div class="sb-right"><div class="sb-left"><div class="sb-rb"><div class="sb-lb"><div class="sb-rt"><div class="sb-lt">',
        'after_widget' => '</div></div></div></div></div></div></div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
?>
<?php function widget_search() {
?><?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_search');
?>