<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Karis
 */

get_header();
?>

<div id="content-area" class="content-area">
	<main id="primary" class="main-content">

		<?php /* Start the Loop */
		while ( have_posts() ) :
			the_post();

			do_action( 'karis_single_post_before' );

			// Include the post content template.
			get_template_part( 'template-parts/post/content-single' );

			/**
			 * Functions hooked in to karis_single_post_after action:
			 *
			 * @hooked karis_author_info     - 10
			 * @hooked karis_content_widgets - 20
			 */
			do_action( 'karis_single_post_after' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile; // End of the loop. ?>

	</main><!-- #primary -->
</div><!-- #content-area -->

<?php
get_footer();
