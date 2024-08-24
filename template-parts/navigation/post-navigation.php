<?php
/**
 * The template for displaying post navigation.
 *
 * @package Karis
 */

?>

<?php // Previous post navigation.
$prev_post = get_previous_post();

if ( ! empty( $prev_post ) ) : ?>

	<div class="post-navigation-area">
		<article class="post-card post-card--image<?php if ( has_post_thumbnail( $prev_post ) && ! post_password_required( $prev_post ) ) : ?> post-card--has-thumbnail<?php endif; ?>">
			<?php
			if ( has_post_thumbnail( $prev_post ) && ! post_password_required( $prev_post ) ) : ?>
				<figure class="post-card__thumbnail">
					<a href="<?php the_permalink( $prev_post ); ?>" aria-hidden="true" tabindex="-1">
						<?php echo get_the_post_thumbnail( $prev_post, 'post-thumbnail', array( 'sizes' => '100vw' ) ); ?>
					</a>
				</figure><!-- .post-card__thumbnail -->
			<?php
			endif; ?>

			<div class="post-card__body">
				<div class="post-card__meta"><span><?php echo esc_html__( 'Previous post', 'karis' ); ?></span></div>
				<h3 class="post-card__title"><a href="<?php echo get_permalink( $prev_post ); ?>" rel="bookmark"><?php echo esc_html($prev_post->post_title); ?></a></h3>
			</div>
		</article><!-- .post-card -->
	</div><!-- .post-navigation-arear -->

<?php
endif; ?>
