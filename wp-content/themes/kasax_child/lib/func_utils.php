<?php

/**
* 学年関係
*
* @param [type] $text
* @param [type] $hani_min 学年下限
* @param [type] $hani_max 学年上限
* @return void
*/
function kx_gakunen( $text	, $hani_min = null	, $hani_max = null ){

	//何故か必要。2023-08-01。
	if( empty( $text ))
	{
		return;
	}

	if(	$hani_max	== 'off' || $hani_min	== 'off' )
	{
		return 	preg_replace('/^(\w{1,}).*/'	,'$1',	$text);
	}

	//echo $hani_min;

	if( preg_match( '/(\d{1,}),(\d{1,})/' ,$hani_min  , $matches ) )
	{
		$hani_min	= $matches[1];
		$hani_max	= $matches[2];
	}

	//TEST
	//$hani_min=6;
	//$hani_max=18;

	$hani_min	= (string)$hani_min;
	$hani_max	= (string)$hani_max;

	//echo $hani_min;


	//echo 'on';
	//off時の処理。
	if( !ctype_digit( $hani_min ))
	{
		$hani_min = 5;
	}
	elseif( empty( $hani_min ) )
	{
		$hani_min = 5;
	}




	if( !ctype_digit( $hani_max ) )
	{
		$hani_max = 22;
	}
	elseif( empty( $hani_max ) )
	{
		$hani_max = 22;
	}

	//echo $hani_min.'-'.$hani_max.'<br>';

	$s0	= $hani_min;
	//$s1	= $s0	+	1;

	/*
	$arr = [
		'年長'	=> 6,
		'小1'		=> 7,
		'小2'		=> 8,
		'小3'		=> 9,
		'小4'		=> 10,
		'小5'		=> 11,
		'小6'		=> 12,
		'中1'		=> 13,
		'中2'		=> 14,
		'中3'		=> 15,
		'高1'		=> 16,
		'高2'		=> 17,
		'高3'		=> 18,
		'大1'		=> 19,
		'大2'		=> 20,
		'大3'		=> 21,
		'大4'		=> 22,
	];
	*/

	$arr = [
		5 => '年中',
		6 => '年長',
		7 => '小1',
		8 => '小2',
		9 => '小3',
		10 => '小4',
		11 => '小5',
		12 => '小6',
		13 => '中1',
		14 => '中2',
		15 => '中3',
		16 => '高1',
		17 => '高2',
		18 => '高3',
		19 => '大1',
		20 => '大2',
		21 => '大3',
		22 => '大4',
	];


	/*
	echo $text;
	echo '-';
	echo $hani_min;
	echo '-';
	echo $hani_max;
	echo '<br>';
	*/


	for( $i = $hani_min;	$i <= $hani_max; $i++ ):

		$arr2[ $i] = $arr[ $i ];

	endfor;

	if( preg_match( '/((-|)\w{1,})(-\w{1,2}|)/', $text , $matches ) )
	{

		if( !empty( $matches[3] ) && preg_match( '/0[1-3]/' , $matches[3]) )
		{
			$text = (int)$text;
			$_num = $text - 1;
		}
		else
		{
			$_num = (int)$text;
		}

		if( !empty( $arr2[ $_num ] ))
		{
			$ret = $arr2[ $_num ].'（'. $matches[1] .'）';
		}
		else
		{
			$ret = $matches[1];
		}
	}
	else
	{
		$ret = $matches[1];
		echo $text;
	}

	return $ret;
}



/**
 * categoryID呼び出し
 *
 * @param [type] $id
 * @return void
 */
function kx_get_category(	$id = null) {

	$categorys    = get_the_category( $id );

	$cat_top = NULL;
	$cat_end = NULL;
	if( !empty( $categorys ) )
	{
		$category_top = $categorys[0];
		$category_end = end(	$categorys	);
		$cat_top	    = $category_top->cat_ID;
		$cat_end      = $category_end->cat_ID;
	}

	return[
		'cat_top'	=>	$cat_top,
		'cat_end'	=>	$cat_end
	];
}



/**
 * 存在してはいけないpostを検索。
 * plug-in用。
 * 2023-08-30
 *
 * @return void
 */
function kx_get_Post_error_id() {

	//管理画面のpost削除用。2023-09-02
	//消さない。2023-09-02
	/*
	$the_query = new WP_Query(
		[
			's'              => '＿＿OLD＿＿', //検索文字列。2023-09-25
			'post_type'      => 'post',
			'posts_per_page' => -1,
		]
	);

	$i = 0;
	// The Loop
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		$_id = get_the_ID();

		if( $_id > 60000)
		{
			$_title = get_the_title( $_id );

			echo $_title;
			echo '<br>';
			wp_delete_post( $_id );
		}
	endwhile;

	//ここまで削除。2023-09-25
	*/


	$the_query = new WP_Query(
	[
		'post_type'      => 'post',
		'posts_per_page' => -1,
	]	);


	if( empty( $the_query->found_posts ) )
	{
		//Error。
		return;
	}

	$i = 0;
	$str = '';
	// The Loop
	while ( $the_query->have_posts() ) :

		$the_query->the_post();
		$_id = get_the_ID();
		$_title = get_the_title( $_id );

		if( !preg_match( '/≫/' , $_title  ) && empty(KxSu::get('titile_name')[ $_title ] ) )
		{
			$_array[] = $_id;
			$str .= $_id;

			$str .= '<div>';
			$str .= '<a href="'. get_permalink( $_id ) .'">'.get_the_title( $_id ).'</a>';

			$str .= '</a>';
			$str .= '</div>';
		}

		$_title_array = explode('≫',$_title);

		if( empty(KxSu::get('titile_name')[ $_title_array[0] ] ) )
		{
			$_array[] = $_id;
			$str .= $_id;

			$str .= '<div>タイトル表記のエラー：';
			$str .= '<a href="'. get_permalink( $_id ) .'">'.get_the_title( $_id ).'</a>';

			$str .= '</a>';
			$str .= '</div>';

		}


		//書き換え用。
		if(
			get_post_type( $_id ) == 'post'
			&& get_post_field( 'post_author' , $_id ) != 2
		)
		{
			$i++;

			if( $i == 30 )
			{
				$str .= '
					<script>
					window.location.reload();
					</script>
				';

				break;
			}
			$str .= kx_authorID( $_id  );
		}


	endwhile;

	if( !empty($_array  ) )
	{
		$str .= 'エラーpost数：';
		$str .= count( $_array );
		wp_reset_postdata();
	}
	else
	{
		$str .= 'エラーpost';
		$str .= 'なし';
	}

	return $str;
}



/**
 * arr_IDを取得。
 *
 *
 * @param array $args
 * @param array $type idの配列。2023-03-11
 * @return void
 */
function kx_get_Post_IDs(	$args ){

	$ret = NULL;

	if( !empty( $args['s'] ) || !empty( $args['category__not_in'] ) || !empty( $args['tag__not_in'] ) )
	{
		// The Query
		$the_query = new WP_Query( $args );

		if( empty( $the_query->found_posts ) )
		{
			//Error。
			return;
		}

		// The Loop
		while ( $the_query->have_posts() ) :

			$the_query->the_post();
			$ret[] = get_the_ID();

		endwhile;

		wp_reset_postdata();
	}
	else
	{
		global $post;

		$my_posts = get_posts( $args );

		foreach( $my_posts as $post) :

			$ret[] = get_the_ID( $post->ID );

		endforeach;
	}

	return $ret;
}




/**
 * 新型judge。2025-04-28
 * 条件に基づいて配列を更新する関数
 *
 * この関数は `$setting` 配列のキー（正規表現）と `$subject` を照合し、
 * マッチした場合に対応する値を `$args` 配列に追加または上書きします。
 * `$args` が指定されない場合はデフォルトで空の配列が利用されます。
 *
 * @param array $setting 判定条件の配列（キーは正規表現文字列、値は連想配列）
 * @param string $subject 判定対象となる文字列
 * @param array|null $args 更新される基底の配列（省略可能）
 * @return array `$args` に `$setting` の条件を基に追加された結果の配列
 */
function kx_Judge(array $setting, string $subject, ?array $args = null): array {
	// 初期値の設定
	$args = $args ?? [];

	// 設定配列の判定と処理
	foreach ($setting as $pattern => $values)
	{
			if (preg_match($pattern, $subject))
			{
					foreach ($values as $key => $value)
					{
							$args[$key] = $value;
					}
			}
	}

	return $args;
}






/**
 * 各設定の選別。2023/02/28
 * 引数 $args、$type、$subjectを受け取り、設定を選別。2023-02-28
 *
 * @param array $args 各設定
 * @param string $type 正規表現（preg）または01値。どのように比較するかを決定
 * @param string $subject。判定要素。"t"やタイトルなど。比較する対象。
 * @return array 	'on''settings'で配列を出力。2023-03-01
 */
function kx_Judge_OLD( $args , $type , $subject ){

	$_on				= NULL;
	$_settings	= [ 'not_applicable' => NULL ];


	if( !empty( $args[ 'array' ] ) && is_array( $args[ 'array' ] ) )
	{
		//arrayキーあり。配列型。2023-03-01

		foreach( $args[ 'array' ] as $_key0 => $_arr ):

			if( $type == 'preg' )
			{
				//正規表現に一致するかどうかを確認。2023-02-28
				//echo '+'.$subject.'+'.$args[ 'array' ][ $_key0 ][ 'preg' ];
				if( preg_match( $args[ 'array' ][ $_key0 ][ 'preg' ] , $subject ) )
				{
					$_on = 1;
				}
			}
			elseif( $type == '01' )
			{
				//単純な等価性チェックを実行。2023-02-28
				if( $args[ 'array' ][ $_key0 ][ '01' ] == $subject )
				{
					$_on = 1;
				}
			}
			else
			{
				$_error = 1;
			}

			if( $_on == 1 )
			{
				if( !empty( $_arr[ 'settings' ] )  && is_array( $_arr[ 'settings' ] ) )
				{
					foreach( $_arr[ 'settings' ] as $_key1 => $_value ):

						$_settings[ $_key1 ] = $_value;

					endforeach;
				}
				else
				{
					$_settings = $_arr[ 'settings' ];
				}
			}

			$_on = NULL;

		endforeach;
	}
	else
	{
		//シングル型。主にオンオフ出力。
		if( $type == 'preg')
		{
			if( preg_match( $args[ $type ] , $subject ) )
			{
				$_on	= 1;

				if( !empty( $args[ 'settings' ] ) )
				{
					$_settings = $args[ 'settings' ];
				}

			}
		}
		else
		{
			$_error = 1;
		}
	}


	if( !empty( $_error ) )
	{
		echo 'kx_Judge-error:line-'.__line__;
	}


	return [
		'on' 				=> $_on ,
		'settings'	=> $_settings ,
	];
}


/**
 * URL判定
 *
 * @return void
 */
function kx_Judge_URL(){

	$_url = $_SERVER[ "REQUEST_URI" ];

	$_str = NULL;
	if( strpos( $_url,'?s=') !== false)
	{
		$_str = 's';
	}
	elseif( strpos( $_url,'?cat=') !== false)
	{
		$_str = 'cat';
	}
	elseif( strpos( $_url,'?tag=') !== false)
	{
		$_str = 'tag';
	}
	elseif( preg_match( '/\?p=(\d{1,})/' , $_url , $matches ) )
	{
		$_str = $matches[1];
	}

	return $_str;
}





/**
 * jsonファイルからの。配列化。デコード。
 * 2023-02-25
 *
 * @return array
 */
function kx_json_arr( $url ){

  $json1	= file_get_contents(  $url  );

	return kx_json_decode( $json1 );
}



/**
 * 値を JSON 形式にして返す。
 * array → json
 *
 * @return array
 */
function kx_json_encode( $json ){

	return json_encode( $json , JSON_UNESCAPED_UNICODE );

}


/**
 * jsonを配列に変換。
 * json → array
 *
 * @return array
 */
function kx_json_decode( $json  ){



	$json = preg_replace( '/(\r\n|\n|\r)/' , '' ,$json);
	$json2	= mb_convert_encoding(  $json , 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'  );
	$json3	= json_decode(  $json2 , true  );

	return $json3;


}




/**
 * マークダウン関連。2025-05-28
 *
 * @param [type] $markdown
 * @return void
 */
function kx_markdownToHtml($markdown) {
    // `###` を `<h3>` に変換

		/*
		if(preg_match('/####\s*(.+)/',  $markdown ,$matches))
		{
			echo $matches[1];
		}
		*/

		$html = preg_replace('/#####\s*(.+)/', '<h5>$1</h5>', $markdown);
    $html = preg_replace('/####\s*(.+)/', '<h4>$1</h4>', $html);
		$html = preg_replace('/###\s*(.+)/', '<h3>$1</h3>', $html);
    // `##` を `<h2>` に変換
    $html = preg_replace('/##\s*(.+)/', '<h2>$1</h2>', $html);



    return $html;
}


/**
 * 指定された投稿IDの配列を、対応する投稿タイトルの文字数が短い順にソートします。
 *
 * @param array $ids ソートしたい投稿IDの配列。
 * @return array タイトルが短い順にソートされた投稿IDの配列。投稿が存在しないなどの理由でタイトルが取得できなかったIDは、ソート結果から除外されます。
 */
function kx_sort_ids_by_title_length(array $ids): array {
	$title_id_pairs = [];

	foreach ($ids as $id) {
			$title = get_the_title($id);
			if ($title) {
					$title_id_pairs[$title] = $id;
			}
	}

	// タイトルの長さでソートするカスタム比較関数
	uksort($title_id_pairs, function ($a, $b) {
			return strlen($a) - strlen($b);
	});

	// ソートされた配列からIDのみを抽出
	$sorted_ids = array_values($title_id_pairs);

	return $sorted_ids;
}


/**
 * タイトルの階層構造を解析し、最後の項目のみを取得する関数
 *
 * - `＠` が含まれる場合は、その後のテキストを取得
 * - `＠` がない場合は、 `≫` で区切られた最後の項目を取得
 *
 * @param string $title 階層構造を持つタイトル文字列
 * @return string 抽出されたタイトルの最後の部分
 */
function kx_title_end_format($title) {
    // ＠が含まれている場合、その後の部分を取得
    if (strpos($title, '＠') !== false)
		{
			return end(explode('＠', $title));
    }
    // それ以外は ≫ で区切って最後の要素を取得
    $parts = explode('≫', $title);
    return end($parts);
}




/**
 * タイム差のカラー表示。
 *
 * @param [type] $type
 * @return void
 */
function kx_time_color( $modified_date ){

	$_time_margin = time() - $modified_date;

	$_time_day   = 60*60*24;
	$_time_p_day = $_time_margin / $_time_day;


	$_time_week1  = 60*60*24*7;
	$_time_p_week1 = $_time_margin / $_time_week1;

	//$_time_week2  = 60*60*24*14;
	//$_time_p_week2 = $_time_margin / $_time_week2;

	$_time_month1 	= 60*60*24*30;
	$_time_p_month1 = $_time_margin / $_time_month1 * 30;

	$_time_month6 	= 60*60*24*180;
	$_time_p_month6 = $_time_margin / $_time_month6;

	$_time_year2 		= 60*60*24*365*2;
	$_time_p_year2	= $_time_margin / $_time_year2;

	$_time_year5 		= 60*60*24*365*5;
	$_time_p_year5	= $_time_margin / $_time_year5;

	$_time_year10 	= 60*60*24*365*10;
	$_time_p_year10 = $_time_margin / $_time_year10;


	//基本色相。2023-09-26
	$_h = floor( 90 - ( $_time_p_day / 4) );//切り捨て。色相。


	if( $_h < 0 )
	{
		$_h = 0;
	}

	//基本彩度。半年で100-0へ。グレーへ。
	//$_s = 100;//彩度。100は純色。
	//$_s = 100 - ( $_time_margin / $_time_month6 * 100 );

	$_s = 100 - ( $_time_margin / $_time_year2 * 100 );	//2年で0

	if( $_s < 0 )
	{
		$_s = 0;
	}

	$_l = 50;//明度。50が基準。100は白。


	if( $_time_p_day < 1 )
	{
		$_a = 5;
	}
	else
	{
		$_a = 25;//透明度
	}

	//5年前
	if( $_time_p_day > ( 365 * 5) )
	{
		$_h = 240;
		$_s = 50;
		$_a = 75;
	}



	/*
	if( $_time_p_day < 1 )
	{
		$_h = 120;
		$_a = 5;
	}
	elseif( $_time_p_day < 2 )
	{
		$_h = 105;
		$_a = 45;
	}
	elseif( $_time_p_week1 < 1 )
	{
		$_h = 90;

		//透明度変更
		$_a = 40;
	}
	elseif( $_time_month1 < 1 )
	{
		$_h = 90;

		//透明度変更
		$_a = 33;
	}
	elseif( $_time_month1 < 2 )
	{
		$_h = 330;

		//透明度変更
		$_a = 33;
	}
	elseif( $_time_p_year5 < 1 )
	{
		$_h = 0;
		$_a = 33;//透明度
	}
	elseif( $_time_p_year10 < 1 )
	{
		//5年以内は基本カラー
	}
	elseif( $_time_p_year10 > 1 )
	{
		//5年以上

		$_time_year15 = 60*60*24*365*25;
		$_time_p_year15 = $_time_margin / $_time_year15;



		if( $_time_p_year15 < 1 )
		{
			$_color15 = $_time_p_year15 * 100;

			$_h = 280 - $_color15;
			$_s = $_color15 ;
			$_l = 33 + ($_color15 / 3) ;
			$_a = 75 - floor( $_color15 / 4 );
			//$_a = 75;

			//echo $_color15 .'--S'. $_s. '<br>';
		}
		else
		{
			$_h = 180;
			$_s = 50;
			$_l = 66;
			$_a = 75;
		}
	}
	else
	{

		if( $_time_p_month6 > 1 )
		{
			$_s = 0;
		}
		else
		{
			$_s = 100 - $_time_p_month6;
		}
	}
	*/


	return
	[
		'h' => $_h,
		's' => $_s,
		'l' => $_l,
		'a' => $_a,
	];
}


/**
 * Undocumented function
 *
 * @return void
 */
function kx_time_human_diff( $modified_date ){

	if( $modified_date > date("U",strtotime("-1 minute") ) )
	{
		$ret = ( date("U",strtotime("-1 second" ) ) - $modified_date ).'秒';
	}
	elseif( $modified_date > date("U",strtotime("-2 hour") ) )
	{
		$_time = date("U",strtotime("-1 second" ) - $modified_date );
		$ret = ceil( $_time / 60 ).'分';
	}
	elseif( $modified_date > date("U",strtotime("-1 day") ) )
	{
		$_time = date("U",strtotime("-1 hour" ) - $modified_date );
		$ret = ceil( $_time / ( 60*60 ) ).'時間';

		//echo ( $_time / ( 60*60 ) );
	}
	elseif( $modified_date > date("U",strtotime("-100 day") ) )
	{
		$_time = date("U",strtotime("-1 day" ) - $modified_date );
		$ret = ceil( $_time / ( 60*60*24 ) ).'日';

		//elseif( $modified_date > date("U",strtotime("-10 month") ) ):
		//$_time = date("U",strtotime("-1 month" ) - $modified_date );
		//$ret = round( $_time / ( 60*60*24*30 ) ).'ヶ月';
	}
	elseif( $modified_date > date("U",strtotime("-2 year") ) )
	{
		$_time = date("U",strtotime("-1 month" ) - $modified_date );
		$ret = round( $_time / ( 60*60*24*30 ) ).'ヶ月';
	}
	else
	{
		$ret = human_time_diff( $modified_date ).'前' ;
	}

	return $ret;
}





/**
 * ■更新時間。時間差。
 *
 * @param int $id
 * @param object $post
 * @return void
 * 'sa' 時間差
 */
function kx_time_modified(	$id = null	,	$post	= null) {

	if( !empty( $id ) )
	{
		$id_mae	= get_the_ID();
	}
	else
	{
		$id = get_the_ID();
	}


	if( empty( $post ) )
	{
		global $post;
		$post	 = get_post( $id );
	}


	setup_postdata( $post );
	$time							= time();
	$modified_date 		= get_post_modified_time('U',true) ;
	$ret['sa']				= $time	-	$modified_date;

	$ret['modified']	= $modified_date  ;
	//$ret['mae']			= human_time_diff( $modified_date, $to ) ;
	$ret['mae']				= human_time_diff( $modified_date ) ;


	//ポスト戻し。
	if( !empty( $id_mae ) )
	{
		setup_postdata(get_post($id_mae));
	}

	return $ret;
}



/**
 * 正規表現でタイトルをマッチングする共通関数
 *
 * @param string $pattern 正規表現パターン
 * @param string $subject マッチング対象の文字列
 * @return array|false マッチ結果の配列、または false
 */
function kx_preg_match_pattern($pattern, $subject) {
	$matches = [];
	if (preg_match($pattern, $subject, $matches)) {
		return $matches; // マッチした結果を返す
	}
	return false; // マッチしなかった場合は false を返す
}




/**
 * 複数の正規表現パターンを適用してマッチングを行う関数
 *
 * @param array $patterns 正規表現パターンの配列
 * @param string $subject マッチング対象の文字列
 * @return array|false 最初にマッチした結果の配列、または false
 */
function kx_preg_match_pattern_s($patterns, $subject) {
	foreach ($patterns as $key => $pattern) {
		$matches = kx_preg_match_pattern($pattern, $subject);
		if ($matches !== false) {
			return ['key' => $key, 'matches' => $matches];
		}
	}
	return false; // マッチしなかった場合は false を返す
}


/**
 * SESSION・メモリー用・ワード順
 *
 * @param array $args
 * @param string $type
 * @return string
 */
function kx_session_memory( $args , $type = null ){

	//順番設定の配列。2023-02-28。
	$_arr = [
		'cat',
		'tag',
		'orderby',
		'order',
		'post_type',
		'tag_not',
		'cat_not',
		'search' => 'search',
	];

	if( $type == 'category')
	{
		unset( $_arr[ 'search' ] );
	}
	else
	{
		$type = 'NoType';
	}


	foreach( $_arr as $value):

		if( !empty( $args[ $value ] ))
		{
			$_arr2[ $value ] = $args[ $value ];
		}

	endforeach;

	$ret = NULL;
	$i = 0;
	foreach( $_arr2 as $key => $value2):

		if( $i != 0)
		{
			$ret .= '_';
		}


		if( $key == 'tag_not' || $key == 'cat_not' )
		{
			$ret .= '-';
		}

		$ret .= $value2;
		$i++;

	endforeach;

	return $type. '-' .$ret;
}



/**
 * Heading_count関連
 *
 * @param [type] $arr
 * $id
 * $type
 * $raretu_count
 * $h_x
 * $daimei
 *  @return void
 */
 function kx_session_raretu_Heading(	$args	){

	//作品来歴用・同一タイム排除。
	if( !empty( $args[ 'on-off' ] ) && $args[ 'on-off' ]  == 'off'  )
	{
		return;
	}

	extract( $args );

	if( empty( $_SESSION[ 'Heading_count' ][	$id	][	$type	] ))
	{
		$_SESSION[ 'Heading_count' ][	$id	][	$type	] = 1;
	}
	else
	{
		$_SESSION[ 'Heading_count' ][	$id	][	$type	]++;	//たぶん使ってない。2021-05-12
	}


	if( empty( $_SESSION[ 'Heading_count' ][	$id	][	$type.$h_x ] ) )
	{
		$_SESSION[ 'Heading_count' ][	$id	][	$type.$h_x ] = 1;
	}
	else
	{
		$_SESSION[ 'Heading_count' ][	$id	][	$type.$h_x ]++;
	}


	if( empty( $_SESSION[ 'Heading_count' ][	$id	][ 'h'.$h_x ] ) )
	{
		$_SESSION[ 'Heading_count' ][	$id	][ 'h'.$h_x ] = 1;
	}
	else
	{
		$_SESSION[ 'Heading_count' ][	$id	][ 'h'.$h_x ] ++;
	}


	if( empty( $daimei_add ) )
	{
		$daimei_add = NULL; //原因不明。
	}


	if( empty( $haeding_plot_on ) )
	{
		$haeding_plot_on = NULL; //原因不明。
	}



	$_SESSION[ 'Heading_count' ][	$id	][ 'raretu_count' ] = $raretu_count;

	$_SESSION[ 'Heading' ][  $id  ][	$_SESSION[ 'Heading_count' ][	$id	][	$type	]	]	=
	[
		'h_x'							=> $h_x,
		'h'.$h_x					=> $_SESSION[ 'Heading_count' ][	$id	][ 'h'.$h_x ],
		'daimei'					=> $daimei,
		'daimei_add'			=> $daimei_add,
		'haeding_plot_on' => $haeding_plot_on,
		'id_js'						=> $id_js,
		'memo'						=> 'func3',
	];
}



/**
 * Undocumented function
 *
 * @param [type] $content
 * @return void
 */
function kx_session_raretu_Heading_content(	$content	){

	//echo $content;

	preg_match_all('/<h(\d)>(.*?)<\/h(\d)>/', $content	, $matches	,PREG_OFFSET_CAPTURE	);

	$i	= 0;

	//調整中。2021/05/11
	/*
	$i_arr[1]	= 0;
	$i_arr[2]	= 0;
	$i_arr[3]	= 0;
	$i_arr[4]	= 0;
	$i_arr[5]	= 0;
	$i_arr[6]	= 0;
	*/
	//調整。制作中。2021-03-02

	foreach(	$matches[0]	as $_arr	):

		//print_r($_arr[0] );
		//echo '+';

		preg_match('/(<h(\d))(>.*?<\/h\d>)/',	$_arr[0]	,$matches1);
		//echo $matches1[2];

		if( empty( $i_arr[ $matches1[2] ] ) )
		{
			$i_arr[ $matches1[2] ] = 0;
		}

		$i_arr[ $matches1[2] ]++;

		//アンカー
		$content0	= preg_replace('/(<h\d)(>.*?<\/h\d>)/',	'$1 id=kxanchor'.$i.' $2'	,	$_arr[0]	);

		$content	= str_replace(	$_arr[0]	,	$content0	,		$content	);


		$i++	;

	endforeach;

	$i	= 0;
	foreach(	$matches[1]	as $_arr	):

		$arr[$i][ 'h_x' ]		= $_arr[0]	;
		$i++	;

	endforeach;


	$kxo	= new	kxol;
	$replace	= $kxo->kxol_title_replace;

	$i	= 0;
	foreach(	$matches[2]	as $_arr	):

		foreach(	$kxo->kxol_title_replace	as	$key	=>	$v	):

			$_arr[0]	= preg_replace(	$key	,	$v	,	$_arr[0]	);

			$arr[$i]['daimei']	= $_arr[0];

		endforeach;


		$i++	;

	endforeach;

	$id	= get_the_ID();

	if( !empty( $arr ) )
	{
		foreach( $arr	as	$_v):

			$_SESSION[ 'Heading' ][  $id  ][]	= [

				'h_x'			=>$_v[ 'h_x' ],
				'daimei'	=> $_v['daimei'],

			];

		endforeach;
	}

	if( empty( $_css) )
	{
		$_css = NULL;
	}



	return	$_css . $content;

}








/**
 * 指定されたキーの順序で配列をソートし、不要なキーを削除する関数
 *
 * この関数は `$item` 配列の中から `$order` に含まれるキーのみを抽出し、
 * `$order` の順序通りに並べ替えます。
 * `$order` に含まれていないキーは結果の配列から **削除** されます。
 *
 * `$item` は参照渡し（`&`）によって渡されるため、この関数内で `$item` に
 * 変更を加えると元の配列も影響を受けます。
 *
 * さらに `$unset` パラメータを指定すると、値が空（null, 空文字, 0, false など）であるキーは
 * 配列から `unset()` によって **完全に削除** されます。
 *
 * @param array &$item ソート対象の配列（参照渡しで操作されます）
 * @param array $order ソート順を決めるキーの配列
 * @param string|null $unset アンセットを実行するかどうかのフラグ（何か値があれば有効）
 * @return array `$order` に含まれるキーのみを保持し、必要に応じて空のキーも削除したソート済み配列
 */
function kx_array_sort_filtered(array &$item, array $order, $unset = null ){
  $sorted = [];
  foreach ($order as $key) {
    // 1. 指定されたキーが元の配列にあるか確認
    if (array_key_exists($key, $item)) {
      $val = $item[$key];

      // 2. unsetフラグが有効かつ、値が空の場合はスキップ（追加しない）
      if (!empty($unset) && empty($val)) {
        continue;
      }

      // 3. 条件をクリアした値だけを新しい配列に格納
      $sorted[$key] = $val;
    }
  }
  // 4. 【最重要】参照渡しの変数に結果を書き戻す
  $item = $sorted;
}



/**
 * 使用開始。2020/08/01
 * Contents表示のメイン。2023-02-20
 *
 * @param int $id	postID
 * @param string $type full or それ以外。
 * @return void
 */
function kx_break_excerpt(	$id	,	$type	= null ) {

	global $post;
	$post = get_post( $id );
	setup_postdata( $post );

	global $more;
	$more = ($type === 'full'); //条件演算子（比較演算子）

	$content = apply_filters(	'the_content'	, get_the_content("")	);

	//trim()前後の余白排除。トリミング。2023-02-25
	$content = preg_replace(	"/\r\n|\r|\n/"	, ""	, trim( $content )	);


	//先頭のbr削除。‘171101'
	if( substr( $content , 0 , 6 ) == "<br />" )
	{
		$content = mb_substr($content, 6);
	}

	//多分必要。場所移動が必要かも。2020/08/01
	wp_reset_postdata();

	return $content;
}


/**
 * ゴミ箱（trash）にある投稿を更新日時順にリスト表示する
 * * 仕様書「2. 主要コンポーネント」のDBレイヤーおよびUI補助に該当する関数。
 * WordPress標準のwp_postsテーブルを参照し、削除日時の近似値としてpost_modifiedを使用する。
 * * @global wpdb $wpdb WordPressデータベースオブジェクト
 * @return string HTML形式のリスト（h4およびul/liタグ）
 */
function kx_list_trashed_posts_by_deleted_date() {
    global $wpdb;
    $str = '';

    // SQLを少し修正：postmetaから削除日時を取得することを検討
    // ここではシンプルに、ゴミ箱にある記事を最新順で取得
    $trashed_posts = $wpdb->get_results("
        SELECT ID, post_title, post_modified
        FROM {$wpdb->posts}
        WHERE post_status = 'trash'
        ORDER BY post_modified DESC
    ");

    $str .= '<h4 class="__radius_kumi_top20">削除タイトル（直近の変更順）</h4>'; // 既存CSSクラスの活用

    if ($trashed_posts) {
        $str .= '<ul style="list-style: none; padding: 0;">';
        foreach ($trashed_posts as $post) {
            // 編集画面へのリンクを作成（誤って消したか確認するため）
            $edit_link = get_edit_post_link($post->ID);

            $str .= '<li style="margin-bottom: 5px;">'
                . '<small style="color: #888;">' . esc_html($post->post_modified) . '</small> '
                . '<strong>' . esc_html($post->post_title) . '</strong>'
                //. ' <a href="' . esc_url($edit_link) . '" style="font-size: 10px;">[確認]</a>'
                . '</li>';
        }
        $str .= '</ul>';
    } else {
        $str .= '<p>削除済み投稿はありません。</p>';
    }
    return $str;
}



/**
 * 独自テーブル(wp_kx_0)とwp_postsの整合性をチェックする
 * 独自テーブルに存在するが、WP側でゴミ箱(trash)にあるデータをリストアップする
 */
function kx_check_db_integrity_mismatch() {
    global $wpdb;

    $str = '';
    $str .= '<h4 class="__radius_kumi_top20" style="color: #c0c1ffff;">不整合チェック：ゴミ箱内の独自データ</h4>';

    // 独自テーブル(wp_kx_0)に存在するIDの中で、wp_postsで'trash'ステータスになっているものを取得
    // kx_0側にデータがあり、wp_posts側がtrashまたは削除済み（存在しない）ケースを網羅
    $mismatched_posts = $wpdb->get_results("
        SELECT kx.id, kx.title, p.post_status
        FROM wp_kx_0 AS kx
        LEFT JOIN {$wpdb->posts} AS p ON kx.id = p.ID
        WHERE p.post_status = 'trash'
        OR p.ID IS NULL
        ORDER BY kx.id DESC
    ");

    if ($mismatched_posts) {
        $str .= '<p style="font-size: 0.9em; color: #666;">※独自テーブルには残っていますが、WP標準側でゴミ箱に入っているか、投稿自体が消失しているデータです。</p>';
        $str .= '<ul style="background: #fff5f5; border: 1px solid #ffcccc; padding: 10px; list-style: none;">';

        foreach ($mismatched_posts as $post) {
            $status_label = ($post->post_status === 'trash') ? '[ゴミ箱]' : '[WP投稿なし]';

            $str .= '<li style="margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 4px;">'
                . '<span style="color: #e22; font-weight: bold; margin-right: 10px;">' . esc_html($status_label) . '</span>'
                . '<small>ID: ' . esc_html($post->id) . '</small> | '
                . '<strong>' . esc_html($post->title) . '</strong>'
                . ' <a href="' . admin_url('post.php?post=' . $post->id . '&action=edit') . '" target="_blank" style="font-size: 11px; margin-left: 10px;">[WP編集画面]</a>'
                . '</li>';
        }
        $str .= '</ul>';
        $str .= '<p style="color: #d63638; font-weight: bold;margin-left: 40px;">推奨アクション：不要なら独自テーブルからも削除、必要ならWP側で「復元」してください。</p>';
    } else {
        $str .= '<p style="color: #64b7faff;margin-left: 40px;">✔ データの不整合は見つかりませんでした。良好です。</p>';
    }

    return $str;
}
