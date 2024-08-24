<?php
/**
 * The template for displaying widgets in the footer.
 *
 * @package Karis
 */

if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_customize_preview() ) {
	return;
}
?>

<?php
if ( is_active_sidebar( 'footer-1' ) ) : ?>
	<div class="widget-area">
		<?php dynamic_sidebar( 'footer-1' ); ?>
	</div><!-- .widget-area -->
<?php
endif;

if ( is_active_sidebar( 'footer-2' ) ) : ?>
	<div class="widget-area">
		<?php dynamic_sidebar( 'footer-2' ); ?>
	</div><!-- .widget-area -->
<?php
endif;

if ( is_active_sidebar( 'footer-3' ) ) : ?>
	<div class="widget-area">
		<?php dynamic_sidebar( 'footer-3' ); ?>
	</div><!-- .widget-area -->
<?php
endif;
