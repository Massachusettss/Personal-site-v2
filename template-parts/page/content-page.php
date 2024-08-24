<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Karis
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry__header">
		<?php
		if ( get_edit_post_link() ) : ?>
			<div class="entry__meta">
				<?php karis_edit_link(); ?>
			</div><!-- .entry__meta -->
		<?php
		endif;

		the_title( '<h1 class="entry__title">', '</h1>' );
		karis_post_thumbnail(); ?>
	</header><!-- .entry__header -->

	<div class="entry__content">
		<?php
		the_content();

		/**
		 * Functions hooked in to karis_page_content_bottom action:
		 *
		 * @hooked karis_page_links - 10
		 */
		do_action( 'karis_page_content_bottom' ); ?>
	</div><!-- .entry__content -->

	<?php karis_entry_footer(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
