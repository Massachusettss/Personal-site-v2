<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Karis
 */

get_header();
?>

<div id="content-area" class="content-area">
	<main id="primary" class="main-content">

		<section class="error-404 not-found">
			<header class="page__header">
				<h1 class="page__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'karis' ); ?></h1>
			</header><!-- .page__header -->

			<div class="page__content">
				<p><?php esc_html_e( 'The page you were looking for cannot be found, it may have been moved or no longer exists. Perhaps searching can help.', 'karis' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .page__content -->
		</section><!-- .error-404 -->

	</main><!-- #primary -->
</div><!-- #content-area -->

<?php
get_footer();
