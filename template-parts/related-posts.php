<?php
/**
 * Prints HTML for related posts.
 *
 * @package Karis
 */

?>

<?php
global $post;

// Get array of cached results if they exist.
$related_posts = get_transient( 'related_posts_' . $post->ID );

if ( false === $related_posts ) {
	$categories = get_the_category( $post->ID );
	$categories_array = '';

	// Params for our query.
	$args = array(
		'post_type'           => 'post',
		'post__not_in'        => array( $post->ID ),
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'rand'
	);

	if ( $categories ) {
		foreach ( $categories as $category ) {
			$categories_array .= $category->slug . ',';
		}

		$args['category_name'] = $categories_array;
	}

	// The Query.
	$related_posts = new WP_Query( $args );

	// Put the results in a transient.
	set_transient( 'related_posts_' . $post->ID, $related_posts, WEEK_IN_SECONDS );
} ?>

<?php // The loop.
if ( $related_posts->have_posts() ) : ?>

	<section id="related-posts" class="related-posts">
		<header class="related-posts__header">
			<h2 class="related-posts__title"><span><?php esc_html_e( 'You may also like', 'karis' ); ?></span></h2>
		</header><!-- .related-posts__header -->

		<div class="related-posts__list">

			<?php // Start the loop.
			while ( $related_posts->have_posts() ) :
				$related_posts->the_post(); ?>

				<div class="related-posts__item">
					<article class="post-card post-card--large<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
						<?php
						$custom_attr = array( 'sizes' => '(max-width: 479px) calc(100vw - 2rem), (max-width: 767px) calc(100vw - 5rem), (max-width: 1359px) calc((100vw - 5rem - 3rem) / 2), 616px' );
						karis_post_card_thumbnail( 'large', 'post-card__thumbnail', $custom_attr ); ?>

						<div class="post-card__body">
							<?php
							karis_postcard_meta();
							the_title( '<h3 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );

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
				</div><!-- .related-posts__item -->

			<?php // End the loop.
			endwhile; ?>

		</div><!-- .related-posts__list -->
	</section><!-- .related-posts -->

<?php
endif;

// Restore original Post Data
wp_reset_postdata();
