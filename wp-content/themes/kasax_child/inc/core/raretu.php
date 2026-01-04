<?php
/**
 * D:\00_WP\xampp\htdocs\0\wp-content\themes\kasax_child\inc\core\raretu.php
 */


add_shortcode( 'raretu' , 'kxsc_raretu' );
/**
 * 羅列型。
 *
 * @param [type] $atts
 * @return void
 */
function kxsc_raretu( $atts ){
    if ( is_admin() ) {
        return '';
    }
	$args	=
	[

		'table_name' => '', // データベース内のテーブル名を指定します。例えば "kx_0" のような名前を記述します。
		'conditions' => '', // 検索条件をキーと値のペア形式で指定します。例: "column1=value1&column2=value2" のように条件を設定できます。
		'columns'    => '', // 取得したいカラムを指定します。デフォルトは '*'になる。（すべてのカラムを取得）。複数カラムの場合は "column1,column2" と記述します。
		'operator'   => 'AND', // 条件間の論理演算子を指定します。"AND" で条件をすべて満たすレコードを検索し、"OR" でいずれかを満たすレコードを検索します。
		'limit'      => '', // 結果の最大取得件数を指定します。例: "10" と記述すると検索結果を最大10件までに制限できます。
		'order_by'   => '', // 結果の並び順を指定します。"column_name ASC"（昇順）または "column_name DESC"（降順）を記述できます。例: "date DESC"。
		'use_like'   => true, // 初期値は部分一致。falseで完全一致。部分一致はLIKEクエリを使用してワイルドカード検索（%）が可能。2025-04-05
		'date'       => true, // 初期値はtrue。Dateがある場合は、そのとおりに並べる。":"の検索は＿により置換。 2025-04-23

		'tougou'				=>	'', //posts統合用。2025-09-04
		'tougou_sort'	  =>	'', //sortのみ。id指定。

		'db_type'				=>	'', //works か shared。2022/06/10
		'db'						=>	'', //column
		'db_like'				=>	'',
		'db2'						=>	'', //column2
		'db_like2'			=>	'',
		'db_like2_and' 	=>	'',
		//'db_WHERE'		=>	'',//複数検索用
		'cat'						=>	'',	// デフォルト =0
		'tag'						=>	'',	// デフォルト =0
		'sys'						=>	'',//month_noなど。
		'add_search'		=>	'',
		'c'							=>	'',	// 番号。配列可。
		'c0'						=>	'',	// ヒロイン番号・介入。
		'c1'						=>	'',	// 主人公番号。
		'csa'						=>	'',	// 年齢差。"1,2,3"の書き方。ヒロイン除外。
		'add_id'				=>	'',	// デフォルト =0
		'gaku'					=>	'5,22',	// 学年、教育範囲。無記名は5,22で記述。カットはoff。
		'j'							=>	'',	//ソート順位
		'je'						=>	'',	//ソート順位
		'order_type'		=>	'',	//ソート順位
		'text_test'			=>	'',	//テスト
		'cat_check_on'	=>	'',	//相違カテゴリーのアップデート・チェック。ほぼ不使用
		'update_cat'		=>	'',	//相違カテゴリーのアップデート

		'time_min'      => '',  //最低タイム。この数字からスタート。
		'time_max'      => '',  //最大タイム。この数字まで。

		'index_t'       =>  70, //outlineのt番号。初期値は70。

		//'t'							=>	'',	//使用終了。削除予定。2022-06-10
		//'s'							=>	'',	//使用終了。削除予定。2022-06-10

		//'sys_h2'				=>	'',
		//'sc_off'				=>	'', //不明
	];
	$kxra = new raretu;
	return $kxra->kxra_Main( shortcode_atts( $args , $atts ) );
}


class raretu
{

//初期値の保存用。2023-02-26
public $kxraS0;

//S1を配列として設置。2023-02-26
public $kxraS1 =
[
	'c' 												=> NULL,	//ショートコードの値。2023-02-26
	'j' 												=> NULL,	//ショートコードの値。2023-02-26
	'je' 												=> NULL,	//ショートコードの値。2023-02-26

	'gaku'											=> NULL,	//DBTemplate対策。カットはoff。2024-02-06
	'c0' 												=> NULL,	//DBTemplate対策。2023-09-25
	'tag' 											=> NULL,	//DBTemplate対策。2023-09-25
	'index_t'                   => 70,    //DBTemplate対策。2023-09-25

	'memo'											=> NULL,

	'order'											=> [],	//$kxraSaから統合。2023/02/27。
	'order_j_je'								=> 'N/A',//$kxraSaから統合。2023/02/27。

	'id_base' 									=> NULL,	//ポストID。2023-02-26
	'title_base'								=> NULL,	//ポストタイトル。2023-02-26

	'content'                   => NULL ,
	'time_sa'                   => NULL ,
	'shortcode' 	              => NULL ,
	'shortcode_format' 	        => NULL ,
	'shortcode_format_id'       => NULL ,
	'shortcode_format_one_way'  => NULL ,
	'shortcode_format_base'    	=> NULL ,

	'DB_ON'											=> NULL, //kxxの自己呼び出し対策。2023-02-28
];

//DB系の設定。主にソートに使用。2023-02-27
public $kxraS_DB;

//各ポストの設定。2023-02-27
public $kxraS_post = [];

//アウトプットの設定用。2023-07-04
public $kxraS_Out;

//各検索済みのid。2023-02-27
public $kxra_arr_id;

//メインhtmlへの出力用。2023-07-03
public $kxraM = [
	'top_text' => null,
];


//memory保存用。
public $kxra_memory;

//Error表示用。2023-03-23
public $kxra_error			= [ 'memo' =>  'error：初期状態' ];


public $kxra_Heading_memo;
public $haeding_title_add;
public $haeding_plot_on;
//public $outline_only;

//public $kxra_judge;
public $contents;

//public $class;

public $h_x;
//public $bar;
public $plot;
public $plot_old;

//public $add_gaiyou_name;
//public $add_gaiyou;
//public $add_idea;
//public $add_study;
//public $add_analyze;
//public $add_Sensitivity;
//public $add_Plan;

/*
	public $update;
	public $update_text;
	public $id_count;
	public $end_list;
	public $ra_title_divide;
	public $ver;
*/

/**
* 判断。下で上書き。
* 2022/06/10。
*/
public $kxraJUDGE =
[
	'kxra_type' =>
	[
		'array' =>
		[
			0 =>  //初期値。2022/06/10
			[
				'preg' 			=> '/./' ,
				'settings' =>
				[
					't' 		=> 'set' ,
					't2'		=> 'set' ,
					'auto'	=> 'wws' ,
				],
			] ,

			'Chara_Base_W' =>  //初期値。2022/06/10
			[
				'preg' 			=> '/^∬\d{1,}≫c\w{1,}≫c\w{1,}$/',
				'settings' =>
				[
					't' 		=> 'set' ,
					't2'		=> 'set' ,
					'auto'	=> 'wws' ,
				],
			] ,

			'来歴' =>
			[
				'preg' 			=> '/^∬\d{1,}≫c\w{1,}.*来歴/' ,
				'settings' =>
				[
					't' 		=> 'chara' ,
					't2'		=> 'chara' ,
					'auto'	=> 'wws' ,
				],
			],

			'来歴作品' =>
			[
				'preg' 			=> '/^∬\d{1,}≫c\w{1,}.*(ksy|olf|ygs|pnm|sys)\d{1,}≫来歴$/i' ,
				'settings' =>
				[
					't' 		=> 'chara_ww' ,
					't2'		=> 'chara' ,
					'auto'	=> 'wwr' ,
				],
			],
		],
	],

	'kxra_name_bar_color' =>
	[ 'array' =>
		[
			'etc' => //その他
			[
				'preg' 	=> '/./' ,
				'settings' => 45,
			],

			'a' => //その他
			[
				'preg' 	=> '/a|g|m|s/' ,
				'settings' => 0,
			],

			'b' => //その他
			[
				'preg' 	=> '/b|h|n|t|x|y|z/' ,
				'settings' => 60,
			],

			'c' => //その他
			[
				'preg' 	=> '/c|i|o|t/' ,
				'settings' => 120,
			],

			'd' => //その他
			[
				'preg' 	=> '/d|j|p|v/' ,
				'settings' => 180,
			],

			'e' => //その他
			[
				'preg' 	=> '/e|k|q|w/' ,
				'settings' => 240,
			],

			'f' => //その他
			[
				'preg' 	=> '/f|l|r/' ,
				'settings' => 300,
			],

			'xyz' => //その他
			[
				'preg' 	=> '/x|y|z/' ,
				'settings' => 330,
			],
		],
	],

	'kxra_chara_count' =>
	[ 'array' => //横幅。たまに狂わされるが、ブラウザの拡大縮小が影響。？2024-11-14
		[
			'5up' =>
			[
				'preg' 			=> '/./' ,
				'settings' =>
				[
					'css_div' 		=> '__kxra_wwr_div5' ,
					'css_div_B' 		=> '__kxra_wwr_div5_B' ,
					//'width'  		  => 327,
				],
			],

			'1' =>
			[
				'preg' 			=> '/0/' ,
				'settings' =>
				[
					'css_div' 		=> NULL ,
					//'width'  		  => NULL,
				],
			],

			'2' =>
			[
				'preg' 			=> '/1/' ,
				'settings' =>
				[
					'css_div' 		=> '__kxra_wwr_div2' ,
					'css_div_B' 		=> '__kxra_wwr_div2_B' ,
					//'width'  		  => 820,
				],
			],

			'3' =>
			[
				'preg' 			=> '/2/' ,
				'settings' =>
				[
					'css_div' 		=> '__kxra_wwr_div3' ,
					'css_div_B' 		=> '__kxra_wwr_div3_B' ,
					//'width'  		  => 550,
				],
			],

			'4' =>
			[
				'preg' 			=> '/3/' ,
				'settings' =>
				[
					'css_div' 		=> '__kxra_wwr_div4' ,
					'css_div_B' 		=> '__kxra_wwr_div4_B' ,
					//'width'  		  => 410,
				],
			],

		],
	],
];

//public	$kxraSa				= [];	//S1に統合。
//public $DB_order_type; $kxraS_DBに統合。
//public $DB_1st;
//public $ra_search1; //一段回検索。2023-02-26
//public $ra_search2; //検索したidの配列。2023-02-26
//public $arr_sort;
//public $ra_set1				= [];
//public	$kxraM				= [];//出力用素材。
//public $kxra_memo;$kxraS_DBに統合。2023-02-27
//public $error;

//public $ra_set_t1_t2;
//public $TEST;

/*
public	$ver	= [
'raretu'	=>[
	'main'							=> 245,
	'set'								=> 1,
	'chara'							=> 1,
	'data'							=> 1,	//古いタイプ訳。2020/06/20現在はSetに統一。
	'etc'								=> 1,
	'version_minor'			=> 'A0',
]
];
*/

//まだ未使用。
//public	$kxraSa_base	= [];




/*
public	$ra_set0			= [
'content_margin'  =>	'0',
];
*/


/**
* メインプログラム
*
* @param [type] $args
* @return string
*/
public function kxra_Main( $args ){
	//echo kx_display_child_hierarchy_ids();//TEST

	$this->kxraS0	= $args;

	// C0. キャッシュ処理準備
	$post_id = get_the_ID();

//echo'+';
//var_dump(KxDy::get('content'));



	//エラー排除
	if(	$this->kxra_Error_Start_Elimination() )
	{
		return $this->kxra_error[ 'memo' ];
	}

	//各種・設定
	$this->kxra_Setting1_a();
	$this->kxra_Setting1_ErrorCheck();
	$this->kxra_Setting1_c();
	$this->kxra_Setting1_SESSION();


	if( !empty( $this->kxraS1[ 'table_name'] ) ) //AIで作ったdb型。DBからの検索。2025-04-05
	{
		//id指定型。2025-11-02
		if( $this->kxraS1[ 'table_name']  == 'db_list')
		{
			$table_name = 'wp_kx_temporary';
			$where  = ['type' => 'DB_list' ];

			$results = kx_db_Read(
				$table_name, $where
			);

			$this->kxraS1[ 'table_name']   = $results[ 0 ]->text1;
			$this->kxraS1[ 'conditions']   = $results[ 0 ]->text2 . '=%'.$results[ 0 ]->text3.'%';
			echo '<div style="margin-left:10px;color:red;">DB_Lost_TEXT3= '.$results[ 0 ]->text3.'</div>';
		}

		$this->kxra_search_Table();
		if( !empty($this->kxraS1[ 'tougou'] ))
		{
			kx_db1(
				[
					'id'  => $this->kxraS1[ 'id_base' ] ,
					'ids' => $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ],
					'consolidated_to'    => $this->kxraS1[ 'tougou']
				]
				,'consolidated_to'
			);

			/*
			kx_db0(
				[
					'id' =>$this->kxraS1[ 'id_base' ] ,
					'ids' => $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ],
				]
				,'raretu_add'
			);
			*/
		}

	}
	elseif( !empty( $this->kxraS1[ 'db'] ) )
	{
		$this->kxra_search_DB(); //db型を指定。DBからの検索。2023-02-27
	}
	else
	{
		$_args['id'] = $this->kxraS1[ 'id_base' ];

		//echo $this->kxraS1[ 't' ];
		if(
			!empty($this->kxraS1[ 'c' ]) &&
			(
				$this->kxraS1[ 't' ] == 'chara_ww' ||
				$this->kxraS1[ 't' ] == 'chara_w'
			)
		)
		{
			$_args['characters'] =  $this->kxraS1[ 'c' ] ;
		}
		elseif( preg_match('/^(∬\d{1,}≫c\w{1,})≫(c\w{1,})$/',$this->kxraS1[ 'title_base' ] ,$matches ) )
		{
			$this->kxraS1['t3']	= 'Chara_Base_W';
			$_args['Chara_Base_W'] =
			[
				$matches[1].'≫2構成',
				$matches[1].'≫＼'.$matches[2],
			];
		}
		elseif(!empty($this->kxraS1['tougou_sort']))
		{
			$_args['tougou_sort'] = $this->kxraS1['tougou_sort'];
		}

		$_raretu_DB = ( kx_db0( $_args ,'raretu_read' ) );



		//var_dump($this->kxraS1);
		//echo '<hr>';
		//echo $_args['id'];
		//var_dump($_raretu_DB);

		if( !empty( $_raretu_DB[ 'time' ] ))
		{
			if(!empty( $_raretu_DB['reload']))
			{
				$_clear_on = '余分ID削除';
			}
			$_time = time() - $_raretu_DB[ 'time' ] ;

			if(empty( KxDy::get('trace')['kxx_sc_count'] ?? null )  && $_time > 2 && $_time < 5  )
			{
				$_clear_on = 'time';
			}

			if( !empty( $_clear_on ) )
			{
				$_text = 'DB削除'.$_clear_on.'：'.$_time.'s：'.get_the_title( $this->kxraS1[ 'id_base' ] ) ;
				echo '<div id="error-message5" class="__error_fixed_left_bottom__">'.$_text.'</div>';
				unset( $_raretu_DB[ 'ids' ] );
			}
		}

		if( empty( $_raretu_DB[ 'ids' ] ) )
		{
			if( !empty($this->kxraS1[ 'tougou_sort' ]) )
			{
				return ;
			}

			if( empty( $_clear_on ) )
			{
				echo '<div id="error-message2" class="__normal_fixed_left_bottom__">羅列FULL検索ON</div>';
			}

			//一段目検索（Wordpress通常型）。2023-02-27
			$this->kxra_search1();

			//二段目検索
			$this->kxra_search2();

			//var_dump($this->kxraS1['c']);


			$_array_id = (empty($this->kxraS1['c']))?	$this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] : null;

			kx_db0(
				[
					'id' =>$this->kxraS1[ 'id_base' ] ,
					'ids' => $_array_id,
				]
				,'raretu_add'
			);

		}
		else
		{
			//echo '+'.$_time;
			$this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] = $_raretu_DB[ 'ids' ];
			$this->kxra_arr_id[ 'search_1' ][ 'memory_on' ]	= NULL;

			/*
			echo count( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ]).'<br>';
			foreach($this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] as $_id ):
				echo get_the_title( $_id);
				echo '<br>';
			endforeach;
			*/


		}
	}

	//Error排除
	if( !empty( $this->kxra_error[ 'error_type' ] ) )
	{
		return kx_CLASS_error( $this->kxra_error );
	}
	elseif( !is_array( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] )  )
	{
		//配列なし・ショートコード対応
		return $this->kxra_error_NoID();
	}
	else
	{
		// 下位カテゴリのIDをすべて取得して、タイトル変更対象として格納
		$this->kxra_arr_id['title_change_ids'] = $this->kxra_arr_id['search_end']['arr_id'];

		/*
		$base_ids = $this->kxra_arr_id['title_change_ids'];  // 初期ID群
		$all_ids = [];

		foreach ($base_ids as $_id) {
				kx_db0_raretu_get_all_sub_ids($_id, $all_ids); // 下位IDを再帰的に取得
		}
		unset($_id);

		// $all_ids に取得した全IDを追加
		$this->kxra_arr_id['title_change_ids'] = array_merge($this->kxra_arr_id['title_change_ids'], $all_ids);

		// 最終的にベースIDも明示的に追加（重複の可能性がある場合は要チェック）
		$this->kxra_arr_id['title_change_ids'][] = $this->kxraS1['id_base'];
		*/
	}


	//ソート
	$this->kxra_sort();
	if( !empty( $this->kxra_error[ 'error_type' ] ) )
	{
		return kx_CLASS_error( $this->kxra_error );
	}

	if( !empty($this->kxraS1[ 'tougou_sort' ]) )
	{
		return $this->kxra_arr_id[ 'sort' ]['arr_id'];
	}

	//エラー排除。タイトルミス
	if( preg_match(	'/≫≫/' , $this->kxra_arr_id[ 'sort' ][ 'new_title_list_check' ]	, $matches ) )
	{
		$this->kxra_error['type']	= 'タイトルミス⇒';
		$this->kxra_error['memo']	= $matches[ 0 ] . 'Line:' . __LINE__ ;
		$this->kxra_error['title']	= $this->kxraS1[ 'title_base' ].'+'.$this->kxra_arr_id[ 'sort' ][ 'new_title_list_check' ];

		return kx_CLASS_error( $this->kxra_error );
	}
	unset( $matches );


	//分岐・wwS・wwR
	if(	!empty( $this->kxraS1[ 'outline_only' ] ) )
	{
		//トップのoutline・オンリー。contents（本体表示）なし。
		$this->kxra_outline_only();
		foreach( $this->kxra_arr_id[ 'sort' ]['arr_id'] as $_id_tougou)
		{
			//echo '+';
			kx_tougou_update($_id_tougou);
		}


	}
	elseif(	$this->kxraS1[ 'kxra_type' ][ 'auto' ] == 'wws' )
	{

		//wwS
		$this->contents	= $this->kxra_wws();
	}
	elseif( $this->kxraS1[ 'kxra_type' ][ 'auto' ] == 'wwr')
	{

		//wwR
		$this->contents	= $this->kxra_wwr();
	}

	//return	$this->kxra_output();



	return  $this->kxra_output(); // 最終的なHTML生成
}



/**
* 基本項目の設定。
* 2022/06/10
*
* @return void
*/
public function kxra_Setting1_a(){

	// S1生成。2023-02-26
	$this->kxraS1 = $this->kxraS0 + $this->kxraS1;

	$this->kxraS1[ 'id' ]  = $this->kxraS1[ 'tougou_sort' ] ?? null;

	// 基本・要素獲得
	if( empty( $this->kxraS1[ 'id' ] ) )
	{
		$this->kxraS1[ 'id' ] 		= get_the_ID();
	}

	$this->kxraS1[ 'id_base' ] 		= $this->kxraS1[ 'id' ];
	$this->kxraS1[ 'title_base' ] = get_the_title($this->kxraS1[ 'id' ]);
}



/**
 * 基本要素設定。
 * エラーチェックと表示。
 * html、echo系。
 * 2023-07-03
 *
 * @return void
 */
public function kxra_Setting1_ErrorCheck(){


	$post		       = get_post( $this->kxraS1[ 'id_base' ] );
	$_post_content = preg_replace(	'/\[.*\]/'	,	''	,	$post->post_content	);

	if( preg_match( '/\[raretu \]/' ,$post->post_content) )
	{
		//空白あり。空白削除。リロード。2024-06-24
		echo '<div style="text-align:center;height:100px;background:red;color:white;">';
		echo '<div style="font-size:x-Large;text-align:center;">■ERROR■raretuの余分スペース■'.$post->post_title.'■■■</div>';
		echo '<div><button onclick="location.reload();">リロード：'.$post->post_title.'</button></div>';
		echo '<div><a href="#" onclick="location.reload();">リロード</a></div>';

		//自動アップデート。2023-07-02
		$update_post =
		[
			'post_title'  	=> $post->post_title,
			'ID'					  => $this->kxraS1[ 'id_base' ],
			'post_content'  => "[raretu]",
		];

		print_r( $update_post );
		wp_update_post( $update_post );
		echo '</div>';
	}


	if(	!empty( $_post_content ) )
	{
		//contents(残りカス)ありチェック。2023-07-02
		echo kx_CLASS_error(
		[
			'error_type' =>	'output',
			'text'	     =>	'ID' . $this->kxraS1[ 'id_base' ] . ' NO SAVE。コンテンツあり'.get_the_title( $this->kxraS1[ 'id_base' ] ),
			'memo'	     =>	'NO SAVE。コンテンツあり',
			'Title'	     =>	get_the_title( $this->kxraS1[ 'id_base' ] ),
			'LINE'	     =>	__LINE__,
			'TEST'	     =>	$_post_content.'+',
		] );
	}

	if( preg_match( '/\[raretu.* s=.*\]/' , $post->post_content ) )
	{
		//削除予定箇所。2022/06/10
		echo kx_CLASS_error( 'shortChord Error『s=』の問題：'.$this->kxraS1[ 'title_base' ] );
	}


	if( preg_match( '/\[raretu.* t=.*\]/' ,$post->post_content) )
	{
		//削除予定箇所。2022/06/10
		echo kx_CLASS_error( 'shortChord Error『t=』の問題：'.$this->kxraS1[ 'title_base' ] );
	}
}



/**
* 旧ra_setの設定。2023-02-27
* kxraS1に統合。2023-02-27
*/
public function kxra_Setting1_c(){

	//カラー呼び出し。色相。2022/06/10
	$this->kxraS1[ 'c_sikisou' ] = kx_CLASS_kxcl(	get_the_title( $this->kxraS1[ 'id_base' ] )	,	'色相' )[ '色相' ];

	//創作ワールド取得。template判断。2025-09-10
	if( preg_match(	'/^∬(\d{1,})/' , $this->kxraS1[ 'title_base' ] , $_matches ) )
	{
		$this->kxraS1[ 'title_world' ] = $_matches[1];

		$kxtp = new kxtp;
		$_raretu_template = $kxtp->kxtp_Main(['type'=>'raretu_template']);

		if( !empty($_raretu_template))
		{
			$this->kxraM[ 'template_on' ] = 1;
			$this->kxraM[ 'template' ] = $_raretu_template;
		}



	}
	else
	{
		$this->kxraS1[ 'title_world' ] = NULL;
	}
	unset( $_matches );


	//タイプ判定。タイトル別。t,t2,auto,を呼び出し。基本はset、wws。2023-07-03
	$this->kxraS1[ 'kxra_type' ] = kx_Judge_OLD( $this->kxraJUDGE[ 'kxra_type' ] , 'preg' , $this->kxraS1[ 'title_base' ] )[ 'settings' ];

	//廃止予定。2023-07-03
	$this->kxraS1[ 't' ] = $this->kxraS1[ 'kxra_type' ][ 't' ];

	//廃止予定。2023-07-03
	$this->kxraS1[ 't2' ] = $this->kxraS1[ 'kxra_type' ][ 't2' ];


	//t2タイプ分岐。キャラ・タグなど。2022/06/10
		//$this->kxraS1[ 'search_list_on' ] = NULL;

	$this->kxraS1[ 'search' ]        = NULL;
	$this->kxraM[ 'class_contents' ] = NULL;
	if( $this->kxraS1[ 'kxra_type' ][ 't2' ]	== 'chara')
	{
		//キャラクター系。2023-07-04

		$this->kxraM[ 'class_contents' ] = '_chara_';
		$this->kxraS1[ 'sys_kxx10' ]	   = 'edit_chara';

		//メインキャラ（ヒロイン）ナンバー・獲得。2023-07-04
		preg_match('/^∬\d{2}≫c(\d\w{1,}\d)/i', $this->kxraS1[ 'title_base' ] , $_matches );

		$this->kxraS1[ 'chara_num_arr' ][ 0 ]	= $_matches[1];
		$this->kxraS1[ 'tag' ]	= 'c'.$_matches[1];

		unset( $_matches );


		//作品要素取得（t:chara）
		$this->kxraS1[ 'kxtt' ] = kx_CLASS_kxTitle( [
			'type'  => 'work',
			'title' => $this->kxraS1[ 'title_base' ] ,
		]);

		$this->kxraS1[ 'code' ] = strtolower( $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] ) . $this->kxraS1[ 'kxtt' ][ 'work_code_number_s' ];

		if( !empty( $this->kxraS1[ 'kxtt' ][ 'character_gaku' ] ))
		{
			$this->kxraS1[ 'gaku' ] = $this->kxraS1[ 'kxtt' ][ 'character_gaku' ];
		}


		$this->kxraS1[ 'chara_count' ]  = 0;

		//kxttのwork系上書き。

		if( !empty( $this->kxraS1[ 'kxtt' ][ 'work_plot_time_min' ] ) )
		{
			$this->kxraS1[ 'time_min' ] = $this->kxraS1[ 'kxtt' ][ 'work_plot_time_min' ];
		}

		if( !empty( $this->kxraS1[ 'kxtt' ][ 'work_plot_time_max' ] ) )
		{
			$this->kxraS1[ 'time_max' ] = $this->kxraS1[ 'kxtt' ][ 'work_plot_time_max' ];
		}

		//Cの上書き。kxttにある場合。2024-06-22
		if( !empty( $this->kxraS1[ 'kxtt' ][ 'work_charas' ] ) )
		{
			$this->kxraS1[ 'c' ] = $this->kxraS1[ 'kxtt' ][ 'work_charas' ];
		}


		if( !empty( $this->kxraS1[ 'c' ] ) )
		{
			foreach( explode(	","	, $this->kxraS1[ 'c' ] ) as $_value):

				$this->kxraS1[ 'chara_count' ]++;
				$this->kxraS1[ 'chara_num_arr' ][	$this->kxraS1[ 'chara_count' ] ]	= $_value;

			endforeach;
			unset( $_value );

			$this->kxraS1[ 'chara_count_judge' ] = kx_Judge_OLD( $this->kxraJUDGE[ 'kxra_chara_count' ] , 'preg' , $this->kxraS1[ 'chara_count' ]  )[ 'settings' ];
		}
		else
		{
			$this->kxraS1[ 'search' ]					= $this->kxraS1[ 'title_base' ];
		}

		$this->Setting1_characters();

		//年齢作成。2024-02-06
		if( empty( $this->kxraS1[ 'csa' ] ) )
		{
			//年齢呼び出し。メインキャラ。2024/02/06
			$_age_chara = kx_CharacterAge( [ 'title' => $this->kxraS1[ 'title_base' ] ] );

			//echo $_age_chara;

			$this->kxraS1[ 'csa' ] = '';

			foreach( explode( ',' , $this->kxraS1[ 'c' ] )  as $value ):

				if(
						preg_match( '/∬\d{1,}≫c[1|2]/' , $this->kxraS1[ 'title_base' ]  )
						&& $this->kxraS1[ 'title_world' ] == 10
						&& ( $value == 301 || $value == 302 )
					)
				{
					//スルー。Σシリーズのクローン。2024-02-06
				}
				else
				{
					$_age = kx_CharacterAge( [ 'title' => '∬' . $this->kxraS1[ 'title_world' ] . '≫c' . $value ] );


					if( !empty ( $_age ) )
					{
						if( $_age == 'zero')
						{
							$_age = 0;
						}

						if( $_age_chara == 'zero')
						{
							$_age_chara = 0;
						}
						//echo $_age_chara;
						$_age = $_age_chara - $_age ;
					}
					/*
					elseif( $value == 989 && $this->kxraS1[ 'title_world' ] != 10 )
					{
						$_age = $_age_chara - 0 ;
					}
						*/
					$this->kxraS1[ 'csa' ] .= $_age;
				}

				$this->kxraS1[ 'csa' ] .= ',';

			endforeach;
			unset( $value ) ;
		}

	}
	elseif( $this->kxraS1[ 'kxra_type' ][ 't2' ] == 'set' )
	{
		//Set系。2023-07-04。
		$this->kxraS1[ 'sys_kxx10' ]		 =  'reference_off';
		$this->kxraS1[ 'chara_num_arr' ] = NULL;
		$this->kxraS1[ 'chara_count' ] 	 = NULL;
		$this->kxraS1[ 'kxtt' ]          = NULL;
		$this->kxraS1[ 'code' ]	         = NULL;
		$this->kxraS1[ 'search' ]	       = $this->kxraS1[ 'title_base' ];
	}
	else
	{
		//Errorパターン。2023-07-04
		$this->kxraS1[ 'sys_kxx10' ]		 =  'reference_off';
		$this->kxraS1[ 'chara_num_arr' ] = NULL;
		$this->kxraS1[ 'chara_count' ]   = NULL;
		$this->kxra_error['type']        = 't2';
		$this->kxra_error['memo']        = 't2・無し';
	}



	//csa・年齢差調整。2022/06/10
	//ない場合は、上記で作成している。2024-02-06
	if( !empty( $this->kxraS1[ 'csa' ] ) )
	{
		$this->kxraS1[ 'csa' ]     = '0,'. $this->kxraS1[ 'csa' ];
		$this->kxraS1[ 'csa_arr' ] = explode(",", $this->kxraS1[ 'csa' ] );
	}
	else
	{
		$this->kxraS1[ 'csa_arr' ] = NULL;
	}

	//ヒロイン介入
	if( $this->kxraS1[ 'c0' ]  )	//ヒロイン番号
	{
		$this->kxraS1[ 'tag1' ]	= $this->kxraS1[ 'tag' ] .',c' . $this->kxraS1[ 'c0' ];
	}
	else
	{
		$this->kxraS1[ 'tag1' ]	= $this->kxraS1[ 'tag' ];
	}


	//カテゴリー取得
	if( !empty($this->kxraS0[ 'cat' ]) )
	{
		$_get_category = get_category( $this->kxraS0[ 'cat' ] );
		$this->kxraS1[ 'catname' ]	= $_get_category->cat_name;
	}
	else
	{
		$_get_categorys = get_the_category( !empty($this->kxraS1['tougou_sort']) ? $this->kxraS1['tougou_sort'] : null );

		$_end_category             = end(	$_get_categorys	);

		$this->kxraS1[ 'cat' ]	   = $_end_category->cat_ID;
		$this->kxraS1[ 'catname' ] = $_end_category->cat_name;
	}


	//タグ取得
	if( !$this->kxraS1[ 'tag' ]  )
	{
		$_get_tags = get_the_tags();

		if( !empty( $_get_tags ) )
		{
			$this->kxraS1[ 'tag' ] = '';

			foreach (	$_get_tags as $_value ) :

				$this->kxraS1[ 'tag' ]	.= $_value->name.' ';

			endforeach;
			unset(	$_value	);

			$this->kxraS1[ 'tag' ]	=  substr( $this->kxraS1[ 'tag' ] , 0, -1);
		}
	}

	//ソート用順位 $j,$je

	if(	!empty( $this->kxraS1[ 'order_type' ] ) && !empty( KxSu::get('raretu')[ 'order_type' ][ $this->kxraS1[ 'order_type' ] ] ) )
	{
		$this->kxraS1[ 'j' ]	= KxSu::get('raretu')[ 'order_type' ][ $this->kxraS1[ 'order_type' ] ][ 0 ];
		$this->kxraS1[ 'je' ]	= KxSu::get('raretu')[ 'order_type' ][ $this->kxraS1[ 'order_type' ] ][1];
		$this->kxraS1[ 'order_j_je' ] = 'order_type:'.$this->kxraS1[ 'order_type' ];
	}
	elseif(	empty( $this->kxraS1[ 'j' ] ) && empty( $this->kxraS1[ 'je' ] )	)
	{
		foreach( KxSu::get('raretu')[ 'order' ]	as $_key	=>	$_value ):

			if(	preg_match(	$_key	,	$this->kxraS1[ 'title_base' ]	)	)
			{
				$this->kxraS1[ 'j' ]	        = $_value[ 0 ];
				$this->kxraS1[ 'je' ]	        = $_value[ 1 ];
				$this->kxraS1[ 'order_j_je' ] = $_key;
				break;
			}

		endforeach;
		unset(	$_key	,	$_value	);

		foreach( KxSu::get('raretu')[ 'order_add' ]	as $_key	=>	$_value ):

			if(	preg_match(	$_key	,	$this->kxraS1[ 'title_base' ]	)	)
			{
				$this->kxraS1[ 'j' ]	= $_value[ 0 ] . $this->kxraS1[ 'j' ];
				$this->kxraS1[ 'je' ]	= $_value[1] . $this->kxraS1[ 'je' ];

				break;
			}

		endforeach;
		unset(	$_key	,	$_value	);
	}
	else
	{
		$this->kxraS1[ 'order_j_je' ] = 'SC_ON';
	}


	//ソート用配列作成。2023-07-03
	if( !empty( $this->kxraS1[ 'j' ] ) )
	{
		$this->kxraS1[ 'sort_order' ] = explode( ',' , $this->kxraS1[ 'j' ] );
		//echo $j;
	}
	/*
	else
	{
		$this->kxraS1[ 'sort_order' ][ '1' ]	= '設計';
	}
	*/


	if( !empty( $this->kxraS1[ 'je' ] ) )
	{
		foreach( explode(',' , $this->kxraS1[ 'je' ] ) as $_key => $_value ):

			$this->kxraS1[ 'sort_order' ][ '100'.$_key ]	= $_value;

		endforeach;
		unset(	$_key	,	$_value	);
	}
	else
	{
		$this->kxraS1[ 'sort_order' ]['1001']	= 'その他';
		$this->kxraS1[ 'sort_order' ]['1002']	= '一覧';
		$this->kxraS1[ 'sort_order' ]['1003']	= 'リンク';
		$this->kxraS1[ 'sort_order' ]['1004']	= '関連';
	}

	//kx10系のsysに追記。t1t2
	if( $this->kxraS1[ 'kxra_type' ][ 'auto' ] == 'wws' )
	{
		$this->kxraS1[ 'sys_kxx10' ]	.= ',edit_on_title,new_on,plot_on,hr_off,hr_off';
	}
	else
	{
		$this->kxraS1[ 'sys_kxx10' ]	.= ',edit_on,new_on,plot_on,hr_off';
	}


}



/**
* セッティング。$this->kxraS1で出力。
* 2022-06-10
*
* @return void
*/
public function kxra_Setting1_SESSION(){
	//年齢・学年・修学範囲系。Session出力。
	if( $this->kxraS1[ 'kxra_type' ][ 't' ] == 'set')
	{
		//2024-06-13
		$_SESSION[ 'raretu' ][ 'gakunen_hani' ][ 'set' ]	= NULL;
	}
	elseif( !empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
	{
		$_SESSION[ 'raretu' ][ 'gakunen_hani' ][ $this->kxraS1[ 'kxtt' ][ 'character_number'] ]	= NULL;
	}
	else
	{
		$_SESSION[ 'raretu' ][ 'gakunen_hani' ][ $this->kxraS1[ 'kxtt' ][ 'character_number'] ]	= $this->kxraS1[ 'gaku' ];
		if( preg_match( '/^(∬\d{1,}≫).*＼(c\d\w{1,}\d)≫来歴/' , $this->kxraS1[ 'title_base' ] , $matches ) )
		{
			$_etc_chara_kxtt = kx_CLASS_kxTitle( [
				'type'  => 'character',
				'title' => $matches[1] . $matches[2] ,
			]);

			if( !empty( $_etc_chara_kxtt[ 'character_age_sa'] ) )
			{
				$_etc_chara_sa = $_etc_chara_kxtt[ 'character_age_sa'];
			}
			else
			{
				$_etc_chara_sa = 0;
			}

			if( $_etc_chara_sa == 'zero')
			{
				$_etc_chara_sa = 0;
			}

			if( $this->kxraS1[ 'kxtt' ][ 'character_age_sa' ] == 'zero')
			{
				$this->kxraS1[ 'kxtt' ][ 'character_age_sa' ] = 0;
			}

			$_SESSION[ 'raretu' ][ 'etc_chara' ][ 'ON' ]	= '＼ON';
			$_SESSION[ 'raretu' ][ 'etc_chara' ][ 'sa' ]	= $_etc_chara_sa - $this->kxraS1[ 'kxtt' ][ 'character_age_sa' ];
		}
		unset( $matches ) ;

	}

	if( !empty($this->kxraS0[ 'gaku' ] ) && $this->kxraS0[ 'gaku' ] == 'off' ) //S0であることが重要。2024-06-20
		{
			$_SESSION[ 'raretu' ][ 'gaku_off' ] = 1;
		}




	//羅列ツリーのCOUNT。上位羅列があるか否か。2022/06/10
	if( empty( $_SESSION[ 'raretu' ][ 'count' ] ) )
	{
		$_SESSION[ 'raretu' ][ 'count' ] = 1;
	}
	else
	{
		$_SESSION[ 'raretu' ][ 'count' ]++;
	}


	//dbか否か。Sample作品関係で必要。2023-08-27
	if( !empty( $this->kxraS0[ 'db'] ) )
	{
		//db型を指定。DBからの検索。2023-02-27
		$_SESSION[ 'raretu' ][ $this->kxraS1[ 'id_base' ] ][ 'db_ON' ] = 1;
	}


	$this->kxraS1[ 'raretu_count' ] = $_SESSION[ 'raretu' ][ 'count' ];

	//outlineのカラーオフ。
	$_SESSION[ 'Heading_count' ][ $this->kxraS1[ 'id_base' ] ][ 'color_off' ] = 1;

if(
		(
			!empty( $this->kxraS1[ 'raretu_count' ] )
			&& $this->kxraS1[ 'raretu_count' ]	!=1
		)
		|| !empty( KxDy::get('trace')['kxx_sc_count'] ?? null )
	)
	{
		$this->kxraS1[ 'outline_only' ]	= 1;
	}
}



/**
 * Undocumented function
 *
 * @return void
 */
public function Setting1_characters(){

	foreach( $this->kxraS1[ 'chara_num_arr' ]  as $key => $value ):

		$_kxcl = kx_CLASS_kxcl(	'∬'.$this->kxraS1[ 'title_world' ].'≫c'.$value.'≫来歴'	);

		$this->kxraS1[ 'chara_num_setting_array' ][ $value ][ '色相' ]        = $_kxcl[ '色相' ];
		$this->kxraS1[ 'chara_num_setting_array' ][ $value ][ 'hsla_normal' ] = $_kxcl[ 'hsla_normal' ];
		$this->kxraS1[ 'chara_num_setting_array' ][ $value ][ 'text_class' ]  = $_kxcl[ 'text_class' ];

		$this->kxraS1[ 'chara_num_setting_array' ][ $value ][ 'kxtt' ] =  kx_CLASS_kxTitle(
		[
			'type' => 'character' ,
			'title' => '∬'.$this->kxraS1[ 'title_world' ].'≫c'.$value,
		] );

	endforeach;
}

/**
 * kxxクラスによる一段目	Category検索
 * 配列化したIDを$this->kxra_arr_id[ 'search_1' ][ 'arr_id' ]に収納。
 * 2023-02-27
 *
 * @return void
 */
public function kxra_search1(){

	/*
	$kxx	= new kxx;
	$kxx->kxxS1	=
	[
		'orderby'		=> 'title',
		'order'			=> 'asc',
		'post_type'	=> 'post',
		'cat'				=> $this->kxraS1[ 'cat' ],
	];
	*/

	if(	$this->kxraS1[ 'tag1' ]	)
	{
		//$kxx->kxxS1[ 'tag' ]		= $this->kxraS1[ 'tag1' ];
		//$this->in_ra[ 'tag' ]		= $this->kxraS1[ 'tag1' ];	//必要？2020-07-22
		$this->kxraS1[ 'tag' ]	= $this->kxraS1[ 'tag1' ];	//必要？2020-07-22

		//$_tag	= $this->kxraS1[ 'tag1' ];
	}
	else
	{
		//$kxx->kxxS1[ 'tag' ]		= $this->kxraS1[ 'tag' ];
		//$this->in_ra[ 'tag' ]		= $this->kxraS1[ 'tag' ];	//必要？2020-07-22
		//$_tag	= $this->kxraS1[ 'tag' ];
	}


	//要注意要素。TEMPLATEの便利化設定。2021/10/01
	if( preg_match( '/∬\d{1,}≫c\d\w{1,}\d≫補足/' , $this->kxraS1[ 'title_base' ] ) )
	{
		//$kxx->kxxS1['tag_not']		= '来歴';
		$_tag_not = '来歴';
	}
	else
	{
		//$kxx->kxxS1['tag_not']		= NULL;
		$_tag_not = null;
	}

	$_args =
	[
		'cat' 		=> $this->kxraS1[ 'cat' ]	,
		'tag' 		=> $this->kxraS1[ 'tag' ],
		'orderby'	=> 'title',
		'order' 	=> 'asc',
		'tag_not' => $_tag_not,
	];

	$this->kxra_arr_id[ 'search_1' ][ 'arr_id' ]	= kx_CLASS_kxx( $_args	,'array_ids' )[ 'array_ids' ];

	$this->kxra_arr_id[ 'search_1' ][ 'memory_on' ]	= kx_session_memory( $_args );



	//print_r($_arr_id);

	/* 削除。旧版。2024-06-24
	$_memory0	= kx_session_memory(
	[
		'cat' 		=> $this->kxraS1[ 'cat' ]	,
		'tag' 		=> $_tag,
		'orderby'	=> 'title',
		'order' 	=> 'asc',
		'tag_not' => $kxx->kxxS1[ 'tag_not' ]
	] );



	if( !empty( $_SESSION[ 'kx_memory' ][ $_memory0 ] ))
	{
		$_arr_id	= $_SESSION[ 'kx_memory' ][ $_memory0 ];
		$this->kxra_arr_id[ 'search_1' ][ 'memory_on' ]	= $_memory0;
	}
	else
	{
		$this->kxra_arr_id[ 'search_1' ][ 'memory_on' ]	= NULL;

		$_arr_id	= $kxx->kxx_category_2();

		//ポスト戻し。概要表示でエラーになることが有る。2023-03-02
		if( get_the_ID() != $this->kxraS1[ 'id_base' ] )
		{
			global $post;
			$post = get_post( $this->kxraS1[ 'id_base' ] );
			setup_postdata( $post );
		}
	}

	$this->kxra_arr_id[ 'search_1' ][ 'arr_id' ]	= $_arr_id;

	*/
}



/**
 * kxxクラスによる二段目検索
 *
 *
 * @return void
 */
public function kxra_search2(){

	$kxx = new kxx;

	if( ( $this->kxraS1[ 't2' ] == 'set' || $this->kxraS1[ 't' ] == 'chara' ) && $this->kxraS1[ 'search' ] )
	{
		//ノーマル。2024-06-24
		$kxx->kxxS1[ 'search' ]	= $this->kxraS1[ 'search' ] .'≫ -共通\w{1,}$ -作業\w{3}$';

		/*
		多分、無意味。2024-09-23
		if( !preg_match( '/≫/' , $this->kxraS1[ 'title_base' ] ))
		{
			$kxx->kxxS1[ 'title_s' ]	='-≫.*≫.*≫';
		}
			*/

		$_arr_id = $kxx->kxx_title_2( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] );
	}
	elseif(	preg_match(	'/chara_w/', $this->kxraS1[ 't' ] ) )
	{
		//複数キャラクターの履歴型

		//Error排除
		if(	!preg_match( '/\d$/' , $this->kxraS1[ 'code' ] ) && $this->kxraS1[ 't' ] == 'chara_ww' )
		{
			return kx_CLASS_error(
			[
				'error_type'	=>	'output',
				'text'			=>	'タイトル未登録',
				'title'			=>	get_the_title(),
				'code'			=>	$this->kxraS1[ 'kxtt' ][ 'work_code_top1' ],
				'number'		=>	$this->kxraS1[ 'kxtt' ][ 'number' ],
				'number-s'	=>	$this->kxraS1[ 'kxtt' ][ 'number_s' ],
				'LINE'			=>	__LINE__,
			] );
		}


		$_search_code	= $this->kxraS1[ 'code' ] .' ';
		$_p_code			= '_'. $this->kxraS1[ 'code' ];


		//短縮形。機能するけど、未配備。2024-06-23
		/*
		if( $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] == 'S' )
		{
			$_p_code = preg_replace( '/_s\w{6}(\w{3})/' ,'(_s$1|'.$_p_code .')', $_p_code );
		}
		*/
		if( strtolower( $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] ) == 's' ) //$this->kxraS1[ 'tag' ] == 'c800'  ||
		{
			$_p_code = NULL;
		}

		foreach( $this->kxraS1[ 'chara_num_arr' ] as $_key1 => $_v_num):

			$_chara_code = NULL;
			if(	$_key1 == 0	)
			{
				//メイン以外を出力（==0 メインキャラを選択）

				if(	$this->kxraS1[ 't' ] == 'chara_ww')
				{
					$_search_code	= $_p_code . ' ';
				}

				//ヒロイン番号・介入
				if( !empty( $kxra->kxraS0[ 'c0' ] ) )
				{
					$_c_0s[]	= $_v_num;
					$_c_0s[]	= $kxra->kxraS0[ 'c0' ];
				}
				else
				{
					$_c_0s[]	= $_v_num;
				}

				//メインキャラ以外。2024-06-24
				foreach(	$_c_0s	as $_v_c0	):
					foreach( $this->kxraS1[ 'chara_num_arr' ] as $_key2 => $_v_chara_num ):
						//ヒロイン以外・主人公など
						if(	$_key2 != 0)
						{
							$kxx->kxxS1[ 'search' ]	 = $_search_code . ' c' . $_v_chara_num.'≫';
							$kxx->kxxS1[ 'search' ]	.= '＼c'.$_v_c0.'≫来歴≫  -作業\w{1,}$';
							$_arrID_new	= $kxx->kxx_title_2( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] );

							/*
							//★確認用。消すべからず。2023-08-09
							foreach( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] as $_id )
							{
								echo get_the_title( $_id );
								echo '<br>';							}

							echo 'TEST';
							echo '<br>search:';
							echo $kxx->kxxS1[ 'search' ];
							echo '<br>tag:';
							echo $kxx->kxxS1[ 'tag' ];
							echo '<br>';
							echo '$_arrID_new：';
							print_r($_arrID_new);
							echo '<br>';
							print_r( $kxx->kxxS1);
							echo '<hr>';
							*/

							if(	!empty( $_arr_id1 ) && is_array( $_arr_id1 ) && !empty( $_arrID_new ) )
							{
								$_arr_id1	= array_merge(	$_arr_id1, $_arrID_new	);
							}
							elseif(	!is_array( $_arrID_new ) )
							{
								//Error排除。
								echo '<div style="color:red;">ERROR ID無しNo'.$_v_chara_num.'-' . $this->kxraS1[ 'id_base' ] . '■'.get_the_title( $this->kxraS1[ 'id_base' ] ).'■key:'	. $_key1 . '■Line:'.	__LINE__	.	'</div>'; //スルー
							}
							else
							{
								$_arr_id1	= $_arrID_new;
							}

							//echo 'TEST';
							//print_r($_arr_id1);
							//echo '<hr>';
						}

					endforeach;
					unset( $_key2 );
				endforeach;

				//時間抽出。2024-06-24
				$_time_preg = '/';
				if( $this->kxraS1[ 'tag' ] == 'c800' )
				{
					foreach( $_arr_id1 as $_id1 ):

						//echo preg_replace( '/_s\w{1,}/' ,'', end( explode( '≫' , get_the_title( $_id1 ) ) ) );

						preg_match( '/(^(-|)\d.*)＠/', preg_replace( '/_s\w{1,}/' ,'', end( explode( '≫' , get_the_title( $_id1 ) ) ) ), $matches ) ;
						//echo $matches[1];
						//echo '<br>';

						$_time_preg .= $matches[1].'(_|＠)|';

					endforeach;
					unset( $matches );

					$_time_preg = substr( $_time_preg , 0, -1) .'/';
				}
			}
			else
			{
				//ヒロイン（ヒロイン以外選択・ヒロイン出力）■

				if( $this->kxraS1[ 't' ] == 'chara_ww' && !empty( $_p_code ))
				{
					$_search_code	= $_p_code.' ';
				}
				else
				{
					$_search_code = NULL;
				}

				foreach( $_c_0s as $_v_c1 ):

					$kxx->kxxS1[ 'search' ]	 = $_search_code;

					$kxx->kxxS1[ 'search' ]	.= '≫c' . $_v_c1 . '≫来歴≫\w{1,}.*?';
					//$kxx->kxxS1[ 'search' ]	.= '≫c' . $_v_c1 . '≫来歴≫\w{1,}.*?'. $_chara_code ;
					//$kxx->kxxS1[ 'search' ]	.= '≫c' . $_v_c1 . '≫来歴≫\w{1,}.*?'. $_chara_code .'： -共通\w{1,}$';

					if(	$this->kxraS1[ 't' ]	== 'chara_ww'&& $_key1 == 1 )
					{
						$_arrID_new	= $kxx->kxx_title_2( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] );
					}
					elseif(	$this->kxraS1[ 't' ]	== 'chara_ww'&& $_key1 != 1 )
					{
						//スルー
					}
					else
					{
						$_arrID_new	= $kxx->kxx_title_2( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] );
					}

					$_arrID_new	= $kxx->kxx_title_2( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] );

					//時間抽出。2024-06-24
					if( $this->kxraS1[ 'tag' ] == 'c800' && !empty( $_time_preg ) )
					{
						foreach( $_arrID_new as $_key3 => $_id_new ):

							if( !preg_match( $_time_preg , preg_replace( '/_s\w{1,}/' ,'', end( explode( '≫' , get_the_title( $_id_new ) ) ) ) ) )
							{
								unset( $_arrID_new[$_key3 ] );

							}
							else
							{
								/*
								echo get_the_title( $_id_new);
								echo '<br>';
								echo $_time_preg;
								echo '<br>';
								*/
							}
						endforeach;
					}

					//★
					//unset($_arrID_new);

					//配列合併
					if( !empty( $_arr_id1 ) && is_array( $_arr_id1 ) && $_arrID_new )
					{
						$_arr_id1	= array_merge(	$_arr_id1, $_arrID_new	);
					}
					elseif( !is_array( $_arrID_new ) )
					{
						/*
							スルー
							$_arr_id1	= $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ];
							★↑をやると大きなエラーが起きる。2020-11-14
							ここをスルーせずにヒロインのpostがないと。他のものを表示してしまう。
						*/

						echo kx_CLASS_error(
						[
							'error_type' =>	'output',
							'ERROR'	     =>	'★ヒロインpost無し★'.$this->kxraS1[ 'c' ].'Search:'.$kxx->kxxS1[ 'search' ],//2024-06-19
							'LINE'	     =>	__LINE__,
							't'		       =>	$this->kxraS1[ 't' ],
							't2'	     	 =>	$this->kxraS1[ 't2' ],
							'sys'	     	 =>	$this->kxraS1[ 'sys' ],
						] );

						echo '■■■<br>';
						print_r( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] );
						echo '<br>■■■';
					}
					else
					{
						$_arr_id1	= $_arrID_new;
					}

				endforeach;
			}

		endforeach;	//ナンバー出力
		unset( $_arr_id , $_key1 );

		$_arr_id = $_arr_id1;
	}
	else
	{
		//error出力。2023-02-27
		$this->kxra_error	=
		[
			'type'	=> 'ra_search2',
			'ERROR'	=> '$tの設定ERROR',
			'LINE'	=> __LINE__,
			't'			=> $this->kxraS1[ 't' ],
			't2'		=> $this->kxraS1[ 't2' ],
			'sys'		=> $this->kxraS1[ 'sys' ],
		];

		return;
	}
	$this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] = $_arr_id;
}



/**
* DB型search。
* 2022/06/10
* IDを検索し、$this->kxra_arr_id['search_end']['arr_id']に配列として収納。
*
* @return void
*/
public function kxra_search_DB(){

	//kxxの自據呼び出し対策。2023-02-28
	$this->kxraS1[ 'DB_ON' ] = 'raretu_db,';

	//global $wpdb;

	//DB-Temporary以外。2022/06/11。
	$_title 	= $this->kxraS1[ 'title_base' ];
	$_Column  = $this->kxraS1[ 'db'];

	$_db_like = '%'.$this->kxraS1[ 'db_like'].'%';


	$_gaiyou = preg_replace( '/%$/' , '' ,$_db_like);
	$_gaiyou = preg_replace( '/^.*%/' , '' , $_gaiyou );
	$this->kxraS_DB['sort_top'] = preg_replace( '/%/' , '' , $_gaiyou );

	//echo $this->kxraS_DB['sort_top'];

	$_db_like = preg_replace( '/%%/' , '%' ,$_db_like);


	//追記検索。Column。2022/06/11
	if( !empty( $this->kxraS0[ 'db2'] ) )
	{
		$_Column2 = $this->kxraS0[ 'db2'];
	}
	else
	{
		$_Column2 = '';
	}


	//追記検索。like。2022/06/11
	if( !empty( $this->kxraS0[ 'db_like2'] ) )
	{
		$_db_like2 = '%'.$this->kxraS0[ 'db_like2'].'%';
		$_db_like2 = preg_replace( '/%%/' , '%' ,$_db_like2);

		//and・orの分岐。
		if( empty( $this->kxraS0[ 'db_like2_and'] ))
		{
			//今日の場合はand。2023-03-01
			$_db_like2_AND = 'AND';
		}
		else
		{
			//主にorを使う場合の分岐。2023-03-01
			$_db_like2_AND = $this->kxraS0[ 'db_like2_and'];
		}
	}
	else
	{
		$_db_like2 = '';
		$_db_like2_AND = '';
	}


	$_db_like_key = preg_replace( '/＿.*/' , '' , $_db_like );
	$_db_like_key = preg_replace( '/%/'		 , '' , $_db_like_key );


	//羅列の上部への表示メモ。2022/06/11
	$this->kxraS1[ 'memo' ] = 'DB_Title：'.$_title.'<br>Columu：'.$_Column.'<br>like：'.$_db_like;

	//データベース分岐。2022/06/11。
	if( !empty( $this->kxraS0[ 'db_type'] ))
	{
		if( preg_match( '/'.KxSu::get('titile_search')[ 'SharedTitleDB' ]  .'/' , $_title  ) )
		{
			$db_type = $this->kxraS0[ 'db_type'];
		}
		elseif( preg_match( '/'.KxSu::get('titile_search')['kx_0_DB']  .'/' , $_title  ) )
		{
			$db_type = 'kx_0';
		}
		else
		{
			$db_type = $this->kxraS0[ 'db_type'];
		}
	}
	else
	{
		if( preg_match( KxSu::get('title_preg')['worksDB'] , $_title  ) )
		{
			$db_type = 'works';
		}
		else
		{
			$db_type = 'shared';
		}
	}

	//データベース分岐・検索。
	if( $db_type == 'works')
	{
		//DB_works。作品データベース。2023-03-01

		//echo $this->kxraS0[ 'db_type'].'++';
		//$this->kxraS_DB[ 'type'] = 'works'; コメントアウト。2023-02-27。多分使っていない。
		//preg_match( '/('.KxSu::get('titile_search')[ 'SharedTitleDB' ]  .')≫芸術・作品≫/' , $_title  , $matches );

		preg_match( '/^('.KxSu::get('titile_search')[ 'SharedTitleDB' ]  .')/' , $_title  , $matches );

		//KxSu::get('DBshare_title1_column')[$matches[1]];
		$_db_name = KxSu::get('DBshare_title1_column')[$matches[1]] ?? 'ERROR';

		//$_db_name = $kxst->kxst_db_titletop_name( $matches[1] );

		if( !empty( $_db_like ) )
		{
			if( $this->kxraS1[ 'db'] == 'Date' )
			{
				//dbがdateの場合。2023-03-01
				//なにかの理由で必要だったはず？？。2023-03-01
				$_db_like = preg_replace('/＿/', '":"' , $_db_like );
			}

			$args[ 'Column' ]  	 		= $_Column;
			$args[ 'select1' ]  		= $_db_like;
			$args[ 'Column2' ]   		= $_Column2;
			$args[ 'select2' ]   		= $_db_like2;
			$args[ 'select2_AND' ]	= $_db_like2_AND;
			$args[ 'title' ] 		 		= $_title;
			$args[ 'raretu' ] 	 		= 1;//オン、オフ。


			$_result  = kx_db_Woks( $args , 'select_search' );

			if( $_result[ 0 ] != 'NULL' )
			{
				foreach( $_result as $value):

					if( $value->$_db_name != 0)
					{
						$_arr_id[] = $value->$_db_name ;

						if( $_Column == 'Date' && !empty( kx_json_decode( $value->date )[ $_db_like_key ]  )  )
						{
							$_date = kx_json_decode( $value->date )[ $_db_like_key ];
							$this->kxraS_DB[ 'sort'][ $value->$_db_name ] = $_date;
							$_SESSION[ 'Heading_count' ][ $value->$_db_name ][ 'sort' ] = $_date;
						}
						elseif( $_Column2 == 'Date')
						{
							preg_match( '/('.$_db_like2.'|)":"(\d{4}\/\d{2}\/\d{2})/' , $value->date , $matches );

							$_date = $matches[2];
							$this->kxraS_DB[ 'sort'][ $value->$_db_name ] = $_date;
							$_SESSION[ 'Heading_count' ][ $value->$_db_name ][ 'sort' ] = $_date;
						}
					}
				endforeach;
			}
			else
			{
				echo 'worksでDB検索なし。<br>';
				echo $_title.'■'.$_Column.'■'.$_db_like.'■'.__LINE__;
				echo '<br>';

				$this->kxra_error[ 'error_type' ] = 'DBなし'.__LINE__;
			}
		}
	}
	elseif( $db_type == 'kx_0')
	{
		$args =
		[
			'columu' => $_Column,
			'db_like' => $_db_like,
		];

		$_result  = kx_db0(	$args , 'wp_kx_temporary' );
		//print_r($_result);

		if( !empty( $_result ) )
		{
			foreach( $_result as $value):
				//print_r( $value ).'<br>';
				if( $value->id != 0)
				{
					$_arr_id[] = $value->id ;
				}
			endforeach;
		}
	}
	else
	{
		//DB_shared_title。2023/03/01

		$kxdbST = new kxdbST;

		//タイトルトップ。検出。2022/06/10
		preg_match( '/' . KxSu::get('titile_search')[ 'SharedTitleDB' ] . '/' , $_title , $matches );
		$_title_top = $matches[ 0 ];
		unset( $matches );

		$kxdbST->kxdbST_Main(
			[
				'title' 	  	=> $_title,
				'Column'    	=> $_Column,
				'select1'   	=> $_db_like,
				'Column2'   	=> $_Column, 	//注意。2022/12/26
				'select2' 		=> $_db_like2,
				'select2_AND' => $_db_like2_AND,
				'title_top'   => $_title_top,
				//'select2' => $this->kxraS_DB[ 'select2' ],
			]
		, 'search' );

		//echo $_Column;
		//echo $_db_like2;

		if( empty( $kxdbST->search_value ))
		{
			$this->kxra_error[ 'error_type' ] = 'DBなし';

			echo 'DB：検索結果なし＝'.$_title.'+'.$_Column.'+'.$_db_like.'+'.__LINE__;

			return 'search '.$_db_like.'=N/A';
		}


		foreach( $kxdbST->search_value  as $id => $_date ):

			if( $id != 0)
			{
				$_arr_id[ ] = $id;

				if( !empty( $kxdbST->search_value_date_on ) )
				{
					if( $_Column2 == 'Date' )
					{
						//echo $_date;

						//ショートコードのdb2="Date"の場合。
						$this->kxraS_DB[ 'sort'][ $id ] = $_date;
						$_SESSION[ 'Heading_count' ][ $id ][ 'sort' ] = $_date;
					}
				}
			}
		endforeach;
	}


	//検索結果の有無。2023-02-26
	if( empty( $_arr_id ) )
	{
		$this->kxra_error[ 'error_type' ] = 'DBなし。Line：' . __LINE__;
		$this->kxra_error[ 'memo' ] =  'DB：検索結果なし<br>Title：' . $_title . '<br>Column：' . $_Column . '<br>db_like：' . $_db_like . '<br>■' . __LINE__;
		echo $this->kxra_error[ 'memo' ];

	}
	else
	{
		$this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] 		= $_arr_id;
		$this->kxra_arr_id[ 'search_1' ][ 'memory_on' ]	= NULL;
		$this->kxraM[ 'top_text' ] = '<div style="margin:0px 5px;padding:0 10px;color:purple;">Search_DB_title_base</div>';

	}
}





/**
 * kx_shortcode_example関数
 *
 * この関数はWordPressのショートコードを通じてデータベースから情報を取得し、その結果をHTML形式で出力するためのものです。
 * ショートコードを使うことで、投稿やページ内に動的に生成されたデータを表示することができます。
 *
 * ショートコードの属性（パラメータ）を受け取り、ユーザーが指定した条件に基づいてデータベースの情報を検索します。
 * その後、結果を整形してリスト形式で表示します。
 *
 * @param array $atts ショートコードで渡される属性を格納した連想配列。
 *   - 'table_name' (string): 検索対象のテーブル名を指定します。必須項目です。
 *   - 'conditions' (string): 検索条件を指定します。キーと値のペアを文字列形式（例: 'column1=value1&column2=value2'）で記述します。必須項目です。
 *   - 'columns' (string): 検索結果として取得したいカラムをカンマ区切りで指定します。デフォルトはすべてのカラム（*）を取得します。
 *   - 'operator' (string): 検索条件間の論理演算子を指定します（'AND'または'OR'）。デフォルトは'AND'です。
 *   - 'limit' (integer): 取得する結果の最大数を指定します。省略可能です。
 *   - 'order_by' (string): 結果の並び順を指定します（例: 'column_name ASC' または 'column_name DESC'）。省略可能です。
 *
 * @return string HTML形式で整形された検索結果を返します。
 *   - データが見つからない場合は「データが見つかりませんでした」というメッセージを返します。
 *   - 必須パラメータが足りない場合は「必須パラメータが足りません」というメッセージを返します。
 */
public function kxra_search_Table(){




	// 必須パラメータのチェック
	if (empty($this->kxraS1['table_name']) || empty($this->kxraS1['conditions'])) {
		echo '必須パラメータが足りません';
		$this->kxra_error[ 'error_type' ] = 'DB';
		return ;
	}
	//var_dump($this->kxraS1['date']);

	$this->kxraS1['conditions'] = str_replace('％','%',$this->kxraS1['conditions']);

	//echo $this->kxraS1['conditions'];

	if( empty($this->kxraS1['columns']) && $this->kxraS1['table_name'] !== 'wp_kx_0' && $this->kxraS1['table_name'] !== 'wp_kx_1')
	{
		$_title_top = kx_preg_match_pattern('/^[^≫]+/',$this->kxraS1[ 'title_base' ] );

		switch ($_title_top[0]) {
			case 'Β':
				$this->kxraS1['columns'] = 'id_lesson'; // σ に対応する値
				break;

			case 'γ':
				$this->kxraS1['columns'] = 'id_sens'; // γ に対応する値
				break;

			case 'σ':
				$this->kxraS1['columns'] = 'id_study'; // σ に対応する値
				break;

			case 'δ':
				$this->kxraS1['columns'] = 'id_data'; // δ に対応する値
				break;

			default:
				$this->kxraS1['columns'] = '*'; // 未対応の値の場合
				break;
		}
	}
	else
	{
		$this->kxraS1['columns'] = 'id';
	}


	//	var_dump($this->kxraS1['use_like']) ;
	// 条件を配列に変換
	//echo $this->kxraS1['conditions'];

	$this->kxraS1['conditions'] = preg_replace('/＿/', '":"' , $this->kxraS1['conditions'] );
	$conditions_array = [];
	parse_str($this->kxraS1['conditions'], $conditions_array);

	foreach($conditions_array as $key=>$value)
	{
		if (strpos($value, ',') !== false) {
			// 条件がカンマ区切りの場合、配列として扱う
			$conditions_array[$key] = [];
			//$parts = explode(',', $value); // 「,」で区切る
			foreach ( explode(',', $value) as $part)
			{
				$conditions_array[$key][] = $part;
			}
		}
	}

	//	var_dump($conditions_array) ;
	//$conditions_array = [    'date' => ['%シリーズアニメ":"2023%','%シリーズアニメ":"2024%']	];
	//echo '<br>';
	//var_dump(['json' => '%感想%']) ;
	//echo $this->kxraS1['columns'];
	//echo $this->kxraS1['table_name'];

	$select_columns = explode(',', $this->kxraS1['columns']);

	//if( preg_match('/'	.	KxSu::get('titile_search')[	'work_Platform'	]	.	'/i'	,	get_the_title( $args[ 'id' ] )	) )
	if( $this->kxraS1['date'] === true && preg_match(KxSu::get('base_preg')['Db_date_on'],$this->kxraS1['table_name']	) )
	{
		//echo KxSu::get('base_preg')['Db_date_on'];
		$select_columns[] = 'date';
	}

	//var_dump($select_columns);
	//echo '<br>';

	// kx_db_Read関数を呼び出してデータを取得
	/*
	$results = kx_db_Read(
    $this->kxraS1['table_name'],
    $conditions_array, 											// 検索条件の配列を指定。キーと値のペアで条件を設定。
    $select_columns, // カラム名をカンマ区切りで指定。データ取得対象のカラムを設定。
    $this->kxraS1['limit'] ?? null,
    $this->kxraS1['order_by'], 							// 並び順を指定。例: "column_name ASC" または "column_name DESC"。
    $this->kxraS1['operator'], 							// 条件間の論理演算子を指定。"AND" または "OR" を使用。
    !empty($this->kxraS1['use_like']) && $this->kxraS1['use_like'] === true // 部分一致検索を有効化。trueでLIKEクエリを適用し、falseで完全一致検索。
	);
	*/

	$results = kx_db_Read(
    $this->kxraS1['table_name'],
    $conditions_array,
    implode(',', $select_columns), // カラム名をカンマ区切りで指定
    $this->kxraS1['limit'] ?? null,
    $this->kxraS1['order_by'] ?? null,
    $this->kxraS1['operator'] ?? null,
    $this->kxraS1['use_like'] ?? false
	);



	$_ids = [];
	// 結果の処理
	if (!empty($results))
	{
		foreach( $results as $value )
		{
			$value = (array)$value;
			//var_dump($value[$_columns_name]);
			//echo '<br>';

			if( !empty($value[$this->kxraS1['columns']]) )
			{
				$_id = $value[$this->kxraS1['columns']];
				$_ids[] = $_id;

				if( $this->kxraS1['date'] === true )
				{
					$_date = NULL;
					if (array_key_exists('date', $conditions_array)) {

						//preg_match('/^%([^%]*)(":"|%)/',  $conditions_array['date'] , $matches);
						//preg_match('/^%([^%:"]+)(?=":|%)/',  $conditions_array['date'] , $matches);
						//echo $matches[1];
						//var_dump(kx_json_decode($value['date'])[$matches[1]]  ) ;
						//echo $conditions_array['date'];
						//echo '<br>';

						$matches = [];
						if( is_array($conditions_array['date']))
						{
							foreach ($conditions_array['date'] as $date)
							{
								if (preg_match('/^%([^%:"]+)(?=":|%)/', $date, $match))
								{
									$matches[] = $match[1]; // 必要ならばマッチした値を配列に追加
								}
							}
						}
						else
						{
							preg_match('/^%([^%:"]+)(?=":|%)/',  $conditions_array['date'] , $matches);
						}

						if( !empty( kx_json_decode($value['date'])[$matches[1]] ))
						{
							$_date = kx_json_decode($value['date'])[$matches[1]];
						}
					}
					else
					{
						$_date = !empty($value['date']) ? $value['date'] : NULL;
					}

					$this->kxraS_DB[ 'sort'][ $_id ] = $_date;
					$_SESSION[ 'Heading_count' ][ $_id ][ 'sort' ] = $_date;

				}
				//var_dump($this->kxraS1['columns']);
				//echo '<br>';
				//$this->kxraS_DB[ 'sort'][ $id ]
			}
		}
	}
	else
	{
		echo 'table:データが見つかりませんでした';
		return 'データが見つかりませんでした';
	}

	$this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] = $_ids;
	$this->kxra_arr_id[ 'search_1' ][ 'memory_on' ]	= NULL;
	$this->kxraM[ 'top_text' ] = '<div style="margin:0px 5px;padding:0 10px;color:green;">Search_DB_TableNAME</div>';
}



/**
 * 配列調整
 *
 * $this->kxra_arr_id[ 'sort' ]をID配列をソートしAT結果として出力。
 *
 * @return void
 */
public function kxra_sort(){

	if(	$this->kxraS1['t2']	== 'chara')
	{
		$_array = $this->kxra_sort_Chara();
	}
	elseif(	!empty($this->kxraS1['t3']) && $this->kxraS1['t3']	== 'Chara_Base_W')
	{
		$_array = $this->kxra_sort_Chara_Base_W();
	}
	else
	{
		$_array = $this->kxra_sort_Set();
	}



	if( !empty( $_array[ 'array_id' ] ) && is_array( $_array[ 'array_id' ] ) )
	{
		asort( $_array[ 'array_id' ] );

		//print_r($_array[ 'array_id' ]);

		foreach(	$_array[ 'array_id' ] as $key => $test)
		{
			//echo $test.'<br>';
			$_arr_id[]	= $key;
		}
	}
	else
	{
		$this->kxra_error[ 'error_type' ] = 'sort';
		echo 'ERROR：raretu'. __LINE__;
		echo get_the_title();
		return;
	}

	//print_r($_array[ 'array_id' ]);

	$this->kxra_arr_id[ 'sort' ] = array(
		'arr_id'								=>	$_arr_id,
		'id_lineup'							=>	$_array[ 'array_id' ] ,
		'new_title_list'				=>	$_array[ 'new_title_list' ] ,
		'new_title_list_check'	=>	$_array[ 'new_title_list_check' ] ,
	);
}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxra_sort_Chara(){

	/*
	// 989対応。コードの更新予定。2023-03-01。
	if(
		is_array(	$this->kxraS1[ 'chara_num_arr' ]	)
		&& in_array( '989' , $this->kxraS1[ 'chara_num_arr' ] )
		&& $this->kxraS1[ 'chara_count' ] >4
	){
		echo array_search(  '989' , $this->kxraS1[ 'chara_num_arr' ] ) ;
		echo '<br>';
	}
	else
	{
		echo array_search(  '989' , $this->kxraS1[ 'chara_num_arr' ] ) ;
		echo '<br>';
		echo $this->kxraS1[ 'chara_count' ];
		echo '<br>';
	}
	*/

	// 989対応。キャラが5以上の場合。989のkeyを989にする。2023-03-01
	if(	is_array(	$this->kxraS1[ 'chara_num_arr' ]	)	)
	{
		// 989対応。2023-03-01
		foreach( $this->kxraS1[ 'chara_num_arr' ]  as $key =>  $chara_num):

			if( $chara_num ==  989 && $this->kxraS1[ 'chara_count' ] >4 )
			{
				//キャラクターが5人以上の場合。2023-03-01
				$chara_989_on = 1;

				unset($this->kxraS1[ 'chara_num_arr' ][$key] );
				$this->kxraS1[ 'chara_num_arr' ][989] = $chara_num;
			}
			else{
				$chara_989_on = NULL;
			}
		endforeach;
	}

	//チェック項目★消さない★
	//var_dump($this->kxraS1[ 'chara_num_arr' ] );
	//echo '<br>';

	$_new_title_list = '';
	$_new_title_list_check = '';
	$s = 0;
	$_rank = NULL;

	foreach( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] as $id ):

		$s++;
		$title_list = get_the_title( $id );
		$_new_title_list_check .= $title_list;


		//キャラクターファイルの場合。2023-03-01。

		//$title_end	= end( explode('≫'	,	$title_list ) );

		//タイトルエンドチェック。2023-02-27
		preg_match(	'/^(.*?)＠/' , end( explode('≫' ,	$title_list ) )	, $matches);

		preg_match(	'/∬\w{1,}≫c(\w{1,})/'	, $title_list , $matches_chara	);

		$_pattern_time = 	'/(^\d{1,})(-(\d{2})|)(\d{2}|)/'	;

		//echo $matches[1];
		if( !empty( $matches[1] ) )
		{
			$time	= preg_replace(	'/(_.*)/'	,	''				,	$matches[1]	);

			preg_match( $_pattern_time ,	$time , $matches_time_top	);

			if( !empty( $matches_time_top ))
			{
				if( empty( $matches_time_top[3] ))
				{
					$matches_time_top[3] = '00';
				}
				if( empty( $matches_time_top[4] ))
				{
					$matches_time_top[4] = '00';
				}
				$_time_top = $matches_time_top[1].$matches_time_top[3].$matches_time_top[4];
			}
			else
			{
				$_time_top = NULL;
			}

		}
		else
		{
			$time	= NULL;
		}

		//echo $_time_top.'<br>';

		//989対応。ランク調整。2024-06-22
		$_rank = $this->kxra_sort_Chara989( $matches_chara , $_rank , $chara_989_on );

		//preg_match( '/(\d{1,})(-(\d{1,})|)/' ,$this->kxraS1[ 'time_min' ] , $matches  );
		//echo $matches[0];

		if( preg_match( $_pattern_time ,$this->kxraS1[ 'time_min' ] , $matches  )  )
		{

			if( empty( $matches[3] ))
				{
					$matches[3] = '00';
				}
				if( empty( $matches[4] ))
				{
					$matches[4] = '00';
				}
			$_time_min = $matches[1].$matches[3].$matches[4];
		}


		if( preg_match( $_pattern_time ,$this->kxraS1[ 'time_max' ] , $matches  )  )
		{
			if( empty( $matches[3] ))
				{
					$matches[3] = '00';
				}
				if( empty( $matches[4] ))
				{
					$matches[4] = '00';
				}
			$_time_max = $matches[1].$matches[3].$matches[4];
		}


		if( !empty( $this->kxraS1[ 'time_min' ] ) &&  !empty( $_time_top ) &&  $_time_top < $_time_min)
		{
			//スルー。時間別表示制限。2024-06-22
		}
		elseif( !empty( $this->kxraS1[ 'time_max' ] ) &&  !empty( $_time_top ) &&  $_time_top > $_time_max )
		{
			//スルー。時間別表示制限。2024-06-22
		}
		elseif(preg_match('/^chara$/'	,$this->kxraS1[ 't' ] )	&& preg_match('/＠plot＠/i'	, $title_list )	)//多分使ってない。2025-04-29
		{
			//スルー。2023-02-27
		}
		else
		{
			//echo $_time_top .'-'. $_time_min.'<br>';
			if( !empty( $time ) )
			{
				$_arr_id11[ $id ]	= $time.'_'.$_rank;
			}
			else
			{
				$_arr_id11[ $id ]	= 'zz_'.$_rank;
			}

			$_new_title_list .= $s.'＠'.$time.'＠'.$id.'｜';
		}
	endforeach;
	//print_r($_arr_id11);


	if( empty($_arr_id11))
	{
		$_arr_id11 = NULL;
	}


	return
	[
		'array_id'             => $_arr_id11,
		'new_title_list'       => $_new_title_list,
		'new_title_list_check' =>	$_new_title_list_check,
	];
}



/**
 * 989対応
 * 2024-06-22
 *
 * @return void
 */
public function kxra_sort_Chara989( $matches_chara , $_rank , $chara_989_on ){

	foreach( $this->kxraS1[ 'chara_num_arr' ] as $key => $chara_num):

		if(	$chara_num == $matches_chara[1] )
		{
			//echo $matches_chara[1];

			if( $this->kxraS1[ 'kxra_type' ]['t2']  == 'chara')
			{
				if( !empty( $chara_989_on ) )
				{
					if( $key > 3 && $key < 989 )
					{
						$_rank	= 3;
					}
					else
					{
						$_rank	= $key;
					}
					//echo $matches_chara[1];
					//echo '<br>';
					//echo $_rank;
					//echo '<br>';
					//echo $chara_num;
					//echo '<hr>';
				}
				else
				{
					if( $key > 4 )
					{
						$_rank	= 4;
					}
					else
					{
						$_rank	= $key;
					}
				}
			}
			else
			{
				$_rank	= $key;
			}

			$this->kxraS1[ 'chara_num_setting_array' ][ $chara_num ][ 'rank' ] = $_rank;
			break;
		}

	endforeach;

	//989対応
	if( !empty( $chara_989_on ) && $_rank == 989 )
	{
		$_rank  = 4;
	}

	return $_rank;


}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxra_sort_Chara_Base_W(){

	if( !empty( $this->kxraS1[ 'sys' ]) )
	{
		if( preg_match('/ksy/i',$this->kxraS1[ 'sys' ]) )
		{
			$_pattern = '/(ygs|na)$/i';
		}
		elseif( preg_match('/ygs/i',$this->kxraS1[ 'sys' ]) )
		{
			$_pattern = '/(ksy|na)$/i';
		}
	}

	$_new_title_list = '';
	$_new_title_list_check = '';

	foreach( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] as $id )
	{
		$_title = get_the_title($id);

		if( preg_match('/≫来歴$|≫関連$|≫.*≫.*≫.*≫.*/',$_title))
		{
			continue;
		}
		elseif( !empty($_pattern) && preg_match($_pattern,$_title))
		{
			continue;
		}


		$title_end	=  end(explode('≫',get_the_title($id)));

		if( $this->kxraS1[ 'sort_order' ] )
		{
			foreach( $this->kxraS1[ 'sort_order' ] as $key_j => $j_word ):

				if( preg_match(  '/^' . $j_word . '/' , $title_end ) )
				{
					$key_j	= sprintf( '%05d', $key_j);

					if(	$key_j	<	1000	)
					{
						$_arr_id11[ $id ]	= 'y1'.	$key_j	.	$j_word.'＋'.$title_end;
						//echo $key_j	.	'<br>';
					}
					else
					{
						$_arr_id11[ $id ]	= 'y3'.	$key_j	.	$j_word.'＋'.$title_end;
						//echo $key.'<br>';
					}

					break;
				}
				else
				{
					$_arr_id11[ $id ]	= 'y2＋'.$title_end;
				}

			endforeach;
		}
		else
		{
			$_arr_id11[ $id ] = $title_end;
		}




		$_new_title_list .= $_title;
		$_new_title_list_check .= $_title;

	}

	return
	[
		'array_id'             => $_arr_id11,
		'new_title_list'       => $_new_title_list,
		'new_title_list_check' =>	$_new_title_list_check,
	];

}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxra_sort_Set(){

	$_new_title_list = '';
	$_new_title_list_check = '';
	$s = 0;

	foreach( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] as $id ):

		$s++;

		$title_list = get_the_title( $id );
		$_new_title_list_check .= $title_list;


		////キャラクターポスト以外の場合。主にset。2023/03/01

		$time	= NULL;

		$title_end	= str_replace(	$this->kxraS1[ 'title_base' ] . '≫'	,	'',	$title_list	)	;

		preg_match(	'/^(.*?)＠/'	,	$title_end		, $matches );


		if( !preg_match(	'/^∬\d{1,}≫c(\d\w{1,}\d)/'	,	$title_list	, $matches_chara	))
		{

			$matches_chara[1] = NULL;
		}

		if( !empty( $this->kxraS0[ 'db' ]	)
			|| !empty( $this->kxraS0[ 'table_name' ]	 )
			|| !empty( $this->kxraS1[ 'tougou_sort' ]	 )
		)
		{
			//db系の場合。

			$title_DB = end( explode( '≫' , $title_list) );

			//分類対応。2022-08-05
			$title_DB = preg_replace( '/〈分類〉$/' , '' , $title_DB );

			if( !empty( $this->kxraS_DB[ 'order_type' ] ) &&  preg_match( '/'.$this->kxraS_DB[ 'order_type' ].'$/' ,$title_DB ) )
			{
				$_title_type_DB = '00_'.$title_list;
			}
			elseif( !empty( $this->kxraS_DB['sort_top'] ) &&  preg_match( '/^'.$this->kxraS_DB['sort_top'].'$/' ,$title_DB ) )
			{
				$_title_type_DB = '00_'.$title_list;
			}
			elseif( !empty( $this->kxraS_DB[ 'sort'][ $id ] ))
			{
				//echo $this->kxraS_DB[ 'sort'][ $id ];
				//ショートコードのdb2がDateの場合、ソートに介入する。2023-03-01。
				if(preg_match('/(-?\d{1,4})_(\d{2})_(\d{2})/',$this->kxraS_DB[ 'sort'][ $id ],$matches))
				{
					$_title_type_DB = $matches[1].$matches[2].$matches[3];
				}
				else
				{
					$_title_type_DB = $this->kxraS_DB[ 'sort'][ $id ] .'_'.$title_list;
				}

				unset( $matches);
			}
			elseif( $this->kxraS1[ 'sort_order' ] )
			{
				$_title_type_DB = $this->kxra_sort_order_DB(	 $title_DB	) ;
			}
			else
			{
				$_title_type_DB = 'z_'.$title_list;
			}

			//概要排除。2022/06/10
			if( !preg_match( '/^0(?!.*統合概要).*概要$/' , $title_DB ) && get_post_status( $id ) != 'trash' )
			{
				$_arr_id11[ $id ]	= $_title_type_DB;
			}

		}
		elseif(	!preg_match('/≫/'	,$title_end	)  )
		{
			//子階層排除。endの中に≫があるものを排除。

			if( !empty( $matches[1] ) && !empty( $matches_chara[1] )  )
			{
				$_arr_id11[ $id ]	= $matches[1].'＋'.$matches_chara[1].'＋'.$title_end;
			}
			elseif( !empty( $matches[1] ) )
			{
				$_arr_id11[ $id ]	= $matches[1].'＋'.$title_end;
			}
			elseif( $this->kxraS1[ 'sort_order' ] )
			{
				foreach( $this->kxraS1[ 'sort_order' ] as $key_j => $j_word ):

					if( preg_match(  '/^' . $j_word . '/' , $title_end ) )
					{
						$key_j	= sprintf( '%05d', $key_j);

						if(	$key_j	<	1000	)
						{
							$_arr_id11[ $id ]	= 'y1'.	$key_j	.	$j_word.'＋'.$matches_chara[1].'＋'.$title_end;
							//echo $key_j	.	'<br>';
						}
						else
						{
							$_arr_id11[ $id ]	= 'y3'.	$key_j	.	$j_word.'＋'.$matches_chara[1].'＋'.$title_end;
							//echo $key.'<br>';
						}

						break;
					}
					else
					{
						$_arr_id11[ $id ]	= 'y2＋' . $matches_chara[1] . '＋'.$title_end;
					}

				endforeach;
			}
			else
			{
				$_arr_id11[ $id ]	= 'zz＋'.$matches_chara[1].'＋'.$title_end;
			}

			$_new_title_list .= $s	.	'─'	.	$time	.	'─'	.	$id	.	'｜';
			//echo $_arr_id11[ $id ];
		}
	endforeach;
	//print_r($_arr_id11);
	//var_dump($_arr_id11);
	return
	[
		'array_id'             => $_arr_id11,
		'new_title_list'       => $_new_title_list,
		'new_title_list_check' =>	$_new_title_list_check,
	];
}

/**
* ソート順位。DB用。foreach内。
* 2022/06/11
*
* @param [type] $ids
* @return void
*/
public function kxra_sort_order_DB(	$title_end ){

	foreach( $this->kxraS1[ 'sort_order' ] as $key => $j_word ):
		//echo $j_word;
		//echo '<br>';

		//カッコ内排除。分類のみ。2022-08-05
		//$title_end = 	preg_replace( '/〈分類〉/' , '' , $title_end );


		if( preg_match(  '/^' . $j_word . '/' , $title_end ) )
		{
			$key	= sprintf( '%05d', $key );

			if(	$key	<	1000	)
			{
				$str	= 'y1'.	$key	.	$j_word.'＋'.$title_end;
			}
			else
			{
				$str	= 'y3'.	$key	.	$j_word.'＋'.$title_end;
			}

			break;

		}
		else
		{
			$str	= 'y2＋'.$title_end;
		}

	endforeach;

	return $str;
}



/**
* 各ポストの設定。
*
* @param [type] $id
* @return void
*/
public function kxra_Setting_Post( $id ){

	//title系。2023-07-05
	$_title                          = get_the_title( $id );
	$this->kxraS_post[ 'title_end' ] = end(	explode	(	"≫", $_title	)	);


	//題名・イベント名。2023-07-05
	$this->kxraS_post[ 'daimei' ]    = preg_replace('/.*＠/'	,''	,	$this->kxraS_post[ 'title_end' ]	);


	//kxra_search_DB()で使用。2023-07-05
	//日付。Date。年月。検索用。
	if( !empty( $_SESSION[ 'Heading_count' ][ $id ][ 'sort' ] ))
	{
		if( preg_match( '/^({"0":"|\["|)(-?\d{1,4})/' , $_SESSION[ 'Heading_count' ][ $id ][ 'sort' ] , $matches ) )
		{
			$this->kxraS_post[ 'daimei' ]	= $matches[ 2 ] .'-'. $this->kxraS_post[ 'daimei' ];
		}
	}
	unset( $matches );


	//kxtt。2023-07-05
	$this->kxraS_post[ 'arr_character' ] = kx_CLASS_kxTitle(
	[
		'type'             => 'character',
		'title'            => $_title,
		'character_number' => '',
	] );

	$this->kxraS_post[ 'chara_name' ]  = $this->kxraS_post[ 'arr_character' ][ 'character_name' ];


	//キャラ設定。
	if(preg_match( '/^∬\d{1,}≫c/' , $_title ) )
	{
		$this->kxra_Setting_Post_Chara();
	}


	//時間関係
	if( preg_match(	'/^(.*)＠/'	,	$this->kxraS_post[ 'title_end' ]	,	$matches	) )
	{
		$time_full	= preg_replace('/_.*/'	,''	,	$matches[1]	);
	}
	else
	{
		$time_full	=  NULL;
	}
	unset( $matches );


	if( !empty( $time_full ) && preg_match('/(^\w{1,})(-(\w{1,2})(\w{1,2}|)|)/'	,	$time_full	,	$matches ) )
	{
		$time_nendo	= $matches[1];

		if( !empty( $matches[3] ))
		{
			$time_month	= $matches[3];
		}
		else
		{
			$time_month	= 'n_a';
		}

		if( !empty( $matches[4] ))
		{
			$time_day		= $matches[4];
		}
		else
		{
			$time_day		= NULL;
		}

		$time	= $time_nendo . '-' . $time_month . $time_day;

		$time_time	= preg_replace('/^'.$time_nendo.'/'	,''	,	$time_full	);
		$time_time	= preg_replace('/-'.$time_month.'/'	,''	,	$time_time	);
		$time_time	= preg_replace('/^'.$time_day.'/'		,''	,	$time_time	);

		$time_time1	= substr(	$time_time	, 0, 1);
		$time_time2	= substr(	$time_time	, 0, 2);
	}
	else
	{
		$time = NULL;
		$time_time = NULL;
		$time_time1 = NULL;
		$time_time2 = NULL;
	}
	unset($matches);



	if( empty( $time_full )  ){ $time				= 'n/a'; }
	if( empty( $time_nendo ) ){	$time_nendo	= 'n/a'; }
	if( empty( $time_month ) ){	$time_month	= 'n/a'; }
	if( empty( $time_day	)  ){ $time_day		= 'n/a'; }
	if( empty( $time_time )  ){	$time_time	= 'n/a'; }


	$_kxcl[ 'hsla_normal' ] = NULL;
	$_kxcl[ 'hsla_light' ]  = NULL;
	if( !empty( $this->kxraS_post[ 'plot_kousei_top' ] ) )
	{
		if(preg_match('/1|a/' , $this->kxraS_post[ 'plot_kousei_top' ] ) )
		{
			$sikisou	= '0';
		}
		elseif(preg_match('/2|b/' , $this->kxraS_post[ 'plot_kousei_top' ] ))
		{
			$sikisou	=210;
		}
		elseif  (preg_match('/3|c/' , $this->kxraS_post[ 'plot_kousei_top' ] ))
		{
			$sikisou	=150;
		}
		elseif  (preg_match('/4|d/' , $this->kxraS_post[ 'plot_kousei_top' ] ))
		{
			$sikisou	=300;
		}
		elseif  (preg_match('/5|e/' , $this->kxraS_post[ 'plot_kousei_top' ] ))
		{
			$sikisou	=180;
		}
		elseif  (preg_match('/6|f/' , $this->kxraS_post[ 'plot_kousei_top' ] ))
		{
			$sikisou	=120;
		}
		elseif  ( preg_match(	'/\w/',	$this->kxraS_post[ 'plot_kousei_top' ] ) )
		{
			$sikisou	=150;
		}
	}
	elseif( !empty( $this->kxraS1[ 'kxra_type' ][ 't' ] ) )
	{
		$_kxcl = kx_CLASS_kxcl(	get_the_title()	,	'');

		$sikisou	= $_kxcl[ '色相' ];
	}
	else
	{
		$sikisou	= 'gray';
	}


	//年齢差
	if( !preg_match('/∬\d{1,}≫c(\d\w{1,}\d)/i' , get_the_title( $id )  , $matches_c_num ) )
	{
		$matches_c_num[1] = NULL;
	}

	if( !empty( $this->kxraS1[ 'chara_num_arr' ] ))
	{
		$arr  = (array)$this->kxraS1[ 'chara_num_arr' ];
		$rank = array_search( $matches_c_num[1] , $arr);

		if( !empty($this->kxraS1['csa_arr'][ $rank ] ) )
		{
			$sa = $this->kxraS1['csa_arr'][ $rank ];
		}
		elseif( $rank == 989 )
		{

			$_csa_count = count( $this->kxraS1['csa_arr'] );
			//echo $_csa_count;
			$_csa_count = $_csa_count -2 ;
			//echo $this->kxraS1['csa_arr'][$_csa_count];
			//print_r($this->kxraS1['csa_arr']);
			$sa = $this->kxraS1['csa_arr'][$_csa_count];
		}
		else
		{
			$sa = NULL;
		}
	}
	else
	{
		$rank = NULL;
		$sa = NULL;
	}


	if( $sa  !=  0 && ctype_digit( $time_nendo ) )
	{
		//$sa = (int)$sa;
		//$time_nendo_sa	= $time_nendo + (int)$sa ;

		if( $time_nendo + (int)$sa == 0 )
		{
			$this->kxraS_post[ 'time_sa' ]  = '00-'.$time_month;
		}
		else
		{
			$this->kxraS_post[ 'time_sa' ]  = $time_nendo + (int)$sa .'-'.$time_month;
		}
	}
	else
	{
		$this->kxraS_post[ 'time_sa' ]  = NULL;
	}


	$_arr_ra_post_set  = array(
		'c_sikisou_raretu_sx'	=>	$sikisou,
		'hsla_normal'					=>	$_kxcl[ 'hsla_normal' ],
		'hsla_light'					=>	$_kxcl[ 'hsla_light' ],

		//'time_sa'					=>	$time_sa,

		'time_full'				=>	$time_full,
		'time'						=>	$time,
		'time_nendo'			=>	$time_nendo,
		'time_month'			=>	$time_month,
		'time_day'				=>	$time_day,
		'time_time'				=>	$time_time,
		'time_time1'			=>	$time_time1,
		'time_time2'			=>	$time_time2,
	);

	$this->kxraS_post = $_arr_ra_post_set + $this->kxraS_post;
}



/**
 * 各ポスト、キャラ設定。
 *
 * @return void
 */
public function kxra_Setting_Post_Chara(){

	//plotコード（_k1_a1など）。
	if( preg_match('/_(.*)＠/'	, $this->kxraS_post[ 'title_end' ]	,$matches))
	{
		$this->kxraS_post[ 'plot_code_base' ]	= preg_replace('/＠.*$/' , '' , $matches[1] );
	}
	else
	{
		//ここでNULLが必要。どこかで何かが消されている。2023-07-05
		$this->kxraS_post[ 'plot_code_base' ]	= NULL;
	}
	unset( $matches );

	$this->kxraS_post[ 'plot_sakuhin' ]			= NULL;
	$this->kxraS_post[ 'plot_kousei' ]			= NULL;
	$this->kxraS_post[ 'plot_kousei_top' ]	= NULL;


	if( !empty( $this->kxraS1[ 'kxtt' ] ) )
	{
		$_sakuhin_code_short	= $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] . $this->kxraS1[ 'kxtt' ][ 'work_code_number_s' ];

		if( preg_match('/('. $_sakuhin_code_short .')(-((\w)(\d|))|)/i'	,$this->kxraS_post[ 'plot_code_base' ] , $matches ) )
		{
			$this->kxraS_post[ 'plot_sakuhin' ]	= $matches[1];

			if( !empty( $matches[3] ) )
			{
				$this->kxraS_post[ 'plot_kousei' ]	= $matches[3];
			}


			if( !empty( $matches[4] ) )
			{
				$this->kxraS_post[ 'plot_kousei_top' ]	= $matches[4];
			}
		}
	}
	unset( $matches);
}



/**
 * 羅列ポストのHeadingの分岐。
 * 配列で出力。
 * 2023-03-21
 * @param array $args
 * @return array
 */
public function kxra_Heading( $args ){

	//$this->kxra_Heading_memo[ 'title' ] = get_the_title( $args[ 'id' ] );

	if(
		( !empty( $this->kxraS1[ 't' ] ) && $this->kxraS1[ 't' ]	== 'set' ) ||
		( !empty( $args[ 'type' ] ) && 	$args[ 'type' ]	== 'wwt' )
	){
		//Set系の場合。2023-03-21
		$this->kxra_Heading_memo[ 'Heading_type' ] = 'SET';
		return $this->kxra_Heading_set( $args );
	}
	else
	{
		//Set系以外、主にキャラクターの場合。2023-03-21


		if( preg_match('/'	.	KxSu::get('titile_search')[	'work_Platform'	]	.	'/i'	,	get_the_title( $args[ 'id' ] )	) )
		{
			$this->kxra_Heading_memo[ 'Heading_type' ] = 'Chara_WW';
			return $this->kxra_Heading_chara_WW( $args );
		}
		else
		{
			$this->kxra_Heading_memo[ 'Heading_type' ] = 'Chara';
			return $this->kxra_Heading_chara( $args );
		}
	}
}



/**
* Undocumented function
*
* @param [type] $args
* @return void
*/
public function kxra_Heading_set( $args ){


if( !empty( $args[ 'id' ] ))
{
	$id 	 = $args[ 'id' ];
}
else
{
	$id = get_the_ID();
}


if( !empty( $_SESSION[ 'h2_check' ][ $id ][ 'old_time_year' ] ) ):

	$pattern_year		= '#'.	$_SESSION[ 'h2_check' ][ $id ][ 'old_time_year' ]	.'#';

endif;


if( !empty( $_SESSION[ 'h2_check' ][ $id ]['old_time_month'] ) ):

	$pattern_time_month		= '#'.	$_SESSION[ 'h2_check' ][ $id ]['old_time_month']	.'#';

endif;


if( !empty( $_SESSION[ 'h2_check' ][ $id ]['old_daimei'] ) ):

	$pattern_daimei	= '/^'.	$_SESSION[ 'h2_check' ][ $id ]['old_daimei']	.'/';

endif;


//echo $this->kxraS_post[ 'time' ].'<br>';
//echo $this->kxraS_post['time_nendo'].'<br>';
//echo $this->kxraS_post['daimei'].'<br>';
//var_dump( $this->kxraS_post).'<br>';
//echo $this->kxraS_post['time_nendo'];
//echo $pattern_year	.'+'.	$this->kxraS_post['time_nendo'] . '+'  . $this->kxraS_post['daimei']. $id.'<br>';

unset( $_damei_memory );
unset( $_month_memory );

if( empty( $_SESSION[ 'h2_check' ][ $id ][ 'old_time_year' ] ) )
{
	$_h_x = 2;
}
elseif( !empty( $_SESSION[ 'h2_check' ][ $id ]['old_daimei'] ) &&	preg_match(	$pattern_daimei	,	$this->kxraS_post['daimei'] ) )
{
	//題名かぶり。

	$_damei_memory = 1;

	if(
		!empty( $pattern_time_month )
		&& preg_match(	$pattern_time_month	,	substr( $this->kxraS_post[ 'time_month' ]	,0,1	)	)
		&& $this->kxraS_post[ 'time_month' ]	!= 'n/a'
	)
	{
		//題名かぶり、かつ月日かぶり。

		$_h_x = 4;
		$_month_memory = 1;
		//echo substr( $this->kxraS_post[ 'time_month' ]	,0,1	).$this->kxraS_post['daimei'].'<br>';
	}
	else
	{
		$_SESSION[ 'h2_check' ][ $id ]['old_time_month']	= substr(	$this->kxraS_post[ 'time_month' ], 0, 1);
		$_h_x = 3;
	}
}
elseif( $_SESSION[ 'h2_check' ][ $id ][ 'old_time_year' ] == 'n/a' )
{
	$_h_x = 2;
}
elseif( preg_match(	$pattern_year	,	$this->kxraS_post['time_nendo'] ) )
{
	//年度かぶり。

	if(
		!empty( $pattern_time_month )
		&& preg_match(	$pattern_time_month	,	substr( $this->kxraS_post[ 'time_month' ]	,0,1	)	)
		&& $this->kxraS_post[ 'time_month' ]	!= 'n/a'
	)
	{
	//年度かぶり。かつ月日かぶり。

		$_h_x = 4;
		$_month_memory = 1;
	}
	else
	{
		$_SESSION[ 'h2_check' ][ $id ]['old_time_month']	= substr(	$this->kxraS_post[ 'time_month' ], 0, 1);
		$_h_x = 3;
	}
}
else
{
	$_h_x = 2;
}


$_SESSION[ 'h2_check' ][ $id ][ 'old_time_year' ] 	= $this->kxraS_post[ 'time_nendo' ];


if( empty(  $_month_memory ) ):

	$_SESSION[ 'h2_check' ][ $id ][ 'old_time_month' ]	= substr(	$this->kxraS_post[ 'time_month' ], 0, 1);

endif;


if( empty(  $_damei_memory ) ):

	$_SESSION[ 'h2_check' ][ $id ][ 'old_daimei' ]			= $this->kxraS_post['daimei'];

endif;


return[
	'h_x' => $_h_x,
];

}


/**
 * キャラ。Set系以外
 *
 * @param [type] $args
 * @return void
 */
public function kxra_Heading_chara( $args ){

	$this->kxra_Heading_memo[ 'chara' ] = 'TEST-chara';

	if( !empty( $args[ 'id' ] ) )
	{
		$id 	 = $args[ 'id' ];
	}
	else
	{
		$id = NULL;
	}


	if( !empty( $args[ 't2' ] ) )
	{
		$t2 	 = $args[ 't2' ];
	}
	else
	{
		$t2 = NULL;
	}

	//2024-06-13
	$this->kxraS1[ 'kxtt' ] = kx_CLASS_kxTitle( [
		'type'  => 'work',
		'title' => $this->kxraS1[ 'title_base' ] ,
	]);

	$_SESSION[ 'h2_check' ][ 'kxx10' ][ 'type' ] = 'wwx';
	$ga_arr		= explode( ',' , $_SESSION[ 'raretu' ][ 'gakunen_hani' ][ $this->kxraS1[ 'kxtt' ][ 'character_number'] ] );
	$ga_min		= $ga_arr[ 0 ];
	$ga_max		= end($ga_arr);

	if(	empty( $_SESSION[ 'h2_check' ][ $id ] )	)
	{
		//初期値

		$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]	= 2;
		$_SESSION[ 'h2_check' ][ $id ]['time_nendo'] = kx_gakunen( $this->kxraS_post[ 'time' ] , $ga_min , $ga_max );

		$this->kxra_Heading_memo[ 'chara' ] = 'TEST-A';


		return
		[
			'h_x' => 2
		];
	}

	//題名が同じ場合
	if( !empty( $_SESSION[ 'h2_check' ][ $id ]['daimei'] ) && $_SESSION[ 'h2_check' ][ $id ]['daimei']	== $this->kxraS_post['title_end'] )
	{

		$this->kxra_Heading_memo[ 'chara' ] = 'TEST-B';

		return [
			'h_x' => $_SESSION[ 'h2_check' ][ $id ][ 'daimei_h' ],
		];
		//return $_SESSION[ 'h2_check' ][ $id ][ 'daimei_h' ];
	}


	//初期値
	$_h						= 2;




	if( preg_match( KxSu::get('raretu')[ 'outline_color' ] ,  $this->kxraS_post[ 'daimei' ] ) )
	{
		//★|▼など。
		$this->kxra_Heading_memo[ 'chara' ] = 'colorと題名→2<br>';


		$_h						= 2;
		$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]	= $_h;

		if(	preg_match('/'	.	KxSu::get('titile_search')[ 'work_Platform' ]	.	'/i' , get_the_title( $id )	) )
		{
			$this->kxra_haeding_plot();
		}

		$_SESSION[ 'h2_check' ][ $id ]['time_nendo'] = kx_gakunen( $this->kxraS_post[ 'time' ] , $ga_min , $ga_max );
	}
	elseif( $t2	== 'chara' && !ctype_alpha( $_SESSION[ 'raretu' ][ 'gakunen_hani' ][ $this->kxraS1[ 'kxtt' ][ 'character_number'] ] ) )
	{

		//学年範囲に英字が含まれない。

		//■学年

		$ga_arr		= explode( ',' , $_SESSION[ 'raretu' ][ 'gakunen_hani' ][ $this->kxraS1[ 'kxtt' ][ 'character_number'] ] );
		$ga_min		= $ga_arr[ 0 ];
		$ga_max		= end($ga_arr);
		$time_nendo  = kx_gakunen( $this->kxraS_post[ 'time' ] , $ga_min , $ga_max );

		$plot_code_s		= preg_replace('/(\w\d{1,}).*/' , '$1',	$this->kxraS_post[ 'plot_code_base' ]	);

		$plot_code_w		= $this->kxraS_post[ 'plot_code_base' ]	;

		$time_month			= $this->kxraS_post[ 'time_month' ];
		$time_day				= $this->kxraS_post['time_day']	;
		$time_time2			= $this->kxraS_post['time_time2']	;


		if(	preg_match('/'	.	KxSu::get('titile_search')[	'work_Platform'	]	.	'/i'	,	get_the_title( $id )	) 	)
		{
			//制作作品の場合。

			$this->kxra_Heading_memo[ 'Heading_type2' ] = KxSu::get('titile_search')[	'work_Platform'	]	;

			$this->kxra_haeding_plot();

			if( !empty( $_SESSION[ 'h2_check' ][ $id ]['plot'] ) &&	$plot_code_w	== $_SESSION[ 'h2_check' ][ $id ]['plot_w']	)
			{
				$_h						= 3;
				$this->kxra_Heading_memo[ 'chara' ] = 'プロットcodeが前と同じ。'. $plot_code_w . '/' . $_SESSION[ 'h2_check' ][ $id ]['plot_w'];
				$this->kxra_Heading_memo[ 'Heading' ]  = $_h;
			}
			/*
			elseif(
				!empty( $_SESSION[ 'h2_check' ][ $id ][ 'plot_kousei' ] )
				&& !empty( $_plot_kousei )
				&& $_plot_kousei	== $_SESSION[ 'h2_check' ][ $id ][ 'plot_kousei' ]
			){
				echo '+';
				echo $_plot_kousei.'<br>';
				$this->kxra_Heading_memo[ 'chara' ] = 'プロットkouseiが同じ';
				$_h						= 3;

			}
			*/
			else
			{
				if( empty( $_SESSION[ 'h2_check' ][ $id ]['plot_w'] ))
				{
					$_code_w = '無し';
				}
				else
				{
					$_code_w = $_SESSION[ 'h2_check' ][ $id ]['plot_w'];
				}

				$_h						= 2;
				$this->kxra_Heading_memo[ 'chara' ] = 'プロットcodeが変更。'.$plot_code_w .' / '.$_code_w;
				$this->kxra_Heading_memo[ 'Heading' ]  = $_h;


				if( !empty( $matches[1] ) )
				{
					$_add_on = str_replace([1,2,3,4] ,['A','B','C','D'] , $matches[1] );

					$this->haeding_title_add		=  $_add_on .'＠';
				}
				else
				{
					$this->haeding_title_add		=  NULL;
				}
			}

			unset( $matches , $_add_on );
		}
		else
		{

			//	■	作品以外	■
			//echo $time_day;

			if(	$time_nendo	== $_SESSION[ 'h2_check' ][ $id ]['time_nendo']	)
			{
				//echo $this->kxraS_post['daimei'] ;
				//echo $time_nendo;

				$this->kxra_Heading_memo[ 'chara' ] = 'TEST-C<br>';
				$this->kxra_Heading_memo[ 'chara' ] .=	$time_nendo . '<br>' ;
				$this->kxra_Heading_memo[ 'chara' ] .=	$_SESSION[ 'h2_check' ][ $id ]['time_nendo'] . '<br>' ;
				$this->kxra_Heading_memo[ 'chara' ] .=	$id . '<br>' ;

				$_h	= 3;

				if( !empty( $_SESSION[ 'h2_check' ][ $id ]['time_month'] ) && $this->kxraS_post[ 'time_month' ] == $_SESSION[ 'h2_check' ][ $id ]['time_month'] )
				{

					$_h	= 4;
					//echo $this->kxraS_post['daimei'] ;
					//echo $_SESSION[ 'h2_check' ][ $id ][ 'h_x' ];
					//echo '+';

					//memo
					$this->kxra_Heading_memo[ 'chara' ] .= '前ｈ:'.$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ].'<br>';

					if(	$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]  == 2	)
					{
						$_SESSION[ 'h2_check' ][ $id ]['h_3_off']	= -1;
					}


					if(	$time_day	== $_SESSION[ 'h2_check' ][ $id ]['time_day'] )
					{

						$_h	= 5;

						if(	$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]  == 2	)
						{
							$_SESSION[ 'h2_check' ][ $id ]['h_4_off']	= -1;
						}
						elseif(	$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]  == 3	&& empty( $_SESSION[ 'h2_check' ][ $id ]['h_3_off'] ) )
						{
							$_SESSION[ 'h2_check' ][ $id ]['h_4_off']	= -1;
						}


						if(	$time_time2	== $_SESSION[ 'h2_check' ][ $id ]['time_time2'] )
						{
							$_h	= 6;
						}
					}
					else
					{
						unset(	$_SESSION[ 'h2_check' ][ $id ]['h_4_off']	);
					}

					//memo
					$this->kxra_Heading_memo[ 'chara' ] .= 'Last_memo:'.$_h.'<br>';
				}
				else
				{
					unset($_SESSION[ 'h2_check' ][ $id ]['h_3_off']		,$_SESSION[ 'h2_check' ][ $id ]['h_4_off']	);
				}
			}
			else
			{
				$this->kxra_Heading_memo[ 'chara' ] = 'TEST-D<br>';
				$this->kxra_Heading_memo[ 'chara' ] .=	$time_nendo . '<br>' ;
				$this->kxra_Heading_memo[ 'chara' ] .=	$_SESSION[ 'h2_check' ][ $id ]['time_nendo'] . '<br>' ;
				$this->kxra_Heading_memo[ 'chara' ] .=	$id . '<br>' ;

				$_h	= 2;

				unset($_SESSION[ 'h2_check' ][ $id ]['h_3_off']	,	$_SESSION[ 'h2_check' ][ $id ]['h_4_off']	,$_SESSION[ 'h2_check' ][ $id ]['h_5_off']	);
			}
		}

		//$_h	= $_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]	+	$_h_add;

		//if(	$_h	 -	$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]  >1	):
			//$_h	= $_SESSION[ 'h2_check' ][ $id ]	[ 'h_x' ]	+	1	;
		//endif;

		if( !empty($_SESSION[ 'h2_check' ][ $id ]['h_3_off'] ))
		{
			$_h	= $_h	+	$_SESSION[ 'h2_check' ][ $id ]['h_3_off'];
		}

		if( !empty($_SESSION[ 'h2_check' ][ $id ]['h_4_off'] ))
		{
			$_h	= $_h	+	$_SESSION[ 'h2_check' ][ $id ]['h_4_off'];
		}

		if( !empty($_SESSION[ 'h2_check' ][ $id ]['h_5_off'] ))
		{
			$_h	= $_h	+	$_SESSION[ 'h2_check' ][ $id ]['h_5_off'];
		}

		//$_h	= $_h	+	$_SESSION[ 'h2_check' ][ $id ]['h_3_off']	+	$_SESSION[ 'h2_check' ][ $id ]['h_4_off']	+	$_SESSION[ 'h2_check' ][ $id ]['h_5_off']	;


		$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]				= $_h;
		$_SESSION[ 'h2_check' ][ $id ]['plot']				= $this->kxraS_post[ 'plot_code_base' ];
		$_SESSION[ 'h2_check' ][ $id ]['plot_s']			= $plot_code_s;
		$_SESSION[ 'h2_check' ][ $id ]['plot_w']			= $plot_code_w;
		$_SESSION[ 'h2_check' ][ $id ]['time_full']		= $this->kxraS_post[ 'time_full' ];
		$_SESSION[ 'h2_check' ][ $id ]['time_nendo']	= $time_nendo;
		$_SESSION[ 'h2_check' ][ $id ]['time_month']	= $time_month;
		$_SESSION[ 'h2_check' ][ $id ]['time_day']		= $time_day;
		$_SESSION[ 'h2_check' ][ $id ]['time_time2']	= $time_time2;
		//$_SESSION[ 'h2_check' ][ $id ][ 'plot_kousei' ]	= $_plot_kousei;
		$_SESSION[ 'h2_check' ][ $id ][ 'h_x' ]				= $_h;
		$_SESSION[ 'h2_check' ][ $id ]['daimei_h']		= $_h;
		$_SESSION[ 'h2_check' ][ $id ]['daimei']			= $this->kxraS_post['title_end'];
	}


	if( !empty( $_SESSION[ 'h2_check' ][ $id ]	['count'] ))
	{
		$_SESSION[ 'h2_check' ][ $id ]	['count']++;
	}
	else
	{
		$_SESSION[ 'h2_check' ][ $id ]	['count'] = 1;
	}

	$this->h_x	= $_h;

	//$this->TEST= 'TEST';

	return [
		'h_x' => $_h,
		'memo' => $this->kxra_Heading_memo,
	];

}



/**
 * ヘディング用。Chara_WW時
 *
 * @param [type] $args
 * @return void
 */
public function kxra_Heading_chara_WW( $args ){

	//初期値
	$_h = 2;

	//常時プロットON
	$this->kxra_haeding_plot();

	$_id = $args[ 'id' ];

	//wwx指定が、横列のダブりを排除している。2023-07-02
	$_SESSION[ 'h2_check' ][ 'kxx10' ][ 'type' ] = 'wwx';

	//学年範囲関連。
	$_plot_code	= $this->kxraS_post[ 'plot_code_base' ] ;

	$this->kxra_Heading_memo[ 'time' ] = $this->kxraS_post[ 'time' ];
	$this->kxra_Heading_memo[ 'plot' ] = $_plot_code;



	if(	empty( $_SESSION[ 'h2_check' ][ $_id ] )	)
	{
		//初期値
		$this->kxra_Heading_memo[ '分岐' ] = '初期値';

		$_h = 2;
	}
	elseif( preg_match( KxSu::get('raretu')[ 'outline_color' ] ,  $this->kxraS_post[ 'daimei' ] ) )
	{
		//★|▼など。
		$_h	= 2;


		$this->kxra_Heading_memo[ '分岐' ] = '★|▼など';

		//$_SESSION[ 'h2_check' ][ $_id ]['time_nendo'] = kx_gakunen( $this->kxraS_post[ 'time' ] , $ga_min , $ga_max );

	}
	elseif( $_SESSION[ 'h2_check' ][ $_id ]['plot'] == $_plot_code)
	{
		$this->kxra_Heading_memo[ '分岐' ] = '同プロットコード';
		$this->kxra_Heading_memo[ 'memo' ] = $_SESSION[ 'h2_check' ][ $_id ]['plot'] .'='. $_plot_code;
		$_h	= 3;
	}
	else
	{
		$_h	= 2;
	}



	$_SESSION[ 'h2_check' ][ $_id ][ 'h_x' ]		= $_h;
	$_SESSION[ 'h2_check' ][ $_id ]['plot']			= $_plot_code;

	//$_SESSION[ 'h2_check' ][ $_id ]['plot']			= $this->kxraS_post[ 'plot_code_base' ];

	//$_SESSION[ 'h2_check' ][ $_id ]['time_full']		= $this->kxraS_post[ 'time_full' ];

	//	$_SESSION[ 'h2_check' ][ $_id ]['plot_s']			= $plot_code_s;
	//$_SESSION[ 'h2_check' ][ $_id ]['time_nendo']	= $time_nendo;
	//$_SESSION[ 'h2_check' ][ $_id ]['time_month']	= $time_month;
	//$_SESSION[ 'h2_check' ][ $_id ]['time_day']		= $time_day;
	//$_SESSION[ 'h2_check' ][ $_id ]['time_time2']	= $time_time2;
	//$_SESSION[ 'h2_check' ][ $id ][ 'plot_kousei' ]	= $_plot_kousei;

	//$_SESSION[ 'h2_check' ][ $id ]['daimei_h']		= $_h;
	$_SESSION[ 'h2_check' ][ $_id ]['daimei']			= $this->kxraS_post['title_end'];


	if( !empty( $_SESSION[ 'h2_check' ][ $_id ]	['count'] ))
	{
		$_SESSION[ 'h2_check' ][ $_id ]	['count']++;
	}
	else
	{
		$_SESSION[ 'h2_check' ][ $_id ]	['count'] = 1;
	}

	$this->h_x	= $_h;

	return [
		'h_x' => $_h,
		'memo' => $this->kxra_Heading_memo,
	];

}



/**
 * バーの作成。
 * $idは必須。
 * 2023-07-04
 *
 * @param int $id
 * @return string
 */
public function kxra_bar(	$id	){

	$this->kxraM[ 'bar_ID' ] = $id;

	// 色・色相
	$_sikisou  = $this->kxraS_post[ 'c_sikisou_raretu_sx' ];


	if(	$_sikisou == 'gray')
	{
		$_style_bg = 'background: hsl( 0 , 0% , 15% ); border:solid 1px hsl(	0	, 0%	, 66%	);';
		$_sikisou	 = '0';
		$_hsla_s	 = '0';
	}
	else
	{
		$_style_bg = 'background: hsl('.$_sikisou.', 50%, 15%);	border:solid 1px hsl('.$_sikisou.', 50%, 66%);';
		$_hsla_s	= '100';

		//if( $this->kxraS_post[ 'hsla_normal' ] ):
			//$_style_bg = 'background:' . $this->kxraS_post[ 'hsla_normal' ] . ';	border:solid 1px hsl('.$_sikisou.', 50%, 66%);';
		//else:
			//$_style_bg = 'background: hsl('.$_sikisou.', 50%, 15%);	border:solid 1px hsl('.$_sikisou.', 50%, 66%);';
		//endif;
	}

	//学年
	$_arr_ga	= explode(',',$_SESSION[ 'raretu' ][ 'gakunen_hani' ][ $this->kxraS1[ 'kxtt' ][ 'character_number'] ] );

	//echo end( $_arr_ga );



	if( !empty( $_SESSION[ 'raretu' ][ 'etc_chara' ] ) )
	{
		//print_r($this->kxraS_post);

		$_time_nendo = intval($this->kxraS_post[ 'time_nendo' ]) + $_SESSION[ 'raretu' ][ 'etc_chara' ][ 'sa' ];
		$_time = $_time_nendo .'-'.$this->kxraS_post[ 'time_month' ] .$this->kxraS_post[ 'time_day' ];
		$this->kxraM[ 'gakunen' ]  = kx_gakunen( $_time , $_arr_ga[ 0 ] , end( $_arr_ga ) );

		if( $_time_nendo < 0  )
		{
			$this->kxraM[ 'gakunen' ]  = '- '. $this->kxraM[ 'gakunen' ]  ;
		}
	}
	else
	{

		$this->kxraM[ 'gakunen' ]  = kx_gakunen( $this->kxraS_post[ 'time' ] , $_arr_ga[ 0 ] , end( $_arr_ga ) );
	}





	$_change = 0;
	if( !empty( $_SESSION[ 'raretu' ]['gakune'] ) && $this->kxraM[ 'gakunen' ] == $_SESSION[ 'raretu' ]['gakune']	)
	{
		$this->kxraM[ 'bar_style1' ]	= $_style_bg;
		$this->kxraM[ 'bar_class_year' ] = '__equal';
		$_change = 0;
	}
	else
	{
		$this->kxraM[ 'bar_style1' ] = $_style_bg;
		$this->kxraM[ 'bar_class_year' ] = '__inequal';
		$_change = 1;

		unset($_SESSION[ 'raretu' ][ 'month' ] );
	}

	$_SESSION[ 'raretu' ]['gakune']  = $this->kxraM[ 'gakunen' ];


	//月の設定。 2023-07-04
	if( !empty( $this->kxraS1[ 'sys' ] ) &&	preg_match(	'/month_no/'	,	$this->kxraS1[ 'sys' ]	)	)
	{
		//使っている。2023-07-04
		$_unit_month_base	= NULL;
	}
	else
	{
		$_unit_month_base	= '月';
	}


	$this->kxraM[ 'bar_unit_month' ] = NULL;
	if( !empty( $this->kxraS_post[ 'time_month' ] ) && $this->kxraS_post[ 'time_month' ] ==  'n/a' )
	{
		$this->kxraM[ 'bar_class_month' ] = ' __not_applicable';
	}
	elseif( !empty( $this->kxraS_post[ 'time_month' ] ) && !empty( $_SESSION[ 'raretu' ][ 'month' ] ) && $this->kxraS_post[ 'time_month' ] == $_SESSION[ 'raretu' ][ 'month' ]	)
	{
		$this->kxraM[ 'bar_unit_month' ]	= $_unit_month_base;
		$this->kxraM[ 'bar_class_month' ] = ' __equal';
	}
	else
	{
		$this->kxraM[ 'bar_unit_month' ]	= $_unit_month_base;
		$this->kxraM[ 'bar_class_month' ] = ' __inequal';
	}


	if( !empty( $_SESSION[ 'raretu' ][ 'month' ] ) &&	$this->kxraS_post[ 'time_month' ] == $_SESSION[ 'raretu' ][ 'month' ]	)
	{
		//
	}
	else
	{
		$_change = 1;
	}

	$this->kxraM[ 'bar_style_month' ]	= 	$_style_bg;

	$_SESSION[ 'raretu' ][ 'month' ]  = $this->kxraS_post[ 'time_month' ];


	//日時・2023-07-04
	if( $this->kxraS_post[ 'time_day' ]	== 'n/a')
	{
		$this->kxraM[ 'bar_class_day' ] = ' __not_applicable';
	}
	elseif( !empty( $_SESSION[ 'raretu' ]['day'] ) && $this->kxraS_post['time_day'] == $_SESSION[ 'raretu' ]['day'] )
	{
		$this->kxraM[ 'bar_class_day' ] = ' __equal';
	}
	else
	{
		$this->kxraM[ 'bar_class_day' ] = ' __inequal';
	}

	$this->kxraM[ 'bar_style_day' ]	= 	$_style_bg;

	$_SESSION[ 'raretu' ]['day']	= $this->kxraS_post['time_day'];


	//■　$_change
	if( $_change )
	{
		$this->kxraM[ 'bar_style5000' ]  = 'background:hsl('.$_sikisou.', '.$_hsla_s.'%, 25%	);';
	}
	else
	{
		$this->kxraM[ 'bar_style5000' ]  = 'background:hsla('.$_sikisou.', '.$_hsla_s.'%, 50%	,.1);border-top: solid 3px hsl('.$_sikisou.', '.$_hsla_s.'%, 66%);';
	}

	if(
		(
			!empty( $this->kxraS1[ 'kxra_type' ][ 't' ] )
			&& $this->kxraS1[ 'kxra_type' ][ 't' ]	== 'chara_ww'
		) //||	$this->ra_set_t1_t2[ 't' ]	== 'chara_ww'//|| $this->kxraS1[ 'kxra_type' ][ 't' ]	== 'chara_ww'
		&& substr(	$this->kxraS_post[ 'plot_code_base' ],0	,1	)	!= 's'
	){

		$ret = NULL;
		$ret .=  '<span class="__kxra_code_wwr">'; //' . $css_bg . '

		if(	$this->kxraS_post['plot_kousei'] )
		{
			if( !empty( $this->plot_old ) && $this->plot_old  ==  $this->kxraS_post['plot_kousei'] )
			{
				$this->plot++;
			}
			else
			{
				$this->plot = 1;
			}

			$this->plot_old	= $this->kxraS_post['plot_kousei'] ;

			$plot_kousei	= strtoupper($this->kxraS_post['plot_kousei'] );

			if(preg_match('/\d/'	,	$plot_kousei	))
			{
				//プロット置換。
				$plot_kousei	= str_replace([1,2,3,4,5,6]	,['A','B','C','D','E','F']	,$plot_kousei);
			}

			$ret .= $plot_kousei.'-'.$this->plot;
			$_SESSION['plot_kousei']	= strtoupper($this->kxraS_post['plot_kousei'] );
		}
		else
		{
			$ret .= 'n/a';
		}

		$ret .= '</span>';

		$this->kxraM[ 'plot' ] = $ret;


		unset( $ret );
	}
	else
	{
		$this->kxraM[ 'plot' ] = NULL;
	}


	ob_start();
	include get_stylesheet_directory() .'/lib/html/h_raretu_bar.php';

	$this->kxraM[ 'bar' ] = ob_get_clean();
}


/**
 * name bar
 *
 * @param [type] $name
 * @param [type] $sikisou
 * @param [type] $sa
 * @param [type] $time
 * @param [type] $type
 * @return void
 */
public function kxra_bar_name( $args ){


	if(	!empty( $this->kxraS_post[ 'plot_code_base' ] ) )
	{
		$_code	 = '<span class="" style="opacity:.5;	margin-right:50px; display:inline-block;">';
		$_code	.= $this->kxraS_post[ 'plot_code_base' ];
		$_code	.= '</span>';
	}
	else
	{
		$_code = NULL;
	}


	if( !empty( $_SESSION[ 'raretu' ][ 'gaku_off' ] ))
	{
		$_sa = NULL;
	}
	elseif( !empty( $args[ 'sa'] ) )
	{
		$_sa	 = '<span class="__radius_10" style="font-size: large;">' . $args[ 'sa'] . '</span>・';
	}
	else
	{
		$_sa = NULL;
	}


	if( !empty( $args[ 'time'] ) )
	{
		if( preg_match( '/(\d{2})-(\d{2})(\w{1,2})(\d{1,}|)/' , $args[ 'time'] , $matches ) )
		{
			if( !empty( $matches[3] ) && is_numeric( $matches[3] ) )
			{
				if( preg_match( '/\d(\d)/',$matches[3] ,$matches_3 ))
				{
					$_iro = $matches_3[1] * 79;
				}
				else
				{
					$_iro = $matches[3] * 79;
				}

				if( $_iro > 360 )
				{
					$_iro = $_iro - 360;
				}

			}
			else
			{
				$_iro = kx_Judge_OLD( $this->kxraJUDGE[ 'kxra_name_bar_color' ] , 'preg' , $matches[3] )[ 'settings' ];
			}


			$_time	 = $_sa;

			$_time	.= '<span class="__kxra_bar_name0" style="background-color:hsla(' . $_iro . ',100%,50%,.2);">';//①

			//$_time	.= '<span class="__opacity5 __radius_10" style="background-color:black;">' . $matches[1] . '</span>';
			$_time	.= $matches[1];
			$_time	.= '-';

			$_time	.= '<span class="__a" style="background-color:hsla(0,0%,0%,.25);">';
			$_time	.= $matches[2];
			//$_time	.= '月';
			$_time	.= '</span>';
			$_time	.= '<span class="__b" style="background-color:hsla(' . $_iro . ',100%,50%,.5);">'	. $matches[3] . '</span>';

			if( !empty( $matches[4] ))
			{
				$_time	.= '-';
				$_time	.= '<span class="__c" style="">' . $matches[4] . '</span>';
			}

			$_time	.= '</span>';//①

			//$_time	.= '<span class="__opacity5">　/　</span>';
		}
		else
		{
			$_time	= '<span class="__opacity5">'. $_sa . $args[ 'time'] . '</span>';
		}

		unset( $matches );
	}
	else
	{
		$_time = NULL;
	}




	//読者視点989・プロット番号
	if(
		(
			$this->kxraS_post[ 'arr_character' ][ 'character_number' ]	== 989 ||
			$this->kxraS_post[ 'arr_character' ][ 'character_number' ]	== 988
		)
		&&
		!preg_match( '/^(s|o)\d{1,}/' ,$this->kxraS_post[ 'plot_code_base' ] )
	)
	{
		if( !empty( $_SESSION[ 'raretu' ][ 'name_count' ] ) )
		{
			$_SESSION[ 'raretu' ][ 'name_count' ]++;
		}
		else
		{
			$_SESSION[ 'raretu' ][ 'name_count' ] = 1;
		}

		if( 	$this->kxraS_post[ 'arr_character' ][ 'character_number' ]	== 989 )
		{
			$_page	= $_SESSION[ 'raretu' ][ 'name_count' ]*2-1;
		}
		elseif( 	$this->kxraS_post[ 'arr_character' ][ 'character_number' ]	== 988 )
		{
			$_page	= $_SESSION[ 'raretu' ][ 'name_count' ]*2-1;
		}



		//最終・置換要素代入
		$args[ 'name'] = '─　'.$_SESSION[ 'raretu' ][ 'name_count' ].' / ヾScene数'.'　P'.$_page.'　─';
	}

	$ret  = '';
	$ret .= '<div class="__white_space_nowrap" ';
	$ret .= 'style="';//text-align:right;
	$ret .= 'font-size:small;';
	$ret .= 'overflow:hidden;';
	$ret .= 'background:' . $args[ 'kxcl'][ 'hsla_normal' ] . ';';
	$ret .= 'margin:0px 0px 0px 0px;';
	$ret .= 'padding:0 0 0 0;';
	$ret .= 'height:20px; color:white;';
	$ret .= '">';

	$ret .= '<div style="text-align: right;float:right;margin-right:5px;direction: rtl;" >';

	$ret .= '<div class="_op__a" style="direction: ltr;">';
	$ret .= $args[ 'name'];
	$ret .= '</div>';

	$ret .= '<div class="_op__z _wwr_name" style="direction: ltr;">';

	$ret .= kx_table_create_3lane(
		$this->kxra_Heading_memo ,
		[
			'width' => '270px;',
			'text-align' => 'left;',
			'margin' => '0px;',
		]
	);

	$ret .= '</div>';

	$ret .= '</div>';


	$ret .= '<span class="__white_space_nowrap" ';
	$ret .= 'style="margin:0px 3px 0 5px;"';
	$ret .= '>';
	$ret .= $_time;
	$ret .= '</span>';


	if(	$args[ 'auto' ] == 'wws' )
	{
		if( !empty( $this->kxraS_post[ 'plot_code_base' ] ) )
		{
			$_add = $this->kxraS_post[ 'plot_code_base' ];

			if( mb_strlen( $_add) > 20)
			{
				$_add = mb_substr( $_add , 0, 80) . '……';
			}

			$_add = '&nbsp;&nbsp;'.$_add;
		}
		else
		{
			$_add = NULL;
		}
		$ret .= '<span class="__white_space_nowrap __opacity5" ';
		$ret .= 'style=""';
		$ret .= '>';
		$ret .= $_add;
		$ret .= '</span>';
	}

	$ret .= '</div>';

	return $ret;
}



/**
* WWS & WWI
* contents生成
*
* @param [type] $ids
* @return void
*/
public function kxra_wws(){

	$kxx  = new kxx;

	if( $this->kxraS1[ 'kxra_type' ][ 't2' ]  ==  'set' )
	{
		$this->kxraS1[ 'kxra_type' ][ 'auto' ]	= 'wwt';
	}

	//kxx用のid配列作成。2023-03-21
	unset( $kxx->kxx_arr_id0 );
	foreach( $this->kxra_arr_id[ 'sort' ][ 'id_lineup' ] as $id => $v	):

		$kxx->kxx_arr_id0[]	= $id;

	endforeach;


	KxDy::kxdy_trace_count('kxx_sc_count', 0);
	KxDy::kxdy_trace_count('kxx_sc_count', 1);

	//outline用・ID

	//kxxの設定作成。2023-03-21
	$kxx->kxxS1	=
	[
		't'							=>  19,
		'ppp'						=>  999,
		'sys'						=>  $this->kxraS1[ 'sys_kxx10' ],
		'auto'					=>  $this->kxraS1[ 'kxra_type' ][ 'auto' ],

		'id_Heading'					=> $this->kxraS1[ 'id_base' ],

		'arr_wws' =>
		[
			'arr_sakuhin'		=>  $this->kxraS1[ 'kxtt' ],
			'chara_count'	 	=>  $this->kxraS1[ 'chara_count' ] ,
			'raretu_count'	=>  $this->kxraS1['raretu_count'] ,
			'raretu_t'			=>  $this->kxraS1[ 't' ] ,
			'raretu_t2'			=>  $this->kxraS1['t2'] ,
			'raretu_sys'		=>  $this->kxraS1[ 'sys' ] ,

			'wwl'	       		=>	NULL,//削除予定。2022-02-03
		],
	];



	//sysスイッチon。
	$kxx->kxxS1	= kx_shortcode_sys( $kxx->kxxS1 );

	unset( $kxx->kxxError['type'] );

	$kxx->kxxS1[ 'ra_post_set' ]  = $this->kxraS_post;

	$output	= $kxx->kxx_output();

	wp_reset_postdata();

	if( !empty( $kxx->kxxError['type'] ) )
	{
		$kxx->kxxError[ 'kxxErrS1' ] = $kxx->kxxS1;
		$contents = kx_CLASS_error( $kxx->kxxError );
	}
	else
	{
		$contents	= $output[ 0 ];
	}

	return  $contents;
}



/**
 * WWR
 * contents出力
 *
 * @return string
 */
public function kxra_wwr(){

	//outline非表示。2023-08-10
	$_SESSION[ 'raretu' ][ 'NO_outline' ] = 1;

	if( $this->kxraS1[ 'chara_count' ]	>	4	)
	{
		//キャラ数が5以上の場合。2023-03-03

		foreach( $this->kxraS1[ 'chara_num_arr' ] as $key => $c_num ):

			/*
			if( $key > 4 )
			{
				//多分いらない。2023-08-10
				unset( $this->kxraS1[ 'chara_num_arr' ][ $key ] );
			}
			*/

			if( $key == 989)
			{
				$this->kxra_memory[ 'c989_on' ] = 1;
			}

		endforeach;
	}

	// ID配列から、時間だけの配列を作成。
	// 時間とIDを割り振る。2023-07-01
	$_arr_time	= array();
	foreach( $this->kxra_arr_id[ 'sort' ][ 'id_lineup' ] as $key => $value	):
		// 配列説明。 $id => $title。2023-07-04

		//時間作成。タイトルの、_より後を削除。2023-07-01
		$_time	= preg_replace('/_.*$/'	,''	, $value	);

		if( empty( $_arr_time[ $_time ] ) )
		{
			$_arr_time[ $_time ]	= $key;
		}

	endforeach;
	unset( $key , $value , $_time );


	//表示開始


	//前回post日時
	$this->kxra_memory[ 'wwr_time_old' ] = '';
	$this->kxra_memory[ 'wwr_s_h2' ] = 0; //多分使っていない。2023-07-04
	$this->kxra_memory[ 'chara_on' ] = 0;

	//■出力開始。2023-07-04
	$ret = '';

	//キャラクターバー。作成。2023-08-12
	$this->kxra_wwr_chara_bar();
	$ret .= $this->kxraM[ 'kxra_wwr_chara_bar2' ];

	// 縦軸の配置。時間ごとの割り振り。$key0 はtime。横軸。$value0は$id。2023-03-03
	foreach( $_arr_time as $key0 => $value0 ):

		//時間のメインポストのpostセッテイングを取得。2023-07-04

		$this->kxra_Setting_Post( $value0 );

		//横列編集用。2023-07-04
		$this->kxra_memory[ 'wwr_plot_code_base' ] = '_'.$this->kxraS_post[ 'plot_code_base' ] ;

		$ret .= '<div style="background-color:hsla(' . $this->kxraS_post[ 'c_sikisou_raretu_sx' ] . ',100%,50%,.05);">';


		//barの生成。設置の有無。2023-07-04
		$ret .= $this->kxra_wwr_bar( $key0 , $value0 );
		unset( $this->kxraS_post );



		$ret .= '<table class="__kxwwr_table__" style="border-spacing:0px;"><tr>';

		// 横軸の配置。$key1 は $rank。$value1は $c_num。 2023-07-04
		foreach( $this->kxraS1[ 'chara_num_arr' ] as $key1 => $value1 ):

			//こちらが先。'wwr_add_class'が後。2023-07-04
			$_wwr_content = $this->kxra_wwr_td( $key0 , $key1 , $value1 );


			$ret .='<td class="__kxra_wwr_td '.$this->kxra_memory[ 'wwr_add_class' ].'">';

			//横幅要素。何故かたまに狂わされる？2024-11-14
			$ret .='<div class="' . $this->kxraS1[ 'chara_count_judge' ][ 'css_div' ] . '">';

			$ret .= $_wwr_content;

			$ret .= '</div>';
			$ret .= '</td>';

		endforeach;

		//echo $this->kxra_memory[ 'wwr_plot_kousei' ][ $key0 ];

		$ret .= $this->kxra_wwr_time_edit();

		$ret .='</tr></table>';

		$ret .= '<div class="__back_gray_op01" style="height:1px;">';
		$ret .= '</div>';

		$ret .= '</div>';

	endforeach;


	return $ret;
}


/**
 * wwrでのbar設置。その有無。
 * 制作中。
 * 2023-07-04
 *
 * @return void
 */
public function kxra_wwr_bar( $key0 ,  $value0 ){

	$key_time = $key0;
	$id       = $value0;

	$ret = NULL;


	//新規用の題名作成。時間ごとに題名を割り振る。2023-07-01
	$this->kxra_memory[ 'wwr_time_damei' ]  = [ $key_time => $this->kxraS_post[ 'daimei' ] ];
	$this->kxra_memory[ 'wwr_plot_kousei' ] = [ $key_time => $this->kxraS_post[ 'plot_kousei' ] ];

	//現在日時
	$time				= $this->kxraS_post['time_nendo'] . $this->kxraS_post['time_month'] . $this->kxraS_post['time_day'];
	$time_full	= $this->kxraS_post[ 'time_full' ];

	$this->kxra_memory[ 'wwr_new_time' ] = $time_full ;

	/*
	if( !empty( $this->kxraS_post[ 'plot_sakuhin' ] ))
	{
		$_new_time .= '_' .$this->kxraS_post[ 'plot_sakuhin' ];
	}
	*/

	if( preg_match( '/^\w\d{1,}(-(\d)|)/' , $this->kxraS_post[ 'plot_code_base' ] , $matches ) )
	{
		$plot_code 		 =  $matches[ 0 ];
	}
	else
	{
		$plot_code 		 = NULL;
	}

	//月日判断
	if( !$this->kxra_memory[ 'wwr_time_old' ] )
	{
		//初期値

		$_line_on	=1;
		$this->kxra_memory[ 'chara_on' ]++;
	}
	elseif( $this->kxra_memory[ 'wwr_time_old' ]	!= $time )
	{
		//日付変更

		$_line_on	=1;
		$this->kxra_memory[ 'chara_on' ]++;
	}
	elseif( $plot_code && $plot_code != $this->kxra_memory[ 'wwr_plot_code_old' ] )
	{
		$_line_on	=1;
	}
	else
	{
		//日付同じ

		$_line_on	=0;
		$this->kxra_memory[ 'chara_on' ] =0;
	}

	$this->kxra_memory[ 'wwr_plot_code_old' ] =  $plot_code;

	if( $this->kxra_memory[ 'chara_on' ] == 2 )
	{
		$this->kxra_memory[ 'chara_on' ] = 0;
	}

	//旧時間保存
	$this->kxra_memory[ 'wwr_time_old' ]				= $time;
	/*$time_full_old	= $time_full;*/




	//barの設置。2023-07-04
	if( $_line_on )
	{
		$ret .= '<div class="__kxra_h2_hidden_id" id=ww'. $this->kxra_memory[ 'wwr_s_h2' ] .'>';
		$ret .= '</div>';

		$this->kxra_bar( $id );
		$ret .=  $this->kxraM[ 'bar' ];
	}



	return $ret;

}


/**
 * 各postの配置。
 * $keyは $id
 * $valueは $key_time_rank
 *
 * 同一時間帯対策。追記型に変更	.= $_wwr_content
 *
 * 2023-07-04
 *
 * @return void
 */
public function kxra_wwr_td( $key0 , $rank , $c_num ){

	$ret = '';
	foreach( $this->kxra_arr_id[ 'sort' ][ 'id_lineup' ] as $key => $value ):

		$ret .= $this->kxra_wwr_content( $key0 ,$rank ,$key , $value );

	endforeach;


	//postがない場合。2023-03-21
	if( ( !empty( $this->kxra_memory[ 'wwr_rank_on' ] ) && $this->kxra_memory[ 'wwr_rank_on' ] != $rank ) || !$ret )
	{
		$ret = $this->kxra_wwr_non_content( $key0 , $rank , $c_num );
	}

	unset( $this->kxra_memory[ 'wwr_rank_on' ] );

	return $ret;
}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxra_wwr_content( $key_time , $rank , $id , $key_time_rank  ){

	$ret = NULL;

	//$this->kxraS_postを生成。
	$this->kxra_Setting_Post( $id );

	if(	preg_match(	'/^' . $key_time . '_' . $rank . '/' , $key_time_rank	)	)
	{
		//ランク一致。2023-03-21

		//kxxの準備。2023-03-03
		$kxx	= new kxx;
		$kxx->kxxS1	=
		[
			't'							=> 19	,
			'ppp'						=> 999	,
			'sys'						=> $this->kxraS1[ 'sys_kxx10' ].',chara_count'.$this->kxraS1[ 'chara_count'],
			'auto'					=> $this->kxraS1[ 'kxra_type' ][ 'auto' ],
			'id_Heading'		=> $this->kxraS1[ 'id_base' ],

			'arr_wws'				=>
			[
				'arr_sakuhin'			=>	$this->kxraS1[ 'kxtt' ],
				'raretu_count'		=>  $this->kxraS1[ 'raretu_count' ],
				'raretu_id_base'	=>  $this->kxraS1[ 'id_base' ],
				'raretu_t2'				=>  $this->kxraS1[ 't2' ],
			],
		];

		$this->kxra_memory[ 'wwr_rank_on' ]	= $rank;

		if(	$this->kxraS1[ 'chara_count' ] > 1 && $rank	== 0	)
		{
			$kxx->kxxS1[ 'kxEdit_right' ]	= 'kxEdit_right';
		}
		else
		{
			$kxx->kxxS1[ 'kxEdit_right' ]	= NULL;
		}


		$kxx->kxxS1[ 'ra_post_set' ]  = $this->kxraS_post;

		$kxx->kxx_arr_id0[]	    = $id;
		$_SESSION['wwr_id']	= $id;

		$kxx->kxxS1	= kx_shortcode_sys(	$kxx->kxxS1	);

		$this->kxra_memory[ 'wwr_add_class' ]	= '__top';

		//kxxのアウトプット。2023-03-03
		$ret	= $kxx->kxx_output()[ 0 ];

		wp_reset_postdata();

		//横列一括日時変更。2020/03/05
		$this->kxraM[ 'wwr_time_edit' ][ 'ids_time' ][]	= $id;
	}

	return $ret;


}


/**
 * postが無い場合のニューポスト作成。
 * 2023-07-04
 *
 * @return void
 */
public function kxra_wwr_non_content( $key_time , $rank , $c_num ){



	if( preg_match('/('	.	KxSu::get('titile_search')[	'work_Platform'	]	.	')\d{1,}/i'	, $this->kxraS1[ 'title_base' ]	,	$matches ) )
	{
		$ma = '<br>';
	}
	else
	{
		$matches[ 0 ] = NULL;
		$ma = NULL;
	}

	$this->kxra_memory[ 'wwr_add_class' ]	= '__na';

	if(	$rank	== 0	)
	{
		//if( preg_match( '/共通w/'	,	$this->kxraS1[ 'title_base' ]	)	)
		//{
			//$_new_title	= 	preg_replace('/共通w/'	,	''	,	$this->kxraS1[ 'title_base' ]	);

			//$_w_kyoutu	= 1;
		//}
		//else
		//{
		preg_match( '/∬\d{1,}≫c\d\w{1,}\d/'	,	$this->kxraS1[ 'title_base' ]	,$matches_title	);

		$_new_title	= 	$matches_title[ 0 ].'≫来歴≫';
		//}
	}
	else
	{
		if( $rank	== 4 && !empty( $this->kxra_memory[ 'c989_on' ] ) ) //$rank == 4 &&
		{
			//989対応

			$c_num =989;
		}

		preg_match('/(∬\d{1,}≫)(c\d\w{1,}\d)/' , $this->kxraS1[ 'title_base' ]	,	$matches_new_title );

		$_new_title	= $matches_new_title[1].'c'.$c_num.'≫＼'.$matches_new_title[2].'≫来歴≫';
	}


	if( strtolower( $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] ) == 's' )
	{
		$_plot_code			= NULL;
		$_w_kyoutu_text = NULL;
	}
	elseif(	!empty( $this->kxraS_post[ 'plot_code_base' ] ) && !empty( $this->kxraS_post[ 'plot_sakuhin' ] ) )
	{
		$_plot_code	= '_'.$this->kxraS_post[ 'plot_sakuhin' ] ;

		if( !empty( $this->kxra_memory[ 'wwr_plot_kousei' ][ $key_time ]  ))
		{
			$_plot_code	.= '-' . $this->kxra_memory[ 'wwr_plot_kousei' ][ $key_time ];
		}

		$_w_kyoutu_text	= '❗プロットコード:TypeA❗'."\n".$_plot_code;
		//echo $this->kxraS_post[ 'plot_code_base' ];
	}
	elseif(	$rank	== 0	) //&&	$_w_kyoutu
	{
		$_plot_code			= NULL;
		$_w_kyoutu_text	= '❗TypeC❗';
	}
	else
	{
		$_plot_code			= NULL;
		$_w_kyoutu_text = NULL;
	}


	if( $rank == 0 )
	{
		$_sys	= 'kxEdit_right';
	}
	else
	{
		$_sys = NULL;
	}


	/*
	//Error補正。2023-04-09。
	//後で確認が必要。
	if( empty($_sys) )
	{
	}
	*/

	//新規の題名senat区。
	if( !empty( $this->kxra_memory[ 'wwr_time_damei' ][ $key_time ] ))
	{
		$_new_title_daimei = $this->kxra_memory[ 'wwr_time_damei' ][ $key_time ];
	}
	else
	{
		$_new_title_daimei = '新規';
	}


	$_new_title	.= $key_time . $_plot_code . '＠' . $_new_title_daimei;

	$_edit	= kxEdit(
	[
		'new'						=>	1,
		'hyouji'				=>	'╋',
		'hyouji_style'	=>	'background:non;',
		'kx30_on'				=>	1	,
		'sys'						=>	$_sys,
		'new_title'			=>	$_new_title,
		'new_content'		=>	$_w_kyoutu_text,
	]	);

	$ret  = NULL;
	$ret .= '<div style="margin:30px 0px;">';
	$ret .= $_edit[ 0 ];
	$ret .= '<span class="__font_weight_bold __xxlarge" style="color:hsla(0,0%,50%	,	.075	);">';
	$ret .= 'N/A'. $ma;	//$maはbrであることが多い。2020-11-13
	$ret .= $matches[ 0 ]	.'<br>';
	$ret .= $rank .'-'. $c_num;
	$ret .= '</span>';
	$ret .= $_edit[1];
	$ret .= '</div>';

	return $ret;
}


/**
 * wwrの横軸時間とタイトルの編集。
 * <td>要素として出力。
 * 2023-07-04
 *
 * @return string
 */
public function kxra_wwr_time_edit(){

	//横一列・更新
	$this->kxraM[ 'wwr_time_edit' ][ 'str_ids' ] = NULL;
	//id配列用のstring文字列作成。2023-07-04
	if( is_array( $this->kxraM[ 'wwr_time_edit' ][ 'ids_time' ] ) )
	{
		foreach( $this->kxraM[ 'wwr_time_edit' ][ 'ids_time' ] as $value ):

			$this->kxraM[ 'wwr_time_edit' ][ 'str_ids' ]	.= $value . ',';

		endforeach;
		unset( $value );
	}


	//戻るURL作成。
	if( !empty( $this->kxra_memory[ 'wwr_fulltime_count' ] ))
	{
		$this->kxra_memory[ 'wwr_fulltime_count' ]++;
	}
	else
	{
		$this->kxra_memory[ 'wwr_fulltime_count' ] = 1;
	}

	$this->kxraM[ 'wwr_time_edit' ][ 'url' ]	 = (empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" );
	$this->kxraM[ 'wwr_time_edit' ][ 'url' ]	.= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'#fulltime'.$this->kxra_memory[ 'wwr_fulltime_count' ];


	//ENDタイトル作成。
	$this->kxraM[ 'wwr_time_edit' ][ 'end_title' ]	= preg_replace( '/^.*＠/' , '' , end( explode( '≫' , get_the_title( $this->kxraM[ 'wwr_time_edit' ][ 'ids_time' ][ 0 ] ) )	)	);

	//print_r($this->kxraS1[ 'cat' ]);
	//echo '<hr>';




	//2
	if( preg_match( '/∬\d{1,}≫(c800)/' ,$this->kxraS1[ 'title_base' ] ))
	{
		$this->kxraM[ 'c800_on' ] = 1;


	}
	else
	{
		$this->kxraM[ 'c800_on' ] = null;
	}

	ob_start();
	include get_stylesheet_directory() .'/lib/html/h_raretu_wwr_time_edit.php';
	$ret = ob_get_clean();

	unset( $this->kxraM[ 'wwr_time_edit' ] );




	return $ret;
}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxra_wwr_chara_bar(){

	//制作中。2023-08-10。
	//キャラクターの名前バー


	foreach( $this->kxraS1[ 'chara_num_arr' ] as $value ):

		if( isset( $this->kxraS1[ 'chara_num_setting_array' ][ $value ][ 'rank' ] )  )
		{
			$_bar_array[ $this->kxraS1[ 'chara_num_setting_array' ][ $value ][ 'rank' ] ][] = $value;
		}
		else
		{
			echo $value . ':No-Post<br>';
			$_bar_array[][] = $value;
		}



	endforeach;
	unset( $value );

	$retA = '';
	$retB = '';
	foreach( $_bar_array as $value ):

		$_td0  = '';
		$_td0 .= '<td>';
		$_td0 .= '<td>';

		$_td0 .= '<div class="'.$this->kxraS1[ 'chara_count_judge' ][ 'css_div_B' ].'"; style=" ';

		//$_td0 .= 'width:'. $this->kxraS1[ 'chara_count_judge' ][ 'width' ] .'px;';
		//$_td0 .= 'border:0;';

		//$_td0 .= 'border-left:solid 0px hsl(0,0%,5%);border-right:solid 0px hsl(0,0%,5%);';
		$_td0 .= '">';

		$retA .=  $_td0;
		$retB .=  $_td0;

		$_count = count($value );
		if( $_count != 1)
		{
			$_display = 'inline-block';
		}
		else
		{
			$_display = NULL;
		}
		$_width = 100 / $_count;

		foreach( $value as $c_num ):

			if( strtolower( $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] ) == 's' )
			{
				$_p_code = NULL;
			}
			elseif( !empty( $this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] && !empty( $this->kxraS1[ 'kxtt' ][ 'work_code_number_s' ] ) ) )
			{
				$_p_code = '_'.$this->kxraS1[ 'kxtt' ][ 'work_code_top1' ] . $this->kxraS1[ 'kxtt' ][ 'work_code_number_s' ];
			}
			else
			{
				$_p_code = NULL;
			}


			$_in_kxx	=
			[
				't'							=>	62,
				'cat'						=>	$this->kxraS1[ 'cat' ],
				'tag'						=>	$this->kxraS1[ 'tag' ],
				'new_content'	  =>	'＿raretu＿',
				'text_c' 		    => 'Link',
			];

			$_new_title  = '∬';
			$_new_title .= $this->kxraS1[ 'title_world' ];
			$_new_title .= '≫c'.$c_num;



			$_in_edit	=
			[
				't'				      => 78,
				'new'			      => 1,
				'new_content'		=> '',//'＿kx_tp type=plot＿',
				'css_hyouji'		=> '__text_shadow_black1_02 '.$this->kxraS1[ 'chara_num_setting_array' ][ $c_num ][ 'text_class'],
				'hyouji_style' 	=> '	background:'. $this->kxraS1[ 'chara_num_setting_array' ][ $c_num ][ 'hsla_normal' ] .';',
				'hyouji'				=> '╋New&nbsp;',
				'hue'           =>	$this->kxraS1[ 'chara_num_setting_array' ][ $c_num ][ '色相' ],
			];



			if(	$this->kxraS1[ 'chara_num_arr' ][ 0 ]	== $c_num)
			{
				if( empty( $this->kxraS1[ 'c1' ] ) )
				{
					$this->kxraS1[ 'c1' ]	= $this->kxraS1[ 'chara_num_arr' ][1];
				}
				$_in_kxx[ 'search' ]		= 'c'.$c_num.'＞来歴'; //cを追加。2024-06-15
				$_in_kxx[ 'title_s' ]	  = '来歴＄ -＼';
				$_in_kxx[ 'new_title' ] = $_new_title . '来歴';

				$_new_title .= '≫来歴≫00-00';
				$_new_title .= $_p_code;
				$_new_title .= '：New';


				$_in_edit[ 'sys']	=	'kxEdit_right';
				$_in_edit[ 'new_title' ]	=	 $_new_title ;
			}
			else
			{
				$_new_title .= '≫＼c'.$this->kxraS1[ 'chara_num_arr' ][ 0 ];

				$_in_kxx[ 'search' ]	= 'c'.$c_num.'≫＼';
				$_in_kxx[ 'title_s' ]	= '来歴＄';
				$_in_kxx[ 'new_title' ] = $_new_title . '≫来歴';

				$_new_title .= '≫来歴≫00-00';
				$_new_title .= $_p_code;
				$_new_title .= '：New';


				$_in_edit[ 'new_title' ]	=	 $_new_title ;
			}

			$_div  = '';

			$_div .= '<div style="';
			$_div .= 'display:'.$_display.';';
			$_div .= 'width:'. $_width .'%;';
			$_div .= 'text-align: center;';
			$_div .= 'background:'. $this->kxraS1[ 'chara_num_setting_array' ][ $c_num ][ 'hsla_normal' ] .';';
			$_div .= 'white-space: nowrap;overflow: hidden;';
			$_div .= '">';

			$_div .= 'C';
			$_div .= $c_num;
			$_div .= '：';
			$_div .= $this->kxraS1[ 'chara_num_setting_array' ][ $c_num ][ 'kxtt' ][ 'character_name'];


			$retA .= $_div;
			$retB .= $_div;


			$retA .= '<div>';
			$retA .= '<div style="float: right;">';
			$retA .= kxEdit( $_in_edit ) ;
			$retA .= '</div>';

			$retA .= '<div>';
			$retA .= kx_CLASS_kxx( $_in_kxx );
			$retA .= '</div>';


			$retA .= '</div>';

			$retA .= '</div>';

			$retB .= '</div>';

		endforeach;


		$retA .=  '</td>';

		$retB .= '</div>';
		$retB .= '</td>';
	endforeach;

	$ret1  = '';
	$ret1 .= '<table style="border-collapse:collapse;background:hsl(0,0%,5%);"><tr>';
	$ret1 .= $retA ;
	$ret1 .= '<td style="width:20px;"></td>';
	$ret1 .= '</tr></table>';

	$this->kxraM[ 'kxra_wwr_chara_bar1' ] = $ret1;

	//retB用を表示
	ob_start();
	include get_stylesheet_directory() .'/lib/html/raretu_wwr_chara_bar.php';

	$this->kxraM[ 'kxra_wwr_chara_bar2' ] = ob_get_clean();
	//ここまで。



}



/**
* アウトプット。
* 旧・非save系
* 2023-07-03
*
* @return string
*/
public function kxra_output(){

	if( $this->kxraS1[ 'raretu_count' ] == 1 )
	{
		$this->kxra_output_content();
	}

	//羅列の基本情報作成。2023-07-03
	if( empty( $this->kxraS1[ 'db'] ) )
	{
		$this->kxraM[ 'table_navi' ] 	= kx_table_navi(
		[
			'memory_on'		=> $this->kxra_arr_id[ 'search_1' ][ 'memory_on' ],
			'Cat'					=> $this->kxraS1[ 'cat' ],
			'Tag'					=> $this->kxraS1[ 'tag' ],
			'Search'			=> $this->kxraS1[ 'search' ],
			'T'						=> $this->kxraS1[ 'kxra_type' ][ 't' ],
			'T2'					=> $this->kxraS1[ 'kxra_type' ][ 't2' ],
			'Auto'				=> $this->kxraS1[ 'kxra_type' ][ 'auto' ],
			'J-Je_type' 	=> $this->kxraS1[ 'order_j_je' ],
			'J-Je_J'		  => $this->kxraS1[ 'j' ],
			'J-Je_Je'		  => $this->kxraS1[ 'je' ],
			'Chara'       => $this->kxraS1[ 'c' ],
			'T-Min'       => $this->kxraS1[ 'time_min' ],
			'T-max'       => $this->kxraS1[ 'time_max' ],
			'memo'				=> $this->kxraS1[ 'memo' ],
		]	);

		$this->kxraM[ 'system_name' ] = '▼System/N';
	}
	else
	{
		$this->kxraM[ 'table_navi' ] 	= kx_table_navi(
		[
			'db'		 		=> $this->kxraS1[ 'db'],
			'db_type'	  => $this->kxraS1[ 'db_type' ],
			'db_like'		=>  $this->kxraS1[ 'db_like' ],
			'T'					=>	$this->kxraS1[ 'kxra_type' ][ 't' ],
			'T2'				=>	$this->kxraS1[ 'kxra_type' ][ 't2' ],
			'J-Je_type' 	=> $this->kxraS1[ 'order_j_je' ],
			'J-Je_J'		  => $this->kxraS1[ 'j' ],
			'J-Je_Je'		  => $this->kxraS1[ 'je' ],
			'memo'			=>	$this->kxraS1[ 'memo' ],
		]	);

		$this->kxraM[ 'system_name' ] = '<span style="color:hsl(0,100% , 85% );">▼System/DB<spna>';
	}


	if( $this->kxraS1[ 'kxra_type' ][ 't' ] == 'chara_w' || $this->kxraS1[ 'kxra_type' ][ 't' ] == 'chara_ww' )
	{
		$this->kxraM[ 'all_title_change' ]	= null;
	}
	else
	{
		//全タイトルチェンジ。作成。2023-07-03
		ob_start();
		include get_stylesheet_directory() .'/lib/html/h_raretu_all_title_change.php';
		$this->kxraM[ 'all_title_change' ]	= ob_get_clean();
	}

	//メインコンテンツ。
	ob_start();
	include get_stylesheet_directory() .'/lib/html/raretu_no_save.php';
	return ob_get_clean();
}


/**
 * メインループ画面の作成。
 * 2023-07-04
 *
 * @return void
 */
public function kxra_output_content(){

	//raretuの最上位表示。2023-07-02

	if( $this->kxraS1[ 'chara_count' ] >	0 && $this->kxraS1[ 'kxra_type' ][ 't2' ]	== 'chara' )
	{
		//共通来歴、Chara_WW。複数キャラ用。

		$this->kxraM[ 'chara_list_edit_on' ] = 1;
	}
	elseif( empty( $this->kxraS1[ 'db'] ) )
	{
		$this->kxraM[ 'set_edit' ] = kxEdit(
		[
			't'				        =>	78,
			'new'			        =>	1,
			'hyouji'				  =>	'╋NEW',
			'new_title'			  =>	get_the_title().'≫新規',
		] ) ;
	}
	else
	{
		$this->kxraM[ 'set_edit' ] = NULL;
	}


	if( !empty( $_SESSION[ 'raretu' ][ 'name_count' ] ))
	{
		$this->contents	= str_replace('ヾScene数',$_SESSION[ 'raretu' ][ 'name_count' ]	,	$this->contents);
	}
}



/**
* IDなし、Error表示
* 新規ポスト追加機能。
*
* @return void
*/
public function kxra_error_NoID(){

	$str = NULL;

	if( !empty( $this->kxraS1[ 'shortcode_format' ] ) )
	{
		$str	 = '';
		$str	.= '<div class="__float_right2">';
		$str	.= '<a href="' . get_permalink( $this->kxraS1[ 'shortcode_format_id' ]	).'">';
		$str	.= '─　F：raretu　─';
		$str	.= '</a>';	//a
		$str	.= '</div>';

		return	$str;
	}
	else
	{
		//エラー出力。2023-02-27
		$_arr = [
			'memo' 				=>  [ '■■raret ERROR　─該当なし─■■<br>' ],
			'title' 			=>	[ $this->kxraS1[ 'title_base' ]  ],
		];

		if( is_array( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] ))
		{
			$_arr[ '一段目' ] = [ count($this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] ) , 'hr_on' => 1];
		}
		else
		{
			$_arr[ '一段目' ] = [ '無し' , 'hr_on' => 1 ];
		}


		if( is_array( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] ) )
		{
			$_arr[ '二段目' ] = [ count($this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] )];
		}
		else
		{
			$_arr[ '二段目' ] = [ '無し' ];
		}


		//シリーズ検索呼び出し
		//require(	__DIR__ ."/php_array/set.php"	);


		if(	preg_match(	'/(∬\d{1,}≫c\d\w{1,}\d)≫('	.	KxSu::get('titile_search')[	'work_Platform'	]	.	')(\d{1,})/i'	,	$this->kxraS1[ 'title_base' ] ,	$matches	)	)
		{
			//echo'+++++++++++';

			$_new_title			= $matches[1].'≫来歴≫00-00_'. strtolower( substr(	$matches[ 2 ] , 0 , 1 ) ) . ltrim ( $matches[ 3 ] , 0 ) . '＠新規' ;
			$_new_content	= '❗注意❗企画系❗';
		}
		elseif(	preg_match(	'/(∬\d{1,}≫c\d\w{1,}\d)≫来歴≫共通w/i'	,	$this->kxraS1[ 'title_base' ]	,	$matches	)	)
		{
			$_new_title		= $matches[1].'≫来歴≫00-00＠新規';
			$_new_content	= '❗注意❗共通系❗';
		}
		else
		{
			$_new_title		= $this->kxraS1[ 'title_base' ] . '≫新規';
			$_new_content	= '《' . date("Y/m/d H:i:s")	.	'》';
		}

		unset( $matches );


		$str	.= '<p>[kxedit new=1';
		$str	.= ' css_hyouji="__text_shadow_black1_02 __bg_100_33_240"';
		$str	.= ' css_bg="__bg_100_80_240"';
		$str	.= ' hyouji="＋＋＋＋＋＋＋＋＋＋＋＋新規追加＋＋＋＋＋＋＋＋＋＋＋＋"';
		$str	.= ' new_title="'. $_new_title . '"';
		$str	.= ' new_content="'.$_new_content.'"';
		$str	.= '"';
		$str	.= ']</p>';
		$str	.= '</div>';

		$_arr[ 'new' ] = [ 'unity' => do_shortcode( $str	) , 'style' => 'text-align:right;' ];

		unset( $str );

		$ret = NULL;
		$ret .= '<form method="post" action="wp-content/themes/kasax_child/lib/php/p_update_post.php"	class="" style="margin:0;">';

		//隠し要素
		$_url = NULL;
		$_url	.= (empty($_SERVER["HTTPS"] ) ? "http://" : "https://") ;
		$_url	.= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ;

		$ret .= '<input type="hidden" name="url" value="'.$_url.'">	';

		$ret .= '<input type="text" name="title" style="width:100%;height:2em;" value="';

		$ret .= $_new_title;

		$ret .= '">';
		$ret .= '<input type="text" name="text" style="width:100%;height:2em;" value="';//─新規─php製作中─">
		$ret .= $_new_content;
		$ret .= '">';

		$ret .= '<input type="submit" name="reload"	value="───⟳───"	class="__btn_form1">';

		$ret .= '</form>';

		$ret_arr['New'] = $ret;
		unset($ret);

		$ret_arr['LINE'] 		  = [ __LINE__ ];
		$ret_arr['title'] 	  = [ get_the_title( $this->kxraS1[ 'id_base' ] ) ];
		$ret_arr[ 'cat' ] 		= [ $this->kxraS1[ 'cat' ] ];
		$ret_arr[ 'tag' ] 		= [ $this->kxraS1[ 'tag' ] ];

		if( !empty( $kxx->kxxS1[ 'search' ] ))
		{
			$ret_arr['search'] 	= [ $kxx->kxxS1[ 'search' ] ];
		}

		$ret_arr[ 't' ] 			= [ $this->kxraS1[ 't' ] ];
		$ret_arr['t2'] 			= [ $this->kxraS1[ 't2' ] ];
		$ret_arr[ 'id' ] 			= [ $this->kxraS1[ 'id_base' ] ];
		$ret_arr['sys'] 		= [ $this->kxraS1[ 'sys' ] ];

		$ret_arr['shortcode_format'] 	= [ $this->kxraS1[ 'shortcode_format' ] ];

		if( $this->kxraS1[ 'code' ] )
		{
			$ret_arr[ 'code' ] = [ $this->kxraS1[ 'code' ] ];
		}

		if( $this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] )
		{
			$ret_arr['arr_id1'] 	= [ count($this->kxra_arr_id[ 'search_1' ][ 'arr_id' ] ) ];
		}

		if(is_array( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] ) )
		{
			$ret_arr['arr_id2'] = [count( $this->kxra_arr_id[ 'search_end' ][ 'arr_id' ] ) ];
		}

		$OUT_echo_fixed = $ret_arr;
		unset( $OUT_echo_fixed['New'] );

		return kx_CLASS_error(
		[
			'OUT_echo_top'   => $_arr ,
			'OUT_echo_fixed' => $OUT_echo_fixed,
			'table'          => $ret_arr ,
			'memo'           => '羅列・下位が存在しない（たぶん）'
		] );
	}
}



/**
 * 序盤エラー排除のチェック。
 * エラーがある場合は停止。
 * 2023-07-03
 *
 * @return void
 */
public function kxra_Error_Start_Elimination(){

	$_str = NULL;
	$_error_on = NULL;
	//エラーチェック。
	if(	!empty( $this->kxraS1[ 'c' ]) && preg_match( '/^\d.*,\d/' , $this->kxraS1[ 'c' ] ) )
	{
		// 'c'チェック。
		//キャラ番号チェック。
		//スルー
	}
	elseif( !empty( $this->kxraS1[ 'c' ] ) && !ctype_digit( $this->kxraS1[ 'c' ] ) )
	{
		$_error_on = 'sc_c';

		$_str .= '「c」の入力数値間違え：';
		$_str .=  $this->kxraS1[ 'c' ];
	}


	//エラー出力。
	if( !empty( $_error_on ) )
	{
		echo '■echo■'. $_str .'■'. get_the_title().'<hr>';

		$this->kxra_error  =
		[
			'type'    =>  $_error_on ,
			'memo'    =>  $_str ,
		];
	}
	return $_error_on;
}



/**
* haeding_plot。設定調整。
*
* @return void
*/
public function kxra_outline_only(){
	//スイッチ

	unset( $_SESSION[ 'h2_check' ][ $this->kxraS1[ 'id_base' ] ] );

	foreach(	$this->kxra_arr_id[ 'sort' ][ 'id_lineup' ]	as $_k => $_v	):

		if(	preg_match( '/chara_w/'	,	$this->kxraS1[ 't' ]	)	 && !preg_match( '/0$/'	,	$_v	) )
		{
			//スルー。2023-02-27
		}
		else
		{
			//各ポストの設定。ID指定。2023-02-27
			$this->kxra_Setting_Post( $_k );

			$_arr_type =
			[
				't' 	=>	16,
				'id'	=>	$_k,
				'sys'	=>	$this->kxraS1[ 'DB_ON' ] . 'reference_off',
			];

			//echo $this->kxraS_DB['like'];

			$_title_end = end( explode( '≫' , get_the_title( $_k ) ) );

			//分類対応。
			if( !empty( $this->kxraS_DB['sort_top'] ) )
			{
				$_title_end = preg_replace( '/〈分類〉/' , '' ,$_title_end );
			}


			//幅の設定。2023-08-28
			if( !empty( $_SESSION[ 'reference_on' ] ) )
			{
				$this->kxraM[ 'add_gaiyou_class' ] = '__gaiyou_reference';
			}
			else
			{
				$this->kxraM[ 'add_gaiyou_class' ] = '__gaiyou';
			}


			if(	preg_match(	'/'.$this->kxraS1[ 'title_base' ].'≫/'	,	get_the_title( $_k ) ) )
			{
				if(	preg_match(	'/概要$/'	,	get_the_title( $_k ) ) ) //&&	!$this->kxraM[ 'add_gaiyou' ]
				{
					$this->kxraM[ 'add_gaiyou' ]	= kx_CLASS_kxx( $_arr_type );
				}
				elseif( !empty( $this->kxraS_DB[ 'sort_top' ] ) && preg_match(	'/^'. $this->kxraS_DB['sort_top'] .'$/'	,	$_title_end	)	 )
				{
					//$_arr_type['t'] = 60;
					//アウトライン消去。概要のあとに補足文字。2022-12-24
					$_SESSION[ 'raretu' ][ 'NO_outline' ] = '：DB';
					$this->kxraM[ 'add_gaiyou' ]	= kx_CLASS_kxx( $_arr_type );
					unset( $_SESSION[ 'raretu' ][ 'NO_outline' ] );
				}


				if(	preg_match(	'/0.*Idea》$/i' , get_the_title( $_k ) ) )//&&	!$this->kxraM[ 'add_idea' ]
				{
					$this->kxraM[ 'add_idea' ]	= kx_CLASS_kxx( $_arr_type );
				}


				if(	preg_match(	'/0.*研究》$/i' , get_the_title( $_k ) ) )
				{
					$this->kxraM[ 'add_study' ]	= kx_CLASS_kxx( $_arr_type );
				}


				if(	preg_match(	'/0.*(教訓|分析|感想)》$/i'	,	get_the_title( $_k ) )	)
				{
					$this->kxraM[ 'add_analyze' ]	= kx_CLASS_kxx( $_arr_type );
				}


				if(	preg_match(	'/0.*感性》$/i'	,	get_the_title( $_k ) )	)
				{
					$this->kxraM[ 'add_Sensitivity' ] = kx_CLASS_kxx( $_arr_type );
				}


				if(	preg_match(	'/0.*計画》$/i'	,	get_the_title( $_k ) )	)
				{
					$this->kxraM[ 'add_Plan' ] = kx_CLASS_kxx( $_arr_type );
				}
			}


			$_Heading	= $this->kxra_Heading(	[ 'id' 		=> $this->kxraS1[ 'id_base' ] ] );

			$_h_x = $_Heading[ 'h_x' ];

			if( $_h_x ==2 || $_h_x ==3 )
			{
				kx_session_raretu_Heading(
				[
					'id'            => $this->kxraS1[ 'id_base' ],
					'id_js'         => $_k,
					'type'          => 'outline_only'	,
					'raretu_count'  => $this->kxraS1[ 'raretu_count' ],
					'h_x'           => $_h_x,
					'daimei'        => $this->kxraS_post['daimei'],
				] );
			}
		}

	endforeach;
}


/**
* haeding_plot。設定調整。
*
* @return void
*/
public function kxra_haeding_plot(){

	if( preg_match( '/^\w\d{1,}-(\d)/' , $this->kxraS_post[ 'plot_code_base' ] , $matches ) )
	{
		$this->haeding_plot_on = $matches[1];
	}
	else
	{
		$this->haeding_plot_on = NULL;
	}
}

}	//class