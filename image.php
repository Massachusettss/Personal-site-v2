<?php
/**
 * The template for displaying image attachments.
 *
 * @package Karis
 */

get_header();
?>

<div id="content-area" class="content-area">
	<main id="primary" class="main-content">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry__header">
					<?php
					karis_entry_meta();
					the_title( '<h1 class="entry__title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

				<div class="entry__content entry__content--attachment">
					<figure class="entry__attachment wp-block-image">
						<?php
						/**
						 * Filter the default karis image attachment size.
						 *
						 * @param string $image_size Image size. Default 'post-thumbnail'.
						 */
						$image_size = apply_filters( 'karis_attachment_size', 'post-thumbnail' );

						echo wp_get_attachment_image( get_the_ID(), $image_size );

						if ( has_excerpt() ) : ?>
							<figcaption class="wp-caption-text"><?php the_excerpt(); ?></figcaption>
						<?php
						endif; ?>
					</figure><!-- .entry__attachment -->

					<?php
					the_content();

					/**
					 * Functions hooked in to karis_post_content_bottom action:
					 *
					 * @hooked karis_page_links - 10
					 */
					do_action( 'karis_post_content_bottom' ); ?>
				</div><!-- .entry-content -->

				<footer class="entry__footer">
					<?php
					// Retrieve attachment metadata.
					$metadata = wp_get_attachment_metadata();

					if ( $metadata ) {
						printf( '<div class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s" title="%1$s">%3$s %4$s &times; %5$s</a></div>',
							esc_attr_x( 'Full size', 'Used before full size attachment link.', 'karis' ),
							esc_url( wp_get_attachment_url() ),
							karis_get_icon_svg( 'image', 24 ),
							absint( $metadata['width'] ),
							absint( $metadata['height'] )
						);
					} ?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->

			<div class="post-navigation-area">
				<?php
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'karis' ) . '</span> ' .
						'<span class="screen-reader-text">' . esc_html__( 'Published in:', 'karis' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) ); ?>
			</div><!-- .post-navigation-arear -->

			<?php // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		// End of the loop.
		endwhile; ?>

	</main><!-- #primary -->
</div><!-- #content-area -->

<?php
get_footer();
