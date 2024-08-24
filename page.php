<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Karis
 */

get_header();
?>

<div id="content-area" class="content-area">
	<main id="primary" class="main-content">

		<?php // Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/page/content', 'page' );

			do_action( 'karis_single_page_after' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile; // End of the loop. ?>

	</main><!-- #primary -->
</div><!-- #content-area -->

<?php
get_footer();
