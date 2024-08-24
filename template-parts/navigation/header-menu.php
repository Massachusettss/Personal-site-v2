<?php
/**
 * The template for displaying primary menu.
 *
 * @package Karis
 */

?>

<button id="menu-toggle" class="button--menu-toggle" type="button">
	<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'karis' ); ?></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button><!-- #menu-toggle -->

<nav id="header-menu" class="header__menu" aria-label="<?php esc_attr_e( 'Header Menu', 'karis' ); ?>">
	<?php
	if ( has_nav_menu( 'header-menu' ) ) :
		wp_nav_menu(
			array(
				'theme_location' => 'header-menu',
				'menu_id'        => 'menu-primary',
				'menu_class'     => 'header__menu--primary',
			)
		);
	endif; ?>

	<ul id="menu-secondary" class="header__menu--secondary">
		<?php do_action( 'karis_menu_secondary_search_before' ); ?>

		<li id="menu-item-search" class="menu-item menu-item--search">
			<a href="#" title="<?php esc_html_e( 'Search', 'karis' ); ?>"><?php echo karis_get_icon_svg( 'search', 20 ); ?><span><?php esc_html_e( 'Search', 'karis' ); ?></span></a>
		</li>

		<?php do_action( 'karis_menu_secondary_search_after' ); ?>
	</ul>
</nav><!-- .sidebar__navigation -->
