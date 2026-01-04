<?php

//use Kx\Utils\Time;
//use Kx\Core\SystemConfig as Su;
use Kx\Core\DynamicRegistry as Dy;




/**
 * コンテンツの追加要素。
 *
 * @param [type] $id
 * @return void
 */
function kx_add_content($id){




	if ($consolidated_from = kx_tougou_Check($id)) {
		//$ret = apply_filters('the_content', '＿引き出し＿'.kx_tougou_update($id).'＿引き出し＿end');
		kx_tougou_update($id);
		return '<div style="float:right;">'.kx_CLASS_kxx( ['t' =>65,'id'=>$consolidated_from ,'text_c' => '✦✦統合✦ID'.$consolidated_from.'✦✦' ,'tougou'=>'consolidated_from']  ).'</div>';//.$ret
	}
}


/**
 * Undocumented function
 *
 * @param [type] $id
 * @return void
 */
function kx_tougou_Check($id) {
    $result = kx_db1(['id' => $id], 'SelectID');

		if(!empty($result['consolidated_from']))
		{
			kx_db1(['id' => $result['consolidated_from'] ], 'id');
		}


    return !empty($result['consolidated_from']) ? $result['consolidated_from'] : false;
}




/**
 * 統合系アップデート。
 *
 * @param [type] $id
 * @return void
 */
function kx_tougou_update($id){
	//echo '+'.$id;
	$ret = null;

	//echo $id;
	$_result0 = kx_db1([ 'id' => $id ] , 'SelectID' );


	if( !empty( $_result0['consolidated_from']))
	{
		//echo '+'.$id;
		//var_dump($_result0);

		//$kxra = new raretu;
		//$ids = $kxra->kxra_Main( ['tougou_sort' => $_result0['consolidated_from'] ] );
		//var_dump($_KxDy = KxDy::get('content')[$id]['db_kx1']['json']) ;

		// 1. キャッシュからJSONデータを取得
		$kx1_json_data = KxDy::get('content')[$id]['db_kx1']['json'] ?? null;

		$ids = []; // 初期化

		if (!empty($kx1_json_data)) {
            // 2. データが文字列の場合はデコード、配列の場合はそのまま使用
            $json_arr = is_string($kx1_json_data) ? kx_json_decode($kx1_json_data) : $kx1_json_data;

            // 3. consolidated_ids キーが存在し、かつ配列であることを確認して取得
            if (isset($json_arr['consolidated_ids']) && is_array($json_arr['consolidated_ids'])) {
                $ids = $json_arr['consolidated_ids'];
            }
        }

        // 確認用
        //var_dump($ids);


		if( !empty($ids)  )
		{
            //echo '++';
			//$ids = (kx_json_decode($_result1[0]->json)['raretu_id']) ?? null;
			$_post_title = get_the_title( $_result0['consolidated_from']);

			// 投稿ID配列 $ids から、特定のタイトルパターンに一致する投稿を除外する
			$ids = array_filter($ids, function($id) use ($_post_title) {
					// 投稿IDからタイトルを取得
					$_title = get_the_title($id);

					// タイトルが「$_post_title(ポストタイトル直下の場合のみ)≫00-00＠統合概要」で始まる場合は除外する
					// preg_quote により $_post_title 内の記号を正規表現用にエスケープ
					return !preg_match('/^' . preg_quote($_post_title, '/') . '≫(00-00＠.*統合概要|関連)$|nollm/i', $_title);
			});

			//アップデート処理。
			kx_maybe_update_post_content( $id , $ids );
			return kx_generate_post_texts($ids,'','','tougou_update');
		}

	}

}




/**
 * Undocumented function
 *
 * @param [type] $text
 * @return void
 */
function kx_change_any_texts1st( $text	){

	$array = [

		'/(^|\n|\])■(.*?)(\n|\s|<br \/>|　)/'
    =>	'##■$2$3',

		'/(^|\n|\])◆(.*?)(\n|\s|<br \/>|　)/'
    =>	'###$2$3',

		'/(^|\n|\])▼(.*?)(\n|\s|<br \/>|　)/'
    =>	'####$2$3',

		'/(^|\n|\])□(.*?)(\n|\s|<br \/>|　)/'
    =>	'#####$2$3',

		'/(^|\n|\])✤(.*?)(\n|\s|<br \/>|　)/'
    =>	'######$2$3',


    /*'/(<p>|\s)◆(?=<\/p|<br \/>)/'
    =>	'$1<span class="__kxct_sikaku2 __text_shadow_normal" style="color:ヾ色hsla普通ヾ;">◆</span>',

    '/(^|\n)◆(\n|\s)/'
    =>	'$1<span class="__kxct_sikaku2 __text_shadow_normal" style="color:ヾ色hsla普通ヾ;">◆</span>',

    '/(<p>|\s)□(.*?)(?=　|<\/p|<br \/>)/'
    => 	'$1<span class="__kxct_sikaku2">□</span><span class="__kxct_sikaku_shiro" style="border-bottom:1px solid hsla(ヾ色相ヾ,100%,25%,1);border:1px solid hsla(ヾ色相ヾ,100%,90%,1);">$2</span>$3',

    '/(^|\n)□(.*?)(　|\n|\s)/'
    => 	'$1<span class="__kxct_sikaku2">□</span><span class="__kxct_sikaku_shiro" style="border-bottom:1px solid hsla(ヾ色相ヾ,100%,25%,1);border:1px solid hsla(ヾ色相ヾ,100%,90%,1);">$2</span>$3',
		*/
	];

	foreach(	$array as $key => $value):

		$text = preg_replace (	$key		,$value	,$text	);

  endforeach;

  return $text;


}


/**
 * contents介入用。テキスト置換
 *
 * @param [type] $text
 * @return void
 */
function kx_change_any_texts(	$text	){


	//エディター回避。GET判定。エディターがインクルードできない。2023-03-03。
	if( !empty( $_GET[ 'action' ] ) &&	$_GET[ 'action' ]	== 'edit')
	{
		return;
	}

	$_title				= get_the_title();


	//タイム差のカラー表示。2023-03-03
	$text = kx_change_any_texts_time(	$text	);


	$kxct			= new kxct;

	$kxct->title	= $_title;

	//http置換
	if(	preg_match ('/(>|^|\n)http(.*?)(<|$)/' , $text ) )
	{
		$text	= $kxct->kxct_http(	$text	);
	}



	//preg単純置換
	foreach( $kxct->preg as $key1 => $arr1 ):

		if( preg_match( $key1 , $_title ) )
		{
			foreach( $arr1 as $key2	=> $value2 ):

				$text = preg_replace( $key2 , $value2 , $text );

			endforeach;
		}

	endforeach;
	unset( $arr1 , $key1 , $key2 , $value2 );


	//preg単純置換。構文複雑
	$text	= $kxct->kxct_preg2( $text );


	//preg置換+色。2024-01-22
	$text	= $kxct->kxct_preg_color( $text , $_title );

	//moreタグの置換。2023-03-03
	$ad = '</p><table><tr><td><HR class="__hr_more"></td><td width="6em"><span class="__color_gray __xxsmall">　more　</span></td><td><HR class="__hr_more"></td></tr></table><p>';
	$text = preg_replace( '/(<p>)?<span id="more-([0-9]+?)"><\/span>(.*?)(<\/p>)?/i', "$ad$0", $text );

	//置換用配列の呼び出し。json。2023-03-03
		$replace = kx_json_arr( get_stylesheet_directory() . "/data/json/add_change.json" )["change_str"];

	$_kxcl = kx_CLASS_kxcl( '' , 'kxx' );

		//追記
	$replace['∌']								= '';
	$replace['ヾ色置換ヾ']			= $_kxcl[ 'background_class_normal' ];
	$replace['ヾ色置換・薄ヾ']	= $_kxcl[ 'background_class_u50' ];
	$replace['ヾ色hsla普通ヾ']	= $_kxcl[	'hsla_normal'	];//$c_hsla;
	$replace['ヾ色hsla薄いヾ']	= $_kxcl[ 'hsla_light' ];//$c_hsla_u;

	$replace['ヾ色相ヾ']				= $_kxcl[ '色相' ]; //





	$text = str_replace( array_keys( $replace ), $replace , $text );

	return $text;
}



/**
 * タイムスタンプのカラー化置換。
 *
 * @param string $text
 * @return string
 */
function kx_change_any_texts_time( $text ){

	//来歴のポストでは、日時表記をしない。2023-10-30
	preg_match( '/p=(\d{1,})/', $_SERVER['REQUEST_URI'] , $matches ) ;

	if( !empty( $matches[1]) && preg_match( '/≫来歴/' ,get_the_title( $matches[1] ) )   )
	{
		$_raireki_on = 1;
	}
	else
	{
		$_raireki_on = NULL;
	}

	unset( $matches );

	preg_match_all( KxSu::get('base_preg')['timestamp'] , $text , $matches );
	//文中のタイムスタンプを繰り返し処理。
	foreach( $matches[0] as $_timestamp ):

		$_timestamp = str_replace('_','-' , $_timestamp );

		//テキスト中のタイムスタンプをUNIX時間に変更。
		$date = new DateTime( $_timestamp );
		$date = $date->format('U');

		//タイムスタンプのカラー表示呼び出し。
		$_time_color =  kx_time_color( $date ) ;

		preg_match('/\d{2}(\d{2})-(\d{2})-(\d{2})/' , $_timestamp , $matches1 );

		//来歴の場合は、日付は非表示。2023-10-26
		if( empty( $_raireki_on ))
		{
			$_replacement = '<span style="font-size:xx-small;opacity:0;display:inline-block;margin-right:-1.5em;margin-left:.75em;">$1</span><span style="font-size:xx-small;color:hsla('. $_time_color[ 'h' ] .','. $_time_color[ 's' ] .'%,'. $_time_color[ 'l' ] .'%,.'. $_time_color[ 'a' ] .');">$2_$4<span style="font-size:xx-small;opacity:0;display:inline-block;margin-right:-4px;">_</span>$6</span>';
		}
		else
		{
			$_replacement = '';
		}

		$text = preg_replace(
			'/(\d{2})('.$matches1[1].')(_|-)('.$matches1[2].')(_|-)('.$matches1[3].')/' ,
			$_replacement ,
			$text
		);

	endforeach;

	return $text;
}


/**
 * テーブル内の行に交互の背景色を適用する
 *
 * @param string $text HTML形式のテキスト
 * @return string 背景色が適用されたHTMLテキスト
 */
function kx_change_any_texts_table($text) {
    // UTF-8 に変換してから処理する
    $text = mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8');

    // DOMDocumentを使ってHTMLを解析
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // HTMLの警告を無視
    $dom->loadHTML('<?xml encoding="UTF-8">' . $text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    $tables = $dom->getElementsByTagName('table');

    foreach ($tables as $table) {
    $rows = $table->getElementsByTagName('tr');
    foreach ($rows as $index => $row) {
        if ($index === 0) {
            $row->setAttribute('style', 'background-color: hsla(ヾ色相ヾ, 100%, 50%, 0.1);font-size: 14px;line-height: 2.0;'); // 一行目の特別な色
        } elseif ($index % 2 === 0) {
            $row->setAttribute('style', 'background-color: hsla(0, 0%, 50%, 0.1);font-size: 14px;line-height: 2.0;'); // 偶数行
        } else {
            $row->setAttribute('style', 'background-color: hsla(0, 0%, 50%, 0.01);font-size: 14px;line-height: 2.0;'); // 奇数行
        }
    }
}

    return mb_convert_encoding($dom->saveHTML(), 'UTF-8', 'HTML-ENTITIES');
}






/**
 * 各種置換系の統合
 * 2023-03-07
 *
 * @param string $text 置換する文字。
 * @param string type 置換タイプ
 * @return void
 */
function kx_change_outline_title( $text , $type ){

	if( $type == 'outline_text')
	{
		$ret = str_replace( array_keys( KxSu::get($type) ), array_values( KxSu::get($type) ), $text );
	}

	return $ret;

}



/**
 * ポスト置換用。
 *
 * @return void
 */
function kx_ChangePOST_Form( $array ){

	echo '<h2>配列：$array </h2>';
	var_dump( $array );
	echo '<hr>';

	extract( $array );

	if( $content_replace_1d	== '//' )
	{
		$content_replace_1d = '/⊕⊕⊕⊕⊕⊕⊕⊕⊕⊕/';
	}

	//■一段目検索
	$args =
	[
		's'									=>	$search1	,
		'posts_per_page'		=>	-1,
		'post_type'					=>	'post',	//投稿ページのみ
    'post_status'      	=>	'publish',
	];

  global $post;		//必要
	$my_posts = get_posts($args);

	$count1 = count( $my_posts );


	echo '<h2>確認</h2>';
	if( empty( $count1 ) )
	{
		return ['string' => '一段目・❗該当なし❗'];
	}


	//一段目count
	echo '+一段目検索数：' . $count1 . '件<br>';

	$s=0;
  foreach ( $my_posts as $post ) :

		setup_postdata( $post );

		//echo $content_replace_1.'++++<br>';

		if(
      !empty( $content_on )	&&
      !empty( $content_replace_1 )	&&
			preg_match(	$content_replace_1	,	$post->post_content	, $matches)	&&
			!preg_match( $content_replace_1d	,	$post->post_content)
		){
			//コンテンツ変換あり。

			$s++;

			//echo $matches[0].'<br>';

			$arr_id1[get_the_ID()]['content1']	= $post->post_content;
			$arr_id1[get_the_ID()]['matches0'] 	= $matches[0];

			if( !empty( $content_replace_3 ) &&	$content_replace_3	== 'sc_only'	)
			{
				$arr_id1[get_the_ID()]['content2']	= preg_replace(	$content_replace_1	,$content_replace_2	,	$matches[0]	);
			}
			else
			{
				$arr_id1[get_the_ID()]['content2']	= preg_replace(	$content_replace_1	,$content_replace_2	,	$post->post_content	);
				$arr_id1[get_the_ID()]['matches']		= preg_replace(	$content_replace_1	,$content_replace_2	,	$matches[0]	);
			}

			$arr_id1[	get_the_ID()	]['on'] = 1;
		}
		elseif( empty( $content_on ) && !empty( $title_replace_1 ) )
		{
			//タイトル変換のみ。
			//echo $title_replace_1.'-'. get_the_title().'<br>';
      if( preg_match( $title_replace_1 , get_the_title() ) )
			{
        $arr_id1[	get_the_ID()	]['on'] = 1;
      }
		}
    elseif( empty( $content_on ) )
		{
      $arr_id1[	get_the_ID()	]['on'] = 1;
    }

  endforeach;


  //二段目チェック
	//❗該当なし❌の記述は、リロード停止に使っているので要注意。2023-03-11
	if( empty( $arr_id1 ) )
	{
    echo '+二段目・❗該当なし❌';
    //return;
    //return '二段目・❗該当なし❌';
		return ['string' => '二段目・❗該当なし❌'];
	}
	else
	{
		echo '+二段目検索数：'.count(	$arr_id1	).'件<br><hr>';
	}


	$s    = 0;
	$_ids = [];
	foreach(	$arr_id1	as $_k => $_arr	):
    $s++;

    $_title	= get_the_title(  $_k );

		//echo $_title.'+'.$title_search.'<br>';

		if(	empty( $title_search_on ) )
		{
			$title_search = '/' . $search1 . '/';
		}
		elseif( $title_search == '//' && $title_search_on	 )
		{
			return '■■■■■■■■■■■title_search■error■■■■■■■■■■■';
		}

		if(	preg_match(	$title_search	,	$_title	)	)
		{
			if(	!empty( $title_replace_1 )	&& !empty( $title_replace_2 ) &&	preg_match( $title_replace_1 , $_title ) )
			{
				$title	= preg_replace(	$title_replace_1	,$title_replace_2	,	$_title	);

				$view[$s]['Title']				= $_title;
				$view[$s]['title置換前']	= $_title;
				$view[$s]['title置換後']	= $title;

				$arr_id2[	$_k	]['update_title'] = $title;
				$_ids[$s] =  $_k;
			}


			if(	!empty( $_arr['content2'] ) )
			{
				$view[$s]['Title']	= $_title;
				$view[$s]['content置換前']	= $_arr['matches0'];
				$view[$s]['content置換後']	= $_arr['matches'];

				if( !empty( $content_replace_3 ) )
				{
					$view[$s]['content_削除']	= 'ON';
				}

				$arr_id2[	$_k	]['update_content'] = $_arr['content2'];
				$_ids[$s] =  $_k;
			}
		}

	endforeach;
  unset($_k	,	$_arr);


	if(	!empty( $title_search ) && !empty( $arr_id2 ) && is_array( $arr_id2 )	)
	{
		$count = count(	$arr_id2	);
		$count_time = $count	/ 26	;

		$up_count	= '─　残り　─　UPdate数　'.$count.'件　／　' . round( $count_time , 1)	.'分　─<hr>';
	}
	else
	{
		$up_count	= '三段目・配列なし:001<br>';

		if( empty( $title_search ) )
		{
			$up_count	.= '検索なし<br>';
		}
		else
		{
			$up_count	.= '検索あり<br>';
		}

		if( !empty( $title_replace_1 ) && empty( $title_replace_2 ) )
		{
			$up_count	.= 'title_replace_2：無し<br>';
		}

		$up_count	.= '<hr>';
	}


	//表示要素
	$ret = NULL;

	$ret .= 'IDs<br>';

	$str = '';
	foreach( $_ids as $_id)
	{
		$str .=  $_id;
		$str .=  ',';

	}

	$ids_string  = rtrim($str, ',');

	$ret .= $ids_string;

	$ret .= '<hr>';


	if( !empty( $view ) && is_array( $view )	)
	{
		foreach( $view as $arr ):
			foreach(	$arr	as $_k =>	$_v	):

				$ret .= $_k.' ： '.$_v.'<br>';

			endforeach;

			$ret .= '<hr>';

		endforeach;
		unset($arr);
  }


	//update//echo '❌❌❌';
	if( !empty( $on ) )
	{
		if( empty($arr_id2) || !is_array( $arr_id2 ))
		{
			return '❗❗❗該当なし❗❗❗';
		}

		$s_up = 0;
		foreach( $arr_id2	as $_k => $arr	):
			$s_up++;

			//件数制御
			if(	$s_up	== $ppp	){break;}

			$up_arr[ 'ID' ]	= $_k;

			if( !empty( $arr['update_title'] ) )
			{
				$up_arr['post_title']		= $arr['update_title'];
			}

			if( !empty( $arr['update_content'] ) )
			{
				$up_arr['post_content']	= $arr['update_content'];
			}

			wp_update_post(	$up_arr	);

			wp_enqueue_script(
				'reload',
				get_stylesheet_directory_uri().'/../kasax_child/js/reload.js',
				array( 'jquery' ),
				'1.0',
				true
			);


		endforeach;

		$on	= '★★　ON　★★<br>';
	}
	else
	{
		$on	= 'OFF<br>';
	}

	return
	[
		'string' => $on . $up_count . $ret,
		'ids'    => $ids_string,
	];
}


/**
 * Undocumented function
 *
 * @return void
 */
function kx_ChangePOST_FormTIME( $arr ){

	if( !empty( $arr[ 'search1' ] ) )
	{
		$_base_search1 = $arr[ 'search1' ];
	}
	else
	{
		$_base_search1 = '≫';
	}


	if( !empty( $arr['time1'] ) )
	{
		$announce = 'time1-Type：190401';

		$_POST = [

			'content_replace_1'		=>	'/\‘([0-1]\d)(\d{2,})(\d{2,})\'/',	//‘060327D27'
			'content_replace_2'		=>	'20$1-$2-$3',
		];
	}
	elseif( !empty( $arr['time2'] ) )
	{
		$announce = 'time2-Type：--';

		$_POST  =  [
			'content_replace_1'		=>	'/\‘([0-1]\d)\/(\d{2,})\/(\d{2,})(.*?)\'/',
			'content_replace_2'		=>	'20$1-$2-$3$4',
		];
	}
	elseif( !empty( $arr['time3'] ) )
	{
		$_POST  =  [
			'content_replace_1'		=>	'/\‘([0-1]\d)_(\d{2,})_(\d{2,})(.*?)\'/',
			'content_replace_2'		=>	'20$1-$2-$3$4',
		];
	}
	elseif( !empty( $arr['time4'] ) )
	{
		$_POST  =  [
			'content_replace_1'		=>	'/\‘([0-1]\d)(\d{2,})(\d{2,})(.*?)\'/',
			'content_replace_2'		=>	'20$1-$2-$3$4',
		];
	}
	elseif( !empty( $arr['time5'] ) )
	{
		$announce = 'time5-Type4桁';

		$_POST  =  [
			'content_replace_1'		=>	'/\‘(19|20)(\d{2})(\d{2})(\d{2})(.*?)\'/',
			'content_replace_2'		=>	'$1$2-$3-$4',
		];
	}
	elseif( !empty( $arr['time6'] ) )
	{
		$announce = 'time6-Type19xx年タイプ：99/04/01';

		$_POST  =  [
			'content_replace_1'		=>	'/\‘(9\d)\/(\d{2,})\/(\d{2,})(.*?)\'/',
			'content_replace_2'		=>	'19$1-$2-$3$4',
		];
	}
	elseif( !empty( $arr['time7'] ) )
	{
		$announce = 'time7-Type19xx年タイプ：990401';

		$_POST  =  [
			'content_replace_1'		=>	'/\‘(9\d)(\d{2,})(\d{2,})(.*?)\'/',
			'content_replace_2'		=>	'19$1-$2-$3$4',
		];
	}

	$_POST[ 'search1' ]             = $_base_search1;
	$_POST[ 'content_on' ]          = 1;
	$_POST[ 'title_search' ]        = '/≫/';
	$_POST[ 'content_replace_1d' ]	= '/⊕⊕⊕⊕/';

	echo $announce.'<hr>';

	return $_POST;
}




/**
 * Character年齢
 *
 * @param [type] $arr
 * @return void
 */
function kx_CharacterAge( $args ){

	$_arr_title = explode( '≫' , $args[ 'title' ]);

	$_arr      = kx_json_arr( get_stylesheet_directory() . "/data/json/chara.json" );

	if( !empty( $_arr[ $_arr_title[0] ][ str_replace( 'c' , '' ,  $_arr_title[1]  ) ][2] ))
	{
		$_age = $_arr[ $_arr_title[0] ][ str_replace( 'c' , '' ,  $_arr_title[1]  ) ][2];
	}
	else
	{
		$_age = NULL;
	}

	//echo $_age;

	return $_age;
}


/**
 * エラー出力。
 * パターン
 * 'OUT_echo_fixed'
 * 'table'
 * 'OUT_echo_top'
 * 'string'
 *
 * @param array $args0	Error設定。
 * @param array $args1 ショートコードベース設定。
 * @return void
 */
function kx_CLASS_error( $args ){

	$kxer = new kxer;
	$kxer->kxer_Main( $args );

	return $kxer->kxerOUT[ 'Return_String' ];

}


/**
 * class kxcl
 *
 * @param [type] $args
 * @param [type] $Special_operation
 * @return void
 */
function kx_CLASS_kxcl( $title = null , $type = null ){

	$kxcl = new kxcl;
	$kxcl->kxcl_Main( $title , $type );

	return $kxcl->kxclOUT;

}





/**
 * タイトル置換。取得。
 *
 * @param [type] $args
 * @return void
 */
function kx_CLASS_kxTitle( $args ){
	return (new kxtt($args))->get();
	//var_dump((new kxtt($args))->get());
	//echo '<hr>';
	/*
	$kxtt = new kxtt( $args );
	$kxtt->kxtt_Main( $args );
	return $kxtt->kxttOUT;
	*/
}


/**
 * outline・メイン
 * 途中代入用。
 *
 * @param [type] $in
 * @return void
 */
function kx_CLASS_outline( $args ){

	$kxol = new kxol;

	return $kxol->kxol_Main( $args );
}



/**
 *
 * @param [type] $arr
 * @return void
 */
function kx_CLASS_SCP( $args ){

	//return new kxscp( $args )->get();

	//echo '+';

 	//$kxscp = (new kxscp2('TEST'))->get();
	//$kxscp = new kxscp2('TEST');
	//echo $kxscp->get();

	return (new kxscp($args))->get();

	//$kxscp = new kxscp;
	//return $kxscp->kxscp_Main( $args );
}




/**
 * 投稿IDに基づいてテキストデータを生成・保存するエクスポート関数。
 *
 * - 指定された投稿ID群からテンプレートに従ってテキストを生成。
 * - 生成されたテキストをローカルディレクトリに保存。
 * - 文字数が多い場合は分割保存処理を実行（3万文字以上）。
 * - 特定ID（除外対象）を分割対象から除外し、別ファイルとして保存。
 * - 分割時には指示文を自動挿入し、処理状況を明示。
 *
 * @param array $args POSTデータを模した連想配列。
 *                    - 'ids' (string): 投稿IDのカンマ区切り文字列（必須）
 *                    - 'ids_add' (string): 追加ID（checkbox_ids_addが有効な場合）
 *                    - 'template_id' (int|null): 使用するテンプレートID
 *                    - 'post_id' (int): タイトル取得用の代表投稿ID
 *                    - 'simple_join' (bool): 単純結合モードの有無
 *                    - 'checkbox_text_change' (bool|int): テキスト変換オプション
 *
 * @return void
 *
 * 注意点:
 * - 保存先は `D:/00_WP/Export/` に固定。
 * - `kx_generate_post_texts()` は投稿ID配列とテンプレート情報を元にテキストを生成する外部関数。
 * - 分割ファイルには待機指示や完了指示などの制御文が自動挿入される。
 */
function kx_export_text(array $args) {
  // 必須チェック
  if (empty($args['ids'])) {
      echo 'ERROR-IDsなし';
      return;
  }

  // 初期化
  $ids = $args['ids'];

  $str = '';

	if (!empty($args['template_id']) && is_numeric($args['template_id']))
	{
		//$args['checkbox_ids_add']= 1;
		$str_ids_add = $args['template_id'] . ',' . $ids;
		//echo $str_ids_add;
	//}
  // 追加IDが指定されている場合
  //if (!empty($args['checkbox_ids_add'])) {
		$template_id = $args['template_id'] ?? null;

		$ids = $str_ids_add;
		$str .= 'template_ID：' . $template_id . '<br>';
  }
	else
	{
		$template_id = null;
	}

  echo "IDs：{$ids}<br>{$str}<hr>";

  // 投稿ID配列化
  $post_ids = explode(",", $ids);
	//var_dump($post_ids);

  // タイトル取得
  $_title = !empty($args['post_id']) ? end(explode('≫', get_the_title($args['post_id']))) : null;

	$simple_join = ($args['template_id'] == 'simple');



  /*
	$checkbox_text_change = (!empty($args['checkbox_ids_add'])) ? ($template_id == 134 ? 134 : 1) : null;
	//通常型LLM用
	if (empty($checkbox_text_change) && !empty($args['checkbox_text_change']))
	{
		$checkbox_text_change = $args['checkbox_text_change'];
  }
	*/
	$checkbox_text_change = !empty($args['checkbox_text_change']) ? $args['checkbox_text_change'] : null;


	//var_dump($post_ids);
  // テキスト生成
  $output_text = kx_generate_post_texts($post_ids, $template_id, $_title, $simple_join, $checkbox_text_change);

  // 保存設定
  $save_directory = "D:/00_WP/Export/";
  $datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
  $filename = "WPtexts_" . $datetime->format("Ymd_His") . "_id：" . ($args['post_id'] ?? 'unknown') . "_{$_title}.txt";
  $file_path = $save_directory . $filename;

  if (!file_exists($save_directory)) {
		mkdir($save_directory, 0755, true);
  }

  file_put_contents($file_path, $output_text);
  echo "データをテキストファイルに保存しました。<br>保存先: {$file_path}<hr>";

  // 状況文追記
  $output_text .= "\n【状況：「分割送信完了」。最優先タスク：「待機指示」を解除。分割送信された内容を統合し内容を確認せよ。出力は、分割を統合し取得した［ID_番号］のみとする】";

  // 分割処理（3万文字以上）

	if(!empty( $args['ai_select']))
	{
		$_ai_select = [
			'gemini' => ['max_length' => 30000 , 'name'=> 'Google_Gemini_'] ,
			'grok'   => ['max_length' => 50000 , 'name'=> 'X_Grok_'],
		];

		$max_length_array_base = $_ai_select[ $args[ 'ai_select' ] ];
		$max_length = $max_length_array_base['max_length'];

	if (mb_strlen($output_text, 'UTF-8') > $max_length) {
		kx_handle_text_splitting($post_ids, $template_id, $_title, $simple_join, $checkbox_text_change, $save_directory, $datetime , $max_length_array_base );
	}
	}
	else
	{
		echo '分割無し';
	}
}




/**
 * 長文テキストを分割し、複数のファイルに保存する処理を行います。
 *
 * 主に kx_generate_post_texts() によって生成されたテキストが
 * 指定された最大文字数（例：30,000文字）を超える場合に、
 * 投稿IDごとに分割し、分割指示文を付加したファイルとして保存します。
 * また、除外対象のID（例：11181, 11182）を個別ファイルとして保存します。
 *
 * @param array $post_ids 投稿IDの配列（分割対象）
 * @param int|null $template_id 使用するテンプレートID（null可）
 * @param string|null $_title 出力ファイル名に使用するタイトル（null可）
 * @param bool $simple_join テキスト結合モードのフラグ
 * @param int|null $checkbox_text_change テキスト変換オプション（1 または テンプレートID）
 * @param string $save_directory 保存先ディレクトリのパス（例：D:/00_WP/Export/）
 * @param DateTime $datetime ファイル名に使用する日時オブジェクト（Asia/Tokyo）
 *
 * @return void
 */
function kx_handle_text_splitting($post_ids, $template_id, $_title, $simple_join, $checkbox_text_change, $save_directory, $datetime,$max_length_array) {

	$export_text = KxSu::get('export_text');

	$exclude_ids = $export_text['exclude_ids'];
	$original_ids = $post_ids;

	// 除外処理
	$post_ids = array_values(array_filter($post_ids, fn($id) => !in_array($id, $exclude_ids)));
	$excluded_found = array_intersect($original_ids, $exclude_ids);

	if (!empty($excluded_found)) {
			echo "除外されたID: " . implode(', ', $excluded_found) . '<hr>';
	}


	$exclude_ids = [$template_id];

	$post_ids = array_filter($post_ids, function ($id) use ($exclude_ids) {
			return !in_array($id, $exclude_ids);
	});

	$original_ids = array_filter($original_ids, function ($id) use ($exclude_ids) {
			return !in_array($id, $exclude_ids);
	});

	$_endID = end($post_ids);

	$_text_template_A = "・ここまでのスレッドにおいてLLMが認識できている「全体資料」の［ID_番号］を確認。出力形式：上記の「全体資料」のid番号とPost_titleのみ表示。\n全体資料が確認できない場合はタスク停止を厳命。\n";

	// 初期化
	$p = 1; // パート番号
	$current_length = 0;
	$output_text = '';
	$is_new_part = true; // 新しいパートの先頭かどうか

	foreach ($post_ids as $id) {
			// 新しいパートの開始時に必ずヘッダーを挿入
			if ($is_new_part) {
					$part_header = build_part_header($p, $_text_template_A);
					$output_text .= $part_header;
					$current_length += mb_strlen($part_header, 'UTF-8');
					$is_new_part = false;
			}

			// まずテキスト生成
			$text = kx_generate_post_texts([$id], null, $_title, $simple_join, $checkbox_text_change);
			$text_length = mb_strlen($text, 'UTF-8');

			// 追加前チェック：超えるなら「今のパートを保存」して「新しいパートのヘッダー」を即挿入し、このidのテキストを新パートに追加
			if ($current_length + $text_length > $max_length_array['max_length']) {
					// いまのパートを保存（このidはまだ含めない）
					$filename = "WPtexts_" . $max_length_array['name'] . $datetime->format("Ymd_His") . "_part{$p}.txt";
					file_put_contents($save_directory . $filename, $output_text);
					echo "分割ファイル保存: {$save_directory}{$filename}<br>";

					// 新パートに切り替え
					$p++;
					$output_text = '';
					$current_length = 0;

					// 新パートのヘッダーを先頭に必ず入れる
					$part_header = build_part_header($p, $_text_template_A);
					$output_text .= $part_header;
					$current_length += mb_strlen($part_header, 'UTF-8');
					// continue; は使わない。ここで同じ $id の text を「新パート」に追加する。
			}

			// テキスト追加（超えない場合、または新パートに切り替えてからの追加）
			$output_text .= $text;
			$current_length += $text_length;

			// 最終IDに到達したら即保存（追記コメントを入れる場合はここで出力_textに追加してから保存）
			if ($id == $_endID) {

					$filename = "WPtexts_" . $max_length_array['name'] . $datetime->format("Ymd_His") . "_part{$p}.txt";
					file_put_contents($save_directory . $filename, $output_text);
					echo "分割ファイル保存: {$save_directory}{$filename}<br>";

					// 保存後はクリア（後続の安全保存で二重保存を避ける）
					$p++;
					$output_text = '';
					$current_length = 0;
					// ここで break してもよいが、念のためこのままループを自然終了させる
			}
	}

	// 念のため、ループ終了後に残りがあれば保存（安全策）
	if ($output_text !== '') {
			$filename = "WPtexts_" . $max_length_array['name'] . $datetime->format("Ymd_His") . "_part{$p}.txt";
			file_put_contents($save_directory . $filename, $output_text);
			echo "分割ファイル保存: {$save_directory}{$filename}<br>";
			$p++;
	}





	$output_text = '';
	foreach ($excluded_found as $id) {
			$output_text .= "タスク1：";
			$output_text .= $_text_template_A;
			$output_text .= "タスク2：［ID_x］以下を全体資料に追加。\n出力形式・全体資料の［ID_番号］のみで出力。\n\n";
			$output_text .= kx_generate_post_texts([$id], null, $_title, $simple_join, $checkbox_text_change);
			$filename = "WPtexts_".$max_length_array['name'] . $datetime->format("Ymd_His") . "_part{$p}_ID_{$id}.txt";
			file_put_contents($save_directory . $filename, $output_text);
			echo "分割ファイル保存: {$save_directory}{$filename}<br>";
			$p++;
	}



	$output_text = '';
	if(!empty($template_id))
	{
		$output_text .= "タスク1：以下の［ID_番号］が全体資料に存在するか確認。存在しない場合は、スレッド全体のユーザーの投稿を分析し取得し全体資料に統合せよ。\n";
		foreach($original_ids as $id)
		{
			$output_text .= "［ID_$id ］\n";

			if( $id >= 10 && $id <= 19 )
			{
				$_why[]= $id;
			}
			elseif( $id >= 20 && $id <= 9999 )
			{
				$_how[]= $id;
			}
			else
			{
				$_what[]= $id;
			}

			foreach( $export_text['important'] as $key => $_important_type){

				foreach( $_important_type as $_value_id){

					if( $key == '1st')
					{
						if( $_value_id == $id)
						{
							$_important1[] = $id;
						}
					}
					else
					{
						if( $_value_id == $id ||
								(preg_match('/^\d{4}\d$/', $id) && preg_match('/^'.$_value_id.'\d$/' , $id)  ))
						{
							$_important2[] = $id;
						}
					}
				}
			}
		}



		$output_text .= "合計：".count($original_ids)."\n\n";
		$output_text .= "タスク1出力形式：上記リストの番号が、すべて統合され、全体資料内に存在するか否かの確認のみ。\n全idが存在しない場合はタスク2移行の実行を禁止し、タスク停止を厳命\n\n";

		$output_text .= "タスク2：出力形式：全体資料内に存在する［ID_番号］とPost_titleを出力。番号と確認できたidの合計数のみ出力。\n\n";


		$output_text .= "タスク3：";
		$output_text .= "目的：「全体資料」の調整とスレッド条件の提示。\n";
		$output_text .= "出力形式：";
		$output_text .= "調整と条件の確認できたかの回答だけでOK（100文字以内）\n\n";

		if(!empty( $_why))
		{
			$output_text .= "タスク4：";
			$output_text .= "目的：ゴールンでサークルの割当。\n";
			$output_text .= "Why：";

			foreach($_why as $id)
			{
				$output_text .= "［ID_$id ］,";
			}

			$output_text .= "\n";
			$output_text .= "How：";
			foreach($_how as $id)
			{
				$output_text .= "［ID_$id ］,";
			}

			$output_text .= "\n";
			$output_text .= "What：";

			if(!empty( $_what))
			{
				foreach($_what as $id)
				{
					$output_text .= "［ID_$id ］,";
				}
			}
			$output_text .= "\n\n";
		}

		$output_text .= "タスク5：";
		$output_text .= "目的：重要、最重要の割当。\n";

		unset($id);

		$output_text .= "最重要：";
		if(!empty($_important1))
		{
			foreach( $_important1 as $id){
				$output_text .= "［ID_$id ］,";
			}
		}

		$output_text .= "\n";
		$output_text .= "重要：";
		if(!empty($_important2))
		{
			foreach( $_important2 as $id){
				$output_text .= "［ID_$id ］,";
			}
		}

		$output_text .= "\n\n";

		$output_text .= kx_generate_post_texts([$template_id], $template_id , $_title, $simple_join, $checkbox_text_change);

		$filename = "WPtexts_" .$max_length_array['name']. $datetime->format("Ymd_His") . "_part{$p}_template_{$template_id}.txt";
			file_put_contents($save_directory . $filename, $output_text);
			echo "分割ファイル保存: {$save_directory}{$filename}<br>";
			$p++;
	}
	echo '<hr>';

}



/**
 * header用
 *
 * @param integer $p
 * @param string $_text_template_A
 * @return string
 */
function build_part_header(int $p, string $_text_template_A): string {
    $header  = "タスク：\n";
    if ($p === 1) {
        $header .= "・［ID_x］以下の資料は、［ID_番号］ごとに一つの情報として認識せよ。\n";
        $header .= "・LLMは［ID_x］以下をこのスレッドで使う資料として、「全体資料」という名前で認識。\n\n";
        $header .= "出力形式：LLMが認識した「全体資料」を構成する［ID_番号］とPost_titleのみ表示。\n";
        $header .= "id番号やPost_titleが認識できない場合は不明と回答せよ。（名称のみでよい）。\n\n";
    } else {
        $header .= "・1\n";
        $header .= $_text_template_A;
        $header .= "・2\n";
        $header .= "・［ID_x］以下を全体資料に追加。\n";
        $header .= "・［ID_x］以下の資料は、［ID_番号］ごとに一つの情報として認識せよ。\n";
        $header .= "出力形式：LLMが認識している「全体資料」を構成する［ID_番号］とPost_titleのみ表示。\n\n";
    }
    return $header;
}








/**
 * kx_format検出
 *
 * @param string $id
 * @return array 	format_on , id_f , id_sc , id_arr , format_s_cut
 */
function kx_format_on( $id ){

	$_result = kx_db1( ['id' => $id ] , 'SelectID' );

	if( !empty( $_result['BaseID'] ))
	{
		$_array =  [
			'BaseID'			=> $_result['BaseID'],
			//'id_sc'					=> $id,
			//'id_f'					=> $matches[1],
			//'id_arr'
			//'format_s_cut'	=> $format_s_cut,
		];
	}
	elseif( !empty( $_result['GhostON'] ))
	{
		$_array =  [
			'GhostON'			=> $_result['GhostON'],
			//'base_id'       => $_result['GhostON'],
			//'id_sc'					=> $id,
			//'id_f'					=> $matches[1],
			//'id_arr'				=> $array,
			//'format_s_cut'	=> $format_s_cut,
		];
	}
	else
	{
		$_array = [];
	}
	return $_array;

	$_content	= get_post( $id )->post_content;
	if( preg_match('/\[kx_format.*id=(\d{1,})\]/',$_content,$matches )) //formatSCがある。
	{

		return;


		$array = kx_db1(
		[
			'id' => $matches[1],
			'sc_id' => $id,
		] , 'format_SC' );

		print_r($array);

		$_format_on = 1;
		return [
			'format_on'			=> 1,
			'id_sc'					=> $id,
			'id_f'					=> $matches[1],
			'id_arr'				=> $array,
			//'format_s_cut'	=> $format_s_cut,
		];
	}
	else //通常。idで検索。
	{
		$array = kx_db1([	'id' => $id ] , 'id' );
	}

	return;

	if ( !empty( $_format_on ) )
	{
		$_on	= 'base';
		$id_sc = $id;
		$id_arr = $base_id;
	}
	elseif( !empty( $_SESSION[ $id.'format' ] ) )
	{
		$_content	= get_post( $id )->post_content;

		if(	preg_match( '/\[kx_format.*t=one_way.*\]/' , $_content ,$matches ) )
		{
			$_on	='one_way';
		}
		elseif(	preg_match( '/\[kx_format.*\]/' , $_content ,$matches ) )
		{
			$_on	= 'ghost';
		}
		else
		{
			$_on	=1;
		}

		$id_f	= $_SESSION[$id.'format'];
		$format_s_cut	= '×';
	}
	else
	{
		$_content	= get_post( $id )->post_content;

		if( preg_match ('/\[kx_format.*t=one_way.*\]/' , $_content ,$matches ) )
		{
			$_on	= 'one_way';

			preg_match ('/(?<=id=)(\d{1,9})(?=.*\])/' , $matches[0] ,$matches );
			$id_f	= $matches[0];
			$_SESSION[$id.'format'] = $id_f;
			$format_s_cut	= '─';
		}
		elseif( preg_match ('/\[kx_format.*\]/' , $_content ,$matches ) )
		{
			$_on	= 'ghost';

			if( preg_match ('/(?<=id=)(\d{1,9})(?=.*\])/' , $matches[0] , $matches ) )
			{
				$id_f	= $matches[0];
				$_SESSION[ $id . 'format' ] = $id_f;
			}

			$format_s_cut	= '─';
		}
		elseif( preg_match ('/\[kx_format.*\]/' , $_content ,$matches ) )
		{

			$_on	=1;

			preg_match ('/(?<=id=)(\d{1,9})(?=.*\])/' , $matches[0] ,$matches );
			$id_f	= $matches[0];
			$_SESSION[$id.'format'] = $id_f;
			$format_s_cut	= '─';

			//echo $_SESSION[$id.'format'] .'/'.$id;
		}
	}

	if( empty( $_on ) )
	{
		$_on = NULL;
	}


	if( empty( $id_sc ) )
	{
		$id_sc = NULL;
	}


	if( empty( $id_arr ) )
	{
		$id_arr = NULL;
	}


	if( empty( $id_f ) )
	{
		$id_f = NULL;
	}

	if( empty( $format_s_cut ) )
	{
		$format_s_cut = NULL;
	}

	return [
		'format_on'			=> $_on,
		'id_sc'					=> $id_sc,
		'id_f'					=> $id_f,
		'id_arr'				=> $id_arr,
		'format_s_cut'	=> $format_s_cut,
	];
}




/**
 * 指定された投稿の本文を、ID配列に基づいて再生成し、差分がある場合のみ更新する。
 *
 * 投稿の先頭に「タグ：」行が存在する場合は保持し、それ以外の本文部分のみを置き換える。
 * 差分判定はタグ行を含む全体で行う。
 *
 * @param int   $post_id 投稿ID。対象は post_type が 'post' のみ。
 * @param array $ids     本文生成に使用するID配列。kx_generate_post_texts() に渡される。
 *
 * @return void
 */
function kx_maybe_update_post_content( $post_id, $ids ) {

    $post = get_post( $post_id );

    $new_body = kx_generate_post_texts($ids,'','','tougou_update');

    if ( ! $post || $post->post_type !== 'post' ) {
        error_log( "Invalid post ID or type: $post_id" );
        return;
    }

    $current_content = $post->post_content;

    // タグ行を抽出（先頭行が「タグ：」で始まる場合）
    if ( preg_match( '/^(タグ[:：].*?)(\r?\n|\r)/u', $current_content, $matches ) ) {
        $tag_line = $matches[1];
        $separator = $matches[2];
        $updated_content = $tag_line . $separator . $new_body;
    } else {
        $updated_content = $new_body;
    }

    //echo $current_content;
    //echo '++';

    // 差分判定は「全体」で行う（タグ行＋本文）
    if ( $current_content !== $updated_content ) {
        kx_update_post( 2, $post_id, $updated_content );
    } else {
        error_log( "No update needed for post ID: $post_id" );
    }
}







/**
 * 指定された投稿ID群に対して、タイトルと本文を整形し、テキストとして出力する。
 *
 * 投稿本文内の特定ショートコード（[raretu], [kx_format]）を検出し、
 * それに応じたコンテンツ抽出処理を行う。整形後のテキストは用途に応じて
 * タイトル付き／本文のみ／LLM指示付きなどの形式で出力される。
 *
 * @param array $post_ids 投稿IDの配列（整数または文字列）
 * @param int|null $template_id テンプレートとして扱う投稿ID（該当IDにはLLM指示を付加）
 * @param string|null $_title テンプレート投稿のタイトル（LLM指示用）
 * @param bool $simple_join trueの場合、タイトルやラベルを省略し本文のみを連結する
 *
 * @return string 整形済みの投稿テキスト（複数投稿分を連結）
 *
 * @global WP_Post[] WordPressの投稿オブジェクトにアクセス
 * @global callable kx_title_end_format タイトル整形関数（末尾処理）
 * @global callable kx_db1 投稿関連情報取得関数（ID指定）
 *
 * @note 投稿本文からショートコードを除去し、HTMLタグや不要なラベルも排除する。
 *       特定ショートコードが存在する場合は、関連投稿の本文を代替として使用。
 *       テンプレートIDに一致する投稿には、LLM指示文を付加して出力。
 */
function kx_generate_post_texts($post_ids, $template_id = null, $_title = null, $simple_join = false , $checkbox_text_change = null) {

	// --- ソート処理 開始 ---
    if (!empty($post_ids) && is_array($post_ids)) {
        $sort_map = [];
        foreach ($post_ids as $id) {
            // タイトルを取得してソート用のマップを作成
            $sort_map[$id] = get_the_title($id);
        }
        // 値（タイトル）に基づいて昇順ソート（自然順序/日本語対応）
        asort($sort_map, SORT_NATURAL | SORT_FLAG_CASE);
        // ソート済みのキー（ID）を元の変数に戻す
        $post_ids = array_keys($sort_map);
    }
    // --- ソート処理 終了 ---

    //var_dump(count($post_ids));
    $output_text = "";

		//echo '<hr>+1'.$simple_join.'<hr>';
		//var_dump(count($post_ids));

    foreach ($post_ids as $id) {
        kx_dbX( [ 'id' => $id ] , 'feed_dy' );

        $post = get_post($id);
        //echo $id.'+';

        if (!$post) continue;

        // --- ヘッダー生成部分 省略 ---
        if (!$simple_join && (empty($template_id) || $id != $template_id)) {
            $output_text .= "\n___\n";
            $output_text .= "［ID_$id ］\n";
            $output_text .= "Post_title: " . kx_title_end_format($post->post_title) . "\n";
        }

        //介入
        if($simple_join)
        {
            $post->post_content = preg_replace('/___/','',$post->post_content);
        }

        // コンテンツ抽出ロジック
        // 1. まずキャッシュ(db_kx1)からShortCODEを確認
        $cache_kx1 = Dy::get_content_cache($id, 'db_kx1');
        $is_raretu = false;
        $summary_id = null; // 概要IDを格納する変数
        $is_kx_format = false; // kx_format判定フラグ
        $ghost_id = null;      // GhostON IDを格納する変数

        if (isset($cache_kx1['json'])) {
            $json_data = is_array($cache_kx1['json']) ? $cache_kx1['json'] : json_decode($cache_kx1['json'], true);

            $shortcode = $json_data['ShortCODE'] ?? '';

            if ($shortcode === 'raretu') {
                $is_raretu = true;
                $summary_id = $json_data['概要'] ?? null;
            }
            // ★キャッシュからkx_formatとGhostON IDを直接抽出
            elseif ($shortcode === 'kx_format') {
                $is_kx_format = true;
                $ghost_id = $json_data['GhostON'] ?? null; // テーブルの"GhostON"キーを参照
            }
        }

        /*if (preg_match('/\[raretu(?:\s+[^\]=]+=[^\]]+)?\]/', $post->post_content)) {
            $_result = kx_db1(['id' => $id], 'SelectID');
            $_content = !empty($_result['概要']) ? get_post($_result['概要'])->post_content : '';
        } elseif (preg_match('/\[kx_format\s+id=(\d+)(?:\s+[^\]]+)?\]/', $post->post_content, $matches)) {
            $_content = get_post(intval($matches[1]))->post_content;
            //echo $matches[1].'<br>';
            if ( kx_tougou_Check($matches[1])) {
                $_content =  kx_tougou_update($matches[1]);
            }
        */

        if ($is_raretu) {
            $_content = !empty($summary_id) ? get_post($summary_id)->post_content : '';
            //$_result = kx_db1(['id' => $id], 'SelectID');
            //$_content = !empty($_result['概要']) ? get_post($_result['概要'])->post_content : '';
        }
        // キャッシュ情報を優先し、正規表現をスキップ
        elseif ($is_kx_format && !empty($ghost_id)) {
            $_content = get_post(intval($ghost_id))->post_content;

            // 統合チェック（ここは既存ロジックを維持）
            if (kx_tougou_Check($ghost_id)) {
                $_content = kx_tougou_update($ghost_id);
            }
        }
        // キャッシュに情報がない場合のみ、重い正規表現チェックを行う（フォールバック）
        elseif (preg_match('/\[kx_format\s+id=(\d+)(?:\s+[^\]]+)?\]/', $post->post_content, $matches)) {
            $_content = get_post(intval($matches[1]))->post_content;
            //echo $matches[1].'<br>';
            if ( kx_tougou_Check($matches[1])) {
                $_content =  kx_tougou_update($matches[1]);
            }
        } else {
            $_content = $post->post_content;

            if ( kx_tougou_Check($id)) {
                $_content =  kx_tougou_update($id);
            }
        }

        // クリーンアップ処理
        //$content_cleaned = preg_replace('/\[[^\]]+\]/', '', $_content);

        $content_cleaned = preg_replace_callback('/\$.*?\$/s', function($matches) {
            return '__LATEX__' . base64_encode($matches[0]) . '__';
        }, $_content);

        $content_cleaned = preg_replace('/\[[^\]]+\]/', '', $content_cleaned);

        $content_cleaned = preg_replace_callback('/__LATEX__(.*?)__/', function($matches) {
            return base64_decode($matches[1]);
        }, $content_cleaned);


        $content_cleaned = preg_replace('/^タグ：.*/', '', $content_cleaned);


        if (!empty($checkbox_text_change)) {
            // 置換対象と置換後の語句を配列で定義
            $search  = ['●','■','◆' ,'▼','□','✤','《','》','少女','sex'   ,'Sex'];
            $replace = ['#','##','###','####','#####','######','**','**','ヒロイン','濡れ場','濡れ場'];

            // 出力テキストに対して置換を実行
            $content_cleaned = str_replace($search, $replace, $content_cleaned);
            $content_cleaned = preg_replace('/\d{1,}歳|（(小|中)(\d)）/','〻ヽ',$content_cleaned);

            if( $checkbox_text_change != 134)
            {
                    $content_cleaned = preg_replace(KxSu::get('base_preg')['timestamp'],'',$content_cleaned);
            }
        }

        $content_cleaned = strip_tags($content_cleaned);

        $content_cleaned = trim($content_cleaned);



        // 出力条件分岐
        if (!empty($template_id) && $id == $template_id && count($post_ids) > 1 ) {
            $output_text .= "LLM指示:\n";
            $output_text .= "スレッドタイトル：" . $_title . "\n\n";
            $output_text .= "目的：LLMが［ID_x］以下を全体資料として認識\n";
            $output_text .= "注意：全体資料は、［ID_番号］ごとに一つの情報として認識せよ。\n\n";
            $output_text .= $content_cleaned . "\n\n";
        } elseif ($simple_join) {
            $output_text .= $content_cleaned . "\n";
            if ($simple_join == 'tougou_update' )
            {
                $output_text .= "\n";
            }
        } else {
            $output_text .= "内容:\n" . $content_cleaned . "\n\n";
        }
    }

    return $output_text;
}




/**
 * テキスト出力ボタン生成関数。LLM用。
 * @param array $ids 出力対象のID配列
 * @param int|null $post_id 元ページのID（省略可）
 * @param string|null $button_label ボタンラベル（件数表示など）
 */
function kx_render_export_text_button( array $ids, int $post_id, ?string $button_label = null,$type = null) {

  //エラー
	if ( empty( $ids ) ) return;

	$_post_title = get_the_title($post_id);

	// 投稿ID配列 $ids から、特定のタイトルパターンに一致する投稿を除外する
	$ids = array_filter($ids, function($id) use ($_post_title) {
			// 投稿IDからタイトルを取得
			$_title = get_the_title($id);

			// タイトルが「$_post_title(ポストタイトル直下の場合のみ)≫00-00＠統合概要」で始まる場合は除外する
			// preg_quote により $_post_title 内の記号を正規表現用にエスケープ
			return !preg_match('/^' . preg_quote($_post_title, '/') . '≫(00-00＠.*統合概要|関連)$|nollm/i', $_title);
	});


	$ids = array_values($ids); // インデックスを振り直す

  $str_ids = implode(',', $ids);
  $count   = count($ids);

  // 元ページのID hidden追加
  $post_id_input = '';
  if ( !empty($post_id) ) {
    $post_id_input = '<input type="hidden" name="post_id" value="' . esc_attr($post_id) . '">';
  }


	$export_text_map = KxSu::get('export_text')['map'];
	//$export_text_map = $export_text['map'];


	$_color = 'hsl(30, 100%, 50%)'; //


	/*
	if(is_array($type) && !empty($type['tougou'])  )
	{
		$_str_add .= '＋自動統合<br>';
		kx_maybe_update_post_content( $type['tougou'], $ids );
	}
	*/
	//$_str_simple_join  = '';


	// 条件：KxSu::get('export_text')のidにpost_idが存在し、チェックがONの場合
	if (
    (isset($export_text_map[$post_id]) && $export_text_map[$post_id] === 'simple_join') ||
		$type === 'simple' ||
    preg_match('/^∬/i', $_post_title)||
		//preg_match('/∬\d{2}≫c\d.*≫2構成≫Series/i', $_post_title) ||
    preg_match('/Μ≫AI駆動≫.*固定入力/i', $_post_title)
	)
	{
    $_promptID = 'simple';
	}
	else
	{
		//$_str_simple_join  = '<div>';
		//$_str_simple_join .= '<input type="checkbox" name="simple_join" value="1">単純結合';
		//$_str_simple_join .= '</div>';
		if (isset($export_text_map[$post_id])) {
			$_promptID = $export_text_map[$post_id];
			$_color = 'hsl(0, 100%, 50%)'; // #FF00FF - マゼンタ
		}
		elseif (preg_match('/Ksy|Ygs|Olf|S11/i',$_post_title) ) //in_array(10, $ids, true) && in_array(100000, $ids, true)
		{
			$_promptID = 10104;
			$_color = 'hsl(270, 100%, 50%)'; // #DA70D6 - オーキッド

			$ids = array_values($ids); // インデックスを振り直す

			$str_ids = implode(',', $ids);
			$count   = count($ids);

			//$_str_add2 .= '★サンプル削除';
		}
		elseif (in_array(10, $ids, true))
		{
			$_promptID = 10103;
			$_color = 'hsl(270, 50%, 70%)'; // #CC50D6 - カスタムパープル
		}
		elseif (has_term(86, 'category', $post_id)) {
			$_promptID = 10134;
			$_color = 'hsl(42, 100%, 50%)'; // #FFB300 - 濃いオレンジ
		}
		else {
			$_promptID = 10102;
			$_color = 'hsl(150, 100%, 50%)'; // #00FF7F - スプリンググリーン
		}
	}

	//$id_add = $_promptID;
	//$str_ids_add = $_promptID .','.$str_ids;

	$_str_add  = '<div style="font-size:14pt; color:#66ccff;padding:5px;">TEXT出力</div>';

	if( $_promptID == 'simple')
	{
		$_str_add .= '<input type="hidden" name="simple_join" value="1">';
	}


	$_str_add .= '<div style="color:' . esc_attr($_color) . ';">';
	//$_str_add .= get_the_title($_promptID).'<br>';

	//$_str_add .= '<input type="checkbox" name="checkbox_ids_add" value="1" checked>';
	//$_str_add .= '<input type="hidden" name="ids_add" value="' . esc_attr($str_ids_add) . '">';
	//$_str_add .= '<input type="hidden" name="template_id" value="' . esc_attr($id_add) . '">';
	//$_str_add .= 'Template-付加：ID' . $id_add . '<br>' . get_the_title($id_add) ;

	// 自動判定された $_promptID を決定するロジックはそのまま
	// ...




	$_str_add .= '<div style="color:' . esc_attr($_color) . ';">';
	//$_str_add .= '<input type="checkbox" name="checkbox_ids_add" value="1" checked>';
	//$_str_add .= '<input type="hidden" name="ids_add" value="' . esc_attr($str_ids_add) . '">';

	// ★ここを select に変更
	$_str_add .= '<label for="template_id">プロンプト選択：</label>';
	$_str_add .= '<select name="template_id" id="template_id">';

	// プロンプト候補一覧
	$template_options = [
			'simple'  => '単純結合',
			'none'    => 'プロンプトなし',
			10101     => '101：個別',
			10102     => '102：連続',
			10103     => '103：複雑',
			10104     => '104：ゴールデン・サークル',
			10134     => '134：教訓統合',
			10140     => '140：レポート化',
	];

	// 初期選択は自動判定された $_promptID
	foreach ($template_options as $tid => $label) {
			$selected = ((string)$tid === (string)$_promptID) ? ' selected' : '';
			$_str_add .= '<option value="' . esc_attr($tid) . '"' . $selected . '>' . esc_html($label) . '</option>';
	}

	$_str_add .= '</select>';

	// 表示用に現在の自動判定結果も補足
	//$_str_add .= '<br>Template-付加：ID' . $id_add . '<br>' . get_the_title($id_add);
	$_str_add .= '</div>';




	$_str_add .= '</div>';
	//$_str_add .= $_str_simple_join;



	$_str_add .= '<div>';
	$_str_add .= '<input type="checkbox" name="checkbox_text_change" value="1" checked>テキスト置換';
	$_str_add .= '</div>';

	$_str_add .= '<div>';
	$_str_add .= '<div>';
	$_str_add .= '<label for="ai_select">AI選択：</label>';
	$_str_add .= '<select name="ai_select" id="ai_select">';
	$_str_add .= '<option value="gemini">Gemini</option>';
	$_str_add .= '<option value="grok">Grok</option>';
	$_str_add .= '</select>';
	$_str_add .= '</div>';
	$_str_add .= '</div><hr>';

	//$_str_add .= 	$_str_add2;
	//$_str_add .= '<br>';

	// ラベルが指定されていなければ件数付きデフォルトラベル
	if ( $button_label === null ) {
		$button_label = "データをテキストに出力：{$count}";
	}


  $ret =  <<<HTML
  <form
    method="post"
    action="wp-content/themes/kasax_child/lib/php/export_text.php"
    style="text-align:left;margin-left:10px;"
    target="_blank"
		>
		<input type="hidden" name="ids" value="{$str_ids}">
    {$post_id_input}
		{$_str_add}
    <button class="_op_a" type="submit">{$button_label}</button>
  </form>
	<div style="width:400px; word-wrap:break-word; white-space:normal;">
    {$str_ids}
	</div>

HTML;

  return str_replace(["\n", "\r"], '', $ret);
}


/**
 * テキスト出力ボタン生成関数。LLM用。
 * @param array $ids 出力対象のID配列
 * @param int|null $post_id 元ページのID（省略可）
 * @param string|null $button_label ボタンラベル（件数表示など）
 */
function kx_render_export_singletext_button( $post_id) {

	$str_ids  = $post_id;

	$export_text_map = KxSu::get('export_text')['map'];

	// 元ページのID hidden追加
  $post_id_input = '';
  if ( !empty($post_id) ) {
    $post_id_input = '<input type="hidden" name="post_id" value="' . esc_attr($post_id) . '">';
  }

	$_str_add  = '';
	if (isset($export_text_map[$post_id]) && is_int($export_text_map[$post_id])) {
		$_template_id  = $export_text_map[$post_id];
		$button_label = '指定型：'.$export_text_map[$post_id].'：ID'.$str_ids;
	}
	else{
		$_template_id = 10101;
		$button_label = '個別型：'.$str_ids;
	}

	// 初期値は必ず none に固定
    $_template_base = 'none';
    $button_label = '通常型：'.$str_ids;

 $template_options = [
        'none'          => 'プロンプトなし',
				10101           => '101：個別',
        $_template_id   => $button_label,
    ];


	$str_ids  = $post_id ;
	$str_ids_add  = $_template_id .',' . $post_id ;
	//$_str_add .= 'プロンプト追記<input type="checkbox" name="checkbox_ids_add" value="1">：';
	//$_str_add .= '<input type="hidden" name="template_id" value="none">';
	$_str_add .= '置換<input type="checkbox" name="checkbox_text_change" value="1" checked><br>';
	$_str_add .= '<input type="hidden" name="ids_add" value="' . esc_attr($str_ids_add) . '">';
	//$_str_add .= '<input type="hidden" name="template_id" value="' . esc_attr($_template_id) . '">';

	 // ★ select を追加
	$_str_add .= '<label for="template_id">プロンプト選択：</label>';
	$_str_add .= '<select name="template_id" id="template_id">';
	foreach ($template_options as $tid => $label) {
        $selected = ((string)$tid === (string)$_template_base) ? ' selected' : '';
        $_str_add .= '<option value="' . esc_attr($tid) . '"' . $selected . '>' . esc_html($label) . '</option>';
    }
	$_str_add .= '</select>';



  $ret =  <<<HTML
  <form
    method="post"
    action="wp-content/themes/kasax_child/lib/php/export_text.php"
    style="text-align:left;margin-left:10px;"
    target="_blank"
		>
		<input type="hidden" name="ids" value="{$str_ids}">
		{$post_id_input}
		{$_str_add}
    <button class="_op_a" type="submit">{$button_label}</button>
  </form>
HTML;

  return str_replace(["\n", "\r"], '', $ret);
}



// WordPress側のコード例
/**
 * Laravel API 経由でタイトル検索を実行し、該当する投稿ID群を取得する。
 * * WordPress側の独自テーマ（kxx等）からLaravel側の機能を呼び出すための
 * ブリッジ（架け橋）関数。HTTP通信（wp_remote_get）を用いて
 * 外部（別ポートで動くLaravel）の検索ロジックを利用する。
 * * @param string $title 検索キーとなるタイトル（WordPressの get_the_title() 等から渡される）
 * @return array 取得したIDの配列。エラー時や該当なしの場合は空配列を返す。
 */
function kxlaravel_test_get_ids_from_laravel($title) {
    //$url = 'http://localhost:8000/api/kxx/ids?title=' . urlencode($title);
		// LAN内の別PCからも利用する場合は http://192.168.1.200:8000 などに書き換えてください
    $url = 'http://localhost:8000/api/kx/hierarchy-ids?title=' . urlencode($title);

    $response = wp_remote_get($url);

    if (is_wp_error($response)) return [];

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // ★重要：Laravel側の return に合わせて ['data']['ids'] を指定
    return $data['data']['ids'] ?? [];
}




/**
 * TEST。2025-12-25
 * 現在のタイトル階層以下のIDリストを取得して表示（raretu等で利用）
 */
function kx_display_child_hierarchy_ids() {
    $current_title = get_the_title(); // 現在のページタイトル取得

    //$url = 'http://localhost:8000/api/kx/hierarchy-ids?title=' . urlencode($current_title);
		$url = 'http://192.168.1.200:8000/api/kx/hierarchy-ids?title=' . urlencode($current_title);
    $response = wp_remote_get($url);

    if (is_wp_error($response)) return;

    $data = json_decode(wp_remote_retrieve_body($response), true);
    $ids = $data['data']['ids'] ?? [];

    if (!empty($ids)) {
        // ID群をカンマ区切りで出力（raretuの引数に渡す想定）
        echo implode(',', $ids);
    } else {
        echo '子階層の記事は見つかりませんでした。';
    }
}

