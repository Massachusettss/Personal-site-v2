<?php
/**
 * The template for displaying social menu.
 *
 * @package Karis
 */

?>

<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'karis' ); ?>">
	<?php wp_nav_menu(
		array(
			'theme_location' => 'social-menu',
			'menu_class'     => 'menu--social',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>' . karis_get_icon_svg( 'link', 20 ),
			'depth'          => 1,
		)
	); ?>
</nav><!-- #social-navigation -->
