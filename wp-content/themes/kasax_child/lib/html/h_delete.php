<?php
/**
 * 製作中。2020-11-29
 *
 */

	$ret = NULL;

	if( empty( $style_display )):

		$style_display = NULL;

	endif;

	if( empty( $style_color )):

		$style_color = NULL;

	endif;


	if( !empty( $type ) && $type	== 'left'):

		$lr	= '__text_left';

	else:

		$lr	= '__text_right';
		$lr_s	='style="right:0;"';

		if( !empty( $type ) &&	( $type	== 'kx30'	||	$type	== 'kx40' ) ):

			$style_display	= 'display: inline-block;';
			$style_color		= 'color:#fcc;';
			$lr_s	= '';

		endif;

	endif;

	if(	empty( $text ) ):

		$text	= get_the_title( $id );

	endif;

	$ret .= '<div class="'.$lr.'" style="'.$style_display.'">';	//削除

	$ret .= '<div class="question_d2" style="'.$style_display.$style_color.'">';	//QD
	$ret .= '　';
	$ret .= '✘';
	$ret .= '</div>';	//QD

	$ret .= '<div class="answer_d2 __a_white '.$lr.'" '.$lr_s.'>';	//AD

	$ret .= '<a onclick="return confirm(\'要確認\\n\\n『　'.$text.'　』\\n\\n上記を削除します。\\n宜しいですか？\')"';
	$ret .= ' class="delete-post __a_w" href="';
	$ret .= get_delete_post_link($id);
	$ret .= '" tabindex="-1">';


?>

			<span class="__a_w1" style="margin:0 10px;">
				削除<?php echo $id; ?>
			</span>


			<span class="__a_w2" style="margin:0 10px;">
				✖✖記事を削除する✖✖<?php echo $id; ?>
			</span>

		</a>
	</div>
</div>