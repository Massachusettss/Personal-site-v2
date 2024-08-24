<?php
/**
 * Register the required plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @version    2.6.1 for parent theme Karis for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'karis_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function karis_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'Karis Theme', 'karis' ),
			'slug'               => 'karis-theme',
			'source'             => get_template_directory() . '/inc/plugins/karis-theme.zip',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),

		array(
			'name'     => esc_html__( 'Developer Share Buttons', 'karis' ),
			'slug'     => 'developer-share-buttons',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'karis' ),
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Contact Form 7', 'karis' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),
	);

	tgmpa( $plugins );
}
