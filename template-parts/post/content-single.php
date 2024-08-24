<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Karis
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php
		karis_entry_meta();
		the_title( '<h1 class="entry__title">', '</h1>' );
		karis_post_thumbnail(); ?>
	</header><!-- .entry__header -->

	<?php
	karis_excerpt(); ?>

	<div class="entry__content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'karis' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		/**
		 * Functions hooked in to karis_post_content_bottom action:
		 *
		 * @hooked karis_page_links - 10
		 */
		do_action( 'karis_post_content_bottom' ); ?>
	</div><!-- .entry__content -->
	
	<?php
	karis_entry_footer(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
