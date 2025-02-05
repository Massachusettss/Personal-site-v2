<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Two-column masonry layout".
 *
 * @package Karis
 */

?>

<?php
do_action( 'karis_loop_before' ); ?>

<div id="loop-masonry" class="loop-container loop-container--masonry loop-container--masonry-v1">
	<div class="grid">
		<?php // Start the Loop.
		while ( have_posts() ) :
			the_post(); ?>

			<div class="grid__item grid__item--js">
				<article class="post-card post-card--large<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
					<?php
					$custom_attr = array( 'sizes' => '(max-width: 479px) calc(100vw - 2rem), (max-width: 767px) calc(100vw - 5rem), (max-width: 1360px) calc((100vw - 8rem) / 2), 616px' );
					karis_post_card_thumbnail( 'post-thumbnail', 'post-card__thumbnail', $custom_attr, false ); ?>

					<div class="post-card__body">
						<?php
						karis_postcard_meta();
						the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

						if ( ! post_password_required() && ! has_post_thumbnail() ) : ?>
							<div class="post-card__content">
								<?php
								$content = get_the_content( '' );
								$content = strip_tags( $content );
								echo mb_substr( $content, 0, 200 ) . '&hellip;'; ?>
							</div>
							<?php
							karis_postcard_footer();
						endif; ?>
					</div>
				</article><!-- .post-card -->
			</div><!-- .grid__item -->

		<?php
		endwhile; ?>
	</div><!-- .grid -->
</div><!-- .loop-container -->

<?php
/**
 * Functions hooked in to karis_loop_after action:
 *
 * @hooked karis_pagination - 10
 */
do_action( 'karis_loop_after' );
