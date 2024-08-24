<?php
/**
 * The template for displaying footer copyright.
 *
 * @package Karis
 */

$copyright = sprintf( esc_html__( '©2019. Karis Theme by %1$s', 'karis' ), '<a href="https://themeforest.net/user/v_kulesh">Vladimir Kulesh</a>' );
$copyright_text = get_theme_mod( 'copyright_text', $copyright );
?>

<div class="copyright">
	<?php
	if ( '' !== $copyright_text ) : ?>
		<span class="copyright__text">
			<?php echo wp_kses(
				$copyright_text,
				array(
					'a' => array(
						'href' => array(),
						'title' => array(),
					),
					'br' => array(),
					'i'  => array(),
					'em' => array(),
					'b'  => array(),
					'strong' => array(),
				)
			);
	?></span>
	<?php
	endif;

	if ( function_exists( 'the_privacy_policy_link' ) ) {
		the_privacy_policy_link();
	}

	do_action( 'karis_footer_copyrights' ); ?>
</div><!-- .copyright -->
