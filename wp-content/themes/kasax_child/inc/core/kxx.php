<?php
/**
 * D:\00_WP\xampp\htdocs\0\wp-content\themes\kasax_child\inc\core\kxx.php
 */


add_shortcode(	"kx", "kxsc_kx"	);
/**
 * shortcode
 * KXX系 統合ShortCODE】ver2
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_kx( $atts ){
	$arr=
	[
		't'						=> '',	// デフォルト =0
		'id'					=> '',
		'ids'					=> '',	//,でIDを追記。
		'search'			=> '',
		'all'					=> '',
		'cat' 				=> '',
		'cat_not'			=> '',
		'tag'					=> '',
		'tag_not'			=> '',
		'text'				=> '',
		'text_c'			=> '',

		'ppp'					=> '',
		'orderby'			=> '',
		'order'				=> '',
		'auto'				=> '',	//オート用
		'auto_s'			=> '',	//オート、追記検索
		'sys'					=> 'N-A',	//システム補足。Error対策で必要。理由不明。2022-01-26。

		'title_s'			=> '',
		'chara'				=> '',
		'add_edit'		=> '',

		'new_title'		=> '',	//ニュータイトルの各パターン。

		'post_type'		=> '',	//ポストタイプ。

		'new_content' => '',
		'wwr_name'		=> '',	//wwr用名前
		'wfm_end'			=> '',	//作品FORMAT同期終了
		'm'						=> '',	//メモ
		'type'				=> 'Shortcode',

		//'update'			=> '',	//アプデート用
		//'text_add'	=> '',	//タイトル追加。t=1系列。多分使っていない。2022-10-25
		//'l7'				=> '',
		//'big_c'			=> '',	//登録カテゴリーのみ検出
		//'text_l'		=> '',	//t10 ラスト表示。★終了。2019-08-08

	];
	return kx_CLASS_kxx( shortcode_atts( $arr , $atts) );

}



/**
 * kxショートコードメイン。
 * ショートコード外からの入力用。
 *
 * @param array $args
 * @param string $Special_operation
 * @return string
 */
function kx_CLASS_kxx( $args , $Special_operation = null ){

	$kxx = new kxx;

	if( $Special_operation == 'array_ids' )
	{
		//ID配列のみ呼び出し。2023-02-28
		$args[ 't' ] = 2;
		$args[ 'ppp' ] = 99999;
		$str = $kxx->kxx_Main( $args );

		return [ 'strings' => $str , 'array_ids' => $kxx->kxx_arr_id_S ];
	}
	else
	{
		return $kxx->kxx_Main( $args );
	}
}



/**
 * class　＝　KXX
 *
 * Error配列の組み換え要素はjson化済み。2021/09/22
 */
class kxx {

//初期値保存用
public $kxxS0;


//設定用配列。2023-02-28
public $kxxS1	=  //基本は途中代入用。
[
	0							 => 'TEST_kxxS1-Default',
	't'				     => NULL,
	's_cut'				 => 'N/A(kxxS1-Default)',
	'search'  		 => NULL,
	'cat'					 => NULL,
	'cat_not'			 => NULL,
	'catnames'     => NULL,
	'tag'					 => NULL,
	'tag_not'			 => NULL,
	'order'				 => NULL,
	'sys'					 => 'N-A(kxxS1-Default)',	//Error対策で必要。理由不明。2022-01-26
	'CountPattern' => [], //カウントPatternを登録した配列。

	'count_post'   => NULL,
	'chara'        => NULL,
	'update'       => NULL,

	'test' => __FILE__,
];


public $kxxSxx	= //各id別の設定用配列。2023-02-28
[
	0    => 'TEST_Sxx_OK',
	'id' => NULL,
];


public $kxx_arr_id0; //検索結果のID配列。 * 2023-02-27
public $kxx_arr_id_S; //* $Special_operation == 'array_ids'用。 * 2023-02-28
public $kxxError = [ 'type' => NULL ]; //エラー系。


//各種設定。2023-09-05
public $kxxSetting =
[
	'search_str_replace' =>
	[
		'＄'		=> '',
		'￥d'	 => '',
		'￥w'	 => '',
		'＾'		=> '',
		'ver＿' => 'ver_',
	],

	'LIMIT' =>
	[
		'loop' 						=> 350,						//無限ループ対策count。ENDLESS LOOP対策。
		'shortcode'		 		=> 10,						//ショートコードのループ対策。
		'hr_moji_count'		=> 1500 ,					//抜粋用文字カウント。不使用。2022-01-26
	],
];


//判定。
public $kxxJUDGE =
[
	//メイン設定。準備中。対象はt。
	't' =>
	[
		'/./' => //all
		[
			'kxxtype1'   => 'kxx-error',
			'kxxtype2'   => 'kxx-error',
			'orderby' 	=> 'title',
			//'order'			=> 'asc',
			'ppp'				=>	1,
		] ,

		'/^\d$/' =>		//一桁タイプ
		[
			'kxxtype1'   => 'kx00',
			'kxxtype2'   => '00',
			'order'			=> 'asc',
			'ppp'				=>	9,
		],

		'/^1\d$/'	=>
		[
			'kxxtype1'   => 'kx10',
			'kxxtype2'   => '10',
			'order'			=> 'asc',
		],

		'/^2\d$/'	=>
		[
			'kxxtype1'   => 'kx10',
			'kxxtype2'   => '20',
			'order'			=> 'asc',
			'ppp'				=>	9,
		],

		'/^3\d$/'	=>
		[
			'kxxtype1'   => 'kx30',
			'kxxtype2'   => '30',
			'order'			=> 'asc',
		],

		'/^[4-5]\d$/'	=>
		[
			'kxxtype1'   => 'kx40',
			'kxxtype2'   => '40-50',
			'order'			=> 'asc',
		],

		'/^6\d$/'	=>
		[
			'kxxtype1'   => 'kx40',
			'kxxtype2'   => '60',
			'order'			=> 'asc',
		],

		'/^[7-8]\d$/'	=>
		[
			'kxxtype1'   => 'kx40',
			'kxxtype2'   => '80-90',
			'order'			=> 'asc',
		],

		'/^9\d$/'	=>
		[
			'kxxtype1'   => 'kx40',
			'kxxtype2'   => '90',
		],

		'/^9[1-4]$/'	=>
		[
			'orderby'		=> 'modified',
		],

		'/^91$/'	=>
		[
			'ppp'				=>	10,
		],

		'/^92$/'	=>
		[
			'ppp'				=>	20,
		],

		'/^9[3|4]$/'	=> //設定かぶり。2023/08/25
		[
			'ppp'				=>	30,
		],

		'/^9[0|6]$/'	=>
		[
			'order'			=> 'asc',
			'ppp'				=>	999,
		],

		'/^9[8|9]$/'	=>
		[
			'order'			=> 'asc',
			'ppp'				=>	999,
		],

		'/^(0|100)$/' =>
		[
			'kxxtype1'   => 'kx100',
			'kxxtype2'   => '0-100',
			'order'			=> 'asc',
			'ppp'				=>	99,
		],
	],

	'basu' =>
	[
		'/^([1-5]|[7-8] )\d$/' =>
		[
			'basu_on'	=> 1
		] ,
	] ,

	'color' =>
	[
		'/^(0|7)$|^[1-2]\d$|^[4-6]\d$|^7(0|1|7)$|^8(0|7)$|^9([0-4]|6|7)$|^100$/' =>
		[
			'color_on' => 1,
		],
	],

	'list_head' =>
	[
		'/./'=>
		[
			'list_head_on'  => NULL,
			'list_head_css' => NULL,
		],

		'/^[2]\d$|^[7-9]\d$/'=>
		[
			//'css_main'
			'list_head_on'  => 1,
			'list_head_css'	=> '__radius_list_head  __margin_left10 __margin_bottom5',
		],
	],

	'list_foot' =>
	[
		'/./'=>
		[
			'list_foot_on'  => NULL,
			'list_foot_css' => NULL,
		],

		'/[2]\d|^37$/' =>
		[
			'list_foot_on'  => 1,
			'list_foot_css'	=> '__radius_list_foot __margin_bottom1	',
		],
	],
] ;



/**
 * kxxコンテンツ表示のメイン分岐。
 *
 * @param array $args 入力引数
 * @return string 出力HTML
 */
public function kxx_Main( $args ){

	// Laravel TEST 実行して表示
	//$ids = kxlaravel_test_get_ids_from_laravel(get_the_title());
	//echo implode(', ', $ids);


	//初期値保存。2023-02-27
	$this->kxxS0	= $args;

	//各種設定。2023-02-27
	$this->kxx_setting1a();
	$this->kxx_setting1_session();
	$this->kxx_setting1b();
	$this->kxx_setting1_type();

	// 分岐
	if(	!empty( $this->kxxError[ 'type' ] ) )
	{
		//Error出力。2023-02-27
		$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;
		$ret	= kx_CLASS_error( $this->kxxError );
	}
	elseif( !empty( $this->kxxS1[ 'db_input' ] ) && !empty( $this->kxx_arr_id0 ) && is_array( $this->kxx_arr_id0 )	)
	{
		//検索して、DBへの書き込みのみ。2023-02-28

		$this->kxx_category_2();

		//ID配列によるDBのアップデート確認。2023-02-28
		foreach( $this->kxx_arr_id0 as $_id )
		{
			kx_db0( [ 'id' => $_id ] , 'id' );
		}

		return;
	}
	elseif( !empty( $this->kxxS1[ 'id' ] )	)
	{
		//ID指定による直接出力。
		$this->kxxSxx[ 'id' ] = $this->kxxS1[ 'id' ];
		$ret	= $this->kxx_type();
	}
	else
	{
		//上記以外（error、DB、ID）

		//ID配列取得。2023-02-27
		$this->kxx_get_IDs();

		//出力
		$_output	= $this->kxx_output();

		if( !empty( $this->kxxError[ 'type' ] ) )
		{
			//Errorあり。

			if(
				!empty( $this->kxxSxx[ 'ExcerptA' ] )
				&& $this->kxx_arr_id0[ array_search( $this->kxxS1[ 'shortcode_ID' ] , $this->kxx_arr_id0) ] == $this->kxxS1[ 'shortcode_ID' ]
			){
				unset( $_output[0] );
				$_output[0]		.= '<div class="__text_center __xsmall ">';
				$_output[0]		.= '無限ループA：';
				$_output[0]		.= __LINE__;
				$_output[0]		.= get_the_title();
				$_output[0]		.= '</div>';
			}

			if( empty( $_output[ 'foot' ] ))
			{
				$_output[ 'foot' ] = NULL;
			}

			$this->kxxError[ 'output' ] = $_output[0] . $_output[ 'foot' ];
			$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;
			$ret	= kx_CLASS_error( $this->kxxError );
		}
	}

	if(	empty( $ret ) )
	{
		//多い要素。
		if( empty( $_output['head'] ))
		{
			$_output['head'] = NULL;
		}

		if( empty( $_output[ 'foot' ] ))
		{
			$_output[ 'foot' ] = NULL;
		}

		$ret	= $_output['head'] . $_output[0] . $_output[ 'foot' ];
	}


	//ショートコードのカウント戻し。必須（これ以前にreturn不可）。2023/02/28
	KxDy::kxdy_trace_count('kxx_sc_count', -1);



	//post戻し
	if( get_the_ID() != $this->kxxS1[ 'shortcode_ID' ] )
	{
		global $post;
		$post = get_post( $this->kxxS1[ 'shortcode_ID' ] );
		setup_postdata( $post );
	}

	//最終
	if(	!empty( $this->kxxError[ 'type' ] )	)
	{
		//Error有り。
		return $ret;
	}
	else
	{
		return '<span id="anchor' . $_SESSION[ 'anchor' ] . '">'.$ret	.'</span>';
	}
}



/**
 * 初期設定S1
 *
 * @return void
 */
public function kxx_setting1a(){

	//配列統合。2023-02-27
	$this->kxxS1 = $this->kxxS0 + $this->kxxS1;

	//sys要素を追記。2023-02-27
	$this->kxxS1	= kx_shortcode_sys(	$this->kxxS1 );

	//ID保存。最後に戻す用。
	$this->kxxS1[ 'shortcode_ID' ]	= get_the_ID();

	// 編集レベル
	$this->kxxS1['level'] = current_user_can('level_10')
		? 10
		: (current_user_can('editor')
			? 'editor'
			: ''
		);

	/*
		if( current_user_can( 'level_10' ) )
	{
		$this->kxxS1[ 'level' ]	= 10;
	}
	elseif( current_user_can( 'editor' ) )
	{
		$this->kxxS1[ 'level' ]	= 'editor';
	}
	else
	{
		$this->kxxS1[ 'level' ]	= '';
	}*/


	//カラー有無
	$this->kxxS1 = kx_Judge( $this->kxxJUDGE[ 'color' ] , $this->kxxS1[ 't' ] , $this->kxxS1 );



// 検索ワード-調整
	$this->kxxS1['search'] = !empty($this->kxxS1['search'])
    ? str_replace('＞', '≫', $this->kxxS1['search'])
    : $this->kxxS1['search'];

	// post_type調整
	$this->kxxS1['post_type'] = empty($this->kxxS1['post_type'])
		? 'post'
		: $this->kxxS1['post_type'];


	/*
		// 検索ワード-調整
	if ( !empty( $this->kxxS1[ 'search' ] ) )
	{
		$this->kxxS1[ 'search' ]	= str_replace('＞', '≫' , $this->kxxS1[ 'search' ] );
	}

	//post_type調整
	if( empty( $this->kxxS1[ 'post_type' ] ) )
	{
		$this->kxxS1[ 'post_type' ] = 'post';
	}
		*/

	//カラー化text表示用。2023-08-25
	if( !empty( $this->kxxS1[ 'text_c' ] ) && empty( $this->kxxS1[ 'text' ] ) )
	{
		$this->kxxS1[ 'text' ]	= $this->kxxS1[ 'text_c' ];
	}
}



/**
 * セッション関係の初期設定。
 *
 * @return void
 */
public function kxx_setting1_session(){

	// ショートコード深層カウント。
	if( empty( $this->kxxS1['sc_count_no'] ) )
	{
		KxDy::kxdy_trace_count('kxx_sc_count', 1);
	}


	// アンカーカウント
	$_SESSION['anchor'] = !empty($_SESSION['anchor'])	? $_SESSION['anchor'] + 1	: 1;

	/*
	if( !empty( $_SESSION[ 'anchor' ] )	)
	{
		$_SESSION[ 'anchor' ]	++;
	}
	else
	{
		$_SESSION[ 'anchor' ]	=1;
	}
		*/



	//エラーチェック。無限ループ対策。2023-03-01。
	if ( empty( KxDy::get('trace')['kxx_content_count'] ?? 0 ) || !empty( $this->kxxS1[ 'kxtp' ] )  )
	{
		//スルー。抜粋functionで作業。
	}
	elseif( (KxDy::get('trace')['kxx_sc_count'] ?? 0) > $this->kxxSetting[ 'LIMIT' ][ 'shortcode' ] )
	{
		//ショートコード深層上限
		$this->kxxError[ 'type' ]		   = 'sc_count';
		$this->kxxError[ 'comment' ] 	 = '∞：ShortCODE';
		$this->kxxError[ 'memo' ]			 = '無限ループの可能性count：';
		$this->kxxError[ 'memo' ]			.= (KxDy::get('trace')['kxx_sc_count'] ?? 0);
		$this->kxxError[ 'sc_count' ]	.= (KxDy::get('trace')['kxx_sc_count'] ?? 0);
		$this->kxxError[ 'file' ]			 = __FILE__;
		$this->kxxError[ 'function' ]	 = __FUNCTION__;
		$this->kxxError[ 'line' ]			 = __LINE__;
	}
	elseif( (KxDy::get('trace')['kxx_content_count'] ?? 0) > $this->kxxSetting[ 'LIMIT' ][ 'loop' ] )
	{
		//呼び出しカウント上限に到達。2023-03-01。
		$this->kxxError[ 'type' ]				   = 'basu';
		$this->kxxError[ 'comment' ] 			 = '∞：ShortCODE';
		$this->kxxError[ 'memo' ]			 		 = '無限ループ・カウント';
		$this->kxxError[ 'memo' ]				  .= $this->kxxSetting[ 'LIMIT' ][ 'loop' ];
		$this->kxxError[ 'memo' ]				  .= 'オーバー・ショートコード';
		$this->kxxError[ 'SESSION_count' ] = KxDy::get('trace')['kxx_content_count'] ?? 0;
		$this->kxxError[ 'line' ]					 = __LINE__;
		$this->kxxError[ 'file' ]					 = __FILE__;
		$this->kxxError[ 'function' ]			 = __FUNCTION__;

		KxDy::kxdy_trace_count('kxx_content_count', 0);

	}
	elseif( !empty( $this->kxxS1[ 'id' ] ) && $this->kxxS1[ 'id' ] == $this->kxxS1[ 'shortcode_ID' ] && empty( $this->kxxS1[ 'raretu_db' ] ) )
	{
		var_dump($this->kxxS1);
		//自己呼び出しのError

		$this->kxxError[ 'type' ]		 = 'basu';
		$this->kxxError[ 'comment' ] 	 = '自己呼び出しのエラー';
		$this->kxxError[ 'file' ]			 = __LINE__;
		$this->kxxError[ 'function' ]	 = __FUNCTION__;
		$this->kxxError[ 'line' ]			 = __LINE__;
		$this->kxxError[ 'memo' ]			 = $this->kxxError[ 'line' ] . ':自己呼出<br>SCid:';
		$this->kxxError[ 'memo' ]			.= $this->kxxS1[ 'shortcode_ID' ];
		$this->kxxError[ 'memo' ]			.= '<br>S1id:'.$this->kxxS1[ 'id' ];
	}
}



/**
 * 設定。
 * ショートコードの補正。
 * @return array 基本は、$this->kxxS1 を使う。
 */
public function kxx_setting1b(){

	//タイプ分け 通常モード(1-100)
	if( !empty( $this->kxxS1[ 't' ]  ) &&  $this->kxxS1[ 't' ] >= 1 && $this->kxxS1[ 't' ] < 100 )
	{
		if( !empty( $this->kxxS1[ 'ids'] ) )
		{
			$this->kxxS1[ 'type' ] = 'IDs';
		}
		elseif( ( !empty( $this->kxxS1[ 'id' ] ) &&  is_numeric( $this->kxxS1[ 'id' ] ) ) )
		{
			//ID型

			if( $this->kxxS1[ 't' ] >= 1 && $this->kxxS1[ 't' ] < 70 && !get_the_title( $this->kxxS1[ 'id' ] ) )
			{
				$this->kxxError[ 'type' ]			.= '/id';
				$this->kxxError[ 'comment' ]	= 'NO-id';
				$this->kxxError[ 'memo' ][]		= 'ID入力ミスの可能性。ID=' . $this->kxxS1[ 'id' ];
				$this->kxxError[ 'file' ]			= __FILE__;
				$this->kxxError[ 'function' ]	= __FUNCTION__;
				$this->kxxError[ 'line' ]			= __LINE__;
			}
			elseif(	 get_post_status( $this->kxxS1[ 'id' ] )	== 'trash'	)
			{
				$this->kxxError[ 'type' ]		 .= '/trash';
				$this->kxxError[ 'comment' ]	  = 'ゴミ箱';
				$this->kxxError[ 'file' ]		  = __FILE__;
				$this->kxxError[ 'function' ]	= __FUNCTION__;
				$this->kxxError[ 'line' ]		  = __LINE__;
				$this->kxxError[ 'memo' ][]	  = get_the_title( $this->kxxS1[ 'id' ] );
			}
			elseif ( $this->kxxS1[ 't' ] >= 1 and $this->kxxS1[ 't' ] < 70 )
			{
				$this->kxxS1[ 'type' ] = 'ID';
			}
			else
			{
				if( empty( $this->kxxError[ 'type' ] ))
				{
					$this->kxxError[ 'type' ] = NULL;
				}

				$this->kxxError[ 'type' ]		.= '/’t’';
				$this->kxxError[ 'comment' ] 		 = 'IDタイプのtは1～70';
				$this->kxxError[ 'file' ]		 = __FILE__;
				$this->kxxError[ 'function' ]		 = __FUNCTION__;
				$this->kxxError[ 'line' ]				 = __LINE__;
			}
		}
		elseif( !empty( $this->kxxS1[ 'cat' ] ) || !empty( $this->kxxS1[ 'search' ] ) ) 	//★注意
		{
			//ループ系（search or category）
			if( !empty( $this->kxxS1[ 'cat' ] ) && empty( $this->kxxError[ 'type' ] ) )					//★注意
			{
				$this->kxxS1[ 'type' ] = 'CT';
			}
			elseif( !empty( $this->kxxS1[ 'search' ] ) && !empty( $this->kxxS1[ 'all' ] ) && empty( $this->kxxError[ 'type' ] ) )
			{
				$this->kxxS1[ 'type' ] = 'all';
			}
			elseif( !empty( $this->kxxS1[ 'search' ] ) ) // && empty( $this->r )
			{
				$this->kxxS1[ 'type' ] = 'title';
			}
			else
			{
				$this->kxxError[ 'type' ]		.= '/不明';
				$this->kxxError[ 'comment' ]	= '不明エラー';
				$this->kxxError[ 'file' ]			= __FILE__;
				$this->kxxError[ 'function' ]	= __FUNCTION__;
				$this->kxxError[ 'line' ]			= __LINE__;
			}
		}
		else
		{
			//error
			$this->kxxError[ 'type' ]		.= '/分離';
			$this->kxxError[ 'memo' ][]	= '■t:'.$this->kxxS1[ 't' ];
			$this->kxxError[ 'memo' ][]	= '■search:'.$this->kxxS1[ 'search' ];

			if( !empty( $this->kxxS1[ 'id' ] ))
			{
				$this->kxxError[ 'memo' ][]	= '■id:'.$this->kxxS1[ 'id' ] . '<br>';
			}

			$this->kxxError[ 'memo' ][]	= '全角空白が入っている可能性がある。';
			$this->kxxError[ 'file' ]		= __FILE__;
			$this->kxxError[ 'comment' ]		= 'Type分離エラー'.__LINE__;
			$this->kxxError[ 'function' ]	=__FUNCTION__;
			$this->kxxError[ 'line' ]			= __LINE__;

			if(!empty($this->kxxS1[ 'new_title' ])  )
			{
				$this->kxxError[ 'type' ]		= 'kxx/post0';
			}
		}

		unset( $matches );
	}
	elseif( !empty( $this->kxxS1[ 't' ] ) && $this->kxxS1[ 't' ] == 100 )
	{
		// テストモード100or0
		$this->kxxS1[ 'type' ] = 'TEST';
	}
	else
	{
		// error
		$this->kxxError[ 'type' ]				.= '/’t’';

		if ( empty( $this->kxxS1[ 't' ] ) )
		{
			$this->kxxError[ 'comment' ] = '-t-non-';
		}
		else
		{
			$this->kxxError[ 'comment' ] = '--t--';
		}

		$this->kxxError[ 'file' ]			= __FILE__;
		$this->kxxError[ 'function' ] = __FUNCTION__;
		$this->kxxError[ 'line' ]			= __LINE__;
	}
}



/**
 * 設定▲Type_base
 * ショートコードの補正
 *
 * @return null
 */
public function kxx_setting1_type(){

	//最後に上書きする為。2023-08-26
	$_base_array = $this->kxxS1;

	$this->kxxS1 = kx_Judge( $this->kxxJUDGE[ 't' ] , $this->kxxS1[ 't' ] , $this->kxxS1 );

	if(
		!empty( $this->kxxS1[ 't' ] )
		&& $this->kxxS1[ 't' ] >= 30
		&& $this->kxxS1[ 't' ] < 70
		&& !empty( $this->kxxS1[ 'ids' ] )
	)
	{
		$this->kxxS1[ 'ppp' ] 		= 20;
	}


	if( $this->kxxS1[ 'kxxtype1' ] == 'kxx-error' )
	{
		$this->kxxError[ 'type' ]		   .= '/’t’';
		$this->kxxError[ 'line' ]				= __LINE__;
		$this->kxxError[ 'memo' ][]			= $this->kxxError[ 'line' ] . '：tの間違え：'.$this->kxxS1[ 't' ] ;
		$this->kxxError[ 'memo' ][]			= 'title:'.get_the_title();
		$this->kxxError[ 'comment' ]		= '”t”';
		$this->kxxError[ 'file' ]				= __FILE__;
		$this->kxxError[ 'function' ]		= __FUNCTION__;
	}


	//上書き。ショートコード優先。2023-08-26
	foreach( $_base_array as $key => $value ):

		if( !empty( $value ) )
		{
			$this->kxxS1[ $key ] = $value;
		}

	endforeach;
}




/**
 * カウントPlus。
 *
 * @return void
 */
public function kxx_session_count_Plus(){

	if( !empty( $this->kxxS1[ 'session_count' ] ) )
	{
		$this->kxxS1[ 'session_count' ]++;
	}
	else
	{
		$this->kxxS1[ 'session_count' ] = 1;
	}
}


/**
 * ID配列取得。
 * $this->kxx_arr_id0にID配列を格納。2023-02-28
 *
 * @return void
 */
public function kxx_get_IDs(){

	if( $this->kxxS1[ 'type' ] == 'IDs'	)
	{
		//String形式のidsのID変換。2023-02-28
		$this->kxxGetStringIds();
		return;
	}


	if( !empty( $this->kxxS1[ 'db_on' ] ) )
	{
		//DB系
		$this->kxx_DB_title();
		//$_output	= $this->kxx_output();
	}
	elseif( !empty( $this->kxxS1[ 'search' ] ) && !empty( $this->kxxS1[ 'all' ] ) )
	{
		//全文検索。
		$this->kxx_all_2();
	}
	elseif( !empty( $this->kxxS1['type_level1'] ) && $this->kxxS1['type_level1']	== 'all' )
	{
		//全文検索。
		$this->kxx_all_2();
	}
	elseif( !empty( $this->kxxS1[ 'cat' ] ) || !empty($this->kxxS1[ 'tag' ] ) && empty( $this->kxxS1[ 'search' ] )	)
	{
		//カテゴリー検索。2023-02-28
		$this->kxx_category_2();
	}


	//タイトル検索
	if(( !empty( $this->kxxS1[ 'search' ] )|| !empty( $this->kxxS1[ 'title_s' ] ) ) && empty( $this->kxxS1[ 'all' ] ) )
	{
		$this->kxx_title_2();
	}
}


/**
 * データベースのタイトル検索。
 * id排出。
 *
 * @return void
 */
public function kxx_DB_title(){

	// タイトル作成。キャラタグがある場合。2023-02-28
	if( empty( $this->kxxS1[ 'titleDB'] ) &&  !preg_match( '/^∬/' , $this->kxxS1[ 'search' ] ) )
	{
		preg_match( '/c(\d\w{1,}\d)/' , $this->kxxS1[ 'tag' ]  , $matches );

		$_title1 = str_replace( get_cat_name( $this->kxxS1[ 'cat' ] ) , '' , $this->kxxS1[ 'search' ] );

		//$this->kxxS1[ 'titleDB' ] = get_cat_name( $this->kxxS1[ 'cat' ] ) . $matches[1] . $_title1;
		$_DB_args = ['title' => get_cat_name( $this->kxxS1[ 'cat' ] ) . $matches[1] . $_title1 ] ;

		// DB読み込み
		$db = kx_db0( $_DB_args, 'Select_title' );


		unset( $matches );
	}


	//対応。出力。
	if( !empty($db ) && is_array( $db) && count( $db ) == 1 )
	{
		$this->kxxS1[ 'id' ] = $db[0]->id;
		$this->kxx_arr_id0[] = $db[0]->id;
		//echo $this->kxxS1[ 'id' ];
	}
	elseif( !empty( $db ) )
	{
		foreach( $db as $value ):

			$this->kxx_arr_id0[] = $value->id;

		endforeach;
	}
}


/**
 * string形式の複数IDを配列化。
 *
 * @return void
 */
public function kxxGetStringIds(){

	//ids型のID取得。
	$this->kxx_arr_id0 = explode( ',' , $this->kxxS1[ 'ids'] );

	//エラーチェック。
	foreach( $this->kxx_arr_id0 as $_id  ):

		if ( $this->kxxS1[ 't'] >= 1 && $this->kxxS1[ 't'] < 70 && !get_the_title( $_id ) )
		{
			$this->kxxError[ 'type' ]		 .= '/id';
			$this->kxxError[ 'comment' ]	= 'NO-id';
			$this->kxxError[ 'memo' ][]		= get_the_title() . '。';
			$this->kxxError[ 'memo' ][]		= 'IDs入力ミスの可能性。ID=' . $_id;
			$this->kxxError[ 'file' ]			= __FILE__;
			$this->kxxError[ 'function' ] = __FUNCTION__;
			$this->kxxError[ 'line' ]			= __LINE__;
		}
		elseif(	 get_post_status( $_id )	== 'trash'	)
		{
			$this->kxxError[ 'type' ]	   .= '/trash';
			$this->kxxError[ 'comment' ]	= 'ゴミ箱';
			$this->kxxError[ 'file' ]		 	= __FILE__;
			$this->kxxError[ 'function' ] = __FUNCTION__;
			$this->kxxError[ 'line' ]		  = __LINE__;
			$this->kxxError[ 'memo' ][]	  = get_the_title( $_id );
		}
		elseif ( $this->kxxS1[ 't'] >= 1 and $this->kxxS1[ 't'] < 70 )
		{
			//スルー。エラーなし。
		}
		else
		{
			$this->kxxError[ 'type' ]		.= '/’t’';
			$this->kxxError[ 'comment' ] 		 = 'IDタイプのtは1～70';
			$this->kxxError[ 'file' ]		 = __FILE__;
			$this->kxxError[ 'function' ]		 = __FUNCTION__;
			$this->kxxError[ 'line' ]				 = __LINE__;
		}

	endforeach;
}



/**
 * category検索。
 *
 * @return array ID配列を返す。2023-02-28
 */
public function kxx_category_2(){

	$this->kxxS1[ 'type' ]	= 'CT';

	$_memory0	= kx_session_memory( $this->kxxS1 , 'category' );

	//軽量化・警戒用。2020-07-24
	if(	preg_match(	'/510__title/'	,	$_memory0	) 	)
	{
		$_SESSION[ 'kx_memory_count' ]['attention']	='■要注意■'.$this->kxxS1['search'];
	}

	if( !empty( $_SESSION[ 'kx_memory_count' ][ 'all' ] ) )
	{
		$_SESSION[ 'kx_memory_count' ][ 'all' ]++;
	}
	else
	{
		$_SESSION[ 'kx_memory_count' ][ 'all' ] = 1;
	}


	if( !empty( $_SESSION[ 'kx_memory_count' ][ $_memory0 ] ) )
	{
		$_SESSION[ 'kx_memory_count' ][ $_memory0 ]++;
	}
	else
	{
		$_SESSION[ 'kx_memory_count' ][ $_memory0 ] = 1;
	}


	//var_dump( KxDy::get('content'));
	//var_dump( $_db_ids );
  //var_dump( KxDy::get('work'));
	//echo '+<hr>';


	//不採用。さほど変わらない。
	/*
	if(empty(KxDy::get('content')))
	{
		KxDy::set('content', ['id' => get_the_ID() ]);
		//$_ids = KxDy::get('work')[$_title_array[0]][$_title_array[1]]['ids'];
		//echo '+';
		//var_dump($_arr);
	}

	$_title_array = explode('≫', get_the_title($this->kxxS1[ 'shortcode_ID' ]));
	if( !empty($_title_array[1]) && !empty( KxDy::get('work')[$_title_array[0]][$_title_array[1]]['ids'] ))
	{
		$_db_ids = KxDy::get('work')[$_title_array[0]][$_title_array[1]]['ids'] ;
		//var_dump(KxDy::get('work')[$_title_array[0]][$_title_array[1]]['ids']  );
		//var_dump($_db_ids);

		//foreach($_db_ids as $id)		{
			//echo $id;
			//echo get_the_title($id);
				//echo '<br>';
		//}

		//echo '+';
		//$_db_ids = KxDy::get('content')[$this->kxxS1[ 'shortcode_ID' ]]['ids'];
		$this->kxx_arr_id0 = $_db_ids;
		return $this->kxx_arr_id0;
		}
		*/


	if ( !empty( $_SESSION[ 'kx_memory' ][ $_memory0 ] ) ) ////memoryの有無。
	{
		if( !empty( $_SESSION[ 'kx_memory_count' ][$_memory0.'c'] ))
		{
			//memoryがある場合。2023-03-03
			$_SESSION[ 'kx_memory_count' ][$_memory0.'c']++;
		}
		else
		{
			$_SESSION[ 'kx_memory_count' ][$_memory0.'c'] = 0;
		}

		$_count = $_SESSION[ 'kx_memory_count' ][$_memory0.'c'] + 1;

		$this->kxxS1[ 's_cut' ]  = '';
		$this->kxxS1[ 's_cut' ] .= '<p>Memory-名：'.$_memory0.'</p>';
		$this->kxxS1[ 's_cut' ] .= '<p>Memory-COUNT：'.$_count.'</p>';
		$this->kxxS1[ 's_cut' ] .= '<p>検索数：'.$_SESSION[ 'kx_memory_count' ]['memory0b'] . '</p>';
		$this->kxxS1[ 's_cut' ] .= '<p>総カウント'.$_SESSION[ 'kx_memory_count' ][ 'all' ].'</p>';
		//$this->kxxS1[ 's_cut' ] .= '検索履歴<hr>'.$_SESSION ['memory_name'];

		$this->kxx_arr_id0 = $_SESSION[ 'kx_memory' ][ $_memory0 ] ;

		return $this->kxx_arr_id0;
	}
	else
	{
		if( !empty( $_SESSION[ 'kx_memory_count' ]['memory0b'] ) )
		{
			$_SESSION[ 'kx_memory_count' ]['memory0b']++ ;
		}
		else
		{
			$_SESSION[ 'kx_memory_count' ]['memory0b'] = 0;
		}

		$this->kxxS1[ 's_cut' ] = NULL;
		$this->kxxS1[ 's_cut' ] .= '<p>Memory-名：'.$_memory0.'</p>';
		$this->kxxS1[ 's_cut' ] .= '<p>Memory-COUNT：1</p>';
		$this->kxxS1[ 's_cut' ] .= '<p>検索数：'.$_SESSION[ 'kx_memory_count' ]['memory0b'] . '</p>';
		$this->kxxS1[ 's_cut' ] .= '<p>総カウント'.$_SESSION[ 'kx_memory_count' ][ 'all' ].'</p>';
	}

	$this->kxx_get_Post_IDs( $_memory0 );
	return $this->kxx_arr_id0;
}


/**
 * WP_Query型の検索。
 * 全項目検索。
 * 2023-03-03
 *
 * @return void
 */
public function kxx_all_2(){

	$this->kxxS1[ 'type' ] = 'all';


	/*
	if( !empty( $cat_not))
	{
		$category__not_in	= explode( ',' , $cat_not );
	}
	if( empty( $category__not_in ) )
	{
		$category__not_in = NULL;
	}
	*/

	$this->kxxS1[ 'tag_not_ids' ] = NULL;
	if( !empty( $this->kxxS1[ 'tag_not'] ) )
	{
		$_tag_nots					= explode(',', $this->kxxS1[ 'tag_not' ] );
		$_terms = get_terms( "post_tag", "fields=all&get=all" );

		if ( ! empty( $_terms ) && !is_wp_error( $_terms ) )
		{
			foreach ( $_terms as $_term ):
				foreach( $_tag_nots as $_tag_name):

					if( $_tag_name	== $_term->name)
					{
						$this->kxxS1[ 'tag_not_ids' ][]	= $_term->term_id;
					}

				endforeach;

			endforeach;
		}
	}


	$this->kxxS1[ 'search' ] = str_replace( array_keys( $this->kxxSetting[ 'search_str_replace' ] ) , $this->kxxSetting[ 'search_str_replace' ] , $this->kxxS1[ 'search' ] );
	$this->kxxS1[ 'search' ] = preg_replace( '/\{\d\}/' , '', $this->kxxS1[ 'search' ] );


	$_memory0	= kx_session_memory( $this->kxxS1 );

	if( !empty( $_SESSION[ $_memory0 ] ) )
	{
		$this->kxx_arr_id0 = $_SESSION[ $_memory0 ];

		if( !empty( $_SESSION[ $_memory0.'_count']  ) )
		{
			$_SESSION[ $_memory0 .'_count']++;
		}
		else
		{
			$_SESSION[ $_memory0 .'_count'] = 1;
		}

		$this->kxxS1[ 's_cut' ]	= 'all'.$_SESSION[ $_memory0 .'_count'];

		return;
	}



	// The Query
	$this->kxx_arr_id0 = kx_get_Post_IDs(
	[
		'cat' 							=> $this->kxxS1[ 'cat' ],
		'tag'								=> $this->kxxS1[ 'tag' ],
		'orderby'						=> $this->kxxS1[ 'orderby' ],
		'order'							=> $this->kxxS1[ 'order' ],
		's'									=> $this->kxxS1[ 'search' ],
		'category__not_in'	=> $this->kxxS1[ 'cat_not' ],
		'tag__not_in' 			=> $this->kxxS1[ 'tag_not_ids' ],
		'posts_per_page'		=> -1,
		'post_type'					=> 'post',	//投稿ページのみ
	] );



	if( empty( $this->kxx_arr_id0 ) )
	{
		$this->kxxError[ 'type' ]			.= '/post0';
		//$this->kxx_setting_error();
		$this->kxxError[ 'comment' ]	= 'no-post(all)';
		$this->kxxError[ 'function' ]	= __FUNCTION__;
		$this->kxxError[ 'line' ]			= __LINE__;
		$this->kxxError[ 'file' ]			 = __FILE__;
		$this->kxxError[ 'memo' ][]	= '検索ワードミスの可能性';

		return;
	}

	if( !empty( $this->kxx_arr_id0 ) )
	{
		//カウントパターン登録。2023-02-28
		$this->kxxS1[ 'CountPattern' ][]=[ 'all' , count( $this->kxx_arr_id0 ) ];

		$_SESSION[ $_memory0 ]	= $this->kxx_arr_id0;

		//$this->kxx_arr_id0	= $_array;

		return $this->kxx_arr_id0;
	}
}

/**
 * post取得。全検索以外。
 * 2023-08-26
 *
 * @param [type] $memory
 * @return void
 */
public function kxx_get_Post_IDs( $memory ){

	//notCategory
	if( !empty( $this->kxxS1[ 'cat_not' ] ) )
	{
		$_cat_not	= explode( ',' , $this->kxxS1[ 'cat_not' ] );
	}
	else
	{
		$_cat_not = NULL;
	}


	if( !empty( $this->kxxS1[ 'tag_not' ] ) )
	{
		$_terms = get_terms( "post_tag", "fields=all&get=all" );

		if( !empty( $_terms ) && !is_wp_error( $_terms ) )
		{
			foreach ( $_terms as $_term ):
				foreach( explode(',' , $this->kxxS1[ 'tag_not' ] ) as $_tag_name):

					if( $_tag_name	== $_term->name)
					{
						$_tag_not_ids[]	= $_term->term_id;
					}

				endforeach;
			endforeach;
		}
	}

	if( empty( $_tag_not_ids ))
	{
		$_tag_not_ids = NULL;
	}


	if( !empty( $this->kxxS1[ 'search' ] ) )
	{
		$_search = str_replace( array_keys( $this->kxxSetting[ 'search_str_replace' ] ) , $this->kxxSetting[ 'search_str_replace' ] , $this->kxxS1[ 'search' ] );
		$_search = preg_replace( '/\{\d\}/' , '', $_search );
	}
	else
	{
		$_search = NULL;
	}

	//検索。中核。2023-08-26
	$this->kxx_arr_id0 = kx_get_Post_IDs( [
		'cat'								=>	rtrim( $this->kxxS1[ 'cat' ] , "," ),	//ラスト取り除き。
		'tag'								=>	$this->kxxS1[ 'tag' ],
		'orderby'						=>	$this->kxxS1[ 'orderby' ],
		'order'							=>	$this->kxxS1[ 'order' ],
		'posts_per_page'		=>	-1,
		'post_type'     		=>	$this->kxxS1[ 'post_type' ],
		'post_status'       => 'publish',
		//'s'									=>	$_search,
		'category__not_in'	=>	$_cat_not,
		'tag__not_in' 			=>	$_tag_not_ids,
	]	);


	if ( is_array ( $this->kxx_arr_id0 ) )
	{
		//カウントパターン登録。
		$this->kxxS1[ 'CountPattern' ][] = [ 'cat' , count( $this->kxx_arr_id0 ) ];

		$_SESSION[ 'kx_memory' ][ $memory ] = $this->kxx_arr_id0;
	}
	else
	{
		$this->kxxError[ 'type' ]			.= '/post0';
		$this->kxxError[ 'comment' ]		 = 'Category or tag ”Zero”';
		$this->kxxError[ 'file' ]			 = __FILE__;
		$this->kxxError[ 'function' ]	 = __FUNCTION__;
		$this->kxxError[ 'line' ]			 = __LINE__;
		$_memo						 				 = $this->kxxError[ 'line' ];
		$_memo										.= '行。配列なし（カテゴリー、もしくはタグに該当なし）';

		$this->kxxError[ 'memo' ][]	= $_memo;
	}
}



/**
 * Ⅱtitle
 *
 * @param [type] $args
 *
 * @return array $this->kxx_arr_id0	= $arr_id
 */
public function kxx_title_2( $args	= null ) {

	//エラー排除・サーチ無し
	if( empty( $this->kxxS1[ 'search' ] ) && empty( $this->kxxS1[ 'title_s' ] ) )
	{
		if( !empty( $this->kxx_arr_id0 ) )
		{
			return $this->kxx_arr_id0;
		}
		else
		{
			return $args;
		}
	}

	if( !empty( $args ) )
	{
		$this->kxx_arr_id0 = $args;
	}

	$this->kxxS1[ 'type' ]			= 'title';

	//IDがない場合。全文検索。
	if( empty( $this->kxx_arr_id0 ) )
	{
		$_search_base	= $this->kxxS1[ 'search' ];
		$_replace = array(
			'ζ≫'	=> '',
			'＄'		=> '',
		);

		$this->kxxS1[ 'search' ] = str_replace(array_keys( $_replace ), $_replace, $this->kxxS1[ 'search' ] );
		$this->kxxS1[ 'search' ] = substr( $this->kxxS1[ 'search' ] , 0, strcspn( $this->kxxS1[ 'search' ] ,'-' ) );//マイナス以降を削除。第一ループ

		$this->kxx_all_2();

		$this->kxxS1[ 'search' ]	= $_search_base;//必要？？2022-01-25
	}


	//title_sがる場合。
	if( !empty( $this->kxxS1[ 'title_s' ] ) )
	{
		$_replace =
		[
			'＞'	=> '≫',
			'＠11＠'	=> '{',
			'＠12＠'	=> '}',
			'＠４'	=> 'Β|γ|σ|δ',
		];

		$_search = str_replace(array_keys( $_replace ), $_replace , $this->kxxS1[ 'title_s' ] );

		$this->kxxS1[ 'search' ] .= ' ' . $_search ;
	}

	// ..検索
	$_search = $this->kxxS1[ 'search' ];

	$_replace =
	[
		//'＞'	=> '≫',
		'ζ≫'	=> '',
		'＄'		=> '$',
		'a-z'		=> '[a-z]',
		'￥d'	 => '\d',
		'￥w'	 => '\w',
		'｜'		=> '|',
		'（'		=> '(',
		'）'		=> ')',
		'＾'		=> '^',
		' -'		=> ')(?!.*',
		' '			=> ')(?=.*',
		//		' '			=> ')(?=',
	];

	$_search = str_replace(	array_keys( $_replace )	, $_replace	, $_search	);
	$_search = '/^(?=.*'.$_search.')/i';	//「i」大文字小文字区別せず

	//echo $_search;
	//echo '<br>';


	if( !empty( $this->kxx_arr_id0))
	{
		$_arr = $this->kxx_arr_id0;
	}
	else
	{
		$_arr = NULL;
	}

	$this->kxx_arr_id0 = NULL;


	if( is_array(	$_arr ) )
	{
		$_cunt_db = 0;

		foreach ( $_arr as $_id) :

			$_title	= get_the_title( $_id );

			//一致
			if( preg_match ( $_search , $_title ) )
			{
				//if(	!empty( $this->kxxS1[ 'floor_on' ] )	)
				//{
					//if(	strpos(	preg_replace(	'/.*'. $this->kxxS0[ 'search' ] .'/'	,	''	,		$_title	)		,	'≫'	)  === false )
					//{
						//≫が含まれていたらアウト。2023-08-26
						//$this->kxx_arr_id0[] = $_id;
					//}
				//}
				//else
				//{
				$this->kxx_arr_id0[] = $_id;
				//}
			}


			if(
				!empty( $this->kxxS1[ 't' ] )
				&& !empty( $this->kxxS1[ 'ppp' ] )
				&& !empty( $_cunt_db )
				&& $this->kxxS1[ 't' ] >= 90
				&& $_cunt_db < $this->kxxS1[ 'ppp' ]
				&& $_cunt_db < 300
			){
				kx_db1( [ 'id' => $_id ] , 'content' );

				$_cunt_db++;
			}

		endforeach;


		if( !empty( $this->kxx_arr_id0 ) && is_array( $this->kxx_arr_id0 ) )
		{
			$this->kxxS1[ 'CountPattern' ][] = ['title' , count( $this->kxx_arr_id0 ) ];
		}
		else
		{
			$_line										           = __LINE__;
			$this->kxxError[ 'function' ]	       = __FUNCTION__;
			$this->kxxError[ 'line' ]		         = $_line;
			$this->kxxError[ 'type' ]	          .= '/post0(title)';
			$this->kxxError[ 'comment' ]		     = 'title search ”Zero”';
			$this->kxxError[ 'memo' ][ $_line ]	 =  $_line;
			$this->kxxError[ 'memo' ][ $_line ] .= ':配列なし（タイトル検索-ゼロ）。';
		}
	}

	/*
	不要。2023/08/26
	if( empty( $arr_id) )
	{
		$arr_id = NULL;
	}
	$this->kxx_arr_id0	= $arr_id;
	*/

	return $this->kxx_arr_id0;
}


/**
 * //出力
 *
 * @param array $arr
 * @return string
 */
public function kxx_output(	$arr = null	){

	//ループ数・count
	if( !empty( $this->kxx_arr_id0 ) && is_array( $this->kxx_arr_id0 ) )
	{
		$_count_arr_id0	= count( $this->kxx_arr_id0 );
	}

	//$t	= $this->kxxS1[ 't' ];

	//ID調整とエラー排除。2023-02-28
	if( !empty( $arr ) )
	{
		//直接関数にID配列が入力SARている場合。

		unset( $this->kxx_arr_id0 );
		$this->kxx_arr_id0[] = $arr[ 'id' ][0];
	}
	elseif( empty( $this->kxx_arr_id0 ) && !empty( $this->kxxS1[ 'id' ] ) )
	{
		//ID配列がなく、ショートコードでIDを指定されている場合。2023-02-28

		$this->kxx_arr_id0[]	 = $this->kxxS1[ 'id' ];
	}
	elseif ( empty( $this->kxx_arr_id0 )  ) //&& empty( $this->kxxError[ 'type' ] )
	{
		//IDなし。

		$this->kxxError[ 'type' ]			.= '/post0';
		$this->kxxError[ 'comment' ]	 = 'no-post(output)';
		$this->kxxError[ 'file' ]			 = __FILE__;
		$this->kxxError[ 'function' ]	 = __FUNCTION__;
		$this->kxxError[ 'line' ]			 = __LINE__;
	}
	elseif( $this->kxxS1[ 'ppp' ] == 1 && !empty( $_count_arr_id0 ) && $_count_arr_id0 > 1 && empty( $this->kxxError[ 'type' ] ) )
	{
		//オーバーフロー。

		$this->kxxError[ 'type' ]	 	 .= '/ppp';
		$this->kxxError[ 'comment' ] 	= 'Overflow(output)='. $_count_arr_id0;
		$this->kxxError[ 'memo' ]			= 'Overflow(output)-'. $_count_arr_id0 .'件';
		$this->kxxError[ 'line' ]			= __LINE__;
		$this->kxxError[ 'file' ]			= __FILE__;
		$this->kxxError[ 'function' ]	= __FUNCTION__;
	}


	$x				= 0;					//通常カウント
	$xe				= 0;				//エラーカウント
	//$x_chara	= 0;		//キャラクターカウント
	$xkai			= 0;			//アップデートカウント・上限用
	$_e_out		= '';	//空
	$ret[0]		= '';	//空

	$_test = 0;

	if( !empty( $this->kxx_arr_id0 ) && is_array( $this->kxx_arr_id0 ) )
	{
		//var_dump($this->kxx_arr_id0);
		//return;
		//echo count($this->kxx_arr_id0);
		foreach( $this->kxx_arr_id0 as $id ):

			/*
			$_test ++;

			if($_test >15 )
			{
				echo $id;
				break;
			}
				*/

			//echo $id;
			//echo '+';

			//ユーザーidの置換。2023-08-29
			//不要。重くなるだけ。plug-inに移設。2023-08-30
			//echo kx_authorID( $id );

			//print_r($this->kxxS1);

			//■■■■■■■■■■■■■古い■■■■■■■■■■■■■■■■
			if( $x >= $this->kxxS1[ 'ppp' ] || $xkai > 4 )
			{
				break;
			}
			elseif( !empty( $this->kxxError[ 'type' ] ) )
			{

				$this->kxxSxx[ 'id' ]	= $id;
				$_e_out						 .= $this->kxx00();	//要注意：追記
				$xe++;

				//kxxS1変更。2023-08-25
				$this->kxxS1[ 'ppp' ]		= 8;

				if( $xe >= 5)
				{
					break;
				}
			}
			else
			{
				$this->kxxSxx[ 'id' ]	= $id;
				$x++;
				//$this->x	= $x;

				//要注意：追記型。

				if( $this->kxxS1['t'] >= 10 && $this->kxxS1['t'] < 20 )
				{
					$_t = empty($_t) ? $this->kxxS1['t'] : $_t;
					$this->kxxS1['t'] = preg_match('/統合概要$/', get_the_title($id)) ? 15 : $_t;
				}



				$ret[0] .= $this->kxx_type();
				// 更新・介入
				if( !empty( $this->kxxS1[ 'wfm_end' ] ) && $this->kxxS1[ 'wfm_end' ] == 'end')
				{
					$xkai++;
					$post = get_post( $id );

					$replace =
					[
						'[kx_format'			=> '[kx_end_format',
					];

					$post_content = str_replace(array_keys($replace), $replace, $post->post_content);

					$my_post = array(
						'ID'						=> $id,
						'post_title'		=> get_the_title( $id ),
						'post_content'	=> $post_content,
					) ;
					wp_update_post( $my_post ) ;

				}
				elseif( !empty( $this->kxxS1[ 'update'] ))
				{
					//テンプレートmenuからのアップデート用。2023-08-04
					$post = get_post( $id );

					$my_post = array(
						'ID'						=> $id,
						'post_title'		=> get_the_title( $id ),
						'post_content'	=> $post->post_content,
					) ;
					wp_update_post( $my_post ) ;
				}
			}

			//出力。2023-06-24
			$ret[ 'id' ] = $id;

		endforeach;

		/*
		if( !empty( $x_chara ) )
		{
			$this->kxxS1[ 'CountPattern' ][]=[ 'chara' , $x_chara];
		}
		*/
	}
	else
	{
		//エラー。2023-03-01
		$this->kxxError[ 'type' ]					                     .= '/post0';
		$this->kxxError[ 'file' ]					                      = __FILE__;
		$this->kxxError[ 'line' ] 	 			                      = __LINE__;
		$this->kxxError[ 'memo' ][ $this->kxxError[ 'line' ] ]  = $this->kxxError[ 'line' ];
		$this->kxxError[ 'memo' ][ $this->kxxError[ 'line' ] ] .= ':配列なし（output）';
		$this->kxxError[ 'comment' ]				                    = 'no-post(output)';
		$this->kxxError[ 'function' ]			                      = __FUNCTION__;
	}


	//エラー分岐。
	if( !empty( $this->kxxError[ 'type' ] )  )
	{
		$_line	= __LINE__;

		if( empty( $id ) )
		{
			$id = NULL;
		}

		//事前に$this->kxxError[ 'memo' ]がある場合の回避。修正必要箇所。2023-03-08
		if( !empty( $this->kxxError[ 'memo' ] )  && !is_array( $this->kxxError[ 'memo' ] ))
		{
			$_memo = $this->kxxError[ 'memo' ];
			unset(  $this->kxxError[ 'memo' ] );
			$this->kxxError[ 'memo' ][] = $_memo;
			unset( $_memo );
		}

		$this->kxxError[ 'memo' ][$_line]	 = $_line.':（確認output）';
		$this->kxxError[ 'memo' ][]				 = 'title:'.get_the_title( $id );

		if( !empty( $_e_out ) )
		{
			$ret[0] .= $_e_out;
		}
		elseif( !empty( $this->kxxS1[ 'cat_g' ] ) || !empty( $this->kxxS1[ 'cat_c' ] ) )
		{
			$ret[0] .= $this->kxx_type();
		}
		else
		{
			$ret[0] .= '<div class="__xxsmall __text_center">';
			$ret[0] .= 'Error-LINE'.$_line.'（kxx_output）';
			$ret[0] .= 'Type:' . $this->kxxError[ 'type' ];
			$ret[0] .= '</div>';
		}
	}


	if(	$x	== 0 && $xe	== 0	)
	{
		//スルー
	}
	elseif(
		!empty( kx_Judge( $this->kxxJUDGE[ 'list_head' ] , $this->kxxS1[ 't' ] )[ 'list_head_on' ] )
		|| !empty( $this->kxxError[ 'type' ] )
	){
		if( !empty($this->kxxS1[ 'sys' ] )  &&	preg_match ('/head_no/' , $this->kxxS1[ 'sys' ] ) )
		{
			$head_on	= 0;
			//スルー
		}
		else
		{
			$head_on	= 1;
		}

		if(	!empty( $head_on ) && !empty( $head_line)	)
		{
			$ret['head']	= $this->kxx_list_foot();
		}
		elseif( !empty( $head_on ))
		{
			$ret['head']	= $this->kxx_list_head();
		}
	}

	$this->kxxSxx = kx_Judge( $this->kxxJUDGE[ 'list_foot' ] , $this->kxxS1[ 't' ] , $this->kxxSxx );

	if(
		!empty( $this->kxxSxx[ 'list_foot_on' ]  )
		|| !empty( $this->kxxError[ 'type' ] )
		&& $x!=0
		&& $xe != 0
	){
		$ret[ 'foot' ]= $this->kxx_list_foot();
	}

	return $ret;
}



/**
 * KXX-振り分け
 *
 * @return
 */
public function kxx_type(){

	if( empty( $this->kxxS1[ 'kxxtype1' ] ) )
	{
		$this->kxxS1[ 'kxxtype1' ] = kx_Judge( $this->kxxJUDGE[ 't' ] , $this->kxxS1[ 't' ] )[ 'kxxtype1' ];
	}

	//$t = $this->kxxS1[ 't' ];
	if( !empty( $this->kxxError[ 'type' ] ) )
	{
		if (		preg_match ('/’t’/' , $this->kxxError[ 'type' ] ) ) {}
		elseif(	preg_match ('/ppp/' 	, $this->kxxError[ 'type' ] ) ) { $ret	= $this->kxx00();}
		else
		{
			$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;
			$ret	= kx_CLASS_error( $this->kxxError );
		}
	}
	elseif( $this->kxxS1[ 'kxxtype1' ] == 'kx100' ){$ret	= $this->kxx_test0(); }
	elseif( $this->kxxS1[ 'kxxtype1' ] == 'kx00' ){ $ret	= $this->kxx00(); }
	elseif( $this->kxxS1[ 'kxxtype1' ] == 'kx10' ){ $ret	= $this->kxx10(); }
	elseif( $this->kxxS1[ 'kxxtype1' ] == 'kx30' ){ $ret	= $this->kxx30(); }
	elseif( $this->kxxS1[ 'kxxtype1' ] == 'kx40' ){ $ret	= $this->kxx40(); }
	/*
	elseif( $t == 0 )  							{ $ret	= $this->kxx_test(); }		//test
	elseif( $t >=  1 and $t < 10 )	{ $ret	= $this->kxx00(); }
	elseif( $t >= 10 and $t < 30 )	{ $ret	= $this->kxx10(); }
	elseif( $t >= 30 and $t < 40 )	{ $ret	= $this->kxx30(); }
	elseif( $t >= 40 and $t < 70 )	{ $ret	= $this->kxx40(); }
	elseif( $t >= 70 and $t < 100 )	{ $ret	= $this->kxx40(); }
	elseif( $t == 100 )							{ $ret	= $this->kxx_test(); }		//test
	*/
	else
	{
		$this->kxxError[ 'line' ]					= __LINE__;
		$this->kxxError[ 'type' ]	 .= '/PROGRAM';
		$this->kxxError[ 'file' ]			= $this->kxxError[ 'line' ];
		$this->kxxError[ 'memo' ][]		= 'プログラムエラー。';
		$this->kxxError[ 'memo' ][]		= 'kxxtype1：'.$this->kxxS1[ 'kxxtype1' ];
		$this->kxxError[ 'function' ]			= __FUNCTION__;
		$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;

		$ret = kx_CLASS_error( $this->kxxError );
	}
	return $ret;
}



/**
 * KXX0
 *
 * @return string
 */
public function kxx00(){
	$t				= $this->kxxS1[ 't' ];
	$id				= $this->kxxSxx[ 'id' ];

	//$title		= kx_TitleReplacement( [ 'title' =>  get_the_title( $id )  ] );

	$title = kx_CLASS_kxTitle(
	[
		'type'             => 'TitleReplace',
		'title'            => get_the_title( $id ),
	] )[ 'TitleReplace_html' ];

	$title2		= get_the_title( $id );

	$link 			= get_permalink( $id );
	$edit_link	= get_edit_post_link( $id );
	$edit_class = '__edit2';

	global $post;
	$post = get_post( $id );
	setup_postdata($post);

	$basu = get_the_excerpt();
	wp_reset_postdata();

	//表示開始
	$ret0 = '';
	$ret0 .='<div class="__margin_bottom4 __margin_top5 ">';//' . $c_text1 . '
	$ret0 .='<a href="' . $link . '">' . $title;
	$ret0 .='</a>';
	$ret0 .='</div>';
	$ret0 .='<div class="__xsmall __margin_left25 '.$edit_class.'">';
	$ret0 .='<a href="' . $edit_link . '">';
	$ret0 .= $title2;
	$ret0 .='</a>';
	$ret0 .='</div>';


	$ret = '';

	if( $t == 1 )	//確認用
	{
		$ret .='<div class="__xsmall __error_bg_pink">';
		$ret .='<span class="">確認</span>';
		$ret .='<div>'.$this->kxxS1[ 't' ].'（t項目）</div>';
		$ret .='<div>'.$this->kxxS1[ 'id' ] . '（id）</div>';
		$ret .='<div>'.$this->kxxS1[ 'search' ].'（検索項目）</div>';
		//$ret .='<div>'.$this->memo.'（メモ）</div>';
		$ret .='</div>';
	}
	elseif( $t == 2 )
	{
		//ID配列のみ呼び出すときに使用。2023-02-28
		$_basu_off = 1;
		$ret0 = '';
		$this->kxx_arr_id_S[] = $this->kxxSxx[ 'id' ];

		//print_r( $this->kxx_arr_id0);
		$ret .= 't=2ID出力：';
		$ret .= $this->kxxSxx[ 'id' ];
		$ret .= '<br>';
	}
	elseif( $t == 8 )	//確認用
	{
		$ret .= '調整中・2020-06-24';

		$ret .='<div class="__xsmall __margin_left25">';
		$ret .= $this->kxxS1[ 'search' ].'（検索項目）';
		$ret .='</div>';
		$ret .='<div class="__xsmall __margin_left25">';
		//$ret .= $this->memo.'（メモ）';
		$ret .='</div>';
	}
	elseif( $t == 9 )	//system用
	{
		$ret .= '<div class="">';
		$ret .= 'system';
		$ret .= '</div>';
	}
	elseif( $this->kxxError[ 'type' ] ) //確認用
	{
		//$this->kxx_setting_error();
		$ret .='<div  class="__xsmall __margin_left25">id:';
		$ret .= $id;
		$ret .='category（';
		$category=get_the_category( $id );

		foreach( $category as $v):

			$ret .= $v->cat_ID.',';

		endforeach;

		//$ret .='category'.$category;
		$ret .='）';
		$tags = get_the_tags( $id );

		if ( $tags )
		{
			$ret .='　tag（';

			foreach ( $tags as $tag ):
				$ret .= $tag->name;
			endforeach;

			$ret .='）';
		}

		$ret .='</div>';
	}
	else
	{
		$ret .='<span class="__error_bg_pink">ERROR:<00else>t='.$t.'</span>';
	}

	if( empty( $_basu_off ) )
	{
		$ret .='<div class="__margin_left35 __margin_right15 __margin_bottom8">';
		$ret .= $basu;
		$ret .='</div>';
	}
	return $ret0 . $ret;
}


/**
 * KXX1（10系+20系）
 *
 * link_bottomは廃止。2021-08-07
 *
 * @return
 */
public function kxx10(){

	$kx10 = new kx10;

	//設定。
	$this->kxx_setting_kxXX();

	$kx10->kx10_main( $this->kxxS1 , $this->kxxSxx  );

	ob_start();
	$template_path = locate_template('templates/components/kxx10.php');
	if ( $template_path ) {
    include $template_path;
	}
	return ob_get_clean();

}


/**
 * KXX30（30系）
 *
 * @return string
 */
public function kxx30() {
	//kxx-base基礎設定
	$this->kxx_setting_kxXX();

	$kx30 = new kx30;
	$kx30->kx30_Main( $this->kxxS1 , $this->kxxSxx );

	ob_start();
$template_path = locate_template('templates/components/kxx30.php');
	if ( $template_path ) {
    include $template_path;
	}

	return ob_get_clean();
}


/**
 * KXX4 40～99。
 * l7。機能停止。
 * h2。機能停止。
 *
 * @return string htmlを出力。
 */
public function kxx40(){


	$kx40 = new kx40;

	if( !empty($this->kxxS1[ 'sys' ] ) &&	(preg_match(	'/raretu_check/'	, $this->kxxS1[ 'sys' ] ) )		)
	{
		$kx40->kx40arr_id = $this->kxx_arr_id0;
	}

	//基礎設定
	$this->kxx_setting_kxXX();

	$kx40->kx40_main( $this->kxxS1 , $this->kxxSxx ,  $this->kxxError	);

	//ナビ系
	$jq_template = locate_template('templates/components/kxx40_jq.php');
	if ( $jq_template ) {
    include $jq_template;
	}

	ob_start();
	$template_path = locate_template('templates/components/kxx40.php');
	if ( $template_path ) {
		include $template_path;
	}

	return ob_get_clean();
}



/**
 * KXX base設定
 *
 * @return $this->kxxSxx
 */
public function kxx_setting_kxXX() {

	//確認用。なくてもOK。2023-08-25
	//unset( $this->kxxS1[ 'id' ] );

	//カウント追記
	$this->kxx_session_count_Plus();


	//色を指定するためのタイトル呼び出し。
	$_title	= get_the_title( $this->kxxSxx[ 'id' ] );

	$this->kxxSxx[ 'kxcl' ] = kx_CLASS_kxcl( $_title, 'kxx' );

	$this->kxxS1 = kx_Judge( $this->kxxJUDGE[ 'basu' ] , $this->kxxS1[ 't' ] , $this->kxxS1 );

	$this->kxxSxx[ 'title' ]			 = $_title;
	$this->kxxSxx[ 'link' ]				 = get_permalink( $this->kxxSxx[ 'id' ] ) ;
	$this->kxxSxx[ 'link_edit' ] 	 = get_edit_post_link ( $this->kxxSxx[ 'id' ] ) ;

	//sys系統スイッチ
	if( !empty( $sys ) )	// && preg_match('/,/'	,$sys)
	{
		foreach( explode( ',' , $sys ) as $value ):

			$this->kxxSxx[ $value ]	= 1;

		endforeach;
	}


	//抜粋有無
	if(	!empty( $this->kxxS1[ 'basu_on' ] ) )
	{
		$this->kxxS1[ 'session_count' ] = KxDy::get('trace')['kxx_content_count'] ?? 0;
		$this->kxxExcerpt();
	}

	//$this->kxxSxx				= $ret	+	$this->kxxSxx;
}



/**
 * List-HEAD
 *
 * @return string
 */
public function kxx_list_head(){

	// 装飾
	if( empty( $this->kxxSxx[ 'kxcl' ] ) )
	{
		$this->kxxSxx[ 'kxcl' ] = kx_CLASS_kxcl( '', 'kxx' );
	}


	$_judge = kx_Judge( $this->kxxJUDGE[ 'list_head' ] , $this->kxxS1[ 't' ]  );

	$_class = NULL;

	$_class .= $_judge[ 'list_head_css' ];
	$_class .= ' ' . $this->kxxSxx[ 'kxcl' ][ 'text_class' ];
	$_class .= ' ' . $this->kxxSxx[ 'kxcl' ][ 'border_class' ];

	$_style = 'background:' . $this->kxxSxx[ 'kxcl' ][ 'hsla_normal' ] .';';


	// 表示
	$ret  = '';
	$ret .= '<div class="__switch_start __hover_div_g">';	//---switch_start--

	$ret .= '<div class="'.$_class.'" style="'. $_style .'">';	//空白だと色を表示できない
	$ret .= 'SEARCH：'. $this->kxxS1[ 'search' ];

	if( !empty( $this->kxxS1[ 'auto' ] ) )
	{
		$ret .= 'AUTO：';
	}
	else
	{
		$this->kxxS1[ 'auto' ] = NULL;
	}

	if( !empty( $this->kxxS1[ 'update' ] ) )
	{
		$ret .= '自動更新：';
	}


	if( !empty( $cat ) )
	{
		$this->kxxS1[ 'catnames' ] = get_the_category_by_ID( $this->kxxS1[ 'cat' ] );
	}


	$ret .= '<div class="__float_right">';		//__float_right

	$ret .= 'Count：';
	if( !empty( $this->kxxS1[ 'CountPattern' ] ) )
	{
		$str = NULL;
		foreach($this->kxxS1[ 'CountPattern' ] as $v ):
			$str	.= $v[0];
			$str	.= $v[1];
		endforeach;


		$this->kxxS1[ 'count_post' ]	= $str;
		$ret .= $v[1];
	}


	if ( $this->kxxS1[ 't' ] == 97 )
	{
		$_memo	= '全件表示';
	}
	elseif( empty( $this->kxxS1[ 'ppp' ] ) )
	{
		$_memo	= 'Full・ppp無し';
	}
	else
	{
		$_memo	= 'max・' . $this->kxxS1[ 'ppp' ] . '件';
	}

	$ret .= '</div>';
	$ret .= '</div>';

	$ret .= kx_table_navi(
	[
		'count_post'  => $this->kxxS1[ 'count_post' ],
		//'List_count'	=> 'list_count' ,
		'T' 			 		=> $this->kxxS1[ 't' ],
		'PPP(max)' 		=> $this->kxxS1[ 'ppp' ],
		'Cat'			 		=> $this->kxxS1[ 'cat' ],
		'Tag'			 		=> $this->kxxS1[ 'tag' ],
		'Catnames'		=> $this->kxxS1[ 'catnames' ],
		'orderby'			=> $this->kxxS1[ 'orderby' ],
		'order'				=> $this->kxxS1[ 'order' ],
		'post_type'	  => $this->kxxS1[ 'post_type' ],
		'Search'			=> $this->kxxS1[ 'search' ],
		'Auto'				=> $this->kxxS1[ 'auto' ],
		'UPdate'			=> $this->kxxS1[ 'update' ],
		'chara'				=> $this->kxxS1[ 'chara' ],
		's_cut'				=> $this->kxxS1[ 's_cut' ] ,
		'Memo'				=> $_memo . '+',
	] );

	$ret .= '</div>';	//---switch_start--

	return $ret;
}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxx_list_foot(){

	if( preg_match( '/foot_no/' , $this->kxxS1[ 'sys' ]	) )
	{
		return;
	}

	if( !empty( $this->kxxSxx[ 'kxcl' ] ))
	{
		$this->kxxSxx[ 'list_foot_css' ]	.= ' ' . $this->kxxSxx[ 'kxcl' ][ 'background_class_normal' ];
	}

	$ret = '<table class="'. $this->kxxSxx[ 'list_foot_css' ] .'"></table>';

	return $ret;
}


/**
 * 抜粋 仕分け。
 *
 * @return void
 */
public function kxxExcerpt(){


	//Count
	KxDy::kxdy_trace_count('kxx_content_count', 1);



	//分岐。
	if( (KxDy::get('trace')['kxx_content_count'] ?? 0) > $this->kxxSetting[ 'LIMIT' ][ 'loop' ] )
	{
		//Error排除
		$this->kxxError[ 'type' ]			.= '/basu';
		$_memo		= '抜粋エラー・';
		$_memo		.= $this->kxxSetting[ 'LIMIT' ][ 'loop' ];
		$_memo		.= 'over。';
		$_memo		.= get_the_title( $this->kxxS1[ 'shortcode_ID' ] );
		$this->kxxError[ 'file' ]					= __FILE__;
		$this->kxxError[ 'memo' ][]				= $_memo;
		$this->kxxError[ 'function' ]					= __FUNCTION__;
		$this->kxxError[ 'line' ]							= __LINE__;
		$this->kxxError[ 'SESSION_count' ]	= KxDy::get('trace')['kxx_content_count'] ?? 0;
		$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;

		$this->kxxSxx[ 'ExcerptA' ]										=  kx_CLASS_error( $this->kxxError );

		KxDy::kxdy_trace_count('kxx_content_count', 0);

	}
	elseif( !empty($this->kxxS1[ 'shortcode_ID' ]) && $this->kxxS1[ 'shortcode_ID' ]	 == $this->kxxSxx[ 'id' ] &&	empty( $_SESSION['memo']['etc_chara'] ) ) 	//&& !$_SESSION[ 'reference_on' ]
	{
		if(!empty( $this->kxxS1[ 'id' ] )  && !empty( $_SESSION[ 'reference_on' ] ) && $_SESSION[ 'reference_on' ] == $this->kxxS1[ 'id' ] )
		{
			//Error排除
			$this->kxxError[ 'type' ]				.= '/basu';
			$this->kxxError[ 'comment' ]		 			= '∞';
			$this->kxxError[ 'memo' ][]				= '抜粋エラー・自己呼び出し';
			$this->kxxError[ 'file' ]			 		= __FILE__;
			$this->kxxError[ 'function' ]		 			= __FUNCTION__;
			$this->kxxError[ 'line' ]				 			= __LINE__;
			$this->kxxError[ 'SESSION_count' ]	= KxDy::get('trace')['kxx_content_count'] ?? 0;
			$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;

			$this->kxxSxx[ 'ExcerptA' ] = kx_CLASS_error( $this->kxxError );
		}
	}
	elseif( preg_match( '/^7$|6\d|9\d/' , $this->kxxS1[ 't' ] ) )
	{
		//スルー。
	}
	elseif( !empty( $this->kxxError[ 'type' ] ) )
	{
		//Error排除
		$this->kxxSxx[ 'ExcerptA' ] = '■■ERROR■■（表示テスト）';
	}
	else
	{
		if( (KxDy::get('trace')['kxx_content_count'] ?? 0) > $this->kxxSetting[ 'LIMIT' ][ 'loop' ] )
		//Error排除
		{
			$this->kxxError[ 'type' ] 		.= '/basu';
			$this->kxxError[ 'file' ]		 = __FILE__;
			$this->kxxError[ 'memo' ][]	 = '：抜粋無限ループ【システム不備/危険エラー】';
			$this->kxxError[ 'function' ]		 = __FUNCTION__;
			$this->kxxError[ 'line' ]				 = __LINE__;
			$this->kxxError[ 'kxxErrS1' ] = $this->kxxS1;

			$this->kxxSxx[ 'ExcerptA' ]	= kx_CLASS_error( $this->kxxError );
		}
		elseif( !empty( $this->kxxS1['basu_full'] ) ||( !empty($this->kxxS1[ 'sys' ] ) && preg_match('/basu_full/'	, $this->kxxS1[ 'sys' ]  ) ) )
		{
			//echo get_the_title( $id ).'<br>';
			$this->kxxSxx[ 'ExcerptA' ] = kx_break_excerpt(	$this->kxxSxx[ 'id' ] , 'full' );
		}
		else
		{
			$this->kxxSxx[ 'ExcerptA' ] = kx_break_excerpt(	$this->kxxSxx[ 'id' ] );
		}


		//置換系？
		if( $this->kxxS1[ 't' ] >= 30 and $this->kxxS1[ 't' ] < 40 )
		{
			//スルー
		}
		else
		{
			$this->kxxSxx[ 'ExcerptA' ] =  $this->kxx_break_excerpt_chikan(	$this->kxxSxx[ 'ExcerptA' ]	);
		}


		//機能破壊
		if( $this->kxxS1[ 't' ] >= 40 and $this->kxxS1[ 't' ] <	90 )
		{
			$this->kxxSxx[ 'ExcerptA' ] = str_replace( array( 'div id=' ) , 'div ',$this->kxxSxx[ 'ExcerptA' ]);
			$this->kxxSxx[ 'ExcerptX' ] = str_replace( array( '__absolute_r0'), '__absolute_r00',$this->kxxSxx[ 'ExcerptA' ] );
		}
	}
}





/**
 * 抜粋の置換
 *
 * @param string $basu 抜粋Contents。
 * @return string
 */
public function kxx_break_excerpt_chikan( $basu ) {

	$replace = array(
		'__radius_kumi_top20'			=> '__radius_kumi_bottom20',
		'__radius_kumi_dokuritu'	=> '__radius_kumi_bottom20',
	);
	return str_replace( array_keys( $replace ) , $replace , $basu);
}



/**
 * 100 新作テスト用
 * t=100に設定。2023-02-27
 * @return string
 */
public function kxx_test() {

	$ret= '';
	$ret .= '2019/03/30';
	$ret .= '<div id="1" class="">';
	$ret .= '<a>';
	$ret .= 'リンク++++';
	$ret .= '</a>';
	$ret .= '<div id="a185">';
	$ret .= '■TEST■<BR>';
	$ret .= '</div>';
	$ret .= '</div>';

	$ret .= '<div>TEST100:ID:';
	$ret .= $this->kxxS1[ 'id' ];
	$ret .= '</div>';

	return $ret;
}



/**
 * 確認用
 * t=0に設定。2023-02-27。
 *
 * @return string
 */
public function kxx_test0(){

	$ret = '';
	$ret .= 'ID：';
	$ret .= $this->kxxS1[ 'id' ];
	$ret .= '<BR>';
	$ret .= 'Get-ID：';
	$ret .= $this->kxxS1[ 'id' ];
	$ret .= '<BR>';
	$ret .= 'エラーID1：';
	$ret .= $this->kxxS1[ 'shortcode_ID' ];
	$ret .= '<BR>';
	//$ret .= 'エラーID2：';
	//$ret .= $this->kxxError[ 'measure_ID' ];
	//$ret .= '<BR>';
	$ret .= $this->kxxS1[ 'search' ];

	return $ret;
}

}//class_end