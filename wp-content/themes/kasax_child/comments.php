<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kasax
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

			<?php
			$comment_count = get_comments_number();
			if ( 1 === $comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html_e( 'One thought on &ldquo;%1$s&rdquo;', 'kasax' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'kasax' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>


		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				// コメント本文。2024-02-14

				$_comments = get_comments();


				foreach( $_comments as $value ):

					echo '<div>';
					echo '<a href="';
					echo get_edit_comment_link( $value->comment_ID );
					echo '">編集</a>';
					echo '<br>';
					echo kx_change_any_texts(	$value->comment_content	);
					echo '</div>';

				endforeach;


				/*
				wp_list_comments( array(
					'style'      => 'div',
					'short_ping' => true,
				)  );
				*/
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

		<?php // If comments are closed and there are comments, let's leave a little note, shall we? ?>
		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'kasax' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().


	$args = array(
		// タイトルの「コメントを残す」の文字列を変更
		'title_reply'          => get_the_title(),
		'title_reply_to'       => '%s に返信する',
		// 返信を押した後の「コメントをキャンセル」の文字列を変更
		'cancel_reply_link'    => '取り消す',
		// 送信ボタンの「コメントを送信」の文字列を変更
		'label_submit'         => '送信する',

		'id_form'              => '',
		'id_submit'            => '',

		//'comment_field'        =>  '<p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
		'comment_field'        =>  '<p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
		'must_log_in'          => '',
		'logged_in_as'         => '',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'fields'               => apply_filters( 'comment_form_default_fields', array(
			'author' => '',
			'email'  => '',
			'url'    => '',
			)
		),
	);


	comment_form( $args );
	?>

</div><!-- #comments -->
