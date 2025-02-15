<?php
/**
 * Template Name: Portfolio
 */

get_header(); // Loads the header.php template. ?>

	<div id="content">

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php if ( !is_front_page() ) { ?>
							<header class="entry-header">
								<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
							</header><!-- .entry-header -->
						<?php } ?>

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'chun' ) . '</span>', 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

						<?php get_template_part( 'menu', 'portfolio' ); ?>

					</article><!-- .hentry -->

				<?php endwhile; ?>

			<?php endif; ?>

			<?php $loop = new WP_Query(
				array(
					'post_type'      => 'portfolio_item',
					'posts_per_page' => 8,
				)
			); ?>

			<?php if ( $loop->have_posts() ) : ?>

				<?php while( $loop->have_posts() ) : $loop->the_post(); ?>

					<?php get_template_part( 'content', get_post_type() ); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>