<?php
//header.phpに記入済み
function kasax_phpcss(){
	$title = get_the_title();
	mb_http_output('UTF-8');
	echo '<style type="text/css">';

	//echo	'body {		background-color: #fff;	}';
//記入場所

//	if (preg_match ('/plot/',$title) ) :
//		echo 'h6 { counter-increment: six; }';
//		echo 'h6:after {content:"(" counter(six)")" ;}';
//	endif;
	echo '</style>';
}
?>