<?php
/**
 * The template part for displaying search overlay.
 *
 * @package Karis
 */

?>

<!-- Search -->
<div id="search-overlay" class="search-overlay">
	<button type="button" class="button--close" aria-label="<?php esc_attr_e( 'Close', 'karis' ); ?>">
		<?php echo karis_get_icon_svg( 'close', 24 ); ?>
	</button>

	<div class="search-form__wrapper">
		<h6 class="search-form__title"><?php esc_html_e( 'Search', 'karis' ); ?></h6>
		<?php get_template_part( 'searchform' ); ?>
	</div>
</div>
