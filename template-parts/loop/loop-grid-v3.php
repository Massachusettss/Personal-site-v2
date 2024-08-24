<?php
/**
 * Template part for displaying loop layout.
 * Type of layout: "Three-column grid layout".
 *
 * @package Karis
 */

?>

<?php
do_action( 'karis_loop_before' ); ?>

<div id="loop-grid" class="loop-container loop-container--grid loop-container--grid-v3">
	<div class="grid">
		<?php // Start the Loop.
		while ( have_posts() ) :
			the_post(); ?>

			<div class="grid__item">
				<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
					<?php
					$custom_attr = array( 'sizes' => '(max-width: 479px) calc(100vw - 2rem), (max-width: 767px) calc(100vw - 5rem), (max-width: 1279px) calc((100vw - 8rem) / 2), (max-width: 1360px) calc((100vw - 11rem) / 3), 395px' );
					karis_post_card_thumbnail( 'post-thumbnail', 'post-card__thumbnail', $custom_attr ); ?>

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
