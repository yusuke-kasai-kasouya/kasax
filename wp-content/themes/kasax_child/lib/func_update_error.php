<?php



/**
 * authorID、筆者IDの変更。
 * 2023-09-09
 *
 * @return void
 */
function kx_authorID( $id = NULL  ){

	$id = empty($id) ? get_the_ID() : $id;

	$post_type = get_post_type($id);

	switch ($post_type) {
		case 'post':
			$authorID = 2;
			break;
		case 'page':
			$authorID = 1;
			break;
		default:
			echo 'ERROR';
			return;
	}


	$_CheckAuthorID = get_post_field( 'post_author' , $id );

	if( $_CheckAuthorID != $authorID )
	{
		//追記。投稿者ID。2023-08-29
		$post[ 'ID' ] = $id;
		$post[ 'post_author' ]  = $authorID;

		wp_update_post( $post ) ;

		$ret  = '<div style="color:red;">';
		$ret .= 'データ置換：authorID：';
		$ret .= $_CheckAuthorID;
		$ret .= '⇒⇒';
		$ret .= $authorID;
		$ret .= '■Title：';
		$ret .= get_the_title( $id );
		$ret .= '■ID：';
		$ret .= $id ;
		$ret .= '</div>';

		unset( $id ,$authorID ,$_CheckAuthorID   );

		return $ret;
	}
}



/**
 * Category Check & Update
 * カテゴリーチェック。
 *
 * @param [type] $arr
 * @return void
 */
function kx_update_cat_check(	$arr ){

	//エラー排除。
	//$kxx	= new kxx;
	//unset( $kxx->kxxError );

	if( empty( $arr[ 'cat' ] ) && empty( $arr[ 'cat_not' ] ) && empty( $arr[ 'type' ] ) )
	{
		$categorys		= get_the_category();
		$category			= end(	$categorys	);
		$cat_base			= $category->cat_ID;
		$cat_base_name	= $category->name;

		if( empty( $arr[ 'search' ] ) )
		{
			$all_check = 1;
		}
		else
		{
			$cat_not  = $cat_base;
		}

		$cat		 = NULL;
		$tag		 = NULL;
		$tag_not = NULL;
	}
	else
	{
		$cat_not			= NULL;
		if( !empty( $arr[ 'cat_not' ] ) )
		{
			$cat_not			= $arr[ 'cat_not' ];
			$cat_not_name	= get_cat_name( $cat_not );
		}


		if( empty( $arr[ 'tag' ] ) )
		{
			$arr[ 'tag' ] = NULL;
		}


		$cat			= NULL;
		if( !empty( $arr[ 'cat' ] ) )
		{
			$cat			= $arr[ 'cat' ];
			$cat_name	= get_cat_name( $cat );
		}


		$tag			= $arr[ 'tag' ];
		$tag_not	= $arr[ 'tag_not' ];
	}


	if( empty( $arr[ 'search' ] ) )
	{

		$search	= get_the_title();

		if( preg_match('/^(∬\d{1,}|κ|Β|γ|σ|δ)≫一覧$/' , $search , $matches ) )
		{
			$search	= $matches[1].'≫';
		}
	}
	else
	{
		$search	= $arr['search'];
	}


	if( !empty( $arr[ 'update' ] ) )
	{

		$t		= 90;

		if( !empty( $arr[ 'ppp' ] ) )
		{
			$ppp	= $arr[ 'ppp' ];
		}
		else
		{
			$ppp	= 3;
		}
	}
	else
	{
		$arr[ 'update' ]= NULL;
		$t		= 90;
		$ppp	= 999;
	}


	if(	empty( $stop_on) )
	{
		if( !empty( $all_check ) )
		{
			$cat_not  = $cat_base;
			$_cat_not1  = $cat_base;

			if( !empty( $arr[ 'tag' ] ) )
			{
				$tag_not  = $arr['tag'];
			}

		}

		//相違カテゴリー出力
		$contents1	= kx_CLASS_kxx(
		[
			't'				=>	$t,
			'cat'			=>	$cat,
			'cat_not'	=>	$cat_not,
			'tag'			=>	$tag,
			'tag_not'	=>	$tag_not,
			'search'	=>	$search,
			'update'	=>	$arr[ 'update' ],
			'ppp'			=>	$ppp,
			'sys'			=>	'new_off',
		] );


		if( !empty( $all_check ) )
		{
			unset( $cat_not , $tag_not );
			$cat  = $cat_base;

			if( !empty( $arr['tag'] ) )
			{
				$tag  = $arr['tag'];
			}
			else
			{
				$tag  = NULL;
			}

			if( empty( $cat_not ) )
			{
				$cat_not = NULL;
			}

			if( empty( $tag_not ) )
			{
				$tag_not = NULL;
			}


			$contents2	= kx_CLASS_kxx(
			[
				't'				=>	$t,
				'cat'			=>	$cat,
				'cat_not'	=>	$cat_not,
				'tag'			=>	$tag,
				'tag_not'	=>	$tag_not,
				'search'	=>	'≫ -'. $cat_base_name ,
				'update'	=>	$arr[ 'update' ],
				'ppp'			=>	$ppp,
				'sys'			=>	'new_off',
			] );

		}
	}
	else
	{
		return '<HR><span class="__xlarge __color_red">▼注意”cat=N/A”</span><HR>';
	}

	$_pattern	= '/post0|自動更新なし/';//error|

	if(
		!empty( $contents1 )
		&& !empty( $contents2 )
		&& preg_match( $_pattern ,	$contents1 , $matches1	)
		&& preg_match( $_pattern ,	$contents2 , $matches2	)
	)
	{
		if( !empty( $matches1[0] ) )
		{
			$m1 = '■1：'.$matches1[0] .'：cat_not：'.$_cat_not1;
		}


		if( !empty( $matches2[0] ) )
		{
			$m2 = '■2：'.$matches2[0] .'■';
		}
	}
	elseif( preg_match( $_pattern ,	$contents1 , $matches1	) && $arr[ 'type' ] == 'tagCheck' )
	{
		$m1 = '■1：'.$matches1[0] .'■';
		$m2 = '■2なし■';
	}
	else
	{
		$m1 = NULL;
		$m2 = NULL;
	}


	$ret  = '';
	$ret2 = '';
	if( !empty( $m1 ) && !empty( $m2 ) )
	{
		//Updateなし


		$ret	 .= '<span class="__color_red ">';


		if(	!empty( $arr[ 'update' ] ) )
		{
			$ret	 .= '<span class="__xlarge">⚠️ update=ON　'.$m1.$m2;//.$m3
		}
		else
		{
			$ret	 .= '<span class="_op_a" style="opacity: 0.33;">■update=OFF　'.$m1.$m2;//.$m3

			$ret2	 .= '<div class="_op_z" style="color:white;index-z:2;background:black;">';
			$ret2	 .= $contents1;
			if( !empty( $contents2 ) )
			{
				$ret2	 .= $contents2;
			}
			$ret2	 .= '</div>';
		}


		$ret	 .= '&nbsp;/cat：'.$cat;
		//$ret	 .= '&nbsp;/cat_not：'.$cat_not;
		$ret	 .= '&nbsp;アップデート無し（stop_on）</span>';
		$ret	 .= $ret2;
		$ret	 .= '</span>';

		$stop_on	= 1;
	}
	elseif(	!empty( $arr[ 'update' ] )	)
	{
		$ret	 = '<HR><span class="__xlarge __color_red">⚠️注意”update=ON”</span>';
		$ret .= $contents1;
		$ret .= $contents2;
		//$ret .= $contents3;
	}
	else
	{
		if( empty( $contents2 ) )
		{
			$contents2 = 'contents2：N/A';
		}


		$ret	 = '<HR><span class="__xlarge __color_red">■&nbsp;update=OFF&nbsp;要・アップデート。check_update=入力すればON。自動リロードは"RELOAD"(基本はこれを入力)。&nbsp;';
		$ret .= $m1.$m2;
		$ret .= '&nbsp;■</span>';
		$ret .= '<HR>';
		$ret .= 'contents-1（カテゴリーの違い）';
		$ret .= $contents1;
		$ret .= 'contents-2';
		$ret .= $contents2;
		$ret .= '<HR>';
		//$ret .= $contents3;
		//$ret .= '<HR>';
	}


	if(	$arr[ 'update' ] == 'RELOAD'	&&	empty( $stop_on ) )
	{
		if( !empty( $arr['reload_link'] ) )
		{
			echo '❗RELOAD_ON❗';
		}
		else
		{
			echo '❗RELOAD_ON_script❗';
			wp_enqueue_script(
				'reload',
				get_stylesheet_directory_uri().'/../kasax_child/js/reload.js',
				array( 'jquery' ),
				'1.0',
				true
			);
		}
	}
	elseif( empty( $stop_on) )
	{
		$str = NULL;
		$str2 = NULL;
		$i = 0;
		foreach( $arr as $key => $value ):

			if( $i == 0 )
			{
				$str .= '?';
			}
			else
			{
				$str .= '&';
			}


			$str 	.= $key . '=' . $value;
			$str2 .= '<div>'. $key . '：' . $value .'</div>';

			$i++;
		endforeach;

		$_get = $str;
		unset( $key , $value , $str );

		if( !empty( $arr['reload_link'] ) )
		{
			$strRELOAD = 'RELOAD-ON❗';

			$link = $_get.'&update=RELOAD';
		}
		else
		{
			$strRELOAD = NULL;
			$link = 'wp-content/themes/kasax_child/lib/php/p_UpdateRELOAD.php'.$_get;
		}


		$ret .= '<div style="margin:0 0 0 30px;">';
		$ret .= '<div>';
		$ret .= '<a href="'. $link .'" target="_blank" style="color:red;">　⇒　置換ページ　.' . $strRELOAD . '</a>';
		$ret .= '</div>';

		$ret .= '<div>';
		$ret .= $str2;
		$ret .= '</div>';

		$ret .= '</div>';
	}

	return $ret;
}



/**
 * Undocumented function
 * 不使用。2024-09-11確認
 *
 * @param [type] $content
 * @param [type] $arr_ver
 * @param [type] $list
 * @param [type] $type
 * @param [type] $t
 * @param [type] $text_add
 * @return void
 */
function kx_update_system(	$content	,	$arr_ver	,	$list=null	,	$type	, $t	, $arr_add = null	){

	if(is_array($arr_add)	)
	{
		extract($arr_add);
	}
	else
	{
		$arr_add	= $text_add;
	}


	if(	preg_match	( '/kxsc_ver_(\d{1,})_(\d{1,})(_\w\d|)/'	, $content , $matches	)	&& is_array(	$arr_ver[$type]	)	):
		//バージョンアップ型

		$ver_old1				= $matches[1];
		$ver_old2				= $matches[2];

		if( !empty( $matches[3] ) ):

			$ver_minor_old	= str_replace('_'	,''	,$matches[3]	);

		endif;

		$ver_new1				= $arr_ver[$type][ 'main' ];

		if(	!empty( $arr_ver[$type][$t] ) ):

			$ver_new2				= $arr_ver[$type][$t];
			$ver_new2_name	= $t;

		else:

			$_etc_type	= 1;

		endif;


		$ver_minor_new	= $arr_ver[$type]['version_minor'];


	elseif(	preg_match	( '/kxsc_ver_(\d{1,})/'	, $content , $matches	)	):

		$ver_old1	= $matches[1];
		$ver_new1	= $arr_ver[$type];

	elseif(is_array(	$arr_ver[$type]	)	):

		$ver_new1				= $arr_ver[$type][ 'main' ];

		if(	!empty( $arr_ver[$type][$t] ) ):

			$ver_new2				= $arr_ver[$type][$t];

		else:

			$_etc_type	= 1;

		endif;

		$ver_new2_name	= $t;
		$ver_minor_new	= $arr_ver[$type]['version_minor'];

	else:

		$ver_new1				= $arr_ver[$type];

	endif;

	if( !empty( $_etc_type ) ):

		$ver_new2				= $arr_ver[$type][ 'etc' ];
		$ver_new2_name	= 'etc ＜ '.$t;
		$t	= 'etc';

	endif;


	//message追記
	if( !empty( $t_add ) ):

		$ver_new2_name	.= ' ＋ '.$t_add;

	endif;

	//■message_ver
	unset( $message_ver );

	$message_ver											.= $ver_new1;

	if( !empty( $ver_new2) ){			$message_ver	.= '_'.$ver_new2;	}
	if( !empty( $ver_minor_new )){	$message_ver	.= '_'.$ver_minor_new;	}
	if( !empty( $ver_new2_name )){	$message_ver	.= '（'.$ver_new2_name.'）';	}

	$message_ver_old		= $matches[0];


	// ■■■ マイナーアップデート・メッセージ ■■■
	if( !empty( $ver_minor_new )	&& $ver_minor_new	!= $ver_minor_old ):

		$message_ver_old	.= '<span class="__blinking" style="font-weight:bold;	color:hsla(0,100%,50%,.5);">■'.$ver_minor_new.'■</span>';

	endif;


	if( !empty( $ver_new2_name ) ){
		$message_ver_old	.= '（'.$ver_new2_name.'）';
	}

	//echo	$ver_new1.'++'.$ver_new2.$ver_minor_new;

	$update_text	= '⟳'.$type.'：';


	if( $ver_old1 < $ver_new1):

		$up	= 1;

		if(	is_numeric($ver_new1) && is_numeric($ver_old1)	):

			$_sa	= $ver_new1 - $ver_old1;

		else:

			$_sa	= '不明1-ID：'.get_the_ID().':NEW-'.$ver_new1 .'　+　OLD'. $ver_old1;

		endif;

		$update_text	.= 'VersionUP：'.$ver_new1.'🔺(+'.$_sa.')';

	elseif( $ver_old2 < $ver_new2):

		$up	= 1;

		if(	is_numeric($ver_new2) && is_numeric($ver_old2)	):

			$_sa	= $ver_new2 - $ver_old2;

		else:

			$_sa	= '不明2';

		endif;

		$update_text	.= 'VersionUP（'.$ver_new2_name.'）：'.$ver_new2.'🔺(+'.$_sa.')';

	elseif( !preg_match(	'/kxsc_list_'.$list.'/'	,	$content ) ):

		$up	= 1;
		$update_text	.= 'リスト更新';

	elseif( empty( $matches ) ):

		$up	= 1;
		$update_text	.= '新設';

	endif;

	if( !empty( $text_add ) ):

		$update_text	.= '：'.$text_add;

	endif;

	$update_text	.= '：'.get_the_title().'<br>';

	if( !empty( $ver_minor_new )	&& $ver_minor_new	!= $ver_minor_old ):

		$up_minor	= $ver_minor_new;

	endif;

	//各表示
	//タイプ表示
	unset($ret);
	$ret .= 'TEMPLATE';
	$ret .= ' - ';
	$ret .= $type;
	$ret .= '：';
	$message_type	= $ret;
	unset($ret);

	//■　update判断用埋め込み　■
	$ret .= '<div class="__color_gray80 __hidden">';
	$ret .= $message_type;
	$ret .= 'kxsc_ver_'.$message_ver;
	$ret .= '<span class="">';
	$ret .= 'kxsc_list_'.$list;
	$ret .= '</span>';
	$ret .= '</div>';

	$message_contents	= $ret;
	unset($ret);


	//■　ショートコード・return表示　■
	if( empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) ):

		$ret .= '<div style="text-align:right;	float:right;">';
		$ret .= '<span class="__color_gray80">';
		$ret .= $message_type;
		$ret .= $message_ver_old;
		$ret .= '</span>';

		//if($up_minor):
			//$ret .= '<span style="color:red;opacity: 0.25;">▲'.$up_minor.'</span>';
		//endif;

		$ret .= '</div>';
		$message_sc	= $ret;

	endif;

	return	array(
		'update'						=>	$up,
		'update_text'				=>	$update_text,
		//'up_minor'					=>	$up_minor,
		'message_contents'	=>	$message_contents,
		'message_sc'				=>	$message_sc,
		//'test'							=>	$message_ver,
	);

}


/**
 * アップデート用メッセージ
 *
 * @param [type] $text
 * @param [type] $count
 * @return void
 */
function kx_updat_message( $text , $count ){

	$ret	 = '';
	$ret .= '<div class="__large __margin_bottom8">';
	$ret .= '🔃' . $count;
	$ret .= '　' . $text;
	$ret .= '</div>';

	$_SESSION['kx_updat_message'][$count]	= $ret;

	$message = '';

	$s	= 0;
	foreach( $_SESSION['kx_updat_message'] as $text ):

		$s++;
		$message .= $text;

	endforeach;

	$ret	 = '';
	$ret .= '<div class="kxsc_update">';
	$ret .= '<div class="__xlarge __margin_bottom8">';
	$ret .= '更新中…';
	$ret .= $s;
	$ret .= '件…………';
	$ret .= '</div>';
	$ret .= $message;
	$ret .= '</div>';

	//テスト中
	//echo '<script>document.getElementById("loader2").innerHTML = "UPDATE!!";</script>';

	return $ret;

}



/**
 * Undocumented function
 *
 * @return void
 */
function kx_update_on(){
	$ret	 = '<div class="__reload_js __reload1 __a_white __text_center">';
	$ret .= '▲<br>Update……';
	$ret .= '</div>';
	return $ret;
}




/**
 * 削除機能
 *
 * @param int $id
 * @param string $type
 * @param string $text	なければタイトルを表示。
 * @return void
 */
function kx_delete(	$id	,	$type = null	,	$text = null){

	//製作中。2020-11-29
	ob_start();
	include  __DIR__ .'/html/h_delete.php';
	$ret .= ob_get_clean();

	return	$ret;

}


/**
 * Undocumented function
 *
 * @return void
 */
function kx_delete_post(){

	//製作中。2020-11-29
	ob_start();
	include  __DIR__ .'/html/h_delete_post.php';
	//$ret .= ob_get_clean();

	return	ob_get_clean();

}



/**
 * 投稿の更新処理を行う関数。
 *
 * セッション変数 `update_c` をカウントし、一定条件下で投稿内容を更新。
 * 更新回数やリクエスト内容に応じて JavaScript を読み込んだり、エラーを表示したりする。
 *
 * @param int         $ok_ng         投稿更新の成否フラグ（1: OK, 0: NG）
 * @param int         $id            更新対象の投稿ID
 * @param string      $_post_content 更新する投稿本文
 * @param int|null    $time          処理時間（秒）。未指定時は1000秒として扱う
 * @param string|null $text          表示メッセージ用のテキスト（任意）
 *
 * @return void
 */
function kx_update_post( $ok_ng	,	$id	,$_post_content	, $time = null , $text = null ){

	if( !empty( $_GET[ 'update_c' ] ) )
	{
		$_SESSION['update_c']++;
	}
	else
	{
		$_SESSION['update_c'] = 1;
	}


	if( empty( $time ))
	{
		$time = 1000;
	}


	if(	$ok_ng	== 1)
	{
		echo	kx_updat_message( $text , $_SESSION[ 'update_c' ] );
	}
	elseif(	$ok_ng	== 2)
		{
			echo '<div id="error-message5" class="__error_fixed_left_bottom__" style="cursor: pointer;" onclick="location.reload()">✦✦RELOAD!!!'.$id.'!✦✦</div>';
		}


	if( !empty( $_GET[ 'update_c' ] ) && $_SESSION[ 'update_c' ] > 4 )
	{
		wp_enqueue_script(
			'reload',
			get_stylesheet_directory_uri().'/../kasax_child/js/reload.js',
			array( 'jquery' ),
			'1.0',
			true
		);
	}
	elseif( !empty( $_GET[ 'action' ] ) && $_GET[ 'action' ]	== 'edit' )
	{
		//編集ページ・スルー
	}
	elseif(	!empty( $ok_ng ) && $time	<	5)	//五秒以内NG
	{
		$ret	 = '<div class="__text_center">';
		$ret .= $time;
		$ret .= '秒差・ストップ🔃';
		$ret .= '</div>';

		kx_CLASS_error( [ 'OUT_echo_fixed' => $ret , 'OUT_echo_top'=> $ret ] );
	}
	elseif(	$ok_ng	== 1 || $ok_ng	== 2 )
	{
		$my_post = array(
			'ID'						=> $id,
			'post_title'		=> get_the_title( $id ),
			'post_content'	=> $_post_content,
		) ;

		//アップデート
		wp_update_post( $my_post ) ;

		//リロード
		if(	$ok_ng	== 1)
		{
			wp_enqueue_script(
				'reload',
				get_stylesheet_directory_uri().'/../kasax_child/js/reload.js',
				array( 'jquery' ),
				'1.0',
				true
				);
		}
	}
}


