<?php
/**
 * Contact Form 7 Compatibility File
 *
 * @link https://wordpress.org/plugins/contact-form-7/
 *
 * @package Karis
 */

/**
 * Contact Form 7 specific scripts & stylesheets.
 *
 * @return void
 */
function karis_contact_form_scripts() {
	wp_enqueue_style( 'karis-contact-form-style', get_template_directory_uri() . '/assets/css/contact-form.css', array( 'karis-style' ) );
}
add_action( 'wp_enqueue_scripts', 'karis_contact_form_scripts' );
