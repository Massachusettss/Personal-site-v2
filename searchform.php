<?php
/**
 * Template for displaying search forms.
 *
 * @package Karis
 */

$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>" class="search-form__label">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'karis' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-form__input" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'karis' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
	<button type="submit" class="search-form__button"><?php echo karis_get_icon_svg( 'search', 24 ); ?><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'karis' ); ?></span></button>
	<input type="hidden" name="post_type" value="post" />
</form>
