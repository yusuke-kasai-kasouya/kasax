<?php




/**
 * サイドバー。分岐・選択
 *
 * @return void
 */
function kx_html_side()
{
	$ret	= '';

	$ret .= '<div class="__side __js_show" style="position:fixed;">';

	//固定ページ判定。2023-02-24
	if( is_page() )
	{
		$ret .= '<p> </p>';
		$ret .= kx_category_search( ['t'	=> 24] );
		$ret .= '<div style="text-align: center;" class="__transform_s17">';
		$ret .= '<p> </p>';
		$ret .= '<hr class="hr_side">';

		//ログイン判定。2023-02-24
		if( is_user_logged_in() ){

			//ログインユーザー情報取得。2023-02-24
			$user = wp_get_current_user();
			$ret .= 'Lv' . $user->get( 'wp_user_level' ) . '　';
			$ret .=  $user->get('user_login'); // 表示用の名前を取得
			$ret .=  '　-　logged in<BR>';

			$ret .= '<a href="' . wp_logout_url() . '">[Logout]</a>';

			$ret .= '<BR><A HREF="wp-admin/about.php">《Setting》</A>';

		}
		else
		{
			$ret .= '<div style="color:red;">Not logged in</div>';
			$ret .= '<a href="' . wp_login_url() . '">[Please log in]</a>';
		}


		$ret .= '<hr class="hr_side">';

		$count_posts = wp_count_posts();
		$posts			 = $count_posts->publish;

		$ret .= $posts . '件';
		$ret .= '<BR>';
		$ret .= kx_post_word_count();
		$ret .= '文字</div>';
	}
	else
	{
		//固定ページ以外

		$ret .= '<div class="_op_a __hover"><a>';

		$ret .= '<span>';
		$ret .= 'Search';
		$ret .= '</span>';

		$ret .= '</a></div>';

		$ret .= '<div class="answer __side">';	//answer

		$ret .= kx_category_search( ['t'	=> 24] );


		$ret .= '<p>&nbsp;</p><div class="__side_search">Title</div>';
		$ret .= get_the_title().'<hr>';

		$ret .= '</div>';	//answer


		$ret .= kx_html_side2();
	}	//①

	$ret .= '<div>';
	$ret .= kx_CLASS_outline(	[	't'	=>	'side'	] );
	$ret .= '</div>';

	$ret .= '</div>';

	return $ret;
}


/**
 * サイドバー。post用。
 *
 * @return void
 */
function kx_html_side2()
{
	$title = get_the_title();
	$id		 = get_the_ID();


	// タイトルを解析してマッチング情報を取得
	$matches = kx_preg_match_pattern('/^∬\d{1,}≫(c(\d)\w{1,}\d).*$/', $title);

	if ($matches)
	{
		if( $matches[2] == 2 )
		{
			$matches[2] = 1;
		}

		$on	=1;
		//$search				= '≫2構成≫リスト';
		//$new_content	= '＿kx_tp type＝chara_pickup＿';
		$tag          = $matches[1]; //インクルード要素。2023-02-25
		$type         = 'chara,c' . $matches[2] . '00' ; //インクルード要素。2023-02-25
	}
	elseif ( $matches = kx_preg_match_pattern('/^∬\d{1,}≫(c\d\w\d{1,}).*(ygs|ksy)(\d{3})$/i', $title)) //preg_match('/^∬\d{1,}≫(c\d\w\d{1,}).*(ygs|ksy)(\d{3})$/i', $title	,	$matches ) )
	{
		if( $matches[2] == 2 )
		{
			$matches[2] = 1;
		}

		$on	=1;

		//$type         = 'k3,c' . $matches[2] . '00' ;
		$type         = 'k3';	//インクルード要素。2023-02-25
		$tag          = $matches[1]; //インクルード要素。2023-02-25
		//$search					= $matches[2].$matches[3].'≫リスト';
		//$new_content		= '＿kx_tp type＝list_k3＿';
	}


	if( !empty( $on )	)
	{
		ob_start();
		include  __DIR__ .'/html/h_side_list.php';

		//return ob_get_clean();
		return ob_get_clean();
	}
}



/**
 * ショートコードprint
 *
 * @param [type] $arr
 * @return void
 */
function kx_shortcode_print( $arr ){

	$ret = NULL;


	if( !empty( $arr['top0'] ))
	{
		$ret .= $arr['top0'];
	}

	if( !empty( $arr['top'] ))
	{
		$ret .= $arr['top'];
	}

	$ret .= '[';

	if( !empty( $arr['name'] ))
	{
		$ret .= $arr['name'];
	}


	foreach( $arr[ 'arr' ] as $_k	=> $_v ):

		if( !empty( $_v ) )
		{
			$ret .= ' ' . $_k . "='" . $_v ."'";
		}

	endforeach;

	$ret .= ']';

	if( !empty( $arr['end'] ))
	{
		$ret .= $arr['end'];
	}

	if( !empty( $arr['end0'] ))
	{
		$ret .= $arr['end0'];
	}

	return	$ret;



}





/**
 * sys要素の処理。
 * 基本は、入力配列を追記出力。2022-01-28
 *
 * @param array $args
 * @param string $type
 * @return array
 */
function kx_shortcode_sys( $args , $type = NULL ){

	if( $type == 'extract' )
	{
		//新規配列。
		$_arr = [ 'N-A' => 1 ];
	}
	else
	{
		//追記型。
		$_arr = $args;
	}


	if( !empty( $args['sys'] ) )
	{
		foreach( explode( ',' , $args[ 'sys' ] )	as $value	):

			//配列追加
			$_arr[	$value	]	= 1;

		endforeach;
	}

	return $_arr;
}


/**
 * 縦３レーンの基本表。
 *
 * @param [type] $arr
 * @return void
 */
function kx_table_create_3lane(	$arr , $style_arr = null	){

	if( empty( $style_arr ))
	{
		$style_arr = [];
	}


	$_style_arr = array_merge(
		[
			'width' => '350px;',
			'margin' => '10px;',
			'background-color' => 'hsla(0	,0%		,0%		,1);',
		],
		$style_arr
	);

	$_style = '';
	foreach( $_style_arr as $_key => $_string ):

		$_style .= $_key. ':' . $_string;

	endforeach;
	unset( $_key , $_string);



	$ret = '';
	$ret .= '<table style="'.$_style.'">';

	foreach( $arr as $_key =>	$_string ):

		$ret .= '<tr">';

		if( !empty( $_string ) )
		{
			if( is_array( $_string) )
			{
				$_string = 'array';
			}

			$ret .= '<td style="text-align:right;border-bottom:1px solid hsla(0,0%,50%,.5);">';
			$ret .= $_key;
			$ret .= '</td>';

			$ret .= '<td style="width:30px;border-bottom:1px solid hsla(0,0%,50%,.5);text-align: center;">';
			$ret .= '：';
			$ret .= '</td>';

			$ret .= '<td style="border-bottom:1px solid hsla(0,0%,50%,.5);">';
			$ret .= $_string;
			$ret .= '</td>';
		}

		$ret .= '</td></tr>';

	endforeach;

	$ret .= '</table>';

	return $ret;
}



/**
 * Undocumented function
 *
 * @param [type] $arr
 * @return void
 */
function kx_table_navi(	$arr	){

	$ret	 = '';

	$ret .= '<div class="__navi_back_l2 __color_normal __text_left">';	//navi

	$ret .= kx_table_create_3lane( $arr );

	$ret .= '</div>';	//navi

	return $ret;

}





/**
 * headerバー
 *
 * @return string
 */
function kx_header_bar(){

	if( !empty( $_GET[ 'action' ] )  &&	$_GET[ 'action' ] == 'edit'	)
	{
		return;
	}
	else
	{
		ob_start();
		include __DIR__ . '/html/header_bar.php';
		return ob_get_clean();
	}
}





/**
 * ブラウザのタブ。ヘッドバー用のtitle。
 *
 * @param [type] $title
 * @param [type] $text
 * @return void
 */
function kx_header_title( $title , $text = null ){

	$max		= 26;
	$max_mb = 20;

	$title = str_replace(['UtilityFunction'],['U.F'],$title);
	$title = preg_replace('/\d{1,}-\d{1,}＠/','',$title);

	if( empty( $text ) )
	{
		$text	= ' ';
	}

	if( strlen( $title  ) < $max )
	{
		return str_replace( '≫' , $text , $title );
	}

	$title_str = str_replace( '≫' , $text , $title ) ;//preg_replace( '/≫.*?・/' , '≫' , $title)

	if( strlen( $title_str) < $max )
	{
		return $title_str;
	}

	//配列化
	$title_arr	= explode( '≫' , $title );
	$title_end	= end( $title_arr );

	$_title0 = $title_arr[0] . $text;


	//topチェック。
	$_title_A = NULL;
	foreach( KxSu::get('title_head') as $key => $value_arr ):

		if( preg_match( $key , $title_arr[0]  )  &&  !empty( $value_arr[ '∬' ] ) )
		{
			//制作ファイル

			preg_match( '/^∬\d{1,}≫(c\d\w{1,}\d)/i' , $title , $matches_A );
			preg_match( '/^∬\d{1,}≫(c\d\w{1,}\d)≫(('	.	KxSu::get('titile_search')[	'work_Platform'	]	.	')\d{1,})/i' , $title , $matches_B );


			if( !empty( $matches_B ) )
			{
				//キャラクターマッチ
				if( empty( $matches_B[1] ) )
				{
					$matches_B[1] = NULL;
				}

				//作品マッチ
				if( empty( $matches_B[2] ) )
				{
					$matches_B[2] = NULL;
				}

				if( strtolower( $matches_B[3] ) == 'sys' )
				{

					$_kxtt = kx_CLASS_kxTitle(
						[
							'type'             => 'work',
							'title'            => $title,
							'character_number' => '',
						] );

					if( !empty( $_kxtt['work_name'] ) )
					{
						$_title2 = $_kxtt['work_name'].'&nbsp';
					}
					else
					{
						$_title2 = $matches_B[2];
					}

					return mb_substr( $_title2 . $title_end , 0 , 22);//$_title0 .
				}
				else
				{
					$_title2 = mb_substr( $matches_B[2] , 0 , 6 ).$text;
					return mb_substr( $matches_B[1] . $text . $_title2 . $title_end , 0 , 20);//$_title0 .
				}
			}
			/*

			elseif( $title_end == '共通w')
			{
				return $title_arr[0].' '.$title_arr[1].' 共通来歴';
			}
				*/

			elseif( !empty( $matches_A[ 1 ] ) )
			{
				$count = count( $title_arr );
				$count_end2 = $count -2 ;
				return mb_substr( $matches_A[ 1 ] .' '. $title_arr[ $count_end2 ] .' '. $title_end , 0 , 20);//$_title0 .
			}
			else
			{
				$count = count( $title_arr );

				$count_end2 = $count -2 ;

				return mb_substr( $title_arr[ $count_end2 ] . $text . $title_end , 0 , 20);//$_title0 .
			}

		}
		elseif( preg_match( $key , $title_arr[0]  ) )
		{
			//制作"外"・ファイル

			for( $i = 1 ; $i < 5; $i++):

				//タイトル配列における、該当の有無。kye0が有るか否か。
				if(
					!empty( $title_arr[ $i ] )
					&& !empty( $value_arr [ $title_arr[ $i ] ] )
					&& !empty( $title_arr[ $value_arr [ $title_arr[ $i ] ][0] ] )
				){
					//表示固定するタイトル順位。
					$num 			 = $value_arr[ $title_arr[ $i ] ][0] ;

					if( $title_end != $title_arr[ $num ] )
					{
						$_title_A .= preg_replace( '/^.*・/' , '*' , $title_arr[ $num ]  ) . $text ;
					}

					unset( $num ) ;

					if( !empty( $value_arr [ $title_arr[ $i ] ]['name'] ) )
					{
						foreach( $value_arr [ $title_arr[ $i ] ]['name']  as $key1 => $value1 ):

							if( $title_arr[ $value1 ] == $key1  )
							{
								$_title_A	.=  $key1 . $text;
							}

						endforeach;
					}
				}

			endfor;

		}

	endforeach;
	unset( $key , $key1 , $value_arr , $value1 );

	$title_str = $_title0 . $_title_A  . $title_end ;

	if( strlen( $title_str  ) < $max )
	{
		return $title_str;
	}
	else
	{
		//echo $title_str;

		$_title_B = NULL;
		foreach( explode( $text , $_title_A ) as $value ):

			if( mb_strlen( $value ) > 4  )
			{
				$_title_B .= mb_substr( $value , 0 , 4) . '*' .$text;
			}
			elseif( !empty( $value ) )
			{
				$_title_B .= $value . $text;
			}

		endforeach;

		//echo $_title_B;

		$title_str = $title_arr[ 0 ] . $text . $_title_B . $title_end;

		//echo $title_str;

		if( mb_strlen( $title_str  ) < $max_mb )
		{
			return $title_str;
		}
		else
		{
			return  mb_substr( $title_str , 0 , $max_mb ).'…';
		}
	}
}



/**
 * SideとTemplateで利用。
 * 2023-09-09
 *
 * @param array $in
 * @return void
 */
function kx_category_search( $args ) {

	if( $args[ 't' ] == 24 )
	{
		$_width	= 240;
		$_css1		= '__side_search';
		$_size		= 16;
	}
	elseif( $args[ 't' ]	== 50 )
	{
		$_width	= 300;
		$_css1		= '__kx_search';
		$_size		= 50;
	}
	else
	{
		$_width	= 300;
		$_css1		= '__kx_search';
		$_size		= 24;
	}


	if( empty( $cat ) )
	{
		$_categorys = get_the_category();
	}


	$ret  = '';

	$ret .= '<div id="search">';

	$ret .= '<form  style="vertical-align:bottom;display:table;" >';
	$ret .= '<input type="search" name="s" placeholder="search" size="'.$_size.'" class="__search">';
	$ret .= '<input type="submit" value="➡" alt="検索" title="検索" class="searchsubmit __search_button"  style="">';

	$ret .= '<div class="'.$_css1.'">Category</div>';

	foreach( $_categorys as $_category ):

		$ret .= '<table style="max-width:'.$_width.'px;"><tbody>';
		$ret .= '<tr><td  width="15">';
		$ret .= '<input type="checkbox" name="cat" value="'.$_category->term_id.'" checked></label>';
		$ret .= '</td><td>';
		$ret .= $_category->name;
		$ret .= '</td><td width="60">';
		$ret .= 'id:'. $_category->cat_ID .'';
		$ret .= '</td><td width="40">';
		$ret .= $_category->category_count;
		$ret .= 'p';
		$ret .= '</td></tr>';

		$ret .='</tbody></table>';

	endforeach;

	$ret .= '<div class="'.$_css1.'">tag</div>';
	$_tags = get_the_tags();

	if ( $_tags )
	{
		$_tr = 0;
		$ret .= '<table style="max-width:270px;"><tbody>';

		foreach ( $_tags as $_tag ):

			if( $_tr == 0)
			{
				$ret .= '<tr><td width="33%">';
			}
			else
			{
				$ret .= '<td  width="33%">';
			}


			$ret .= '<input type="checkbox"  name="tag" value="'.$_tag->name.'">';
			$ret .= $_tag->name;

			if( $_tr != 1 )
			{
				$ret .= '</td>';
				$_tr ++;
			}
			else
			{
				$ret .='</td></tr>';

				if( $_tr == 1 )
				{
					$_tr = 0;
				}
			}

		endforeach;

		$ret .= '</tbody></table>';
		$ret .= '</select>';
	}

	$ret .= '</form>';
	$ret .= '</div>';

	return $ret;
}





/**
 * 編集SYSTEM
 *
 * @param array $args。エディター設定。
 *
 */
function kxEdit( $args ){

	//排除・編集レベルによる。
	if(	empty( kx_current_user()[ 'edit' ] ) )
	{
		return;
	}
	else
	{
		$kxed = new kxed;

		return $kxed->kxed_Main( $args );
	}
}



/**
 * Undocumented function
 * 未使用。2023-09-09
 *
 * @param [type] $title
 * @return void
 */
function kxEdit_small( $title ){

	$ret  = '';
	$ret .= '<form action="wp-content/themes/kasax_child/kx_insert_post.php" method="post">';
	$ret .= '<input type="hidden" name="url" value="'.$_SERVER["REQUEST_URI"].'" style="display:block;">';
	$ret .= '<span  style="display:block;">';
	$ret .= 'TEXT：';
	$ret .= '</span>';
	$ret .= '<input type="text" name="text" value="NEW" style = "width:200px;font-size:small;" style="display:block;">';
	$ret .= '<span  style="display:block;">';
	$ret .= '<input type="submit" value=" 新規E" >';
	$ret .= '</span>';
	$ret .= 'title：';
	$ret .= '<input type="text" name="title" value="' . $title . '" style = "width:300px;font-size:small;display:block;">';
	$ret .= '</form>';
	$ret .= '';

	return $ret;
}


/**
 * Undocumented function
 *
 * @param [type] $title
 * @return void
 */
function kxEdit_light( $title ){

	ob_start();
	include  __DIR__ .'/html/edit_light.php';
	return ob_get_clean();
}





/**
 * ショートコード用。
 * タイトルとタグのミスマッチを検出。
 * 2024-06-27
 *
 * @param [type] $args
 * @return void
 */
function kx_check_title_tag_mismatch(){

	$_save = 1;

	$_category_ids = [ 510,1162 ,1191];

	//$_category_id = 510;//増えた場合はループ化。2024-06-27

	$str2 = '';
	foreach( $_category_ids as $_category_id):
		$args = [
			'cat'								=>	$_category_id,
			'posts_per_page'		=>	-1,
			'post_type'					=>	'post',	//投稿ページのみ
		];

		$the_query = new WP_Query( $args );

		$str = NULL;
		// ■The Loop■
		while ( $the_query->have_posts() ) :

			$the_query->the_post();

			$_title = get_the_title();
			$_id    = get_the_ID();

			preg_match('/∬\d{1,}≫(c\w{1,}\d)/', $_title , $matches);

			$_ok = NULL;
			$_tags = get_the_tags( $_id );

			if( is_array( $_tags ) )
			{
				$_tag_name = NULL;
				foreach( $_tags as $tag):

					if( !empty( $matches[1] ) && $tag->name == $matches[1] )
					{
						$_ok = 'OK';
					}
					elseif( empty( $matches[1] ) )
					{
						echo 'キャラクターではない：';
						echo $_title;
						echo '<hr>';
						//$_ok = 'OK';
						$matches[1] = 'タイトルマッチせず';
					}

					$_tag_name .= $tag->name;
					$_tag_name .= '<br>';

				endforeach;
			}
			else
			{
				$_tag_name .= 'tag_ELSE<br>';
			}

			if( empty( $_ok ))
			{
				$str .= 'NG:';
				$str .= $_id;
				$str .= '<br>';
				$str .= $_title;
				$str .= '<br>matches:';
				$str .= $matches[1];
				$str .= '<br>';

				$str .=  $_tag_name;

				$str .= '<a href="';
				$str .= get_permalink( $_id );
				$str .=  '">LInk</a>';
				$str .= '<hr>';

				$_update_ids[] =  $_id;
			}

		endwhile;

		if( !empty( $str ))
		{
			$str2 = 'CATチェック、問題あり:'.$_category_A->name . '≫c'.'<br>';
			$str2 .= '<div style="color:red;">';
			$str2 .= count( $_update_ids );
			$str2 .= '件</div><hr>';
			$str2 .= $str;

			echo '<div style="color:red;">';
			echo count( $_update_ids );
			echo '件</div><hr>';



			if( !empty( $_save ) )
			{
				$_reload = 0;
				foreach( $_update_ids as $_id_up):
					//テンプレートmenuからのアップデート用。2023-08-04
					$post = get_post( $_id_up );

					$my_post = array(
						'ID'						=> $_id_up ,
						'post_title'		=> get_the_title( $_id_up ),
						'post_content'	=> $post->post_content,
					) ;
					wp_update_post( $my_post ) ;
					$_reload++;

					if( $_reload == 8 )
					{
						echo 'ID：';
						echo $_id_up;
						echo '<br>';
						echo $_reload;
						$_reload = 0;
						echo '<script type="text/javascript">window.location.reload();</script>';
					}
				endforeach;
			}
		}
		else
		{
			$_category = get_category( $_category_id );
			if ( $_category) {
				$_category_name = $_category->name; // カテゴリー名を出力
			}
			$str2 .= 'CATチェック、問題なし:'. $_category_name.'<br>';
		}
		//以上・
	endforeach;

	return $str2;
}





/**
 * 色分け
 *
 * @param [type] $_n
 * @param [type] $_s
 * @param [type] $_m
 * @param [type] $_u
 * @param [type] $_sd_ue_px
 * @param [type] $_sd_sita_px
 * @param [type] $bg_main
 * @return string
 */
function kx_css_irowake( $_n, $_s, $_m, $_u, $_sd_ue_px, $_sd_sita_px, $bg_main ){
	$ret = '';

	$_hsla	 = $_n . ',' . $_s . '%,' . $_m . '%,';

	$ret		.= '.__bg_' . $_s . '_' . $_m . '_' . $_n . '{background-color:hsla(' . $_hsla . '1);}';
	$ret		.= '.__bg_' . $_s . '_' . $_m . '_' . $_n . 'u{background-color:hsla(' . $_hsla . $_u . ');}';

	$_sd_kakushi	= 'box-shadow:2px 0px 0px ' . $bg_main . ',-2px 0px 0px ' . $bg_main . ',';
	$_sd_ue				= '0px ' . $_sd_ue_px . ' 1px hsla(' . $_hsla . $_u . ');';
	$_sd_sita			= '0px ' . $_sd_sita_px . ' 1px hsla(' . $_hsla . $_u . ');';

	$ret		.= '.__box_shadow_ue_'		. $_s . '_' . $_m . '_' . $_n . '{' . $_sd_kakushi . $_sd_ue . '}';
	$ret		.= '.__box_shadow_sita_'	. $_s . '_' . $_m . '_' . $_n . '{' . $_sd_kakushi . $_sd_sita . '}';

	return $ret;
}


/**
 * ログインユーザーチェック。
 *
 * @return void
 */
function kx_current_user(){

	if( is_user_logged_in() )
	{
		$user = wp_get_current_user();

		$level				= $user->get('wp_user_level');
		$login_name		= $user->get('user_login');

		$login				= 'ligin';
	}
	else
	{
		$level				= 'Not logged in';
		$login_name		= 'Not logged in';
		$login				= 'Not logged in';
	}

	$edit	= NULL;
	if(  is_numeric( $level ) && $level > 6 )
	{
		$edit	= 1;
	}

	return array(
		'edit'				=>	$edit,
		'level'				=>	$level,
		'login'				=>	$login,
		'login_name'	=>	$login_name,

	);
}




/**
 * kxx用表示系jquery。include。
 * idがinclude先で必要。
 *
 * @param int $id
 * @param string $type	includeのタイプ。
 * @return string
 */
function kx_kxx_jq_main( $_id , $type ) {

	if( $type == 'main' )
	{
		include 'D:\00_WP/xampp/htdocs/0/wp-content/themes/kasax_child/lib/jq/jq_kxx_main.php';
	}
	elseif( $type == 'yomikomi2')
	{
		include 'D:\00_WP/xampp/htdocs/0/wp-content/themes/kasax_child/lib/jq/jq_kxx_yomikomi2.php';
	}

}






/**
 * 文字カウント
 *
 * @return string
 */
function kx_post_word_count() {
	global $wpdb;
	$query = "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish'";
	$words = $wpdb->get_results($query);
	$totalcount=0;

	if( $words )
	{
		foreach ($words as $word)
		{
			$post = strip_tags($word->post_content);
			$count = mb_strlen($post);
			//$totalcount = $count + $oldcount;
			//$oldcount = $totalcount;
			$totalcount = $count + $totalcount;
		}
	}
	else
	{
		$totalcount=0;
	}
	return number_format($totalcount);
}




/**
 * クリップボードにIDをコピー。
 * 2021-08-06
 *
 * @param int $id
 * @param string $type   link or それ以外。
 * @return void
 */
function kx_script_id_clipboard( $id , $type = null ){

	$class = '__js_copy_clipboard';

	$ret = NULL;
	$ret .= '<span class=" __small">';

	if( $type == 'link' )
	{
		$ret .= '<span class="__hidden">'.$id.'</span>';
		$ret .= '<a style="height:20px;padding:3px 10px 5px 10px;" class="' . $class . '">ID：'.$id.'</a>';
	}
	else
	{
		$ret .= '<button class="__btn0" tabindex="-1"></button>';//ダミー。これを入れておかないと機能がおかしくなる。2024-09-08

		//IDのコピー。2023-02-28
		$ret .= '<span class="__hidden">'.$id.'</span>';
		$ret .= '<button style="height:20px;padding:3px 10px 5px 10px;" class="' . $class . ' __btn0" tabindex="-1">ID：'.$id.'</button>';

		//formatショートコードのコピー。2023-02-28
		$ret .= '<span class="__hidden">[kx_format id='.$id.' m='. get_the_title( $id ) .']</span>';
		$ret .= '<button style="height:20px;padding:3px 10px 5px 10px;" class="' . $class . ' __btn0" tabindex="-1">FOM</button>';

		//kxショートコードのコピー。<p>とt=61 に変更。2024-08-07
		$ret .= '<span class="__hidden">[kx t=61 id='.$id.' m='. get_the_title( $id ) .']</span>';
		$ret .= '<button style="height:20px;padding:3px 10px 5px 10px;" class="' . $class . ' __btn0" tabindex="-1">T61</button>';

		//kxショートコードのコピー。<p>とt=65 に変更。2023-03-30
		$ret .= '<span class="__hidden"><p>[kx t=65 id='.$id.' m='. get_the_title( $id ) .']</p></span>';
		$ret .= '<button style="height:20px;padding:3px 10px 5px 10px;" class="' . $class . ' __btn0" tabindex="-1">T65</button>';
	}

	$ret .= '</span>';


	return $ret;
}




/**
 * アラビア数字をローマ数字に変換します。
 *
 * @param int $num 変換するアラビア数字（正の整数）。
 * @return string 対応するローマ数字。入力が正の整数でない場合は空文字列を返します。
 */
function kx_intToRoman($num) {
	$map = [
			1000 => 'M',
			900 => 'CM',
			500 => 'D',
			400 => 'CD',
			100 => 'C',
			90 => 'XC',
			50 => 'L',
			40 => 'XL',
			10 => 'X',
			9 => 'IX',
			5 => 'V',
			4 => 'IV',
			1 => 'I'
	];

	$result = '';
	foreach ($map as $value => $roman) {
			while ($num >= $value) {
					$result .= $roman;
					$num -= $value;
			}
	}

	return $result;
}
