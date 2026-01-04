<?php

/**
 * add_shortcode
 */


//add_shortcode( 'kx_end_base_format' , 'kxsc_AutoDelete_Shortcode' );プログラミング未処理。2023-08-02
add_shortcode	(	"xx", "kxsc_AutoDelete_Shortcode" );
/**
 * 旧ショートコード自動駆除。
 *
 *
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_AutoDelete_Shortcode( $atts ){
	//機能停止。2023-03-07
	echo '<hr>Error＿＿旧ショートコード：'.__FUNCTION__ . __LINE__ .'＿＿Error_ID'.get_the_ID();

	//自動アップデート。2023-07-02

	wp_reset_postdata();

	$_id = get_the_ID();

	$post		       = get_post( $_id );

	$_arr_pattern =
	[
		0 => '/\[xx\]/',
		1 => '/\[basu.*\]/',
	];

	$_content = $post->post_content;

	foreach( $_arr_pattern as $key => $value ):

		if( preg_match(	$value ,	$_content	, $matches ))
		{
			echo '<hr>ショートコード：機能停止作業-Yes⇒code:'.$matches[0];
		}
		else
		{
			echo '<hr>機能停止作業-NO⇒code:'.$value.'GET_ID'.get_the_ID();
		}

		if( $key == 0)
		{
			$_content = preg_replace( $value	,	'' ,	$_content	);
		}
		else
		{
			$_content = preg_replace( $value	,	'＜旧ショートコード＞'	,	$_content	);
		}
		echo '<hr>';

		wp_update_post(
		[
			'post_title'  	=> $post->post_title,
			'ID'					  => $_id,
			'post_content'  => $_content,
		] );

	endforeach;

	return;
}



add_shortcode('kx_tp','kxsc_template');
/**
 * Undocumented function
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_template( $atts ){
    // ★ここに追加：管理画面（編集画面）なら処理をせずに終了する
    if ( is_admin() ) {
        return '';
    }

	$_arr_sc	=[

		//'world'					=>	'',			//∬world
		'type'					=>	'',			//タイプ

		'cat'						=>	'',			//カテゴリー
		'c'							=>	'',	//kousei3用・キャラ用//主人公番号
		'cs'						=>	'',	//kousei3用		//その他キャラ。"xxx,xxx"
		'c_clone'				=>	'',	//キャラ用。多重キャラ。他と設定を共有設定。
		'text'					=>	'',	//キャラ用
		'check_update'	=>	'',	//基本は0。入力すればON。自動リロードは"RELOAD"
		'check_search'	=>	'',	//基本は0
		'sys'						=>	'',	//システム系。例：k3normal

		't'							=>	'', //タイプ(キャラクター種類)

		//'select0'		  	=>	'',	//works DB 列（カラム）
		'select_top'		=>	'', //(σ|γ|Β|δ)の先頭選択。
		'select_c'		  =>	'',
		'select_date'	  =>	'',	//works DB date用SELECT ＿の後に年代（1～4桁）
		'select1'			  =>	'',	//works DB セレクトジャンル。
		'select2_c'		  =>	'',	//ANDによる複数。
		'select2'			  =>	'',	//works DB セレクト名前。

		'test'					=>	'',	//テストコード。
		'wfm_end'				=>	'',	//終了コード

		'f'							=>	'',	//filter	基本は1。保存型は削除。基本不使用。2022-01-30
	];

	$kxtp = new kxtp;
	return $kxtp->kxtp_Main( shortcode_atts( $_arr_sc , $atts ) );

}


add_shortcode('kx_age','kxsc_age');
/**
 * 年齢確認
 *
 * @return void
 */
function kxsc_age( $atts ){
	extract( shortcode_atts( array(
		'type'		 =>	'full', //個別の場合はsoloで統一。
		'chara'		 =>	'',
		'addition' =>	'',
	), $atts));

	$_title = get_the_title();
	$arr_title = explode( '≫' , $_title );

	$_arr_json = kx_json_arr( get_stylesheet_directory() . "/data/json/chara.json" );
	//一覧リストは、json内にある。2023-10-26


	//$name = $arr[ $arr_title[0] ][ str_replace( 'c' , '' ,  $arr_title[1]  ) ][0];
	//$age_base = $arr[ $arr_title[0] ][ $_num_base ][2];

	//色選択。2024-06-19
	if( preg_match( '/＼c(\d\w{1,}\d)/' , $_title , $matches ))
	{
		$color = 'color:red;';
	}
	elseif( preg_match( '/∬\d{1,}≫c(\d\w{1,}\d)/' , $_title , $matches ))
	{
		$color = 'color:aqua;';
	}

	if( !empty( $matches ))
	{
		//ポストのキャラクターナンバー。
		$_num_base = str_replace( 'c' , '' ,  $arr_title[1] );
	}
	else
	{
		$_num_base = NULL;
	}

	//メインキャラ年齢。2024-06-19

	if( empty( $_arr_json[ $arr_title[0] ][ $matches[1] ][2] ))
	{
		$_arr_json[ $arr_title[0] ][ $matches[1] ][2]  = 0;
	}

	$chara_data_main = $_arr_json[ $arr_title[0] ][ $matches[1] ][2];

	if( $chara_data_main == 'zero')
	{
		$chara_data_main = 0;
	}



	//ポスト時の年齢。2024-06-19
	if( !empty( $arr_title[4] ) && preg_match( '/^(\d{1,}).*＠/' , $arr_title[4] , $matches1 ))
	{
		//＼の時。2024-06-19
		$date = $chara_data_main + $matches1[1];
	}
	elseif( preg_match( '/^(\d{1,}).*＠/' , end( $arr_title ) , $matches1 ))
	{
		$date = $chara_data_main + $matches1[1];
	}
	else
	{
		//return;
		$date = NULL;
		$date = 10;
	}



	//キャラ配列
	if( !empty( $_arr_json[ $arr_title[0] ][ 'set'][ $type ] ))
	{
		$_array_chara = $_arr_json[ $arr_title[0] ][ 'set'][ $type ] ;
		$_type =  $type;
	}
	else
	{
		$_array_chara = [];
	}


	//追記キャラがある場合。2024-06-19
	if( !empty( $chara ) )
	{
		$_arr_add_chara = explode( ',' , $chara );
		$_type =  $type .'+chara';

		$_array_chara = array_merge(  $_array_chara  , $_arr_add_chara );
	}


	if ( !in_array( $_num_base , $_array_chara )) {
		$_array_chara[] = $_num_base;
	}

	foreach( $_array_chara as $_num ):

		if( empty( $_arr_json[ $arr_title[0] ][ $_num ][2] ))
		{
			$_arr_json[ $arr_title[0] ][ $_num ][2] = 0;
		}


		$_arr_out[] =
		[
			0      => $date - $_arr_json[ $arr_title[0] ][ $_num ][2],
			'num'  => $_num,
			'name' => $_arr_json[ $arr_title[0] ][ $_num ][0]
		];
	endforeach;

	//print_r($_arr_out );

	if( empty( $_SESSION[ 'kx_Error_age' ] ))
	{
	function kx_compare( $a, $b ) {
    // 数値に変換して比較
		$_SESSION[ 'kx_Error_age' ] = 1;
    return intval($b[0]) - intval($a[0]);
	}
	}
  usort( $_arr_out, "kx_compare");
	//print_r( $_arr_out );

	$_stype_A = 'margin:0 5px;display:inline-block;width:50px;text-align: right;';
	$_stype_C = 'margin-left:5px;display:inline-block;';

	$ret = '';

	$ret .= '<hr><div style="margin-left:10px;">年齢リスト</div>';

	$ret .= '<div>';
	$ret .= '<div style="' . $_stype_A . '">';
	$ret .= 'Type</div>';

	$ret .= '<div style="display: inline-block;">：';
	$ret .= '</div>';

	$ret .= '<div style="' . $_stype_C . '">';
	$ret .= $_type .'</div>';
	$ret .= '</div>';

	$ret .= '<div>';
	$ret .= '<div style="' . $_stype_A . '">';
	$ret .= (int)$date .'</div>';
	$ret .= '<div style="display: inline-block;">：';
	$ret .= '</div>';
	$ret .= '<div style="' . $_stype_C . '">';
	$ret .= '基準歴</div>';
	$ret .= '</div>';



	foreach( $_arr_out as $_chara_array ):


		if( $_chara_array[ 'num' ] == $_num_base )
		{
			$color_on = $color;

			$chara_ok = 1;
		}
		else
		{
			$color_on = NULL;
		}

		$ret .= '<div style="'.$color_on.'">';

		$ret .= '<div style="' . $_stype_A . '">';
		$ret .= $_chara_array[0];
		$ret .= '</div>';

		$ret .= '<div style="display: inline-block;">：';
		$ret .= '</div>';


		$ret .= '<div style="' . $_stype_C . '">';
		$ret .= $_chara_array[ 'name' ];
		$ret .= '</div>';

		/*
		if( !empty( $_arr_chara_addition[ $_chara_array[ 'num' ] ] ) )
		{
			$ret .=  $date - $_arr_json[ $arr_title[0] ][ $_chara_array[ 'num' ] ][2] + $_arr_chara_addition[ $_chara_array[ 'num' ] ] ;
			$ret .= '&nbsp;,&nbsp;Base:';
		}
		*/

		$ret .= '</div>';

	endforeach;

	//print_r( $_arr2 );

	//natsort( $_arr2 );


	if( empty( $chara_ok ) )
	{
		$ret .= '<div style="margin-left:20px;color:red;">';
		$ret .= $_arr_json[ $arr_title[0] ][ $_num_base ][0];
		$ret .= '（';
		$ret .= $date - $_arr_json[ $arr_title[0] ][ $_num_base ][2];
		$ret .= '）';
		$ret .= '</div>';
	}


	$ret .= '<hr>';


	return $ret;

}



add_shortcode('change_contents','kxsc_change_contents');
/**
 * 置換用。
 * ”たぶん”使っている。2023-08-04
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_change_contents($atts) {
	extract(shortcode_atts(array(

		'type'		=>	'',

	), $atts));

	include __DIR__ .'/change_contents.php';
	return $ret;

}


add_shortcode( 'change_contents_raretu' , 'kxsc_change_contents_raretu' );
/**
 * 置換用。
 * 使っている。2023-08-04
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_change_contents_raretu( $atts ){
	extract( shortcode_atts( array(

		'change'				=>	'',
		'change_all'		=>	'',
		'change_all_on'	=>	'',
		'id'						=>	'',
		'test_on'				=>	'',

	), $atts ));

	$id_arr = explode( ',' , $id );

	$count = count( $id_arr );

	$title0			= get_the_title( end( $id_arr ) );


	if( $change_all_on ):

		$change =  $change_all;

		$title0_end = $title0;

	else:

		$title0_end = end( explode( '≫' , $title0 ) );

	endif;

	$change =  str_replace( '＞' , '≫' , $change );

	$ret  = '';
	$ret .= 'change：'.$change.'<hr>';
	$ret .= 'Title0：'.$title0.'<br>';
	$ret .= 'Title0_end：'.$title0_end.'<br>';
	$ret .= 'toptitle'.get_the_title( end($id_arr) ).'<br>';
	$ret .= $count.'件<hr>';

	$update=0;
	foreach( $id_arr as $id ):

		$title = get_the_title( $id );

		$title_change = preg_replace('/'.$title0_end.'(≫|$)/'	,	$change.'$1' , $title);

		if( preg_match( '/'.$title0.'(≫|$)/'	,	$title )):

			$ret .= '★<br>';

		else:

			$ret .= 'OK<br>';

		endif;

		$ret .= $title.'<br>';
		$ret .= $title_change;
		$ret .= '<hr>';

	endforeach;

	if( $title0_end == $change ):

		return '★★変更なし：'.$title0_end .' == ' .$change.'<hr>' . preg_replace('/★/' , '❗■■置換完了■■❗' ,  $ret );

	endif;

	if($test_on):
		return $ret;
	endif;

	foreach($id_arr as $id):

		$title = get_the_title( $id );
		$title_change = preg_replace('/'.$title0_end.'(≫|$)/'	,	$change.'$1' , $title);

		if( preg_match( '/'.$title0.'(≫|$)/'	,	$title )):
			$update++;

			wp_update_post([

				'ID'						=> $id,
				'post_title'	=> $title_change,

			] );

			if( $update == 2 || $id == end($id_arr)):

				wp_enqueue_script(
					'reload',
					get_stylesheet_directory_uri().'/../kasax_child/js/reload.js',
					array( 'jquery' ),
					'1.0',
					true
				);

				break;

			endif;

		endif;

	endforeach;

	return $ret;

}





add_shortcode('csv_spreadsheets','kxsc_csv_spreadsheets');
/**
 * スプレッドシート関係
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_csv_spreadsheets($atts) {

	extract(shortcode_atts(array(
		'file'			=>	'no_file',	//
		'size'			=>	'100,50,200,50',
		'type'			=>	'',
	), $atts));


	//サイズ
	$size = NULL;
	if( $type == 'works' )
	{
		$size = '40,10,500';
	}


	$_width_all = NULL;
	if( $size )
	{
		$_size_ARR = explode( ',' , $size);

		foreach( $_size_ARR as $_valu ):

			if( !empty( $_width_all ) )
			{
				$_width_all = $_width_all + $_valu;
			}
			else
			{
				$_width_all = $_valu;
			}

		endforeach;

		//微調整。
		$_width_all = $_width_all + 20;
	}

	$ret = NULL;

	$file = 'D:\00_WP\CSV\\'.$file.'.csv';


	if( file_exists( $file ) )
	{
		$handle = fopen( $file, "r" );
	}
	else
	{
		$handle = fopen( 'D:\00_WP\CSV\\no_file.csv' , "r" );
		$ret = kx_CLASS_error(
		[
			'table' => [ 'ERROR'=>['fileネームのミス' ] ] ,
			'type'  => 'file',
		] );
	}


	$ret .= '<table style="width:'. $_width_all .'px;">';
	$ret .= "\n";

	$_iy = 0;
	while ( ( $data = fgetcsv ( $handle, 1000, ",", '"' ) ) !== FALSE ) {

		$ret .= "\t<tr>\n";

			if( $_iy == 0 )
			{
				$_style  =  ' style="background:hsl(0, 100%, 10%);';

				if( !empty( $_ix ) )
				{
					$_style .=  ' width:'. $_size_ARR[ $_ix ] .'px;';
				}

				$_style .=  '"';
			}

			$_ix = 0;
			for ( $i = 0; $i < count( $data ); $i++ ) {

				if( $_ix == 0 && $_iy != 0)
				{
					$_style  =  ' style="background:hsl(180, 100%, 10%);';

					if( !empty( $_size_ARR[ $_ix ] ) ):

						$_style .=  ' width:'. $_size_ARR[ $_ix ] .'px;';

					endif;

					$_style .=  '"';
				}
				elseif( $_iy != 0)
				{
					$_style  =  ' style="';

					if( !empty( $_size_ARR[ $_ix ] ) )
					{
						$_style .=  ' width:'. $_size_ARR[ $_ix ] .'px;';
					}

					$_style .=  '"';
				}

				$ret .= "\t\t<td".$_style.">{$data[$i]}</td>\n";	//".$_size_ARR[ $_ix ]."

				$_ix++;

			} //endfor

			$ret .= "\t</tr>\n";



			$_iy++;
	}

	$ret .= "</table>\n";

	fclose( $handle );

	return $ret;
}



// ジェネレータ関数（逐次処理を実現）
function get_posts_generator($query) {
	if ($query->have_posts()) {
			while ($query->have_posts()) {
					$query->the_post();
					yield get_the_ID(); // 1件ずつ処理
			}
	}
}





add_shortcode('KxErrorLogs','kxsc_ErrorLogs');
/**
 * 記事の一部を隠す。スタート。
 * 2023-08-04
 *
 * @return void
 */
function kxsc_ErrorLogs($atts){

	$ret = '';

	$date = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
	$_today = $date->format('Y-m-d');

	$logFilePath = 'D:/00_WP/xampp/mysql/data/mysql_error.log';

	$logFile = fopen($logFilePath, 'r');
	if (!$logFile)
	{
		die('ファイルを開けません: ' . $logFilePath);
	}

	//$date_pattern = '/.*\[ERROR\]/';//test
	$date_pattern = '/('.$_today.'.*)(\d{2}:\d{2}:\d{2}).*\[ERROR\]/';
	$logLines = [];
	$str = '';
	while (($line = fgets($logFile)) !== false)
	{
		$logLines[] = $line;
		if ( preg_match( $date_pattern, $line, $matches )) {
			$str .= $line . "\n".'<br>';
			$_error_on = $matches[2];
		}
	}



	fclose($logFile); // ファイルを閉じる

	if( empty( $_error_on))
	{
		$ret .= 'SQL ERRER check；'.$_today.'：';
		$ret .= 'エラーなし。';
		$_style = 'color:cyan;';

		echo '&nbsp;&nbsp;<span style='.$_style.'>'.$ret.'</span>';
	}
	else
	{
		wp_enqueue_script(
			'javascript',
			get_stylesheet_directory_uri().'/../kasax_child/js/javascript.js',
			 array( 'jquery' ),
			'1.0',
			true
		);

		$_style = 'color:red;';

		$ret .= '<div class="_op_a">SQL ERRER check：'.$_today.'：エラーあり：'.$_error_on.'</div>';
		$ret .= '<div class="_op_z" style="z_index:10; background:black;">';
		$ret .= preg_replace('/\'[.]\\\wp0\\\.*bd\'/','<span style=color:cyan;>$0</span>',$str) ;
		$ret .= '</div>';

		echo '</div><div style='.$_style.'>'.$ret;
	}
}



/**
 * phpmyadminのログ確認
 *
 * @return void
 */
function kxsc_ErrorLogs_phpmyadmin(){

	// curlでphpMyAdminにアクセスする
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://192.168.1.200:4001/phpmyadmin/index.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "login=あなたのユーザ名&password=あなたのパスワード");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	// HTMLからエラーメッセージを抽出 (例: 正規表現)
	preg_match('/環境保管領域が完全に設定されていないため/', $response, $matches);

	if (count($matches) > 0) {
			echo "エラーが見つかりました: " . $matches[0];
	} else {
			echo "エラーは見つかりませんでした。";
	}

}



/**
 * 記事の一部を隠す用の設定。
 * 2023-08-04
 *
 * @param [type] $arr
 * @return void
 */
function kx_sc_hidden_set( $arr ){

	$ret[ 'text' ] = NULL;

	if(	$arr['memo']	== 'non' )
	{
		//スルー
	}
	elseif(	$arr['memo'] )
	{
		$ret['text']	= $arr['memo'];
	}
	else
	{
		$ret['text']	= '＿';
	}

	return	$ret;
}



add_shortcode('kx_hidden_s','kxsc_hidden_start');
/**
 * 記事の一部を隠す。スタート。
 * 2023-08-04
 *
 * @return void
 */
function kxsc_hidden_start($atts)	{
	extract(shortcode_atts(array(
		't'				=>	'',	//20は逆パターン
		'memo'				=>	'',	//20は逆パターン
	), $atts));

	$arr_set	= kx_sc_hidden_set(	['memo'	=>	$memo]	)	;

	if( $t	== 20 )
	{
		if( !empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
		{
			return '<div class="__hidden"> ';
		}
		else
		{
			//スルー
		}
	}
	elseif( empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
	{
		return $arr_set[	'text'	].'<div class="__hidden"> ';
	}

}




add_shortcode('kx_hidden_e','kxsc_hidden_end');
/**
 * 記事の一部を隠す。END。
 * 2023-08-04
 *
 * @return void
 */
function kxsc_hidden_end( $atts ){
	extract(shortcode_atts(array(
		't'				=>	'',	//二桁のみ。 3x：2構成なし。x1:短編
		'c'				=>	'',	// 番号：メインキャラ。ディフォルトc001
		'cs'			=>	'',	//番号：サブキャラ。
		'wfm_end'	=>	'',	//終了コード
		'memo'		=>	'',	//memo
	), $atts));

	$ret = NULL;
	if( $t == 20 )
	{
		if( !empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
		{
			$ret = '</div>';
		}
	}
	elseif( empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
	{
		$arr_set	= kx_sc_hidden_set(	['memo'	=>	$memo]	)	;
		$ret = '</div>' . $arr_set[	'text'	];
	}

	return $ret;

}



add_shortcode('kasax_phpinfo', 'kxsc_Info_php');
/**
 * post有り。
 * 2023-08-04
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_Info_php($atts) {
	return phpinfo();
}




add_shortcode('zenken','kxsc_Info_zenken');
/**
 * // .【全件リストShortCODE】
 * 2023-08-02現在。使っている。postあり。
 *
 * @param [type] $atts
 * @return string
 */
function kxsc_Info_zenken($atts) {
	$args = array(
		'posts_per_page'	=>	-1,
		'orderby'        		=>	'title',
		'order'       	 	  	=>	'asc',
		'post_type'			=>	'post',	//投稿ページのみ
	);
	$the_query = new WP_Query($args);
	$count_post = $the_query->found_posts;
	$ret	='';
	$ret .='□　全'.$count_post. '件　□'.PHP_EOL;
	if ($the_query->have_posts()) {
		$ret .= '<ol>' . PHP_EOL;
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$ret .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>' . PHP_EOL;
		}
		echo '</ol>' . PHP_EOL;
	}
	else {
	}
	wp_reset_query();
	return $ret;
}



/**
 * Undocumented function
 *
 * @param [type] $atts
 * @return void
 */
add_shortcode( "kxedit" , "kxsc_kx_edit" );
function kxsc_kx_edit( $atts ) {
	$arr =
	[
		'id'						=>	'',
		'id_js'					=>	'',
		'sys'						=>	'',
		'title'					=>	'',
		//'number'				=>	'',
		'new'						=>	'',	//新規追記タイトル名（ある場合）。ない場合は1
		'new_title'			=>	'',
		'new_content'		=>	'',
		'hyouji'				=>	'',
		'hyouji_style'	=>	'',
		'css_hyouji'		=>	'',	//css
		//'css_bg'				=>	'',

		//'t'							=>	'',	//不使用
	];

	return kxEdit( shortcode_atts( $arr , $atts) );

}




/**
 * db系フルメンテナンス。手動。
 * [full_scale_maintenance on=ON4] のように使用
 */
add_shortcode('full_scale_maintenance', 'kxsc_Maintenance_full_scale');
function kxsc_Maintenance_full_scale( $atts ) {
    global $wpdb;
    extract( shortcode_atts( array(
        'on' => '',
    ), $atts ));

    $ret = '<div style="background:#f9f9f9; padding:15px; border:1px solid #ccc; border-radius:5px; color:#333;">';
    $ret .= '<h3 style="margin-top:0;">dbX 重メンテナンス・システム</h3>';

    $modes = [
        'ON0' => 'kx_0（基本キャッシュ）※WP標準から取得',
        'ON1' => 'kx_1（拡張キャッシュ）※kx_0から取得',
        'ON2' => 'kx_shared_title（共有タイトルマップ）※kx_0から取得',
        'ON3' => 'kx_works（作品別管理）※kx_0から取得',
        'ON4' => 'kx_hierarchy（階層構造マッピング）※kx_0から取得'
    ];

    // モード一覧表示
    $ret .= '<ul style="font-size:small; background:#fff; padding:10px; border-left:4px solid #0073aa;">';
    foreach ($modes as $key => $label) {
        $style = ($on === $key) ? 'font-weight:bold; color:red;' : '';
        $ret .= "<li style='{$style}'>{$key} : {$label}</li>";
    }
    $ret .= '</ul>';

    if (!preg_match('/^ON\d$/', $on)) {
        $ret .= '<p style="color:red;">実行キー（on="ONx"）が無効です。</p></div>';
        return $ret;
    }

    // --- ボタンとスクリプトの設置 ---
    // URLに run=1 がない場合はボタンを表示
    if ( !isset($_GET['run']) ) {
        $current_url = add_query_arg('run', '1');
        $ret .= '<p>実行対象：<strong>' . $modes[$on] . '</strong></p>';
        $ret .= '<button type="button" onclick="kx_run_maintenance(\''.$current_url.'\', \''.$modes[$on].'\')"
                 style="background:#0073aa; color:#fff; border:none; padding:10px 20px; border-radius:3px; cursor:pointer; font-weight:bold;">
                 メンテナンスを開始する
                 </button>';

        $ret .= '<script>
        function kx_run_maintenance(url, label) {
            if (confirm(label + " の再構築を開始しますか？\n大量のデータを処理するため、完了まで時間がかかる場合があります。")) {
                document.body.style.cursor = "wait";
                location.href = url;
            }
        }
        </script>';
        $ret .= '</div>';
        return $ret;
    }

    // --- ここから実行処理 (URLに run=1 がある場合) ---
    //$ret .= '<p style="color:#d63638; font-weight:bold;">現在実行中です。ブラウザを閉じないでください...</p>';
    $ret .= '<p style="color:#ffae00; font-weight:bold;">現在実行中です。ブラウザを閉じないでください...</p>';

    $process_list = [];
    if ($on === 'ON0') {
        $args = array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids');
        $ids = get_posts($args);
        foreach ($ids as $id) {
            $process_list[] = ['id' => $id, 'title' => get_the_title($id)];
        }
    } else {
        $table_kx0 = $wpdb->prefix . 'kx_0';
        $results = $wpdb->get_results("SELECT id, title FROM $table_kx0");
        foreach ($results as $row) {
            $process_list[] = ['id' => $row->id, 'title' => $row->title];
        }
    }

		// 処理の直前に追加
		set_time_limit(360); // 実行時間制限を無制限にする
		//ini_set('memory_limit', '1024M'); // 大量データを扱うためメモリも拡張

    $count = 0;
    foreach ($process_list as $item) {
        $db_args = ['id' => $item['id'], 'title' => $item['title']];
        $type = 'id';
        switch ($on) {
            case 'ON0': kx_db0($db_args, $type); break;
            case 'ON1': kx_db1($db_args, $type); break;
            case 'ON2': kx_db_SharedTitle($db_args, $type); break;
            case 'ON3': kx_db_Woks($db_args, $type); break;
            case 'ON4': \Kx\Database\Hierarchy::sync($db_args, $type); break;
        }
        $count++;
    }

    $ret .= '<hr><p style="color:green; font-weight:bold;">完了：' . $count . ' 件のデータを同期しました。</p>';
    $ret .= '<a href="'.remove_query_arg('run').'" style="font-size:small;">← 戻る</a>';
    $ret .= '</div>';

    return $ret;
}



add_shortcode('KxMaintenance','kxsc_Maintenance_plugin');
/**
 * Undocumented function
 *
 * @return void
 */
function kxsc_Maintenance_plugin(){



	$output = '';
	$output .= '<hr>' . kx_db_Maintenance();
  $output .= '<hr>' . do_shortcode('[kxss10_c800_check ss=10_800 update=1]');
  $output .= '<hr>' . kx_check_title_tag_mismatch();
	$output .= '<hr>' . kx_get_Post_error_id();
	$output .= '<hr>' . kx_list_trashed_posts_by_deleted_date();
	$output .= '<hr>' . kx_check_db_integrity_mismatch();
  $output .= '<hr>' .\Kx\Database\Hierarchy::maintenance_full();


	$laravel_test_part = locate_template('templates/components/Laravel_test.php');
    if ( $laravel_test_part ) {
        ob_start();
        include $laravel_test_part;
        $output .=  ob_get_clean();
    } else {
        $output .=  'ERROR：Laravel_test.php';
    }

		return $output;

}



add_shortcode('kasax_index','kxsc_outline');
/**
 * outlineショートコード
 * outline
 *
 * @param [type] $atts
 * @return string
 */
function kxsc_outline($atts) {

	return kx_CLASS_outline(	shortcode_atts( array(
		'id'  => '',
		't'   => '',
		'h'   => '',	//正規表現。例、2-6
		'sys' => '',
	), $atts ) 	);
}





add_shortcode( 'kxss10_c800_check' , 'kxsc_kxss10_c800_check' );
/**
 * プロットコード調整
 * 2024-06-24。不使用済み。
 * 何かに使えるかもしれないので残す。
 * 消す場合は、Set系の要素が残っているので消す。800で検索を推奨。2024-06-24
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_kxss10_c800_check( $atts ){
	$args = shortcode_atts(array(
		'update' =>	'1' ,	    //0がoff。なにか入れればON。2024-06-21
		'ss'		 =>	'10_800',	//★現在は∬10-c800のみ。2024-06-21
	), $atts);

	return '不使用SC：削除予定';

	//$kxrtt = new kxrtt;
	//return $kxrtt->kxrtt_Main( $args );
}



add_shortcode( 'system_cat_tag_check' , 'kxsc_system_cat_tag_check' );
/**
 * とりあえずはタグcheckだけ。
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_system_cat_tag_check( $atts ){
	extract(shortcode_atts(array(
		'update'				=>	'',	//0が基本。なにか入れればON。2024-06-16
	), $atts));
	$args = array(
		'post_type' => array( 'post', 'page' ), // 投稿タイプ。
		'posts_per_page' => -1, // 1ページあたりの記事数を-1に設定して全記事を取得
	);

	$wp_query = new WP_Query( $args );



	if ( $wp_query->have_posts() )
	{
		echo '<p>全記事数：' . $wp_query->found_posts . '件</p>'; // 呼び出された記事数を表示
		echo '<p>タグ検索は、現在、∬10のみ</p>';

		$ret = NULL;

		while ( $wp_query->have_posts() ) :
			// 記事のタイトルや本文などを表示

			$wp_query->the_post();

			$_title    = get_the_title();
			$_id       = get_the_ID();
			$_category = get_the_category( $_id );
			$_tags     = get_the_tags( $_id );

			//除外
			$_pattern= '/^0Index$|^INDEX|^TOP$|^∬(\d{1,})≫(0START|Index|0Index)$/';
			if(	preg_match(  $_pattern , $_title )	)
			{
				$_OK = 1;
			}
			else
			{
				$_OK = NULL;
			}



			//echo $_id;
			//echo '：';
			//the_title();
			//echo '<br>';
			//print_r( get_the_tags() );
			//print_r( $_category);

			//cat検索
			if( !empty( $_category ) ) {
				$_NG_cat = NULL;
			} else {
				$_NG_cat = 'NG';
				//$_NG_cat = NULL;
			}


			//tag検索。
			$_title_array = explode( '≫' , $_title );

			$_NG_tag = 'NG';
			$_NG_charatag = 'NG';
			$str = '';

			preg_match('/(∬10)≫(c\w{1,}\d|)/', $_title , $matches);

			if( is_array( $_tags ) && !empty( $matches[1] ) )
			{
				$_no_match = NULL;
				foreach( $_tags as $tag ):

					if( in_array( $tag->name , $_title_array)) {
						//echo "'{$tag->name}' は配列内に存在します。" . PHP_EOL;
						//echo '<br>';
						$_NG_tag = NULL;
					}else{
						//echo "'{$tag->name}' は配列内に存在しません。" . PHP_EOL;
						//echo '<br>';
						$_no_match = '配列マッチせず。<br>';
					}

					if( !empty( $matches[2] ) && $matches[2] == $tag->name )
					{
						$_NG_charatag = NULL;
						/*
						echo $matches[2];
						echo '：';
						echo $tag->name;
						echo '<br>';
						*/
					}
					elseif( !empty( $matches[2] ) )
					{
						$_no_match = $matches[2].':キャラクタータグマッチせず。<br>';
						//$_NG_charatag = $matches[2];
					}
					else{
						$_NG_charatag = NULL;
					}

				endforeach;
				$str .= $_no_match;

			}elseif( !empty( $matches[1] ) )
			{
				$str .= 'タグが存在せず。<br>';
			}else
			{
				$_NG_tag = NULL;
				$_NG_charatag = NULL;

			}

			if( empty( $_OK ) &&(  !empty( $_NG_cat) || !empty( $_NG_tag) ||!empty( $_NG_charatag ) ) )
			{
				$_update_ids[] = $_id;
				$ret .= $_title;
				$ret .=  '<br>';

				$ret .=  '<p>';
				$ret .= '<a href="';
				$ret .= get_permalink( $_id );
				$ret .=  '>';
				$ret .=  $_id;
				$ret .=  '</a></p>';

				if( !empty( $_NG_cat) )
				{
					$ret .=  '<p>カテゴリーなし。</p>';
				}

				if( !empty( $_NG_tag) || !empty( $_NG_charatag) )
				{
					$ret .=  '<p>';
					$ret .=  $str;
					$ret .=  '</p>';

				}
				$ret .=  '<hr>';
			}

		endwhile;
		wp_reset_postdata();


		if( !empty( $_update_ids ) &&  is_array( $_update_ids ) )
		{
			echo '<p>NG（Update）件数：';
			echo count( $_update_ids);
			echo '</p><hr>';

			if( !empty( $update ) )
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
						echo $_reload;
						echo 'xupdate_on_ID：';
						echo $_id_up;
						echo '<br>';
						$_reload = 0;
						echo '<script type="text/javascript">window.location.reload();</script>';
					}
				endforeach;
			}
			else
			{
				echo '★update_NULL';
			}
		}
		else
		{
			echo '<p>問題なし';
		}
		echo '</p><hr>';
		echo $ret;
	}




}




add_shortcode('google_spreadsheets','kxsc_google_spreadsheets');
/**
 * google スプレッドシート用
 * id
 * name
 * size
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_google_spreadsheets($atts) {
	extract(shortcode_atts(array(
		'id'				=>	'',	//
		'name'			=>	'',
		'size'			=>	'',
	), $atts));

	$arr_name	= explode(',',$name);
	$arr_size	= explode(',',$size);

	$data					= "https://spreadsheets.google.com/feeds/list/".$id."/od6/public/values?alt=json";


	$json 				= file_get_contents( $data );

	//echo $json;

	if( !$json ):

		$_error_title = '<span style=color:red;>ERROR　■■　' . get_the_title() . '　■■</span>';

		echo $_error_title;

		return $_error_title;

	endif;

	$json_decode	= json_decode($json);

	$names = $json_decode->feed->entry;

	$url	= 'https://docs.google.com/spreadsheets/d/'.$id.'/edit#gid=0';

	$ret .= '<div style="margin:0 0 0 10px;padding:0 10px 0 10px;border:1px solid #222;">';
	$ret .= '<div style="text-align:right;color:#555;"><a href='.$url.'>google_spreadsheets</a></div>';

	$ret .= '<div>';// style="border-bottom:solid 1px #fff;"

	$i=0;
	foreach ($arr_name as $gsx):
		$ret .= '<span style="display: inline-block;width:'.$arr_size[$i].'px;border-bottom:solid 1px #fff;">';
		$ret .= $gsx;
		$ret .= '</span>';
		$i++;
	endforeach;

	$ret .= '</div>';

	foreach ($names as $name):

		$i=0;
		foreach ($arr_name as $gsx):

			$ret .= '<span style="display: inline-block;width:'.$arr_size[$i].'px;">';
			$ret .= $name->{'gsx$'.$gsx.''}->{'$t'};
			$ret .= '</span>';
			$i++;

		endforeach;

		$ret .= "<br>";

	endforeach;

	$ret .= '</div><p>';

	return $ret;

}




add_shortcode( 'php_js','kxsc_for_php_js' );
/**
 * jQuery。ショートコード生成。2023-02-26
 *
 * @return void
 */
function kxsc_for_php_js(){
	echo '<textarea rows="20">';

	$js ='jQuery(document).ready(function(){';

	for ($i = 0; $i <= 400; $i++) :
		$js	.='
			jQuery(\'.__js_click_hidden'.$i.'\').on(\'click\',function(){
				jQuery(\'.__absolute_js'.$i.'\').toggleClass(\'__js_hidden1\');
				jQuery(\'.__absolute_js'.$i.'\').toggleClass(\'__js_hidden2\');
			});
		';

		//ob_start();
		//include  __DIR__ .'/jq/jq_php1.js';
		//$js1	.= ob_get_clean();

	endfor;

	for ($i = 1000; $i <= 1400; $i++) :
		$js	.='
			jQuery(\'.__js_click_hidden'.$i.'\').on(\'click\',function(){
				jQuery(\'.__absolute_js'.$i.'\').toggleClass(\'__js_hidden1\');
				jQuery(\'.__absolute_js'.$i.'\').toggleClass(\'__js_hidden2\');
			});
		';
	endfor;

	$js	.= '});';

	echo $js;

	echo '</textarea>';

}



add_shortcode('php_css','kxsc_for_phpcss1');
/**
 *	CSS-自動作成　shortCODE
 *
 * @return void
 */
function kxsc_for_phpcss1($atts){
	extract(shortcode_atts(array(
		't'				=>	'n',//Normal・Dark（小文字）
	), $atts));

	echo '<textarea rows="20">';

	ob_start();
	include __DIR__ .'/add_shortcode_css.php';
	echo ob_get_clean();

	echo	"\n";


	//■TESTコード
	$color3 = 'red';
	$ret = '';

	$ret .= '.hoge2018{color:';
	$ret .= $color3;
	$ret .= '}';
	$ret .= '._hoge2018{color:';
	$ret .= 'blue';
	$ret .= '}';

	echo $ret;

	echo '</textarea>';
}




add_shortcode('kx_format','kxsc_format');
/**
 * クローン作成
 * 現在は、ghost型のみ。
 * 2023-08-04
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_format( $atts ) {
	extract( shortcode_atts( array(
		'id' 			    => '',
	), $atts ) );

	$id_sc	= get_the_ID();

	//Error排除
	if( !$id )
	{
		return kx_CLASS_error( 'Errir-NO-ID' );
	}
	elseif( $id == $id_sc )
	{
		return kx_CLASS_error( 'Errir-自己ID呼び出し' );
	}
	elseif( !get_the_title( $id ) )
	{
		$_get_ID = get_the_ID();

		$_link = '<a href="' . get_permalink( $_get_ID ) . '">＿get_ID:'. $_get_ID .'</a>';

		return kx_CLASS_error( 'NO-post_ERROR_ID:' . $id .$_link );
	}


	//先
	global $post;
	$post	 = get_post( $id );
	setup_postdata( $post );
	$post_status_id = $post->post_status;
	$content_id 		= $post->post_content;
	$time_sa 				= kx_time_modified(	$id 	,	$post	)['sa'];

	//post戻し


	if(	$post_status_id	== 'trash'	)
	{
		//ゴミ箱

		$ret		 = '<div class="__text_center __large __back_0 __color_white">';
		$ret		.= '■☣trash：'.$id.'☢■';
		$ret		.= '</div>';
	}
	elseif( preg_match( '/\[kx_format.*id=(\d{1,}).*?\]/' , $content_id , $matches ) )
	{
		$up_text	= '⟳FX_Format★' . $id . '⇒' . $matches[1] . '時間差'.$time_sa;

		$ret =  kx_CLASS_error( [ 'string' => $up_text ] );

		$new_content = '[kx_format id=' . $matches[1] . ']';

		kx_update_post( 1 ,	$id_sc	, $new_content	, $time_sa	, $up_text );
	}
	elseif(	!empty( $_SESSION[ 'reference_on' ] )	)
	{
		//echo '+';

		$content_id  = preg_replace('/<!--more-->/'	, '<table><tr><td><HR class="__hr_more"></td><td width="6em"><span class="__color_gray __xxsmall">　more　</span></td><td><HR class="__hr_more"></td></tr></table>' ,$content_id )	;
		$ret	= apply_filters( 'the_content', $content_id );
	}
	else
	{
		$content_id= preg_replace('/<!--more-->.*[\s\S]*?$/'	, '' ,$content_id )	;

		$ret	= apply_filters( 'the_content', $content_id );
	}

	//ポスト戻し。2023-08-02
	if( get_the_ID() != $id_sc)
	{
		global $post;
		$post = get_post($id_sc);
		setup_postdata($post);
	}

	return $ret;
}



add_shortcode( 'text_change','kxsc_text_file_change' );
/**
 *
 */
function kxsc_text_file_change( $atts ) {
	// ショートコード属性から id を受け取る
    $atts = shortcode_atts(
        array('file' => 'S0000-Ksy_0000'),
        $atts,
        'text_change'
    );

		$_code= 'File：E:/0/00/Seisaku/';

	if( !empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) 	) //ショートコード下。
	{
		return kx_CLASS_kxx(
		[
			't' 		 => 60 ,
			'id' 		 => get_the_ID() ,
			'text_c' => '⇒ShortCODE_ON：'.$_code.$atts['file'].'.txt',
			'sys'    => 'kxtp',
		] ) ;
	}


    // id を元にファイルパスを組み立て
    $file = 'E:/0/00/Seisaku/' . $atts['file'] . '.txt';

    if (!file_exists($file)) {
        return "<p>ファイルが見つかりません: {$file}</p>";
    }

    // ファイル内容を読み込み
    $content = file_get_contents($file);
    $content = mb_convert_encoding($content, 'UTF-8', 'SJIS-win');

    // ドット階層をMarkdown見出しに変換
    //$content = preg_replace('/^\.\s*/m', '## ', $content);
		$content = preg_replace_callback('/^(\.+)\s*/m', function ($m) {
    $dots = strlen($m[1]);            // ドットの数
    $level = min($dots + 1, 6);       // H2開始（+1）、最大H6まで
    return str_repeat('#', $level) . ' ';
		}, $content);

    // ParsedownでMarkdownをHTMLに変換
    $parsedown = new KxParsedown();
    $parsedown->setBreaksEnabled(true);
    $content = $parsedown->text($content);

    // 任意の追加処理（必要なら）
    $content = kx_session_raretu_Heading_content($content);

    return $_code.'<hr>'.$content;
}




add_shortcode( 'kx_backup_spread' , 'kxsc_backup_spread' );
/**
 * PostBackup。
 * 復旧と削除IDの確認。復元。
 * 2023-11-08
 */
function kxsc_backup_spread( $atts ){
	extract( shortcode_atts( array(
		'on' 			    => '',
	), $atts ) );

	echo '基本的にadd_shortcode上でコメントアウト。2023-08-23';
	echo '<br>';
	echo 'SC：kx_backup_spread：';

	if( $on == 'ON' )
	{
		echo $on;
	}
	else
	{
		echo 'OFF';
	}

	$file_json = 'D:\00_WP\CSV_backup\post_backup.json';
	$json1	= file_get_contents( $file_json );
	$json2	= mb_convert_encoding(  $json1 , 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'  );

	$arr_json = json_decode(  $json2 , true  );

	if( !empty( $arr_json ))
	{
		$_time = time();
		echo '<hr>';
		echo 'post_backup.json：Count：';
		echo count( $arr_json ) ;

		//global $post;		//必要

		foreach( $arr_json as $key => $value ):

			//$_time_post = $_time - $value[ 'time' ];
			//$_time_post = $_time_post / 60 /60 ;
			$key = intval($key);
			if(
				get_post_status( $key ) == 'publish'
				&& !empty( get_the_title( $key ) )
				&& get_post_type($key) != 'nav_menu_item'
				//&& (is_page($key) || is_single($key) )
				//&& $_time_post < 48 //48時間以内に限定。

			)
			{

				//ho ':time_48';
				//echo $value[ 'post_content' ].'<br>';
				//print_r( $value );
				//echo '<hr>';

				if( !empty( $on ) && $on == 'ON' )
				{
					if( get_the_title( $key ) != $value[ 'post_title' ] || get_post( $key )->post_content != $value[ 'post_content' ] )
					{
						echo '<hr>';
						echo $key.'：';
						echo $value[ 'post_title' ].'：';

						$my_post = array(
							'ID'						=> $key,
							'post_title'		=> $value[ 'post_title' ],
							'post_content'	=> $value[ 'post_content' ],
						) ;
						wp_update_post( $my_post ) ;
					}
				}
				else
				{

					$on = 'OFF';
					echo '<hr>';
					echo $key.'：';
					//echo get_post_status( $key );
					//echo '：';
					echo get_the_title( $key );
					//echo '：type：'.get_post_type($key);
					//ho '：Time-';
					//ho $_time_post.'<br>';
				}
			}
			elseif(
				empty( get_post_status( $key ) )
				&& !empty( $value[ 'post_title' ] )
			)
			{
				echo '<hr>';
				echo $key.'：';
				//echo get_post_status( $key );
				//echo '：';
				echo $value[ 'post_title' ].'：<span style=color:red;>新規の可能性あり</span>';
			}
			else
			{
				/*
				echo '<hr>';
				echo $key.'：';
				if ( is_single($key) ) {
					// 現在のページは投稿の個別ページです
					echo 'これは投稿ページです。';
				} elseif ( is_page($key) ) {
						// 現在のページは固定ページです
						echo 'これは固定ページです。';
				} else {
						// 投稿ページでも固定ページでもない場合
						echo '-'.get_post_type($key);
				}
						*/
			}
		endforeach;
	}
	else
	{
		echo 'Backupなし';
	}


	unset( $file_json , $json1 ,$json2 );

	//■削除IDの確認。2023-11-08
	$file_json = 'D:\00_WP\CSV_backup\post_delete.json';
	$json1	= file_get_contents( $file_json );
	$json2	= mb_convert_encoding(  $json1 , 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'  );

	$arr_json = json_decode(  $json2 , true  );

	if( !empty( $arr_json ))
	{
		echo '<hr>';
		echo '<h2>削除Count：';
		echo count( $arr_json ) ;
		echo '</h2>';

		foreach( $arr_json as $key => $value ):
			echo '<hr>';
			echo $key.'：';

			$post	 = get_post( $key );

			if( !$post )
			{
				echo 'ポストなし';
			}
			elseif( $post->post_status 	!= 'trash' )
			{
				echo '<a href="'. get_permalink( $key ) .'">'. $value[ 'post_title' ] .'</a><br>';
			}

			else
			{
				echo '削除済み';
			}
		endforeach;
	}
	else
	{
		echo '削除なし';
	}
}



add_shortcode( 'temporary_sc','shortcode_temporary' );
/**
 * ショートコードテスト・TEST
 *
 * @param [type] $atts
 * @return void
 */
function shortcode_temporary( $atts ) {
	extract( shortcode_atts( array(
			'id'     => '',
			'text'     => '',
	), $atts ) );

	echo 'temporary_sc';
	echo '<br>';

	return;

	$_array_ids = kx_CLASS_kxx(
    [
      'cat'     => 1162,
      'tag'     => "c988+来歴",
      'search'  => 'c988≫来歴≫28',
    ] , 'array_ids' );

	//print_r( $_array_ids[ 'array_ids' ]);

	foreach( $_array_ids[ 'array_ids' ] as $_id ):

		preg_match( '/来歴≫(\d{2})/' , get_the_title( $_id )  , $matches );

		if( $matches[1] != '00')
		{
			$_time = $matches[1] - 3;

			$_new_title = preg_replace( '/来歴≫28/' , '来歴≫25'  , get_the_title( $_id )  );

			echo $matches[1];
			echo '<br>';
			echo $_time;
			echo '<br>';
			echo get_the_title( $_id );
			echo '<br>';
			echo $_new_title;
			echo '<hr>';

			$my_post = array(
				'ID'						=> $_id,
				'post_title'		=> $_new_title,
			) ;

			//アップデート
			//wp_update_post( $my_post ) ;



		}





	endforeach;
}




// ショートコードとして登録
//add_shortcode('kx_table', 'display_table_from_text');
/**
 * 主にLLMからコピーしたテキストに使う。
 * 前後にkx_tableを入れるタイプ。
 * 制作中。まだうまく動かない。
 *
 * 現状、殆どつかていない。2025-04-06
 *
 * @param [type] $atts
 * @param [type] $content
 * @return void
 */
function display_table_from_text($atts, $content = null) {
   // テキストを改行で分割し、行の配列を作成
	 $lines = explode("\n", trim($content)); // 余分な空白を取り除く

	 // テーブルの開始タグ
	 $table = '<table class="__kx-table">';

	 foreach ($lines as $index => $line) {
			 // 各行をパイプ(|)で分割し、セルの配列を作成
			 $cells = explode("|", $line);

			 // 空行や内容が不足している行はスキップ
			 if (count($cells) < 1) continue;

			 // 行の開始タグ
			 $table .= '<tr>';

			 foreach ($cells as $cell) {
					 // セルの内容をトリムし、空でない場合はセルを追加
					 $cell = trim($cell);
					 if ($index === 0) {
							 // 最初の行をヘッダー行として処理
							 //$table .= '<th>' . $cell . '</th>';
					 } else {
							 $table .= '<td>' . $cell . '</td>';
					 }
			 }

			 // 行の終了タグ
			 $table .= '</tr>';
	 }

	 // テーブルの終了タグ
	 $table .= '</table>';

	 return $table; // 安全にHTML出力
}


