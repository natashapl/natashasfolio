	<?php if ( is_home() && !is_front_page() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php echo get_post_field( 'post_title', get_queried_object_id() ); ?></h1>

			<div class="loop-description">
				<?php echo wpautop( get_post_field( 'post_content', get_queried_object_id() ) ); ?>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_category() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php single_cat_title(); ?></h1>

			<div class="loop-description">
				<?php echo category_description(); ?>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_tag() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php single_tag_title(); ?></h1>

			<div class="loop-description">
				<?php echo tag_description(); ?>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_tax() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php single_term_title(); ?></h1>

			<div class="loop-description">
				<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>

				<?php if ( is_tax( 'portfolio' ) ) get_template_part( 'menu', 'portfolio' ); ?>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_author() ) : ?>

		<?php $user_id = get_query_var( 'author' ); ?>

		<div id="hcard-<?php echo esc_attr( get_the_author_meta( 'user_nicename', $user_id ) ); ?>" class="loop-meta vcard">

			<h1 class="loop-title fn n"><?php the_author_meta( 'display_name', $user_id ); ?></h1>

			<div class="loop-description">
				<?php echo wpautop( get_the_author_meta( 'description', $user_id ) ); ?>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_search() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php echo esc_attr( get_search_query() ); ?></h1>

			<div class="loop-description">
				<p>
				<?php printf( __( 'You are browsing the search results for "%s"', 'chun' ), esc_attr( get_search_query() ) ); ?>
				</p>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_post_type_archive() ) : ?>

		<?php $post_type = get_post_type_object( get_query_var( 'post_type' ) ); ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php post_type_archive_title(); ?></h1>

			<div class="loop-description">
				<?php if ( !empty( $post_type->description ) ) echo wpautop( $post_type->description ); ?>

				<?php if ( is_post_type_archive( 'portfolio_item' ) ) get_template_part( 'menu', 'portfolio' ); ?>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php elseif ( is_day() || is_month() || is_year() ) : ?>

		<?php
		if ( is_day() )
			$date = get_the_time( __( 'F d, Y', 'chun' ) );
		elseif ( is_month() )
			$date = get_the_time( __( 'F Y', 'chun' ) );
		elseif ( is_year() )
			$date = get_the_time( __( 'Y', 'chun' ) );
		?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php echo $date; ?></h1>

			<div class="loop-description">
				<?php echo wpautop( sprintf( __( 'You are browsing the site archives for %s.', 'chun' ), $date ) ); ?>
			</div>

		</div>

	<?php elseif ( is_archive() ) : ?>

		<div class="loop-meta">

			<h1 class="loop-title"><?php _e( 'Archives', 'chun' ); ?></h1>

			<div class="loop-description">
				<p>
				<?php _e( 'You are browsing the site archives.', 'chun' ); ?>
				</p>
			</div><!-- .loop-description -->

		</div><!-- .loop-meta -->

	<?php endif; ?>