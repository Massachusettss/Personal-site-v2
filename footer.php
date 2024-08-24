<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Karis
 */

?>

		<?php
		/**
		 * Functions hooked in to karis_single_post_after action:
		 *
		 * @hooked karis_related_posts - 10
		 */
		do_action( 'karis_content_bottom' ); ?>
	</div><!-- #content -->

	<footer id="colophon" class="footer">
		<div class="footer__wrapper">
			<div class="footer__row">

				<?php
				/**
				 * Functions hooked in to karis_footer action:
				 *
				 * @hooked karis_footer_widgets - 10
				 * @hooked karis_site_info      - 20
				 */
				do_action( 'karis_footer' ); ?>

			</div><!-- .row -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php
/**
 * Functions hooked in to karis_site_after action:
 *
 * @hooked karis_search_overlay - 10
 */
do_action( 'karis_site_after' );

wp_footer(); ?>

</body>
</html>
