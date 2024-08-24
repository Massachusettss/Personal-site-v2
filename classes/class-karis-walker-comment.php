<?php
/**
 * Custom comment walker for this theme
 *
 * @package Karis
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 */
class Karis_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		?>
		<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
							$comment_author_link = get_comment_author_link( $comment );
							$comment_author_url  = get_comment_author_url( $comment );
							$comment_author      = get_comment_author( $comment );
							$avatar              = get_avatar( $comment, $args['avatar_size'] );
							if ( ! empty( $comment_author_url ) ) {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
							}

							if ( get_option( 'show_avatars' ) && 0 != $args['avatar_size'] ) {
								echo '<span class="comment-author__avatar">' . $avatar . '</span>';

								/*
								 * Using the `check` icon instead of `check_circle`, since we can't add a
								 * fill color to the inner check shape when in circle form.
								 */
								if ( karis_is_comment_by_post_author( $comment ) ) {
									/* translators: %s: SVG Icon */
									printf( '<span class="post-author-badge" aria-hidden="true">%s</span>', karis_get_icon_svg( 'check', 16 ) );
								}
							}

							printf(
								wp_kses(
									/* translators: %s: comment author link */
									__( '%s <span class="screen-reader-text says">says:</span>', 'karis' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								sprintf( '<span class="fn">%s</span>', $comment_author )
							);

							if ( ! empty( $comment_author_url ) ) {
								echo '</a>';
							}
						?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								$comment_timestamp = sprintf( esc_html__( '%1$s at %2$s', 'karis' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
							<time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo esc_attr( $comment_timestamp ); ?>">
								<?php echo esc_attr( $comment_timestamp ); ?>
							</time>
						</a>
						<?php edit_comment_link( esc_html__( 'Edit', 'karis' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'karis' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="comment-reply">',
							'after'     => '</div>',
						)
					)
				); ?>
			</article><!-- .comment-body -->
		<?php
	}
}
