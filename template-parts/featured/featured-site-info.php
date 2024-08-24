<?php
/**
 * The template for displaying header image.
 *
 * @package Karis
 */

$description = get_bloginfo( 'description', 'display' );
?>

<?php
if ( get_header_image() || $description || is_customize_preview() ) : ?>

	<div id="featured-content-area" class="featured-content-area">
		<div class="featured featured--site-info<?php if ( get_header_image() ) : ?> featured--has-header-image<?php endif; ?><?php if ( $description ) : ?> featured--has-site-description<?php endif; ?>">
			<div class="bg-lines">
				<div class="bg-line bg-line--1"></div>
				<div class="bg-line bg-line--2"></div>
				<div class="bg-line bg-line--3"></div>
				<div class="bg-line bg-line--4"></div>
				<div class="bg-line bg-line--5"></div>
			</div>

			<?php
			if ( get_header_image() ) :
				/**
				 * Filter the default Karis custom header sizes attribute.
				 *
				 * @param string $custom_header_sizes sizes attribute
				 * for Header Image. Default '100vw'.
				 */
				$custom_header_sizes = apply_filters( 'karis_custom_header_sizes', '100vw' ); ?>

				<div class="featured__header-image">
					<img src="<?php header_image(); ?>"
							 srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, array( 1920, 1280 ) ) ); ?>"
							 sizes="<?php echo esc_attr( $custom_header_sizes ); ?>"
							 width="<?php echo esc_attr( get_custom_header()->width ); ?>"
							 height="<?php echo esc_attr( get_custom_header()->height ); ?>"
							 alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				</div><!-- .featured__header-image -->
			<?php
			endif; // End header image check.

			if ( $description || is_customize_preview() ) : ?>
				<div class="featured__site-description">
					<p class="site__description"><?php echo esc_attr( $description ); /* WPCS: xss ok. */ ?></p>
				</div><!-- .site-description__holder -->
			<?php
			endif; ?>

			<div class="featured__scroll-to-content">
				<button type="button" class="button--scroll-to-content" aria-label="<?php esc_attr_e( 'Scroll to content', 'karis' ); ?>">
					<?php echo karis_get_icon_svg( 'arrow_downward', 20 ); ?>
				</button>
			</div>
		</div><!-- .featured -->
	</div><!-- .featured-content-area -->

<?php
endif;
