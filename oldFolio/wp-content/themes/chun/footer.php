			</div><!-- #main -->

		</div><!-- .wrap -->

		<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

		<footer id="footer">

			<div class="footer-content">
				<?php echo apply_atomic_shortcode( 'footer_content', '<p class="credit">' . __( 'Copyright &copy; [the-year] [site-link]. Powered by [wp-link] and [theme-link].', 'chun' ) . '</p>' ); ?>
			</div><!-- .footer-content -->

		</footer><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // wp_footer ?>

</body>
</html>