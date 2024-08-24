<?php
/**
 * The template part for displaying an Author info.
 *
 * @package Karis
 */

?>

<div class="author-info">
	<div class="author-info__wrapper">
		<?php // If avatars enabled, show avatar.
		if ( get_option( 'show_avatars' ) ) : ?>
			<div class="author-info__avatar">
				<?php
				/**
				 * Filter the Karis author info avatar size.
				 *
				 * @param int $size The avatar height and width size in pixels.
				 */
				$author_info_avatar_size = apply_filters( 'karis_author_info_avatar_size', 80 );

				echo get_avatar( get_the_author_meta( 'user_email' ), $author_info_avatar_size ); ?>
			</div><!-- .author-info__avatar -->
		<?php
		endif; ?>

		<div class="author-info__description">
			<h2 class="author-info__title">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php printf( esc_attr__( 'View all posts by %s', 'karis' ), get_the_author() ); ?>" rel="author"><?php echo get_the_author(); ?></a>
			</h2>

			<p class="author-info__bio">
				<?php the_author_meta( 'description' ); ?>
			</p>
		</div><!-- .author-info__description -->
	</div><!-- .author-info__wrapper -->
</div><!-- .author-info -->
