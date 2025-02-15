<?php if ( has_nav_menu( 'primary' ) ) {

	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'container'       => 'nav',
			'container_id'    => 'menu-primary',
			'container_class' => 'menu',
			'menu_id'         => 'menu-primary-items',
			'menu_class'      => 'menu-items',
			'fallback_cb'     => ''
		)
	);

} ?>