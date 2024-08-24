<?php
/**
 * The template for displaying full width featured posts carousel.
 *
 * @package Karis
 */

?>

<?php if ( karis_has_featured_posts() ) :
	$featured_posts = karis_get_featured_posts(); ?>

	<div id="featured-content-area" class="featured-content-area">
		<div class="featured featured--carousel-v1">
			<div id="featured-carousel" class="carousel">

				<?php // Start the loop.
				foreach ( (array) $featured_posts as $order => $post ) :
					setup_postdata( $post ); ?>

					<article class="carousel__item carousel-item<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> carousel-item--has-thumbnail<?php endif; ?>">
						<div class="bg-lines">
							<div class="bg-line bg-line--1"></div>
							<div class="bg-line bg-line--2"></div>
							<div class="bg-line bg-line--3"></div>
							<div class="bg-line bg-line--4"></div>
							<div class="bg-line bg-line--5"></div>
						</div>

						<?php
						$custom_attr = array( 'sizes' => '100vw' );
						karis_post_card_thumbnail( 'post-thumbnail', 'carousel-item__thumbnail', $custom_attr ); ?>

						<div class="carousel-item__body">
							<?php
							karis_postcard_meta( 'carousel-item__meta' );
							the_title( '<h2 class="carousel-item__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
						</div><!-- .carousel-item__body -->
					</article>
				<?php
				// End the loop.
				endforeach;

				// Restore original Post Data
				wp_reset_postdata(); ?>

			</div><!-- .carousel -->

			<button class="carousel__arrow carousel__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'karis' ); ?>" type="button"><?php echo karis_get_icon_svg( 'chevron_left', 48 ); ?></button>
			<button class="carousel__arrow carousel__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'karis' ); ?>" type="button"><?php echo karis_get_icon_svg( 'chevron_right', 48 ); ?></button>
		</div><!-- .featured -->
	</div><!-- .featured-content-area -->
<?php endif; ?>
