<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Karis
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">

<?php
/**
 * Functions hooked in to karis_site_before action:
 *
 * @hooked karis_skip_link - 0
 */
do_action( 'karis_site_before' ); ?>

<div id="page" class="site">
	<header id="masthead" class="<?php do_action( 'karis_header_classes' ); ?>">
		<div class="header__wrapper">

			<?php
			/**
			 * Functions hooked into karis_header action:
			 *
			 * @hooked karis_site_branding - 10
			 * @hooked karis_header_menu   - 20
			 */
			do_action( 'karis_header' ); ?>

		</div><!-- .header__wrapper -->
	</header><!-- #masthead -->

	<div id="content" class="content">

		<?php
		/**
		 * Functions hooked into karis_content_top action:
		 *
		 * @hooked karis_featured_content - 10
		 */
		do_action( 'karis_content_top' ); ?>
