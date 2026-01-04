<?php
/**
 *
 */

class kxtp{
/**
 * 初期値。
 * 2023-09-01
 *
 * @var [type]
 */
public $kxtpS_BASE =
[
	'c'               => '001', //特殊。2025-03-26
	'kx2_t_bar_block' => 24,
	'kx3_t' 					=> 30,
	'kx6_t_en' 				=> 65,
	'plot_t' 				  => 34,

	'title_base'      => NULL,
	'title_sakuhin'   => NULL,
	'title_taijin'    => NULL,

	'css_hyouji' 		  => '__kxEdit_chara __color_inversion',
	'css_hyouji15' 	  => '__kxEdit_15 __color_inversion',

	'cat_top' 				=> NULL,
	'cat_end' 				=> NULL,
	'cat_end_name' 		=> NULL,

	'sys_add' 				=> 'div_on',
	'txx_sys'         => 'works_TEMPLATE,error_Generalization,',	//リストバーの削除//sys初期値
	't2x_sys'         => 'head_no,foot_no',	//リストバーの削除//t2xのsys初期値

	'wfm_end'         => NULL,

	'ShortStory'      => NULL,
];

public $kxtpS0;

public $kxtpS1;

/**
 * 展開用設定。
 *
 * @var array
 */
public $kxtp_SAS =
[
	'list_chara'	=>
	[
		[ '2構成≫〇a502'			, '<p>＿kxtt設計＊＿</p>'			, ''							,	''		  ],
		//[ '2構成≫〇a382'			, ''													, ''							,	'/\d/'  ],
		//[ '〇a383'					 , ''													 , ''							 ,	'/(?=k3)(?!.*sh)/'			, '作品'=>1 ],

		[ '2構成≫〇f212'			, ''									  			, ''							,	'/\d/'  ],
		[ '2構成≫〇f312'			, ''									  			, ''							,	'/\d/'  ],
		[ '2構成≫〇f002'			, ''						  						, ''							,	'/\d/'  ],

		//主感情
		[ 'title' => '&nbsp;<p>＿kxtt一構成・主人公＊＿</p>' , 3 => '/001/'			         ],
		[ 'title' => '&nbsp;<p>＿kxtt主感情＊＿</p>'					 , 3 => '/^(?=.*)(?!.*001)/' ],

		//主感情
		//[ '2構成≫〇w511'	 , ''													  , ''      	    	,	'/001/'	],
		[ '2構成≫〇w501'		 , ''							        	    , ''							,	'/001|bigs/'	],
		[ '2構成≫〇w502'		 , ''					 	          		  , ''							,	'/^(?=.*)(?!.*bigs)/'			],

		//[ '〇w513'		  		, '<div style="padding:1px 0 ;border:hsla(0,100%,15%,1) solid 1px;border-radius:10px;margin:0 10px 0 25px;"></div>', '' , '/^(?=.*k3)(?!.*sh)/' , '作品'=>1 ],//(?!.*sh)background:hsla(0,100%,50%,.075);
		[ '〇w503'		  			, '<div style="height:1.9em;border-top:hsla(0,100%,15%,1) solid 1px;border-bottom:hsla(0,100%,15%,1) solid 1px;border-radius:10px;margin:-10px 0 0 0;padding:0;">', '</div>'	 					 , '/^(?=.*k3)(?!.*sh)/'			, '作品'=>1 ],//(?!.*sh)

		[ 'title' => '<p>&nbsp;</p><p>＿kxtt脚本＊＿</p>'											 , 3 => '/(?=.*(001|100|300|400|600|big2))/' ],

		[ '2構成≫〇h111'		, ''				          	     	  , ''							,	'/001|bigs/' ],
		[ '2構成≫〇w581'		, ''				          	     	  , ''							,	'/001|bigs/' ],
		[ '2構成≫〇w591'		, ''				          	     	  , '<p>&nbsp;</p>'	,	'/(?=.*(001)(?!.*bigs))/i' ],
		[ '2構成≫〇w591'		, ''				          	     	  , ''	            ,	'/bigs/' ],



		[ '2構成≫〇h112ksy' , ''				          	     	  , ''							,	'/^(?=.*(k2|chara|.*k3.*ksy|.*k3.*pnm))(?=.*(001|100|300|400|600)(?!.*bigs))/i' ],
		[ '2構成≫〇h112ygs'	, ''						          	    , ''							,	'/^(?=.*(k2|chara|.*k3.*ygs))(?=.*(001|100|300|400)(?!.*bigs))/i'	],//(?!.*sh)
		[ '2構成≫〇w582'		, ''					          		  	, ''							,	'/^(?=.*(001|100|300|400|600)(?!.*bigs))/' ],//(?!.*sh)
		[ '2構成≫〇w592'		, ''					          		  	, ''							,	'/^(?=.*(001|100|300|400|600)(?!.*bigs))/' ],//(?!.*sh)
		[ '〇h113'			  	 , '<div style="height:1.9em;padding:0; border-top:hsla(270,100%,20%,1) solid 1px;border-bottom:hsla(270,100%,20%,1) solid 1px;border-radius:10px;margin:0;">' , '</div>' ,	'/^(?=.*k3)(?!.*sh)/'			, '作品'=>1 ],//(?!.*sh)
		[ '〇w583'				   , ''					          		     , ''							 ,	'/^(?=.*k3)(?!.*sh)/'			, '作品'=>1 ],//(?!.*sh)
		[ '〇w593'				   , ''					          		     , ''							 ,	'/^(?=.*k3)(?!.*sh)/'			, '作品'=>1 ],//(?!.*sh)
		//[ 'title' => '&nbsp;<p>＿kxttその他＊＿</p>'													 , 3 => '/(?=.*(001|100|300|400|500|600))/' ],
		//[ '2構成≫〇n712ygs'		, ''												,	''							, '/^(?=.*(k2|chara))(?=.*(001|100|300)).*$/'	],
		//[ '2構成≫〇n712ygs'		, ''												, ''							, '/^(?=.*k3.*ygs)(?=.*(001|100|300)).*$/'		],
	],


	'list_shiren'	=>
	[
		//[	'h112'		,	'<p>〘緊張・掴みⅡ〙</p>'        , '<p>&nbsp;</p>' ,	'/(?=.*(^chara|^k2))(?!.*sh)/'		, 'sys'=>''],
		[	'h112ksy'	,	'<p>〘緊張・掴みⅡ〙</p>'        , '<p>&nbsp;</p>' ,	'/(?=.*k3.*ksy|k3.*Olf)(?!.*sh)/'	,	'sys'=>''],
		[	'h112ygs'	,	'<p>〘緊張・掴みⅡ〙</p>'        , '<p>&nbsp;</p>' ,	'/(?=.*k3.*ygs)(?!.*sh)/'					, 'sys'=>''],
		[	'h113'		,	'<p>〘各話ⅲ・緊張・掴み〙</p>'	, '<p>&nbsp;</p>' ,	'/100/'			                      , 'sys'=>'plus30_w,head_no,reference_off,new_off'],	//(?!.*sh)
		[	'w583'		,	'<p>〘各話ⅲ・開放・オチF〙</p>' , '<p>&nbsp;</p>'	,	'/100/'			                      , 'sys'=>'plus30_w,head_no,reference_off,new_off'],//(?!.*sh)
		[	'w593'		,	'<p>〘各話ⅲ・開放・オチA〙</p>' , '<p>&nbsp;</p>'	,	'/100/'			                      , 'sys'=>'plus30_w,head_no,reference_off,new_off'],//(?!.*sh)
		[	'w582'		,	'<p>〘開放・オチⅡ〙</p>'	      , ''            	,	'/(?=.*(001|100|300))(?!.*sh)/'		, 'sys'=>''],
		[	'w592'		,	''                               , '<p>&nbsp;</p>' , '/(?=.*(001|100|300))(?!.*sh)/'	 , 'sys'=>''],
	],
];

/**
 * エラー配列。
 * 2023-09-03
 *
 * @var [type]
 */
public $kxtpError;


/**
 * メインプログラム。
 *
 * @param [type] $arr
 * @return void
 */
public function kxtp_Main( $args ){

	//初期排除
	if(
		!empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) &&  //ショートコード下。
		$args[ 'type' ] != 'select_works' &&
		$args[ 'type' ] != 'select_DB'
	)
	{
		return kx_CLASS_kxx(
		[
			't' 		 => 60 ,
			'id' 		 => get_the_ID() ,
			'text_c' => '⇒ShortCODE_ON：'.get_the_title(),
			'sys'    => 'kxtp',
		] ) ;
	}
	elseif( $args[ 'type' ] == 'DB' )
	{
		$args[ 'db_on' ] = 1;

		$table_name = 'wp_kx_temporary';
		$where  = ['type' => 'DB_template' ];

		$results = kx_db_Read(
			$table_name, $where
		);


		$args[ 'title' ] = $results[0]->text1;
		$args[ 'type' ]  = $results[0]->text2;


		$args[ 'id' ]  = kx_CLASS_kxx(
		[
			't'       => 3,
			'search'  => $args[ 'title' ],
			'title_s' => $args[ 'title' ].'$',
		] , 'array_ids')["array_ids"][0];

		echo 'DB_Template';
		echo '：';
		echo $args[ 'type' ];
		echo '：';
		echo $results[0]->text1;
		echo '<hr>';
	}
	elseif($args[ 'type' ] =='NoMarkdown')
	{
		return;
	}

	//設定
	$this->kxtpS0 = $args;

	$this->kxtp_setting_base();
	$this->kxtp_setting_chara_type();//キャラクタータイプ
	//$this->kxtp_setting_title();// タイトル作成
	$this->kxtp_setting_SAS();//検索用アレイ。
	$this->kxtp_setting_etc_chara();
	$this->kxtp_DB_input(); // データベース書き込み

	$str = NULL;

	//分岐
	if (!empty($args['db_on']))  //データベースON。
	{
    switch ($args['type'])
		{
			case 'DB_chara_list':
				break;
			case 'list_chara_all':
				$ret = $this->kxtpDB_chara_list_all2();
				break;
			case 'list_raretu':
				$ret = $this->kxtpDB_raretu();
				break;
			case 'list_chara_maru':
				$ret = $this->kxtpDB_chara_list_maru2();
				break;
			default:
				$ret = $this->kxtpN_DB_test();
    }
    return $ret;
	}


	/*
	if(	$args[ 'type' ]	== 'top'							 ){ $ret = $this->kxtpN_top(); }
	elseif( $args[ 'type' ]	== 'plot'							 ){ $ret = $this->kxtpN_plot_list(); }
	elseif(	$args[ 'type' ]	== 'search'						 ){ $ret = $this->kxtpN_search(); }
	elseif(	$args[ 'type' ]	== 'menu'							 ){ $ret = $this->kxtpN_menu(); }
	elseif(	$args[ 'type' ]	== 'k0_top'						 ){ $ret = $this->kxtpN_k0_top(); }

	elseif(	$args[ 'type' ]	== 'start'						 ){ $ret = $this->kxtpN_k1_Start(); }
	elseif(	$args[ 'type' ]	== 'list_chara_maru'	 ){ $ret = $this->kxtpDB_chara_list_maru2(); }//DBで運用。2023-09-02
	elseif(	$args[ 'type' ]	== 'list_chara_all'		 ){ $ret = $this->kxtpDB_chara_list_all2(); } //DBで運用。2023-09-02

	elseif(	$args[ 'type' ]	== 'list_world'				 ){ $ret = $this->kxtpN_kousei_world_list(); }


	elseif(	$args[ 'type' ]	== 'list_DB'		 			 ){ $ret = $this->kxtpN_list_DB(); }
	elseif(	$args[ 'type' ]	== 'select_works'			 ){ $ret = $this->kxtpN_select_works(); }//使ってる。2023-09-02
	elseif(	$args[ 'type' ]	== 'select_DB'			 	 ){ $ret = $this->kxtpN_select_DB(); }
	*/


	// 通常の `type` に対する分岐
	$functions =
	[
		'top'         => 'kxtpN_top',
		'plot'        => 'kxtpN_plot_list',
		'search'      => 'kxtpN_search',
		'menu'        => 'kxtpN_menu',
		'k0_top'      => 'kxtpN_k0_top',
		'start'       => 'kxtpN_k1_Start',
		'list_chara_maru' => 'kxtpDB_chara_list_maru2',
		'list_chara_all'  => 'kxtpDB_chara_list_all2',
		'list_world'   => 'kxtpN_kousei_world_list',
		'list_DB'      => 'kxtpN_list_DB',
		'select_works' => 'kxtpN_select_works',
		'select_DB'    => 'kxtpN_select_DB',
		'raretu_template'       => 'kxtpN_raretu_template',
	];

	if (isset($functions[$args['type']]))
	{
		$ret = $this->{$functions[$args['type']]}();
	}


	// `filter_ON` が有効な場合の分岐
	if (!empty($this->kxtpS1['filter_ON']))
	{
		$filterFunctions =
		[
				'chara'  => 'kxtpF_chara',
				'charaW' => 'kxtpF_chara',
				'k0'     => 'kxtpF_kousei_world',
				'k1'     => 'kxtpF_kousei1',
				'k2'     => 'kxtpF_kousei2',
				'kbig2'  => 'kxtpF_kousei2big',
				'k3'     => 'kxtpF_kousei3'
		];

		if (isset($filterFunctions[$args['type']]))
		{
			$str = $this->{$filterFunctions[$args['type']]}();
			$str = kx_session_raretu_Heading_content($str);
			$ret = apply_filters('the_content', '[kx_tp type=NoMarkdown]'.$str);
		}
		else
		{
				$this->kxtp_ERROR('タイプの該当なし1', __LINE__);
		}
	} elseif (!isset($ret)) {
		$this->kxtp_ERROR('タイプの該当なし2', __LINE__);
	}

	/*
	elseif(	!empty( $this->kxtpS1[ 'filter_ON' ] ) )
	{
		//アップデート必要型。アップデート機能は作り直しが必要。2022-01-25
		if(			$args[ 'type' ]	== 'chara'  ){ $str = $this->kxtpF_chara(); }
		elseif(	$args[ 'type' ]	== 'charaW' ){ $str = $this->kxtpF_chara(); }
		elseif(	$args[ 'type' ]	== 'k0' 	  ){ $str = $this->kxtpF_kousei_world(); }
		elseif(	$args[ 'type' ]	== 'k1'		  ){ $str = $this->kxtpF_kousei1();}
		elseif(	$args[ 'type' ]	== 'k2'		  ){ $str = $this->kxtpF_kousei2(); }
		elseif(	$args[ 'type' ]	== 'kbig2'  ){ $str = $this->kxtpF_kousei2big(); }
		elseif(	$args[ 'type' ]	== 'k3'		  ){ $str = $this->kxtpF_kousei3(); }
		else
		{
			$this->kxtp_ERROR( 'タイプの該当なし1' , __LINE__ );
		}

		$str = kx_session_raretu_Heading_content( $str );

		$ret = apply_filters( 'the_content', $str );
	}
	else
	{
		$this->kxtp_ERROR( 'タイプの該当なし2', __LINE__ );
	}
	*/


	$_error = NULL;
	if( !empty( $this->kxtpError[ 'type' ] ) )
	{
		$_error = $this->kxtpError[ 'string' ];
	}
	return $_error . $ret;
}



/**
 * メイン設定。
 *
 * @return void
 */
public function kxtp_setting_base(){

	//旧設定の警告表示。削除予定箇所。2023-03-03
	if( !empty( $this->kxtpS0[ 'f' ] ) )
	{
		echo kx_CLASS_error( 'shortChord Error『f=』の問題' );
	}

	$this->kxtpS1 = $this->kxtpS0 + $this->kxtpS_BASE;
	$this->kxtpS1	= kx_shortcode_sys(	$this->kxtpS1 ); //sysの処理

	// 基本・要素
	//echo $this->kxtpS1[ 'id' ];
	//DBがidを入力する可能性あり。2023-09-02
	$this->kxtpS1['id_sc'] = !empty($this->kxtpS1['id'])
	? $this->kxtpS1['id']
	: get_the_ID();

	$this->kxtpS1[ 'title' ] = get_the_title( $this->kxtpS1[ 'id_sc' ] );

	//echo $this->kxtpS1[ 'id_sc' ];
	//echo get_the_title( $this->kxtpS1[ 'id_sc' ] );

	//タイプ分け
	if(	preg_match(	'/^chara|^k(0|1|2|big2|3)$/'	,	$this->kxtpS1[ 'type' ]	)	 )
	{
		$this->kxtpS1[ 'filter_ON' ]	= 1;
		$this->kxtpS1[	'update'	]	= 'filter';
	}

	// sysの処理
	//$this->kxtpS1	= kx_shortcode_sys_on(	$this->kxtpS1[ 'sys' ] , $this->kxtpS1	);
	// systemタイプの企画の場合
	if(
		!empty( $this->kxtpS1[ 'type' ] )
		&& $this->kxtpS1[ 'type' ] == 'k3'
		&& preg_match( '/sys/i' , $this->kxtpS1[ 'title' ] )
		&& !preg_match( '/k3normal/i' , $this->kxtpS1[ 'sys' ] )
	)
	{
		$this->kxtpS1[ 'SysType' ]	= 1;
	}


	//カテゴリー取得
	$_categorys = get_the_category( $this->kxtpS1[ 'id_sc' ] );


	if( !empty( $_categorys ) )
	{
		$this->kxtpS1[ 'category_all_arr' ]		= $_categorys;
		$this->kxtpS1[ 'cat_top' ]						= $_categorys[0]->cat_ID;
		$this->kxtpS1[ 'cat_end' ]						= end( $_categorys )->cat_ID;
		$this->kxtpS1[ 'cat_end_name' ]				= end( $_categorys )->name;
	}


	// world系取得
	$this->kxtpS1[ 'arr_id_world' ]	= kx_json_arr(	get_stylesheet_directory() . "/data/json/world.json"	);





	// キャラ・作品系
	$this->kxtpS1[ 'kxtt' ] = kx_CLASS_kxTitle(
	[
		'type'             => 'work',
		'title'            => $this->kxtpS1[ 'title' ],
		'character_number' => '',
	] );


	//'c'の変換。大型作品用。2025-03-26
	if(
		!empty( $this->kxtpS1[ 'arr_id_world' ][ $this->kxtpS1[ 'kxtt' ][ 'world'] ][ 'Counter_Character'] )
		&& empty( $this->kxtpS0[ 'c' ] )
		)
	{
		$this->kxtpS1[ 'c' ] = $this->kxtpS1[ 'arr_id_world' ][ $this->kxtpS1[ 'kxtt' ][ 'world'] ][ 'Counter_Character'] ;
	}
	elseif( empty( $this->kxtpS0[ 'c' ] ) )
	{
		$this->kxtpS1[ 'c' ] = $this->kxtpS_BASE[ 'c' ];
	}



	$this->kxtpS1[ 'title_base' ]     = $this->kxtpS1[ 'kxtt' ][ 'world'] . '≫c' . $this->kxtpS1[ 'kxtt' ][ 'character_number'];
	$this->kxtpS1[ 'title_taijin' ]	  = $this->kxtpS1[ 'kxtt' ][ 'world'] . '≫c' . $this->kxtpS1[ 'c' ] . '≫＼c' . $this->kxtpS1[ 'kxtt' ][ 'character_number'];
	$this->kxtpS1[ 'title_sakuhin' ]	= $this->kxtpS1[ 'title_base' ] . '≫' . $this->kxtpS1[ 'kxtt' ][ 'work_code' ];

	//print_r($this->kxtpS1[ 'kxtt' ]);

	$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] = $this->kxtp_set_CharaMark( $this->kxtpS1[ 'kxtt' ][ 'character_number' ] );
	$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'c' ] ] 											    = $this->kxtp_set_CharaMark( $this->kxtpS1[ 'c' ] );

	//短編作品の有無。2023-09-10
	if( !empty( $this->kxtpS1[ 'kxtt' ][ 'character_info' ] ) && preg_match( '/ShortStorySystem/' , $this->kxtpS1[ 'kxtt' ][ 'character_info' ])  )
	{
		$this->kxtpS1[ 'ShortStory' ] = 1;
	}
	elseif( !empty( $this->kxtpS1[ 'sh' ] ))
	{
		$this->kxtpS1[ 'ShortStory' ] = 1;
	}
	elseif( !empty( $this->kxtpS1[ 'kxtt' ][ 'character_info' ] ) && preg_match( '/BigStorySystem/' , $this->kxtpS1[ 'kxtt' ][ 'character_info' ])  )
	{
		$this->kxtpS1[ 'BigStory' ] = 1;
	}

	if( !empty( $this->kxtpS1[ 'kxtt' ][ 'character_info' ] ) && preg_match( '/SeriesMain/' , $this->kxtpS1[ 'kxtt' ][ 'character_info' ])  )
	{
		$this->kxtpS1[ 'SeriesMain' ] = 1;
	}
	else
	{
	$this->kxtpS1[ 'SeriesMain' ] = null;
	}


	// 保存型・未整備
	$this->kxtpS1[ 'shortcode' ] = NULL;
	if(	!empty( $this->kxtpS1[ 'filter_ON' ] ) )
	{
		//$this->kxtpS1[ 'type_update']	= 1;
		// 保存用・要素

		//残飯チェック
		//global $post;
		$post													= get_post(	$this->kxtpS1[ 'id_sc' ] );
		$this->kxtpS1[	'content'	]		= $post->post_content;
		$this->kxtpS1[	'time_sa'	] 	= kx_time_modified(	$this->kxtpS1[ 'id_sc' ] , $post	)[ 'sa'];

		if( preg_match( '/\[(.*?)\]/'	,	$post->post_content , $matches ) )
		{
			$this->kxtpS1[ 'shortcode' ] = $matches[0];
			$_leftover = preg_replace( '/\[(.*?)\]/' , ''  , $post->post_content );
		}

		//残飯チェック。
		if(	$_leftover )
		{
			$this->kxtp_ERROR( 'leftover' , __LINE__ , 'Filter ON。コンテンツあり『'.$_leftover.'』' );
		}
	}
	else
	{
		$this->kxtpS1[ 'display']	= '<div style="float: right;opacity: 0.2;">ShortCODE：'. $this->kxtpS1[ 'type' ] .'</div>';
	}
}




/**
 * キャラクターのタイプ。
 *
 * @return void
 */
public function kxtp_setting_chara_type(){
	// $tはキャラクターのタイプ
	if( !empty($this->kxtpS1[ 't' ]) )
	{
		if( !is_numeric( $this->kxtpS1[ 't' ] ) )
		{
			$_chara_type	= $this->kxtpS1[ 't' ] . '（数字外）';
		}
		else
		{
			$_chara_type	= $this->kxtpS1[ 't' ];
		}
	}
	elseif(	preg_match( '/chara|k2|k3/' , $this->kxtpS1[ 'type' ] ) && preg_match('/∬\w{1,}≫c(\d)(\w{1,})(\d)/' , $this->kxtpS1[ 'title' ] ,$matches	) )
	{
		if(	$matches[1]	== 0	&& $matches[2]	== 0	)
		{
			$_chara_type	= '001';
		}
		elseif(	$matches[1]	== 0	&& $matches[2]	)
		{
			$_chara_type	= 400;
		}
		elseif(	$matches[1]	== 2	)
		{
			$_chara_type	= 100;
			//echo'100+';
			//elseif(	$matches[1]	== 8	):
			//$_chara_type	= 800;
		}
		elseif(	$matches[1]	== 9	&&	$matches[2]	== 9	)
		{
			if(			$matches[3]	== 1	)
			{
				$_chara_type	= 100;
			}
			elseif(	$matches[3]	== 3	)
			{
				$_chara_type	= 300;
			}
			elseif(	$matches[3]	== 4	)
			{
				$_chara_type	= 400;
			}
			elseif(	$matches[3]	== 6	)
			{
				$_chara_type	= 600;
			}
		}
		elseif(	$matches[1]	== 9	&&	$matches[2]	== '8'	)
		{
			$_chara_type	= '980';
		}
		elseif(	$matches[1]	== 9	&&	$matches[2]	== 'f'	)
		{
			$_chara_type	= '001';
		}
		else
		{
			$_chara_type	= $matches[1] . '00';
		}
	}
	unset( $matches );


	// tpye
	if( empty( $_chara_type ) )
	{
		$_chara_type = NULL;
	}


	$this->kxtpS1[ 't' ]		= $_chara_type;
	//$this->kxtpS1[ 'type' ]	= $this->kxtpS1[ 'type' ];

	//select要素
	if(	!empty( $this->kxtpS1[ 'ShortStory' ] )	)
	{
		$this->kxtpS1[ 'type_select' ]	= $this->kxtpS1[ 'type' ]	.	','	.	$this->kxtpS1[ 't' ]	.	',sh';
	}
	elseif(	!empty( $this->kxtpS1[ 'BigStory' ] )	)
	{
		$this->kxtpS1[ 'type_select' ]	= $this->kxtpS1[ 'type' ]	.	','	.	$this->kxtpS1[ 't' ]	.	',bigs';
	}
	elseif( !empty($this->kxtpS1[ 'SeriesMain' ]))
	{
		$this->kxtpS1[ 'type_select' ]	= $this->kxtpS1[ 'type' ]	.	','	.	$this->kxtpS1[ 't' ]	.	',sMain';
	}
	else
	{
		$this->kxtpS1[ 'type_select' ]	= $this->kxtpS1[ 'type' ]	.	','	.	$this->kxtpS1[ 't' ];
	}
}




/**
 * その他キャラ
 *
 * @return void
 */
public function kxtp_setting_etc_chara(){

	//$this->kxtpS1[ 'kxtt' ]

	//print_r($this->kxtpS1);

	//その他キャラの配列作成。
	if( !empty( $this->kxtpS1[ 'kxtt' ][ 'work_charas' ] ))
	{

		$_arr_cs = explode( ',', preg_replace( '/('.$this->kxtpS1[ 'c' ].',|989)/' ,'' ,$this->kxtpS1[ 'kxtt' ][ 'work_charas' ] ) );

	}
	elseif(	empty( $this->kxtpS1[ 'cs' ]  ) )
	{
		$this->kxtpS1[ 'etc_chara_off' ] = 1;
		$this->kxtpS1[ 'cs' ] = NULL;
		$_arr_cs[] = NULL;
	}
	elseif( strpos( $this->kxtpS1[ 'cs' ] ,',') !== false)
	{
		$_arr_cs = explode(",", $this->kxtpS1[ 'cs' ] );
	}
	else
	{
		$_arr_cs[] = $this->kxtpS1[ 'cs' ];
	}

	//string生成開始。
	$str = '';
	$str	.= '<h2>その他キャラ</h2>';

	if(	empty( $this->kxtpS1[ 'etc_chara_off' ] ) )
	{
		foreach(	$_arr_cs	as $_cs_num):

			if( !empty( $_cs_num) )
			{
				//よくあるエラー対策。
				if( preg_match( '/^c/' , $_cs_num ) )
				{
					echo '<span style="color:red;">■ERROR■csにcの文字が余分</span>';
				}

				$_name = kx_CLASS_kxTitle(
				[
					'type'             => 'character',
					'title'            => $this->kxtpS1[ 'title' ],
					'character_number' => $_cs_num,
				] )[ 'character_name' ];

				if( empty( $_SESSION[ 'count_gnavi'] ))
				{
					$_SESSION[ 'count_gnavi']	= 0;
				}

				$_SESSION[ 'count_gnavi'] ++;

				$gnavi_count	= $_SESSION[ 'count_gnavi']	;

				include  __DIR__ .'/jq/jq_gnavi_count.php';

				$url	 =  '';
				$url	.= 'wp-content/themes/kasax_child/lib/php/p_chara_etc.php';
				$url	.= '?id=' . $this->kxtpS1[ 'id_sc' ] . '&num='.$this->kxtpS1[ 'kxtt' ][ 'character_number' ] . '&numcs=' . $_cs_num . '&cat=' . $this->kxtpS1[ 'cat_end'];
				$url	.= '&newtitle=' . $this->kxtpS1[ 'kxtt' ][ 'world'] . '≫c' . $_cs_num . '≫＼c' . $this->kxtpS1[ 'kxtt' ][ 'character_number' ] . '≫B3';

				$str	.= '<h3>';
				$str	.= 'C'	.	$_cs_num;
				$str	.= '：'. $_name;
				$str	.= '</h3>';

				$str	.= '<div class="gnavi_number'	.	$gnavi_count	.	' _op_a_block" style="margin-left:20px;">';
				$str	.= '<a href="'	.	$url	.	'">';
				$str	.= '▼';
				$str	.= $_cs_num.'：OPEN';
				$str	.= '</a>';
				$str	.= '</div>';

				$str	.= '<div class="_op_z_block displayArea_gnavi_number' . $gnavi_count . ' _gnavi_number_displayArea_gnavi">';
				$str	.= '</div>';

				unset( $_name );
			}
		endforeach;
	}
	else
	{
		$str .= 'cs登録なし';
	}
	$this->kxtpS1[ 'etc_chara' ]	= $str;
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtp_setting_SAS(){
	/*
	if( empty( $this->kxtpS1[ 'title_base' ] ) )
	{
		$this->kxtpS1[ 'title_base' ] = NULL;
	}
	*/

	$this->kxtp_SAS[ 'mainKX3' ] =
	[
		'name'	=>	'kx',
		'top'		=>	'<p>',
		'end'		=>	'</p>',

		'arr'		=>
		[
			't'					=> $this->kxtpS1[ 'kx3_t' ],
			'cat'				=> $this->kxtpS1[ 'cat_end' ],
			'tag'				=> 'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
			'tag_not'		=> '≫来歴≫',
			'search'		=> '≫',
			'sys'				=> $this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 'sys_add' ],
			'new_title'	=> $this->kxtpS1[ 'title_base' ],
		],
	];

	$this->kxtp_SAS[ 'main〇DB' ] =
	[
		'name'	=>	'kx',
		'top'		=>	'<p>',
		'end'		=>	'</p>',

		'arr'		=>
		[
			't'						=>	$this->kxtpS1[ 'kx3_t' ],
			'search'			=>	$this->kxtpS1[ 'title_base' ].'≫',
			//'new_title'		=>	$this->kxtpS1[ 'title_base' ].'≫',
			'sys'					=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 'sys_add'].',db_on',
		],
	];

	$this->kxtp_SAS[ 'SubKX3' ] =
	[
		'name' =>	'kx',
		'top'	 =>	'<p style="margin:0 0 0 0;">',
		'end'	 =>	'</p>',
		'arr'	 =>
		[
			't'					=>	$this->kxtpS1[ 'kx3_t'],
			'cat'				=>	$this->kxtpS1[ 'cat_end'],
			'tag'				=>	'c' . $this->kxtpS1[ 'c' ] ,
			'tag_not'		=>	'≫来歴≫',
			'search'		=>	'＼c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫〇',
			'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 'sys_add' ],

			//'search'		=>	$this->kxtpS1[ 'title_taijin' ].'≫〇',
			//'sys'						=>	$this->kxtpS1[ 'txx_sys' ] . ',db_on',
		],
	];

	$this->kxtp_SAS[ 'worksKX3' ] =
	[
		'name'	=>	'kx',
		'top'		=>	'<p>',
		'end'		=>	'</p>',
		'arr'		=>
		[
			't'				=>	$this->kxtpS1[ 'kx3_t'],
			'cat'			=>	$this->kxtpS1[ 'cat_end'],
			'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
			'tag_not'	=>	'≫来歴≫',
			'search'	=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ]	.'≫〇',
			'sys'			=>	$this->kxtpS1[ 'txx_sys' ],
		],
	];

	$this->kxtp_SAS[ 'worksKX19' ] =
	[
		'name'	=>	'kx',
		'top'		=>	'<p>',
		'end'		=>	'</p>',
		'arr'		=>
		[
			't'					=>	19,
			'cat'				=>	$this->kxtpS1[ 'cat_end'],
			'tag'				=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
			'tag_not'		=>	'≫来歴≫',
			'search'		=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ]	.'≫',
			'sys'				=>	$this->kxtpS1[ 'txx_sys' ],
		],
	];

	$this->kxtp_SAS[ 'zero構成・○' ] =
	[
		'name'	=>	'kx',
		//'top'		=>	'<p style="margin:0 0 0 0;">',
		//'end'		=>	'</p>',
		'arr' =>
		[
			't'			 =>	$this->kxtpS1[ 'kx3_t'],
			'cat'		 =>	$this->kxtpS1[ 'cat_top' ],
			'tag'		 =>	'"〇 0構成"'	,
			'search' =>	'≫0構成≫〇',
			'sys'		 =>	$this->kxtpS1[ 'txx_sys' ] . $this->kxtpS1[ 'sys_add' ],
		],
	];

	$this->kxtp_SAS[ '試練○' ] =
	[
		'name'	=>	'kx',
		'arr'		=>
		[
			't'					=>	$this->kxtpS1[ 'kx3_t'],

			'cat'				=>	$this->kxtpS1[ 'cat_end'],
			'tag'				=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
			'tag_not'		=>	'≫来歴≫',
			'search'		=>	'≫〇',
			'ppp'				=>	99,
			'sys'				=>	$this->kxtpS1[ 'txx_sys' ],
		],
	];
}



/**
 * データベース書き込み
 *
 * @return void
 */
public function kxtp_DB_input(){

	//データベース書き込み
	if(	preg_match(	'/^(^k2|^k3|^chara)/i'	,	$this->kxtpS1[ 'type' ]	)	)
	{

		kx_CLASS_kxx(
		[
			't' 				=>	9,
			'cat'				=>	$this->kxtpS1[ 'cat_end'],
			'tag'				=>	'c' . $this->kxtpS1[ 'kxtt' ][ 'character_number' ],
			'tag_not'		=>	'≫来歴≫',
			'db_input'	=>	1,
		] );
	}
}


/**
 * Undocumented function
 *
 * @param [type] $num
 * @return void
 */
public function kxtp_set_CharaMark( $num ){

	preg_match( '/^(\d)(.*)/' , $num  , $matches );

	if(	!empty( $matches ) &&	$matches[1] == 0 )	//🟥🟧🟨🟩🟦🟪🟫⬛⬜🔴🟠🟡🟢🔵🟣🟤⚫
	{
		if(  $matches[2] == 01)
		{
			$str = '🟦';
		}
		else
		{
			$str = '🟩';
		}
	}
	elseif( !empty($matches[1] ) && ( $matches[1] == 1 || $matches[1] == 2 || $matches[1] == 3 || ( $matches[1] == 9 && $matches[2] == 91 || $matches[2] == 93 )  ) )
	{
		$str = '🟥';
	}
	else
	{
		$str = '🟨';//NULL
	}

	return $str;
}



/**
 * トップページ用
 *
 * @return void
 */
public function kxtpN_top(){

	$ret = '<hr>';
	foreach( get_categories(array('taxonomy' => 'category')) as $_value ):

		if( !preg_match( '/^∬\d{1,}≫c|^xxx/', $_value->name ) )
		{
			$ret .= kx_CLASS_kxx(
			[
				't'				=> 65,
				'cat'			=> $_value->ID,
				'search'	=> $_value->name,
				'title_s'	=> $_value->name .'$',
				'sys'     => 'error_navi_off',
			] );
		}

	endforeach;





	$ret .= kxEdit([
		'new'					=> 1,
		'hyouji'			=> '＋NEW',
		'new_content'	=> '＿raretu＿',
		'new_title'		=> '∬XX',
		//'css_hyouji'	=> $this->kxtpS1[ 'css_hyouji15' ],
	]);

	return $ret;
}



/**
 * メニューページ用
 *
 * @return void
 */
public function kxtpN_menu(){

	if(	empty( $this->kxtpS1[ 'check_search' ] ) )
	{
		$this->kxtpS1[ 'check_search' ]	= get_the_title();
	}
	elseif(	$this->kxtpS1[ 'check_search' ]	== 'non'	)
	{
		$this->kxtpS1[ 'check_search' ]	= '';

		//$category = get_the_category();
		//$cat = $category[0]->cat_ID;
	}


	if( $this->kxtpS1[ 'check_search' ]	== '∬' )
	{
		$_title_s	= '∬\d{1,}$';
		$this->kxtpS1[ 'cat_end' ]	= '';
	}
	elseif( preg_match(	'/^∬\d{1,}≫c/', $this->kxtpS1[ 'check_search' ] 	))
	{
		$_check_ONLY = 1;
		$_title_s = NULL;
	}
	else
	{
		$_title_s = NULL;
	}



	$_arr	=
	[
		'アップデートチェック'	=>[	'update'							=>	1,	'h2_off'	=>1,],
		'Search'								=>[	'kx_category_search'	=>	1,	],
		'TOP-POST'							=>[	't'										=>	96,	],
		'更新10件'							=>[	't'										=>	91,	],
		'PAGE'									=>[	't'										=>	96,	],
	];

	$ret = '';
	$_s = 0;
	foreach( $_arr as $_k => $_v	):

		$_s++;

		if(	empty( $_v[ 'h2_off'] )	&&  empty( $this->kxtpS1[ 'check_update' ] ) )
		{
			$_SESSION[ 'Heading' ][ 'n' ][ $_s ]	=
			[
				'h_x'			=>	2,
				'daimei'	=>	$_k,
			];

			//アンカー
			$ret .= '<h2 id=kxanchor'. $_s .'>'.$_k.'</h2>';

		}

		if(
			!empty( $_v[ 't' ] )
			&& $_v[ 't' ] == 91
			&& empty( $this->kxtpS1[ 'check_update' ] )
			&& empty( $_check_ONLY )
		)
		{
			//更新10件。2023-08-02。
			$ret .= '
			<div class="__hidden_box">
			<input type="checkbox" class="option-input01">
			<div><p>';

			$ret .= kx_CLASS_kxx(
			[
				't'				=> $_v[	't'	],
				'cat'			=> $this->kxtpS1[ 'cat_end' ],
				'search'	=> $this->kxtpS1[ 'check_search' ],
				'title_s'	=> $_title_s,
			] );

			$ret .= '</p><hr class="__hidden_box"></div>
			</div>
			<p>';
		}
		elseif(
			!empty( $_v[ 't' ] )
			&& $_v[	't'	] == 90
			&& empty( $this->kxtpS1[ 'check_update' ] )
			&& empty( $_check_ONLY )
		)
		{
			//未使用？2023-08-02。
			$ret .= kx_CLASS_kxx(
			[
				't'				=>	$_v[	't'	],
				'cat'			=>	$this->kxtpS1[ 'cat_end' ],
				'search'	=>	$this->kxtpS1[ 'check_search' ],
				'title_s'	=>	$_title_s,
			] );
		}
		elseif(
			!empty( $_v[ 't' ] )
			&&	$_v[	't'	]		== 19
			&& empty( $this->kxtpS1[ 'check_update' ] )
			&& empty( $_check_ONLY )
		)
		{
			//未使用？2023-08-02。
			$ret .= kx_CLASS_kxx(
			[
				't'				=>	$_v[	't'	],
				'cat'			=>	$this->kxtpS1[ 'cat_end' ],
				'search'	=>	$this->kxtpS1[ 'check_search' ] . '$',
				'title_s'	=>	$_title_s,
			] );
		}
		elseif(
			!empty( $_v[ 't' ] )
			&& $_k  == 'TOP-POST'
			&& empty( $this->kxtpS1[ 'check_update' ] )
			&& empty( $_check_ONLY )
		)
		{
			$ret .= kx_CLASS_kxx(
			[
				't'					=>	$_v[	't'	],
				'cat'				=>	$this->kxtpS1[ 'cat_end' ],
				'search'		=>	$this->kxtpS1[ 'check_search' ] ,
				'title_s'		=>	'-' . $this->kxtpS1[ 'check_search' ] . '≫.*≫',
				//'post_type'	=>	'page',
			] );
		}
		elseif(
			$_k  == 'PAGE'
			&& empty( $this->kxtpS1[ 'check_update' ] )
			&& empty( $_check_ONLY )
		)
		{
			$ret .= kx_CLASS_kxx(
			[
				't'					=>	$_v[	't'	],
				'cat'				=>	$this->kxtpS1[ 'cat_end' ],
				'search'		=>	$this->kxtpS1[ 'check_search' ] ,
				'post_type'	=>	'page',
			] );
		}
		elseif( !empty( $_v[ 'update' ] )	)
		{
			if( empty( $this->kxtpS1[ 'check_update' ] ) )
			{
				$this->kxtpS1[ 'check_update' ] = NULL;
			}

			//echo $this->kxtpS1[ 'check_update' ];

			$ret .= kx_update_cat_check( [
				'type'       => NULL,
				'update'     => $this->kxtpS1[ 'check_update' ],	//ショートコード
			]	);

		}
		elseif(
			!empty( $_v[	'kx_category_search'	] )
			&& empty( $this->kxtpS1[ 'check_update' ] )
			&& empty( $_check_ONLY )
		)
		{
			$ret .= kx_category_search( [ 't'=>50] );
		}

		$ret .= '&nbsp';

	endforeach;

	return $this->kxtpS1[ 'display' ] . $ret;
}



/**
 * トップ検索用
 *
 * @return void
 */
public function kxtpN_search(){

// ファイルパスを指定
    $file_path = get_stylesheet_directory() . '/lib/html/Laravel_search_page.php';

    if (file_exists($file_path)) {
        // バッファリングを開始して出力をキャプチャする
        ob_start();
        include $file_path;
        return ob_get_clean();
    }

    //return '検索ファイルが見つかりません。';





	$width_max	= 800;

	$ret	= NULL;
	$ret .='<div id="search">';
	$ret .='<form method="get" action="';
	$ret .='">';
	$ret .='<input name="s" id="s" type="text" style="width:600px">';
	$ret .='    <input id="submit" type="submit" value="search">';


	//カテゴリー指定。2023-03-05
	$_categories = get_categories( array( 'taxonomy' => 'category' ) );
	$ret .='<div>';

	/*
	if ( $_categories )
	{
		$ret .='<div>';
		$ret .= '<select name="cat-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;" class="post-catselect">';
		$ret .= '<option value="" selected="selected">カテゴリーから探す</option>';
		//$ret .= '<option value="'.home_url().'/blog">すべてのカテゴリー</option>';

		foreach ( $_categories as $category ) :

			$ret .= '<option value="'.esc_html( get_category_link( $category->term_id ) ).'">'.esc_html( $category->name ).'</option>';

		endforeach;

		$ret .= '</select>';
		$ret .='</div>';
	}
	*/


	if ( $_categories )
	{
		//カテゴリー名を設定した配列を呼び出し、foreach。2023-03-05
		$_cat_num = 0;
		foreach(KxSu::get('titile_name') as $key =>  $value ):

			$_cat_name_arr[] = [ 'cat_num' => $_cat_num , 'preg' => $key , 'name' => $value[ 'name' ] ];
			$_cat_num ++;

		endforeach;
		unset( $key , $value );


		//ストライプ用。2023-03-05
		$_num = 0;

		foreach( $_categories as $category ):

			if( $_num == 0)
			{
				$_background_color = 'background-color: HSLA(0, 0%, 50%, .075);';
				$_num++;
			}
			else
			{
				$_background_color = 'background-color: hlsa(0, 0, 0, 0);';
				$_num = 0 ;
			}

			$cat_id = $category->cat_ID;

			$str = '';
			$str .='<table style="font-size:16px;line-height: 1.2;max-width:500px;'.$_background_color.'"><tbody>';
			$str .='<tr>';

			$str .='<td  width="15">';
			//$ret .='<div>';
			$str .='<input type="checkbox" name="cat" value="'.$category->term_id.'"></label>';
			$str .='</td><td width="120">';
			$str .= $category->name;
			$str .='</td>';

			$str .='<td width="200">';


			foreach( $_cat_name_arr as $_arr ):

				//$_cat_name_arr[] = $_key;
				if( preg_match( '/^'.$_arr[ 'preg' ].'/' , $category->name ) )
				{
					$_cat_name = $_arr[ 'name'];
					$_cat_num = $_arr[ 'cat_num'];
					break;
				}
			endforeach;

			if( !empty( $_cat_name ))
			{
				$str .= $_cat_name;
			}
			else
			{
				$str .= '<spna style="opacity: 0.2;">N/A</spna>';
			}



			$str .='<td>';
			$str .='no:'. $_cat_num .'';
			$str .='</td>';
			$str .='</td>';

			$str .='<td width="60">';
			$str .='id:'.$cat_id.'';
			$str .='</td><td width="50">';
			$str .= $category->category_count;
			$str .= 'p';
			$str .='</td></tr>';
			//		$ret .='</div>';

			$str .='</tbody></table>';

			if( !empty( $_cat_name ) )
			{
				$_cat_arr[ (int)$_cat_num ]  = $str;
			}
			unset( $_cat_name );

		endforeach;

		ksort( $_cat_arr );


		//非表示型。2023-03-05
		$ret .='<div class="_op_a" style="margin-top: 5px;">──&nbsp;CAT-Click!!&nbsp;──';
		$ret .='</div>';
		$ret .='<div class="_op_z __background_normal"  style="z-index:2;">';
  	foreach( $_cat_arr as $_value ):
			$ret .= $_value;
		endforeach;
		$ret .= '</div>';
	}



	//$tags = get_tags();旧形式。自動削除なし。2023-02-22

	//タグ配列の取得。2023-02-22
	$tags = get_terms( 'post_tag' , 'hide_empty=0' );
	if( $tags )
	{
		$tr = 0;

		if( !empty( $this->kxtpS1[ 't' ] ) && $this->kxtpS1[ 't' ] == 1 )
		{
			$ret .='<div class="_op_a" style="margin-top: 5px;">──&nbsp;TAG-Click!!&nbsp;──';
			$ret .='</div>';
			$ret .='<div class="_op_z __background_normal"  style="z-index:2;">';
		}

		$ret .='<table style="max-width:'.$width_max.'px;"><tbody>';

		foreach ( $tags as $tag ):

			if( empty( $tag->count ) )
			{
				//空タグ自動削除。2023-02-22

				echo '空タグ削除';
				echo '（ID_';
				echo $tag->term_id;
				echo '）:';
				echo $tag->name;
				echo '<br>';

				wp_delete_term( $tag->term_id , 'post_tag' );
			}
			else
			{
				if( $tr == 0 ) //戦闘
				{
					$ret .='<tr><td width="20%" height="20">';
				}
				else
				{
					$ret .='<td width="20%">';
				}

				$ret .= '<table>';
				$ret .= '<tr><td width="15">';
				$ret .= '<input type="checkbox"  name="tag" value="'.$tag->name.'">';
				$ret .= '</td><td>';
				$ret .= $tag->name.'（'.$tag->count.'）';
				$ret .= '</td></tr>';
				$ret .= '</table>';

				if( $tr!=3 )
				{
					$ret .='</td>';
					$tr++;
				}
				else
				{
					$ret .='</td></tr>';

					if($tr==3)
					{
						$tr=0;
					}
				}
			}

		endforeach;

		$ret .= '</tbody></table>';
		$ret .= '</select>';

		if( !empty( $this->kxtpS1[ 't' ] ) && $this->kxtpS1[ 't' ] == 1 )
		{
			$ret .='</div>';
		}
	}

	$ret .= '</form>';
	$ret .= '</div>';
	$ret .= '</div>';

	return $ret;
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpN_k0_top(){

	$ret = NULL;

	$ret .= kxEdit( [
		'new' 		=> 1 ,
		'hyouji'	=> '&nbsp;╋'.$this->kxtpS1[ 'cat_end_name' ] .'&nbsp;ADD&nbsp;',
	] );

	$ret .= kx_CLASS_kxx( [
		't'				=> 96,
		'cat'			=> $this->kxtpS1[ 'cat_end' ],
		'search'	=> $this->kxtpS1[ 'cat_end_name' ] . '≫',
		'title_s'	=> '-'.$this->kxtpS1[ 'cat_end_name' ] . '≫.*≫',
	] );




	return $ret;


}

/**
 * スタート用INDEX
 * type=k1
 *
 * @return void
 */
public function kxtpN_k1_Start(){

	//下位ポストの場合はスルー。2023-08-01。
	/*
	if( !empty( $this->sc_count_on ) )
	{
		$_url	= get_permalink();
		return '<a href="'	.	$_url	.	'">Index</a>';
	}
	*/

	$_category = get_category( $this->kxtpS1[ 'cat_top' ] );


	if( !empty( $_category->cat_name ))
	{
		$_cat_name	= $_category->cat_name;
	}
	else
	{
		$_cat_name	= NULL;
	}


	//■■■最上位
	$arr[ '最上位' ]	=
	[
		'h_x'				=>	2,
		'daimei'		=>	$_cat_name.'：最上位',

		'in_kxx'		=>
		[
			't'					=>	60,
			'cat'				=>	$this->kxtpS1[ 'cat_top' ] ,
			'search'		=>	'∫≫S.*' . $this->kxtpS1[ 'kxtt' ][ 'world' ] ,
			//'title_s'		=>	'∫≫s\d{1,}',
		],
	];


	//■■■一構成
	$arr[ '一構成' ] =
	[
		'h_x'				=>	2,
		'daimei'		=>	'上位構成',

		'in_kxx'		=>
		[
			't'					=>	96,
			'cat'				=>	$this->kxtpS1[ 'cat_top' ] ,
			'search'		=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫',
			'title_s'		=>	'(0|1)構成$',
		],
	];


	//二構成
	$arr[ '二構成' ]	=
	[
		'h_x'				=>	2,
		'daimei'		=>	'二構成',

		'in_kxx'		=>
		[
			't'					=>	96,
			'cat'				=>	$this->kxtpS1[ 'cat_top' ] ,
			'search'		=>	$this->kxtpS1[ 'kxtt' ][ 'world' ] .'≫',
			'title_s'		=>	'2構成$',
		],
	];

	//三構成
	$arr[ '三構成' ]	=
	[
		'h_x' => 2 ,
		'daimei' => '3構成'
	];

	foreach(	[ 'Ksy','Ygs','Olf','Pnm','Sys']	as $value ):

		if(	$value	== 'Sys')
		{
			$_new_content	= "＿raretu＿";//"＿kx_tp type＝k3＿"
			$_new_title		= $this->kxtpS1[ 'kxtt' ][ 'world' ] . '≫c000≫'. $value .'000111000';
			$_orderby = 'title';
		}
		else
		{
			$_orderby = 'ID';

			//$_new_content_add	= ' sys=sh';

			if(	$value	== 'Olf')
			{
				$_c_num						= 'c1n00';
			}
			elseif(	$value	== 'Ygs')
			{
				$_c_num						= 'c200';
			}
			else
			{
				$_c_num	= 'c100';
				$_new_content_add = NULL;
			}

			$_new_content	= "＿raretu＿";//'＿kx_tp type＝k3 cs＝300,600'	.	$_new_content_add	.	'＿';
			$_new_title		= $this->kxtpS1[ 'kxtt' ][ 'world' ] . '≫'	.	$_c_num	.	'≫'	.	$value	.	'000';
		}


		$arr[ '三構成'. $value ]	=
		[
			'h_x'				=> 3,
			'daimei'		=> $value,

			'in_kxx'		=>
			[
				't'					=> 96,
				'cat'				=> $this->kxtpS1[ 'cat_top' ] ,
				'search'		=> $this->kxtpS1[ 'kxtt' ][ 'world' ] . '≫c\d\w{1,}\d≫'. $value .'\d{1,}$',
				'orderby'		=> $_orderby ,
			],

			'in_edit'		=>
			[
				'new'					=> 1,
				'hyouji'			=> '＋'. $value ,
				'new_content'	=> $_new_content,
				'new_title'		=> $_new_title,
				'css_hyouji'	=> $this->kxtpS1[ 'css_hyouji15' ],
			],
		];

	endforeach;
	unset( $value );

	//設定
	$arr[ '設定']	=
	[
		'h_x'				=>	2,
		'daimei'		=>	'設定',

		'in_kxx'		=>
		[
			't'					=>	60,
			'cat'				=>	$this->kxtpS1[ 'cat_top' ] ,
			'search'		=>	$this->kxtpS1[ 'kxtt' ][ 'world' ]  . '≫1構成',
			'post_type' =>	'post' ,
			'title_s'		=>	'1構成≫設定$',
		],
	];

	//■設定
	$arr[ '共通設定']	=
	[
		'h_x'				=>	3,
		'daimei'		=>	'共通設定',

		'in_kxx'		=>
		[
			't'					=>	96,
			'cat'				=>	59 ,
			'search'		=>	$this->kxtpS1[ 'kxtt' ][ 'world' ] ,
			'title_s'		=>	'∫≫設定',
		],

	];

	//キャラトップ
	$arr[]	=
	[
		'h_x'				=>	2,
		'daimei'		=>	'キャラクター',
	];

	//character
	foreach(	range(0, 9)	as $value	):

		$arr[]	= [

			'h_x'				=>	3,
			'daimei'		=>	'一覧C'.$value.'XX',

			'in_kxx'		=>	[

				't'			=>	96,
				'cat'				=>	$this->kxtpS1[ 'cat_top' ] ,
				'search'		=>	$this->kxtpS1[ 'kxtt' ][ 'world' ] . '≫c'. $value ,
				'title_s'		=>	'≫c\d\w{1,}\d$',

			],

			'in_edit'		=>
			[
				'new'					=> 1,
				'hyouji'			=> '＋C'. $value,
				'new_content'	=> "＿raretu＿",//'＿kx_tp type＝chara＿',
				'new_title'		=> $this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'. $value .'99',
				'css_hyouji'	=> $this->kxtpS1[ 'css_hyouji15' ],
			],
		];

	endforeach;
	unset( $value );

	$s	 = 0;
	$ret = NULL;
	foreach(	$arr	as $_k => $value	):

		$s++;

		$_SESSION[ 'Heading' ][ 'n' ][$s]	= [
			'h_x'			=>	$value[ 'h_x' ],
			'daimei'	=>	$value[ 'daimei'],
		];

		$ret .= '<h3 id=kxanchor'.$s.'>'.	$value[ 'daimei']	.'</h3>';


		if( !empty( $value[ 'in_kxx'] )	)
		{
			$ret .= kx_CLASS_kxx( $value[ 'in_kxx'] );
		}


		if( !empty( $value[ 'in_edit'] ) )
		{
			$ret .= kxEdit( $value[ 'in_edit'] );
		}
		else
		{
			$ret .= '&nbsp';
		}
	endforeach;
	unset( $value );

	return $ret;
}



/**
 * Undocumented function
 * 運用終了
 *
 * @return void
 */
/*
public function kxtpN_list_sekibun2(){

	foreach(range(1,12)	as $v):

		$ret .= '<h2>'.$v.'</h2>';
		$ret .= kx_CLASS_kxx( [
			't'				=>	96,
			'search'	=>	'∬',
			'title_s'	=>	'^∬'. sprintf('%02d', $v),
			'ppp'			=>	'3',
		] );

		$ret .= '<hr>';

	endforeach;

	$ret .= '<h2>モデル</h2>';
	$ret .= kx_CLASS_kxx( [
		't'				=>	96,
		'search'	=>	'∬m',
		'title_s'	=>	'^∬m\d{3}$',
		//'ppp'			=>	'3',
	] );

	$ret .= '<hr>';

	return $ret;
}
*/


/**
 * template plot
 *
 * @param [type] $atts
 * @return void
 */
public function kxtpN_plot_list(){

	//preg_match(	'/∬\w{1,}≫(c\d{1,})/'	, $this->kxtpS1[ 'title' ]	,$matches);
	//$_tag_c  = $matches[1];
	//unset($matches);
	$_tag_c  = 'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ];

	$_array	=
	[
		1001  =>[$this->kxtpS1[ 'cat_end' ]	,$_tag_c ,'≫〇a502'		,10	,''	],
		1002  =>[$this->kxtpS1[ 'cat_end' ]	,$_tag_c ,'≫〇f002'		,10	,''	],
		1003  =>[$this->kxtpS1[ 'cat_end' ]	,$_tag_c ,'≫〇w502'		,10	,''	],
		1004  =>[$this->kxtpS1[ 'cat_end' ]	,$_tag_c ,'≫〇f212'		,10	,''	],
		1005  =>[$this->kxtpS1[ 'cat_end' ]	,$_tag_c ,'≫〇f312'		,10	,1	],
		//1003  =>[$this->kxtpS1[ 'cat_end' ]	,$_tag_c ,'≫〇a382'		,10	,''	],
	];

	if( $_tag_c == "c001")
	{
		//主人公項目はフォーマットのため非表示。2023-10-06
		unset( $_array[ 1001 ] , $_array[ 1002 ] , $_array[ 1003 ]);
	}
	elseif( preg_match( '/^c(1|2|3)/', $_tag_c ) )
	{
		unset( $_array[ 1001 ], $_array[ 1002 ] );
	}



	if( $this->kxtpS1[ 't' ] )
	{
		preg_match(	'/_(k|o|y|p)(\d{1,})(＠)/'	, $this->kxtpS1[ 'title' ] ,$matches);

		$sakuhin_num	= str_pad($matches[2]	,3,0,STR_PAD_LEFT); //

		if($matches[1]	== 'k'	)
		{
			$search= 'ksy';
		}
		elseif($matches[1]	== 'o'	)
		{
			$search= 'olf';
		}
		elseif($matches[1]	== 'y'	)
		{
			$search= 'ygs';
		}
		elseif($matches[1]	== 'p'	)
		{
			$search= 'Pnm';
		}


		$search  = $search.$sakuhin_num;


		if( $t ==  'main')
		{
			$_array[2003]	=  	[$this->kxtpS1[ 'cat_end' ]	,$_tag_c	,$search.'≫〇j173'			,10	,1	];
			$_array[2005]	=  	[$cat_top	,'0構成' ,'≫〇a911'		,10	,1	];
		}
		elseif($t ==  '2nd')
		{
		}
	}


	//配列ソート
	ksort( $_array );

	$ret = NULL;
	foreach( $_array	as	$v_in ):

		if( !empty( $_color ) )
		{
			$_color	= '__back_gray_op01';
		}
		else
		{
			$_color	= NULL;
		}


		$ret .= '<div class="'.$_color.'" style="padding-bottom:'.$v_in[3].'px;">';

		$ret .= kx_CLASS_kxx(
		[
			't'				=>	$this->kxtpS1[ 'plot_t' ],
			'cat'			=>	$v_in[0],
			'tag'			=>	'〇 '.$v_in[1],
			'search'	=>	$v_in[2],
			'sys'			=>	'plus1_f11,reference_off',
		] );

		$ret .= '</div>';

		if($v_in[4] )
		{
			$ret .= '<div style="padding-bottom:10px;"><p>&nbsp;</p></div>';
		}

	endforeach;

	//$ret .= '</table>';

	return	$this->kxtpS1[ 'display' ] . $ret;

}


/**
 * list_world
 *
 * @return void
 */
public function kxtpN_kousei_world_list(){

	$ret  = '<h2>キャラ以外</h2>';

	$ret .= kx_CLASS_kxx( [
		't'				=>	96,
		'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
		'search'	=>	'∬',
		'title_s'	=>	'∬\w{1,}≫ -(≫.*≫)  -∬\w{1,}≫c',
		//'sys'			=>	'floor_on'

	] );

	$ret  .= '<h2>0構成</h2>';

	$ret .= kx_CLASS_kxx( [
		't'				=>	96,
		'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
		'search'	=>	'∬',
		'title_s'	=>	'∬\w{1,}≫0構成 -(0構成≫.*≫)',
		//'sys'			=>	'floor_on'

	] );

	$ret  .= '<h2>共通</h2>';

	$ret .= kx_CLASS_kxx( [
		't'				=>	96,
		'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
		'cat_not'	=>	510 ,
		'tag_not' =>	"0構成,1構成,Idea",
		'search'	=>	'∬',
		//'title_s'	=>	'∬\w{1,}≫0構成 -(0構成≫.*≫)',
		//'sys'			=>	'floor_on'

	] );

	return $ret;
}



/**
 * 作品リスト用。データベース系。
 * listや◆のポスト下に登録されているポストにまつわる表示。
 * 2023-03-03
 *
 * @return string
 */
public function kxtpN_list_DB(){


	//ポストのカテゴリー確認と、設定。db呼び出し。2023-03-03
	if( preg_match( '/芸術・作品≫(list)/' , $this->kxtpS1[ 'title' ] , $matches )  )
	{

		//作品用。2023-03-22
		$_type = 'works';
		$tag 	 = '芸術・作品≫list≫';

		$kxdbW = new kxdbW;
		$kxdbW->kxdbW_Main(
		[
			'title' 	=> $this->kxtpS1[ 'title' ],
			'order' 	=> 'select_all',
		] ,'select_all' );

		$result = $kxdbW->result;
	}
	elseif( preg_match( '/人物≫(List)/' , $this->kxtpS1[ 'title' ] , $matches )  )
	{
		//作品用。2023-03-22
		//$_type = 'works';
		$_type = '';
		$tag 	 = '人物≫List≫';

		$kxdbW = new kxdbW;
		$kxdbW->kxdbW_Main(
		[
			'title' 	=> $this->kxtpS1[ 'title' ],
			'order' 	=> 'select_all',
		] ,'select_all');

		$result = $kxdbW->result;
	}
	elseif( preg_match( '/≫(◆)/' , $this->kxtpS1[ 'title' ] , $matches )  )
	{
		$_type = 'data';
		$tag   = '≫◆';

		$kxdbST = new kxdbST;

		$kxdbST->kxdbST_Main(
		[
			'title_base' 	=> $this->kxtpS1[ 'title' ],
			'title_top' 	=> preg_replace( '/^(.*?)≫.*/' , '$1' , $this->kxtpS1[ 'title' ]),
			'title_share'	=> preg_replace( '/^.*?≫(.*)/' , '$1' , $this->kxtpS1[ 'title' ]),
			'id' 	=> $this->kxtpS1[ 'id_sc' ],
		] , 'select_all' );

		$result = $kxdbST->result;
	}
	else
	{
		return 'ERROR_line'. __LINE__;
	}





	//id取得用配列。2023-03-22
	$_array_search = [
		'作品名' 	   => ' -' . $matches[1] . '≫.*≫',
		'作品概要'   => '≫.*≫00.*＠概要$',
		'キャラ'     => '≫.*≫登場人物≫ -登場人物≫.*≫',
		'キャラ概要' => '≫.*≫登場人物≫.*≫00.*＠概要$',
		'芸能人'     => '≫芸能人≫',
	];

	$_kxx_array_ids0 = [];

	foreach( $_array_search as $key => $value ):

		//id配列取得。2023-03-22
		$_kxx_array_ids = kx_CLASS_kxx(
		[
			'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
			'tag'			=>	$tag ,
			'search'  =>	$value,
		] , 'array_ids' );

		if( is_array( $_kxx_array_ids[ 'array_ids'] )  )
		{
			echo 'count（'. $key .'）:' . count( $_kxx_array_ids[ 'array_ids'] ).'<br>';

			//配列合体。2023-03-22
			$_kxx_array_ids0 = $_kxx_array_ids0 + $_kxx_array_ids[ 'array_ids' ];
		}
		else
		{
			echo 'count（'. $key .'）:N/A<br>';
		}
		unset( $_kxx_array_ids );


	endforeach;
	unset( $key , $value );


	foreach( $_kxx_array_ids0 as $_id ):
		$title = get_the_title( $_id );
		$_check[] = $title;

	endforeach;
	unset( $_arr, $_id );


	if( !empty(  $_check  ))
	{
		foreach( array_count_values( $_check )  as $key => $value ):

			if( $value != 1 )
			{
				echo '重複：'. $key ;
				echo '<br>';
			}

		endforeach;

	}


	$ret  = '';

	if( $_type == 'works')
	{
		$_title = '作品名';

	}
	else
	{

		$_title = '一覧';

	}

	//リスト表示。2023-03-22
	$ret .= '<h2>'. $_title .'</h2>';
	$ret .= kx_CLASS_kxx(
	[
		't'				=>	97,
		'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
		'tag'			=>	$tag ,
		'search'  =>	$_array_search[ '作品名' ],
		'ppp'			=>	'999',
	] );

	if( $_type == 'works')
	{
		$ret .= '<h2>キャラクター</h2>';

		$ret .= kx_CLASS_kxx(
		[
			't'				=>	97,
			'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
			'tag'			=>	$tag ,
			'search'  =>	$_array_search[ 'キャラ' ],
			'ppp'			=>	'999',
		] );

		$ret .= '<h2>芸能人</h2>';

		$ret .= kx_CLASS_kxx(
		[
			't'				=>	97,
			'cat'			=>	$this->kxtpS1[ 'cat_top' ] ,
			'tag'			=>	$tag ,
			'search'  =>	$_array_search[ '芸能人' ],
			'ppp'			=>	'999',
		] );
	}




	$ret__non_id_date = '';
	foreach( $result as $_arr ):

		$_dalete_on  = '';
		//print_r( $_arr ) ;
		//echo '<br>';
		//echo $_arr->title;
		//echo '<br>';

		//DB補正。タイトル違い。

		$_arr_DBID_check =
		[
			'id_lesson',
			'id_sens',
			'id_study',
			'id_data'
		];

		foreach( $_arr_DBID_check as $_name_DBID ):

			if( !empty( $_arr->$_name_DBID ) )
			{
				if( !preg_match( '/'.$_arr->title.'$/' , get_the_title( $_arr->$_name_DBID ) ))
				{
					echo '要・メンテナンス。タイトルミスマッチ';
					echo '■';
					echo $_arr->title.'（'.$_name_DBID.'）';
					echo '■';
					echo $_arr->$_name_DBID;
					echo '■';
					$_DB_on  = 1;
				}

				if(  get_post_status( $_arr->$_name_DBID ) == 'trash')
				{
					echo 'ゴミ箱(data)';
					echo  $_arr->title;
					echo '<br>';
					$_DB_on  = 1;
				}
			}

		endforeach;

		if( !empty( $_DB_on ) && $_type == 'works' )
		{
			//
		}
		elseif( !empty( $_DB_on ) && $_type == 'data' )
		{
			echo 'STOP-ID';
			echo '<br>';
		}
		unset($_DB_on);


		//削除。全idなし。
		if(empty( $_arr->id_lesson ) &&  empty( $_arr->id_sens ) && empty( $_arr->id_study ) && empty( $_arr->id_data ) )
		{
			echo '削除A：';
			echo $_arr->title;
			echo '<br>';

			$_dalete_on = 1;
		}

		//削除。タイトルなし。
		if( empty( $_arr->title ) ):
			echo '削除C';
			echo 'タイトルなし';
			//echo '<br>';

			$_dalete_on = 1;

		endif;


		if( !empty( $_dalete_on ) &&  $_type == 'works' )
		{
			$kxdbW->kxdbW_Main( [
				'title' 	=> $_arr->title,
				'order' 	=> 'delete',
			] ,'delete');
		}
		elseif(  !empty( $_dalete_on ) && $_type == 'data' )
		{
			echo '：STOP';
			echo '<br>';
		}


		if( empty( $_arr->id_data )  )
		{
			if( !empty( $_arr->id_sens )  )
			{
				$_url	= get_permalink( $_arr->id_sens );
			}
			elseif( !empty( $_arr->id_study )  )
			{
				$_url	= get_permalink( $_arr->id_study );
			}

			if( !empty( $_url ) )
			{
				$_non_id_date_on = 1;

				$ret__non_id_date .=  '<a href="'	.	$_url	.	'">id_dateなし：'. $_arr->title.'</a><br>';
			}
		}


		if( $_arr->date == 'null'  )
		{
			if( !empty( $_arr->id_data )  )
			{
				$_url	= get_permalink( $_arr->id_data );
			}
			elseif( !empty( $_arr->id_sens )  )
			{
				$_url	= get_permalink( $_arr->id_sens );
			}
			elseif( !empty( $_arr->id_study )  )
			{
				$_url	= get_permalink( $_arr->id_study );
			}

			echo '<a href="'	.	$_url	.	'">DATEなし：'. $_arr->title.'</a><br>';

		}

	endforeach;

	if( !empty( $_non_id_date_on ))
	{
		$ret .= '<hr>'.$ret__non_id_date;
	}

	//outline作成。2023-03-22
	wp_reset_postdata();
	return kx_session_raretu_Heading_content( $ret );
}



/**
 * 作品リスト用
 *
 * @return void
 */
public function kxtpN_select_works(){

	return'<span style="color:red">使用終了</span>';
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpN_select_DB(){

	return 'ショートコード運用終了'.$this->kxtpS0[ 'select1' ];

	//転送型。項目呼び出し。
	if( $this->kxtpS0[ 'select_c' ] == 'DB' && $this->kxtpS0[ 'select1' ] == 'DB' ):

		global $wpdb;
		$sql_rsl = $wpdb->get_results(
			"SELECT *
			FROM wp_kx_temporary
			WHERE id  = '1'
			"
		);

		//print_r( $sql_rsl[0]);

		$this->kxtpS0[ 'select_c' ] = $sql_rsl[0]->select_c;
		$this->kxtpS0[ 'select1' ]  = '%'.$sql_rsl[0]->select1a.'%'.$sql_rsl[0]->select1b.'%';

		$this->kxtpS1[ 'title' ] 		= $sql_rsl[0]->title;

		//echo $this->kxtpS1[ 'title' ];
	endif;



	foreach( KxSu::get('DBjson_pickup')['Works'] as $value_json):

		if( $this->kxtpS0[ 'select1' ] == $value_json ):
			$this->kxtpS0[ 'select_c' ] = 'json';
		endif;

	endforeach;

	$kxdbST = new kxdbST;


	preg_match( '/'.KxSu::get('titile_search')[ 'SharedTitleDB'].'/' , $this->kxtpS1[ 'title'] , $matches ) ;

	$kxdbST->kxdbST_Main(
		[
			'title' 	  => $this->kxtpS1[ 'title' ],
			'Column'    => $this->kxtpS0[ 'select_c' ],
			'select1'   => $this->kxtpS0[ 'select1' ],
			//'Column2'   => $this->kxtpS0[ 'select2_c' ],
			//'select2' 	=> $this->kxtpS0[ 'select2' ],
			'title_top' => preg_replace( '/'.KxSu::get('titile_search')[ 'SharedTitleDB'].'/' , '$1' , $matches[0] ) ,
			//'select2' => $this->kxtpS0[ 'select2' ],
		]
		, 'search'
	);

	unset( $matches );

	//print_r($kxdbST->ids);

	$ret = NULL;

	if( empty( $kxdbST->search_value )):
		echo '■■DB：検索結果なし＝'.$this->kxtpS0[ 'select1' ];
		return 'search '.$this->kxtpS0[ 'select1' ].'=N/A';
	endif;

	$_arr = $kxdbST->search_value;

	if( !empty( $kxdbST->search_value_date_on ) ):

		asort( $_arr );

		$_arrFE = $_arr;

	else:

		foreach( $_arr  as $id => $_date ):
			$_arr2[ $id ] = get_the_title( $id );
		endforeach;

		asort( $_arr2 );

		$_arrFE = $_arr2;

	endif;

	$ret .= $this->kxtp_block_DB_List( $_arrFE );

	$ret = kx_session_raretu_Heading_content( $ret );


	if( !empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) ):
		$ret = '';
	endif;


	$ret1 = apply_filters( 'the_content', '[kasax_index t=70 id='.$this->kxtpS1[ 'id_sc' ].' sys=URL_ON]' );

	return $ret1.$ret;


}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpN_raretu_template(){

	//var_dump($this->kxtpS1[ 'kxtt' ]);
	//var_dump($this->kxtpS1);
	$ret = '';
	$_name = '';

	if( !empty( $this->kxtpS1[ 'kxtt' ][ 'character_number' ]) && $this->kxtpS1[ 'kxtt' ][ 'character_number' ] >= 800 )
	{
		$_name = '：Character800系';
		$_title_base = $this->kxtpS1[ 'title_base' ].'≫';

		$_array = [
			['来歴','＿raretu＿'],
		];
	}
	elseif(
		!empty( $this->kxtpS1[ 'kxtt' ][ 'character_number' ])
		&& preg_match(KxSu::get('title_array')['taijin'],$this->kxtpS1[ 'title' ] ,$matches)
		)
	{
		//echo '≫＼c'.$matches[3];

		$_title_base = $this->kxtpS1[ 'title_base' ];

		$_array = [
			['','＿raretu＿'],
			['≫＼c'.$matches[3],'＿raretu＿'],
			['≫＼c'.$matches[3].'≫概要'],
			['≫＼c'.$matches[3].'≫来歴','＿raretu＿'],
		];
	}
	elseif( !empty( $this->kxtpS1[ 'kxtt' ][ 'character_number' ])  )
	{
		$_name = '：Character'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ];
		$_title_base = $this->kxtpS1[ 'title_base' ].'≫';

		$_array = [
			['UtilityFunction','＿raretu＿'],
			['UtilityFunction≫00-00＠統合概要',''],
			//['0Main≫概要'],
			//['0Main≫設計'],
			['2構成','＿raretu＿'],
			['2構成≫概要',''],
			//['来歴','＿raretu＿'],
		];
	}
	elseif($this->kxtpS1[ 'title' ] === $this->kxtpS1[ 'kxtt' ][ 'world' ] .'≫0構成')
	{
		$_array = [
			['概要'],
			['設定','＿raretu＿'],
			['商品構成','＿raretu＿'],
			['広報','＿raretu＿'],
			['題材','＿raretu＿'],
		];
		$_title_base = $this->kxtpS1[ 'title' ].'≫';
	}


	if(!empty($_array))
	{
		foreach( $_array as $_arr )
		{
			$_title = $_title_base.$_arr[0];
			if(empty( $_arr[1] ))
			{
				$_arr[1] = null;
			}

			$_args['result'] = kx_db0_Template_Base(	['title' => $_title ]  );
			//var_dump($this->kxtpS1['index']);

			$filtered = array_filter( $_args['result'] , function($item) use ($_title) {
				return isset($item->title) && $item->title === $_title;
			});

			if (count($filtered) >= 2) {
				$_args['t'] = 90;
			} elseif (count($filtered) === 1) {
				//
			} else {
				$_args['t'] = 65;
			}

			if( !empty($_args['t'] ))
			{
				$ret .= kx_CLASS_kxx(
				[
					't'					  => $_args['t'],
					'cat'				  => $this->kxtpS1[ 'cat_end' ],
					'search'		  => $_title.'$',
					'new_title'   => $_title,
					'new_content'	=> $_arr[1],
				]);
			}
			unset($_args);
		}
	}

	if( !empty($ret))
	{
		$ret = "<h2>Template{$_name}</h2>".$ret;
	}


	return $ret;

}


/**
 * list_k0
 *
 * @return void
 */
public function kxtpF_kousei_world(){


	//DBmemory ON。
	/*
	凍結。2023-06-24
	$_SESSION[ 'kxx' ][ 'DB_IDs_Memory' ][ 'on' ] = 1;
	$_SESSION[ 'kxx' ][ 'DB_IDs_Memory' ][ 'id_sc' ] = $this->kxtpS1[ 'id_sc' ];
	*/

	//print_r($this->kxtpS1);

	$this->kxtpS1[ 'type_select' ] = $this->kxtpS1[ 'kxtt' ][ 'world' ] ;

	return	kx_session_raretu_Heading_content( kx_CLASS_SCP(
	[

		'select'	=>	$this->kxtpS1[ 'type_select' ],

		[
			'kxscp_array' =>
			[
				'search_base'	=>
				[
					'name'	=>	'kx',
					'arr'		=>
					[
						't'							=>	18,
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'0構成',
						//'search'				=>	'',
						//'sys'						=>	'',
					],

				],

				'contents_array' =>
				[
					[
						'≫',
						'<h2>概要</h2>'	,
						'title_s'				=>	'0構成≫00＠概要＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫00＠概要',
					],

					[
						'0構成≫商品構成',
						'<h2>商品構成</h2>'	,
						'title_s'				=>	'商品構成＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫商品構成',
					],


					[
						'≫構成',
						'<h2>構成</h2>'	,
						'select'				=>	[ '!'	=>	'/∬10/'	],
						'title_s'				=>	'0構成≫構成＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫構成',
					],

					[
						'≫共通',
						'<h2>構成・共通</h2>'	,
						'select'				=>	[ '='	=>	'/∬10/'	],
						'title_s'				=>	'0構成≫共通＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫共通',
					],

					[
						'≫Ksy',
						'<h3>構成・Ksy</h3>'	,
						'select'				=>	[ '='	=>	'/∬10/'	],
						'title_s'				=>	'0構成≫Ksy＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫Ksy',
					],

					[
						'≫Olf',
						'<h3>構成・Olf</h3>'	,
						'select'				=>	[ '='	=>	'/∬10|∬14/'	],
						'title_s'				=>	'0構成≫Olf＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫Olf',
					],

					[
						'≫Ygs',
						'<h3>構成・Ygs</h3>'	,
						'select'				=>	[ '='	=>	'/∬10/'	],
						'title_s'				=>	'0構成≫Ygs＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫Ygs',
					],

					/*
					[
						'≫企画',
						'<h2>企画</h2>'	,
						'select'				=>	[ '＝'	=>	'/model/'	],
						'title_s'				=>	'企画＄',
					],
					*/

					[
						'0構成≫題材',
						'<h2>題材</h2>'	,
						'title_s'				=>	'題材＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫題材',
					],


					[
						'0構成≫設定',
						'<h2>設定</h2>'	,
						'title_s'				=>	'設定＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫設定',
					],

					[
						'0構成≫広報',
						'<h2>広報</h2>'	,
						'select'				=>	[ '!'	=>	'/model/'	],
						'title_s'				=>	'広報＄',
						'new_title'				=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫広報',
					],
				],
			],
		],

		[ 'title_on'	=>	'<h2>Idea</h2>' ],

		[
			'name'	=>	'kx',
			'arr'		=>	[
				't'							=>	18,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'search'				=>	'≫',
				'title_s'				=>	$this->kxtpS1[ 'kxtt' ][ 'world' ] . '≫0構成≫Idea＄',
				'new_title'			=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫Idea',
			],
		],


		[ 'title_on'	=>	'<h2>その他</h2>'	],

		[
			'name'	=>	'kx',
			'top'		=>	'<p>',
			'end'		=>	'</p>',
			'arr'		=>	[
				't'							=>	29,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'tag'						=>	'0構成',
				//'search'			=>	'',
				'title_s'				=>	'0構成≫その他＄',
				'new_title'			=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫その他',
				'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ],
			],
		],

		[ 'title_on'	=>	'<h2>一覧</h2>'	],

		[
			'name'	=>	'kx',

			'arr'		=>	[
				't'							=> 65,
				'cat'						=> $this->kxtpS1[ 'cat_end' ],
				'title_s'				=> '0START＄',
				'new_title'			=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫0START',
				'text_c'				=> 'START'
			],
		],

		[
			'kxscp_array' =>
			[
				'search_base'	=>
				[
					'name'	=>	'kx',
					'arr'		=>
					[
						't'							=>	65,
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'0構成',
						'search'				=>	'',
					],
				],

				'contents_array' =>
				[
					/*
					[
						'≫',
						'select'				=>	[ '!'	=>	'/model/'	],
						'title_s'				=>	'〇＄',
					],
					*/

					[
						'≫0構成≫システムチェック',
						'title_s'				=>	'システムチェック＄',
						//'text_c'				=>	'システムチェック',
						'new_content'	  =>	'＿kx t＝90 cat＝'. get_the_category_by_ID( $this->kxtpS1[ 'cat_top' ] ) .'＿',
						'new_title'			=>	get_the_category_by_ID( $this->kxtpS1[ 'cat_top' ] ).'≫0構成≫システムチェック',
					],

					[
						'≫0構成',
						'title_s'				=>	'≫リスト＄',
						'new_title'			=>	$this->kxtpS1[ 'cat_end_name' ] . '≫0構成≫リスト',
						'new_content'	=>	'＿kx_tp type＝list_world＿',
					],

					[
						'≫0構成',
						'title_s'				=>	'0構成$',
						'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ],
						'new_content'	=>	'＿raretu＿',
						'new_title'			=>	get_the_category_by_ID( $this->kxtpS1[ 'cat_top' ] ).'≫0構成',
					],
				],
			],
		],

		[
			'name'	=>	'kx',
			'arr'		=>
			[
				't'							=>	65,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'tag'						=>	'1構成',
				'search'				=>	'1構成',
				'title_s'				=>	get_the_category_by_ID( $this->kxtpS1[ 'cat_top' ] ).'≫1構成$',
				'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ],
			],
		],
	] ) );
}




/**
 * キャラクターTEMPLATE。
 * add_shortcode('kx_chara_format','kxsc_template_chara');
 *
 * @param [type] $atts
 * @return void
 */
public function kxtpF_chara(){


	$this->kxtpS1[ 'title' ] = preg_replace('/≫W$/','',$this->kxtpS1[ 'title' ]);
	// 表示開始
	$ret = NULL;

	//kx_db0_Template(	$title , $type  )


	//echo $this->kxtpS1[ 'title_taijin' ];
	//echo '<br>';

	$this->kxtpS1['index']   = kx_db0_Template_Base(	['title' => $this->kxtpS1[ 'title' ].'≫2構成' ]  );
	$this->kxtpS1['index_c'] = kx_db0_Template_Base(	['title' => $this->kxtpS1[ 'title' ].'≫＼c'.$this->kxtpS1[ 'c' ] ]  );
	$this->kxtpS1['index_t'] = kx_db0_Template_Base(	['title' => $this->kxtpS1[ 'title_taijin' ] ]  );
	//echo $this->kxtpS1[ 'title' ].'≫＼c'.$this->kxtpS1[ 'c' ] .'<br>';
	//var_dump($this->kxtpS1['index_c']);



	/*
	foreach($this->kxtpS1['index_c'] as $_array)
	{
		var_dump($_array);
		echo '<hr>';
	}
		*/



	/*
	//var_dump($db[0]);
	//echo '<br>';
	//echo count($db);

	// 直接検索可能
	$searchTitle = "∬10≫c001≫2構成≫概要";
	if (isset($index[$searchTitle]))
	{
    echo "一致: " . $index[$searchTitle]->title . PHP_EOL;
	}
	*/


	// トップリンク
	// more
	if(	$this->kxtpS1[ 't' ]	== 800	)
	{
		$ret .= '[kx_hidden_s memo=C-type800]';
		$ret .= '[kasax_index t=70]';
		$ret .= '<p>&nbsp;</p>';
		$ret .= '[kx t=19 cat='.$this->kxtpS1[ 'cat_end' ].' tag=c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].' tag_not="≫来歴≫" search="2構成≫概要"]';
		$ret .= '<p><!--more--></p>';
		$ret .= '[kx_hidden_e memo=non]';
	}
	elseif(	$this->kxtpS1[ 't' ]	== 980	)
	{
		$ret .= 'C-type='. $this->kxtpS1[ 't' ];
	}
	elseif( !is_numeric( $this->kxtpS1[ 't' ] ) )
	{
		$ret .= 'C-type='. $this->kxtpS1[ 't' ];
	}

	$_typeC = '<div style="text-align:right;float: right;">';
	$_typeC .= '<div class="__switch_start __color_gray66"  style="width:85px;margin:0 0px 0 0;display:inline-block;text-align: center;">';
	$_typeC .= '<span class="__a_hover">';
	$_typeC .= '▽Type';
	$_typeC .= '</span>';
	$_typeC .= '<div class="__navi_back_l2">';
	$_typeC .= 'C-type='.$this->kxtpS1[ 't' ] ;
	$_typeC .= '</div>';
	$_typeC .= '</div>';
	$_typeC .= '</div>';

	//隠蔽要素
	if(	$this->kxtpS1[ 't' ]	!= 800 && 	$this->kxtpS1[ 't' ]	!= 980	)
	{
		$ret .= kx_CLASS_SCP(
		[
			'select'	=>	$this->kxtpS1[ 'type_select' ],

			[ 'title_on'	=>	'[kx_hidden_s t=20]'	],
			[ 'title_on'	=>	'<h2>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'設計C：'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ].'</h2>'	],
			[ 'title_on'	=>	 $_typeC ],
			[ 'title_on'	=>	'[kx_hidden_e t=20]'	],

			//[ 'title_on'	=>	'<div class="__ellipsis __margin_left30" style="line-height:150%">',	],
			//[ 'title_on'	=>	'</div>'	],

			//一覧
			[ 'title_on'	=>	'<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'一覧C</h3>'	],

			[
				'kxscp_array' =>
				[
					'search_base'	   => $this->kxtp_SAS[ 'mainKX3' ],
					'contents_array' => $this->kxtp_SAS[ 'list_chara' ],
				],
			],
		] );
	}
	else
	{
		$ret .= kx_CLASS_SCP(
		[
			[ 'title_on'	=>	'<h2>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'設計C：'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ].'</h2>'	],
		] );
	}
	//$ret .= '+++<hr>';

	if(
		empty( $this->kxtpS1[ 'ShortStory' ] )
		&& ($this->kxtpS1[ 't' ] == '001' || $this->kxtpS1[ 't' ] == '100' || $this->kxtpS1[ 't' ] == '300'  ) ) //|| $this->kxtpS1[ 't' ] == '400'
	{
		$ret .= '<p>&nbsp;</p>';

		if( !empty( $this->kxtpS1[ 'BigStory' ] ))
		{
			$ret .= $this->kxtpF_kousei2big_block();
		}
		else
		{
			$ret .= kx_CLASS_SCP(
				[
					'select'	=>	$this->kxtpS1[ 'type_select' ],

					[ 'title_on'	=>	'<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'進行要素</h3>'  ],

					[
						'kxscp_array' =>
						[
							'search_base'    =>	$this->kxtp_SAS[ '試練○' ],
							'contents_array' => $this->kxtp_SAS[ 'list_shiren' ],
						],
					],

					[
						'kxscp_array' =>
						[
							'search_base' =>
							[
								'name'	=>	'kx',
								'top'		=>	'<p>',
								'end'		=>	'</p>',

								'arr'		=>
								[
									't'				=>	$this->kxtpS1[ 'kx3_t' ],
									'cat'			=>	$this->kxtpS1[ 'cat_end' ],
									'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
									'tag_not'	=>	'≫来歴≫',
									'search'	=>	'≫〇',
									'sys'			=>	'reference_off,div_on',
								],

							],

							'contents_array' =>
							[
								[ 'w501' , '<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] . '進行要素Layer：主人公</h3>' , 3=>'/001/' ],
								[ 'w581' ,'' , ''	              , 3=>'/001/' ],
								[ 'w591' ,'' , '<p>&nbsp;</p>'	, 3=>'/001/' ],
							],
						],
					],
				]);
		}


	}

	//$ret .= '+++<hr>';
	/*
	if(	$this->kxtpS1[ 't' ]	!= 800 && 	$this->kxtpS1[ 't' ]	!= 980	)
	{
		//注意作成
		$_id_Caution_arr = kx_db0( [ 'title' => $this->kxtpS1[ 'title_base' ] . '≫2構成≫注意' ] , 'Select_title'  );


		if( !empty( $_id_Caution_arr[0]->id ) )
		{
			$ret .= kx_shortcode_print([
				'name'	=> 'kx',
				'top'		=> '<p>&nbsp;</p><div><span class="__color_red __font_weight_bold __border_red" style="padding:0 5px;">&nbsp;注意&nbsp;</span></div>',
				'end'		=> '',

				'arr'		=> [
					't'							=>	18,
					'id'						=>	$_id_Caution_arr[0]->id ,
				],

			] );
		}
		else
		{
			$ret .= '<p>&nbsp;</p>';
			$ret .= '[kxedit t=78 new_title="' . $this->kxtpS1[ 'title_base' ] . '≫2構成≫注意" new="1" hyouji="╋注意" css_hyouji="'.$this->kxtpS1[ 'css_hyouji' ].'"]</p>';
		}
	}
		*/


	//概要・設計
	$ret .= kx_CLASS_SCP(
	[

		[
			'name'	=>	'kx',
			'top'		=>	'<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'概要</h3><p>',
			'end'		=>	'</p>',

			'arr'		=>
			[
				't'							=>	18,
				'ids'						=>	kx_db0_Template_ID( $this->kxtpS1[ 'title' ].'≫2構成≫概要' , $this->kxtpS1['index'] ),
				'new_title'			=> $this->kxtpS1[ 'title' ].'≫2構成≫概要',
			],
		],

		[
			'name'	=>	'kx',
			'top'		=>	'<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'設計</h3><p>',
			'end'		=>	'</p>',

			'arr'		=>
			[
				't'							=>	18,
				'ids'						=>	kx_db0_Template_ID( $this->kxtpS1[ 'title' ].'≫2構成≫設計' , $this->kxtpS1['index'] ),
				'new_title'			=> $this->kxtpS1[ 'title' ].'≫2構成≫設計',
			],
		],

		/*
		[
			'kxscp_array' =>
			[
				'search_base'	=>
				[
					'top'		=>	'<p>',
					'end'		=>	'</p>',
					'name'	=>	'kx',

					'arr'		=>
					[
						't'					=>	18,
						'cat'				=>	$this->kxtpS1[ 'cat_end' ],
						'tag'				=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
						'tag_not'		=>	'≫来歴≫',
						'search'		=>	'≫2構成≫',
						'new_title'	=>	$this->kxtpS1[ 'title_base' ],
						'sys'				=>	$this->kxtpS1[ 'txx_sys' ],
					],
				],

				'contents_array' =>
				[
					[ '概要'	,'<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'概要</h3>'	,''],
					[ '設計'	,'<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'設計</h3>'	,''],
				],
			],
		]
			*/
	]	);

	if( preg_match( '/数字外/' , $this->kxtpS1[ 't' ] ) )
	{
		return	kx_session_raretu_Heading_content(	$ret	);
	}
	elseif(	$this->kxtpS1[ 't' ]	== 800 ||	$this->kxtpS1[ 't' ]	== 980	)
	{
		return $ret;
	}

	//ヒロイン/メインキャラ視点
	$ret .= '<h2>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].' '		.	$this->kxtpS1[ 'kxtt' ][ 'character_name' ]	.	'</h2>';
	//$ret .= '<hr>++++<hr>';
	$ret .= $this->kxtp_block_situation_taijin(
		$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
		$this->kxtpS1[ 'c' ]	,
		$this->kxtpS1[ 'kxtt' ][ 'character_name' ]	,
		$this->kxtpS1[ 'kxtt' ][ 'character_yobina' ]
	);

	//echo $this->kxtpS1[ 'c' ];


	if( $this->kxtpS1[ 't' ] == '001' || $this->kxtpS1[ 't' ] == 100 || $this->kxtpS1[ 't' ] == 300 )
	{
		$ret .= $this->kxtp_block_situation_series(
			$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
			$this->kxtpS1[ 'c' ]	,
			$this->kxtpS1[ 'kxtt' ][ 'character_name' ]	,
			[
				[ 'K' , '<p>&nbsp;</p>' ],
				[ 'Y' , '<p>&nbsp;</p>' ],
			]
		);
	}


	$ret .= '<p>&nbsp;</p>';

	if( $this->kxtpS0[ 'type' ] == 'charaW' )
	{
		//主人公側視点
		$ret .= '<div class="HTMLcssB">';
		$ret .= '<h2>' . $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'c' ] ] . '  '	.	$this->kxtpS1[ 'kxtt' ][ 'character_yobina' ]	.	'</h2>';
		$ret .= $this->kxtp_block_situation_taijin( $this->kxtpS1[ 'c' ]	,$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,$this->kxtpS1[ 'kxtt' ][ 'character_yobina' ]		,$this->kxtpS1[ 'kxtt' ][ 'character_name' ]		,'taijin');


		if(	$this->kxtpS1[ 't' ] ==100 || $this->kxtpS1[ 't' ] == '001' || $this->kxtpS1[ 't' ] == 300 )
		{
			$arr =
			[
				[ 'K'	,'<p>&nbsp;</p>'],
				[ 'Y'	,'<p>&nbsp;</p>'],
			];

			$ret .= $this->kxtp_block_situation_series(
				$this->kxtpS1[ 'c' ]	,
				$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
				$this->kxtpS1[ 'kxtt' ][ 'character_yobina' ]	,
				$arr
			);
		}

		$ret .= '</div>';


		$ret .= '<div class="HTMLcssC">';

		$ret .= kx_CLASS_SCP(
		[
			[ 'title_on'	=>	'<h2>人間関係・その他</h2>'],

			[ 'title_on'	=>	'■一覧：'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ].'⇒対人関係' ],

			[
				'name'	=>	'kxedit',
				'top'		=>	'<p>',
				'end'		=>	'</p>',
				'arr'		=>	[
					'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ] .'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].	'≫＼c988',
					'new'						=>	1,
					//'new_content'	=>	'"＿kx_tp type＝list_taijin＿',
					'new_content'	  =>	'＿raretu＿',
					'css_hyouji'		=>	$this->kxtpS1[ 'css_hyouji' ],
					'hyouji'				=>	'╋'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ].'⇒対人関係',
				],
			],

			[
				'name'	=>	'kx',
				'top'		=>	'<div class="question1"></div><div class="answer1">',
				'end'		=>	'</div><hr>',

				'arr'		=>
				[
					't'							=>	96,
					'cat'						=>	$this->kxtpS1[ 'cat_end' ],
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
					'tag_not'				=>	'≫来歴≫',
					'search'				=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫＼c'	,
					'title_s'				=>	'c￥d￥w{1,}￥d$'	,
				],
			],

			[ 'title_on'	=>	'<p>&nbsp;</p>■一覧：対人⇒'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ].'／来歴' ],

			[
				'name'	=>	'kxedit',
				'arr'		=>	[
					'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ] . '≫c998≫＼c' . $this->kxtpS1[ 'kxtt' ][ 'character_number' ],
					'new'						=>	1,
					//'new_content'	=>	'＿kx_tp type＝list_taijin＿',
					'new_content'	  =>	'＿raretu＿',
					'css_hyouji'		=>	$this->kxtpS1[ 'css_hyouji' ],
					'hyouji'				=>	'╋対人⇒'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ],
				],
			],


			[
				'name'	=>	'kx',
				'top'		=>	'<div class="question1"></div><div class="answer1">',
				'end'		=>	'</div><hr>',
				'arr'		=>	[

					't'					=>	96,
					'cat'				=>	$this->kxtpS1[ 'cat_end' ],
					'tag'				=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
					'tag_not'		=>	'≫来歴≫',
					'search'		=>	'＼c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'title_s'		=>	'c￥d￥w{1,}￥d$'	,
				],
			],

		]	);
	}
	$ret .= '<p>&nbsp;</p>';

	$ret .= kx_CLASS_SCP(
	[
		'select'	=>	$this->kxtpS1[ 'type_select' ] ,
		[
			'name'		=>	'kx',
			'top'			=>	'<h2>補足</h2>',
			'end'			=>	'</p><p>&nbsp;</p>',

			'arr'			=>
			[
				't'						=>	18,
				'cat'					=>	$this->kxtpS1[ 'cat_end' ],
				'tag'					=>	'c' . $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ,
				'tag_not'		   =>	'≫来歴≫',
				'search'			=>	'≫補'	,
				'title_s'			=>	'足＄'	,
				'new_title'		=>	$this->kxtpS1[ 'title_base' ].'≫補足',
				'new_content' =>	"＿raretu＿",
				'sys'					=>	$this->kxtpS1[ 'txx_sys' ].'head_no,title_last,reference_off'
			],
		],
	] );


	if( empty( $this->kxtpS1[ 'c_clone' ] ) )
	{
		$ret .= '<p>[kxedit t=78 hyouji="╋補足" new_title="' . $this->kxtpS1[ 'kxtt' ][ 'world' ] .'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫補足≫〈新規補足〉" new="1" css_hyouji="' . $this->kxtpS1[ 'css_hyouji15' ] .'"]</p>';
	}

	$ret .= '<p>&nbsp;</p>';


	//echo $this->kxtpS1[ 'type_select' ];


	$ret .= kx_CLASS_SCP(
	[
		'select'	=>	$this->kxtpS1[ 'type_select' ],

		[
			'select'	 =>	[ '!'	=>	'/800/'	]	,
			'name'	=>	'kx',
			'top'		=>	'<h2>視覚表現</h2><p>',
			'end'		=>	'</p>',

			'arr'		=>
			[
				't'							=>	18,
				'ids'						=>	kx_db0_Template_ID( $this->kxtpS1[ 'title' ].'≫2構成≫視覚表現' , $this->kxtpS1['index'] ),
				'new_title'			=> $this->kxtpS1[ 'title' ].'≫2構成≫視覚表現',
				'sys' => $this->kxtpS1[ 'txx_sys' ] ,
			],
		],

		[
			'name'	=>	'kx',
			'top'		=>	'<h2>アイデア</h2><p>',
			'end'		=>	'</p>',

			'arr'		=>
			[
				't'							=>	18,
				'ids'						=>	kx_db0_Template_ID( $this->kxtpS1[ 'title' ].'≫2構成≫Idea' , $this->kxtpS1['index'] ),
				'new_title'			=> $this->kxtpS1[ 'title' ].'≫2構成≫Idea',
				'sys' => $this->kxtpS1[ 'txx_sys' ] . ',reference_off',
			],
		],



		/*
		[
			'kxscp_array' =>
			[
				'search_base' =>
				[
					'name'	=>	'kx',

					'arr'		=>
					[
						't'						=>	19,
						'cat'					=>	$this->kxtpS1[ 'cat_end' ],
						'tag'					=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
						'tag_not'			=>	'≫来歴≫',
						'search'			=>	'≫2構成≫',
						'new_title'		=>	$this->kxtpS1[ 'title_base' ],
					],
				],

				'contents_array' =>
				[
					[ '視覚表現' , '<h2>視覚表現</h2>' , 'select'	 =>	[ '!'	=>	'/800/'	]	, 'sys' => $this->kxtpS1[ 'txx_sys' ] ],
					[ 'Idea'     , '<h2>アイデア</h2>' , 'title_s' => 'Idea＄'            , 'sys' => $this->kxtpS1[ 'txx_sys' ] . ',reference_off' ],
				],
			],
		],
		*/

	] );

	$ret .= '</div>';
	return $ret;
}



/**
 * 1構成・FORMAT
 *
 * @return void
 */
public function kxtpF_kousei1(){

	$ret = '';

	$ret .= '<h2>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'作品-壱</h2>';

	$ret .= kx_CLASS_SCP(
	[
		[
			'kxscp_array' =>
			[
				'search_base' =>
				[
					'name'	=>	'kx',
					'top'		=>	'<p>',
					'end'		=>	'</p>',

					'arr'		=>
					[
						't'				=>	19,
						'cat'			=>	$this->kxtpS1[ 'cat_end' ],
						'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
						'tag_not'	=>	'≫来歴≫',
						'search'	=>	'≫1構成',
						//'sys'			=>	'reference_off,div_on',
					],

				],

				'contents_array' =>
				[
					[ '≫概要'   ,'<h3>概要</h3>' ],
					[ '≫目的Ⅱ' ,'<h3>目的Ⅱ</h3>' ],
				],
			],
		],

		[
			'kxscp_array' =>
			[
				'search_base'	   => $this->kxtp_SAS[ 'mainKX3' ],

				'contents_array' =>
				[
					[ '2構成≫〇h111'		, '<h3>進行概要</h3>'				        , ''							],
					[ '2構成≫〇w581'		, ''				          	     	  , ''							],
					[ '2構成≫〇w591'		, ''				          	     	  , '<p>&nbsp;</p>'	],
				],
			],
		],

		[
			'kxscp_array' =>
			[
				'search_base' =>
				[
					'name'	=>	'kx',
					'top'		=>	'<p>',
					'end'		=>	'</p>',

					'arr'		=>
					[
						't'				=>	19,
						'cat'			=>	$this->kxtpS1[ 'cat_end' ],
						'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
						'tag_not'	=>	'≫来歴≫',
						'search'	=>	'≫1構成',
						//'sys'			=>	'reference_off,div_on',
					],

				],

				'contents_array' =>
				[
					[
						'≫進行'   ,
						'<h3>進行詳細</h3>',
						'new_title'   => $this->kxtpS1[ 'title_base' ].'≫1構成≫進行',
					],
				],
			],
		],
	],);


	$ret .= $this->kxtpF_kousei2big_block();

	$ret .= kx_CLASS_SCP(
		[
			[
				'name'	=>	'kxedit',
				'top'		=>	'<hr><h2>二構成Big</h2><p>',
				'end'		=>	'</p>',
				'arr'		=>
				[
					'new_title'   => $this->kxtpS1[ 'title_base' ].'≫1構成≫二01',
					'new' 			  => 1 ,
					'new_content'	=> "＿kx_tp type＝kbig2＿",
					'css_hyouji'  => $this->kxtpS1[ 'css_hyouji' ],
				],
			],

			[
				'name'	=>	'kx',

				'arr'		=>
				[
					't'							=>	96,
					'cat'						=>	$this->kxtpS1[ 'cat_end' ]	,
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'search'				=>	'≫1構成≫二',
					'title_s'				=>	"￥d＄",
					'new_title'   => $this->kxtpS1[ 'title_base' ].'≫1構成≫二01',
					'new_content'	=> "＿kx_tp type＝kbig2＿",
				],
			],
		] );




	return $ret;
}


/**
 * 2構成・FORMAT
 * add_shortcode('kousei2','kxsc_kousei2_format');
 *
 * @param [type] $atts
 * @return void
 */
public function kxtpF_kousei2(){


	if( empty( $this->kxtpS1[ 't' ] ) )
	{

		$this->kxtpS1[ 't' ] = 'number';

	};

	$ret = NULL;
	//■■■Update/表示 開始■■■
	//if(	$this->kxtpS1[ 'update' ]	 || $this->kxtpS1[ 'wfm_end' ] == 'end'):


	//■■■表示開始■■■

	//■システム■

	if( $this->kxtpS1[ 'wfm_end' ] != 'end')
	{
		//未使用中。2023-09-04
		$_shortcode	= $this->kxtpS1[ 'shortcode' ] . "\n";
	}
	else
	{
		//未使用中。2023-09-04
		$_update	= 1;

		//■■■	終了コード	■■■
		$ret .= '【自動更新＠＠ｔ終了】';
		$ret .= '<p>【終了コード】</p>';
		$ret .= '[kx t=96 search="c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'＞ kx_format"';
		$ret .= ' all=1 wfm_end=';
		$ret .= $wfm_end;
		$ret .= ']';
		$ret .='<p>&nbsp;</p>';
	}

	//■■■	SYSTEM	■■■

	//■■■	内容	■■■
	$ret .= '<h2>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'作品-二</h2>';

	//■一覧

	$ret .= $this->kxtp_block_list_kousei23();





	$ret .= kx_CLASS_SCP(
	[
		'select'	=>	$this->kxtpS1[ 'type_select' ] . ',' .strtolower( $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] ),

		//	■世界観
		[
			'arr_search'	=>
			[
				[	'b111'		,	'<p>&nbsp;</p><p>■世界観</p>'	,	 ''	],
				[	'b311ksy'	,	''														 ,	''	],
				[	'b311ygs'	,	''														 ,	''	],

				'arr_base'	=>	$this->kxtp_SAS[ 'zero構成・○'],
			]

		],

		//■more
		[	'title_on'	=>	'<!--more-->'	],

		//■設計

		[
			'select'				=>	[ '!'	=>	'/sMain/'	],
			'name'	=>	'kx',
			'top'		=>	'<h3>設計Ⅱ</h3><p>',
			'end'		=>	'</p><p>&nbsp;</p>',
			'arr'		=>	[
				't'							=>	19,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'tag'						=>	'c'.	$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
				'tag_not'		=>	'≫来歴≫',
				'search'				=>	'≫2構成≫設計',
			],
		],

		$this->kxtp_block_array(1),

		$this->kxtp_block_array(2),

		//■進行
		[	'title_on'	=>	'<h2>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'進行Ⅱ・一覧</h2>'	],

		[	'title_on'	=>	'<p>&nbsp;</p><p>〘Ⅱ：緊張・掴み〙</p>'	],

		[
			'arr_search'	=>	[

				[	'h112ksy'	,	''		,'sys'=>'head_no'],
				//[	'h112ygs'	,	''		,'sys'=>'head_no'],//ここに記載される可能性はないので不要。2025-02-15


				'arr_base'	=>
				[
					'name'	=>	'kx',
					'arr'		=>
					[
						't'							=>	$this->kxtpS1[ 'kx3_t' ],
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.	$this->kxtpS1[ 'kxtt' ][ 'character_number' ] ,
						'tag_not'	    	=>	'≫来歴≫',
						'search'				=>	'≫〇',
						'ppp'						=>	99,
						'sys'						=>	$this->kxtpS1[ 'txx_sys' ],
					],
				],
			],
		],



		[	'title_on'	=>	'<h3>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'LineAⅡ：緊張と開放</h3>'	],

		[
			'arr_search'	=>
			[
				'arr'      => $this->kxtp_SAS[ 'list_shiren' ],
				'arr_base' =>$this->kxtp_SAS[ '試練○']
			],
		],

		[	'title_on'	=>	'<h3>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'LineBⅡ：各話主感情</h3>'	],


		[
			'arr_search'	=>	[
				//[	'w402'	,	'<h3>LineBⅡ：Trick</h3><p>〚Layer：謎〛</p>'],
				//[	'w522'	,	'<p>&nbsp;</p><p>〚Layer：各話〛</p>'],
				//[	'w583'	,	'<h3>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'LineBⅡ：各話目的</h3><p>〘Layer：各話F〙</p>'	, 'sys'=>'plus30_w,head_no,new_off'],
				//[	'w593'	,	'<p>〘Layer：各話A〙</p>'	, 'sys'=>'plus30_w,head_no,new_off'],
				//[	'w512'	,	'<p>&nbsp;</p>'	],
				[	'w502'	,	'<p>&nbsp;</p><p>〘主感情Ⅱ〙</p>'		,'sys'=>'head_no'],
				[	'w503'	,	'<p>&nbsp;</p><p>〘主感情ⅲ〙</p>'		,'sys'=>'head_no,plus30_w'],

				//[	'w592'	,	''																				,'sys'=>'head_no'],
				//[	'w712'	,	''																				,	'<p>&nbsp;</p>'	,'sys'=>'head_no'],


				'arr_base'	=>
				[
					'name'	=>	'kx',
					'arr'		=>
					[
						't'							=>	$this->kxtpS1[ 'kx3_t' ],
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.	$this->kxtpS1[ 'kxtt' ][ 'character_number' ] ,
						'tag_not'	    	=>	'≫来歴≫',
						'search'				=>	'≫〇',
						'ppp'						=>	99,
						'sys'						=>	$this->kxtpS1[ 'txx_sys' ],
					],
				],
			],
		],
	]	);

	$ret .= $this->kxtp_block_kousei2();


	//	■登場人物・その他
	$ret .= $this->kxtp_block_chara_etc( $this->kxtpS1[ 'cs' ] );

	$ret .= kx_CLASS_SCP([

		[
			'arr_search'	=>	[

				["題名"	,'<h2>題名</h2><p>&nbsp;</p><p>'	,	'</p>'		],

				'arr_base'	=>
				[
					'name'	=>	'kx',
					'arr'		=>
					[
						't'							=>	14,
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
						'tag_not'		=>	'≫来歴≫',
						'search'				=>	'≫2構成≫',
						'title_s'				=>	"題名＄",
						'new_title'			=>	$this->kxtpS1[ 'title_base' ] . '',
					],
				],
			],
		],
	] );


	//■アイディア■

	$ret .= kx_CLASS_SCP(
	[
		[
			'arr_search'	=>
			[
				[ 'Idea' ,	'<h2>アイデア</h2><p>&nbsp;</p>', 'title_s'=>'Idea＄' ],
				//[ 'memo'],

				'arr_base'	=>
				[
					'name'	=>	'kx',
					//'top'		=>	'<p>',
					//'end'		=>	'</p><p>&nbsp;</p>',

					'arr'		=>
					[
						't'							=>	14,
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
						'tag_not'		=>	'≫来歴≫',
						'search'				=>	'≫2構成≫',
						'new_title'			=>	$this->kxtpS1[ 'title_base' ],
						'sys'						=>	 'reference_off',
					],
				],
			],
		],
	] );

	return $ret;
}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpF_kousei2big(){
	$ret	= '';

	$ret .= $this->kxtp_block_list_kousei23();

	preg_match( '/二(\d{1,})$/', $this->kxtpS1[ 'title' ] , $matches );
	//echo $matches[0];


	//$i = 1;
	$ret .= kx_CLASS_SCP(
		[
			[
				'kxscp_array' =>
				[
					'search_base' =>
					[
						'name'	=>	'kx',
						'top'		=>	'<p>',
						'end'		=>	'</p>',

						'arr'		=>
						[
							't'				=>	$this->kxtpS1[ 'kx3_t' ],
							'cat'			=>	$this->kxtpS1[ 'cat_end' ],
							'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
							'tag_not'	=>	'≫来歴≫',
							'search'	=>	'≫2構成≫〇',
							'sys'			=>	'div_on',
						],

					],

					'contents_array' =>
					[
						[ 'w507'.$matches[1] ,'<h3>Ⅱ-'.$matches[1].'</h3>' ],
						[ 'h117'.$matches[1] ],
						[ 'w587'.$matches[1] ,'' , ''	],
						[ 'w597'.$matches[1] ,'' , '<p>&nbsp;</p>'	],
					],
				],
			],

			[
				'kxscp_array' =>
				[
					'search_base' =>
					[
						'name'	=>	'kx',
						'top'		=>	'<p>',
						'end'		=>	'</p>',

						'arr'		=>
						[
							't'				=>	19,
							'cat'			=>	$this->kxtpS1[ 'cat_end' ],
							'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
							'tag_not'	=>	'≫来歴≫',
							'search'	=>	'≫1構成≫二'.$matches[1].'≫',
							//'sys'			=>	'reference_off,div_on',
						],

					],

					'contents_array' =>
					[
						[ '概要' ,'<h3>概要二'.$matches[1].'</h3>' ],
						[ '進行'],
					],
				],
			],

		],
	);


	return $ret;
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpF_kousei2big_block(){

	if(
		!empty( $this->kxtpS1[ 'filter_ON' ] ) &&
		preg_match( '/chara/' ,$this->kxtpS1[ 'type' ] )
	)
	{
		$_h = 3;

	}
	else
	{
		$_h = 2;
	}

	$ret = '';

	$_kouse2_count = kx_CLASS_kxx(
		[
			't'				=> 90,
			'cat'			=>	$this->kxtpS1[ 'cat_end' ],
			'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
			'search'	=> '1構成≫二',
			'title_s'	=> '\d$',
			//'sys'     => 'error_navi_off',
		],'array_ids' );

	//echo count( $_kouse2_count[ 'array_ids' ] );

	if( !empty(  $_kouse2_count[ 'array_ids' ] ) )
	{
		for ($i = 1; $i <= count( $_kouse2_count[ 'array_ids' ]); $i++) {

			$i = sprintf('%02d', $i);

			$ret .= kx_CLASS_SCP(
				[
					[
						'name'	=>	'kx',
						'top'		=>	'<hr><h'.$_h.'>Ⅱ-' . $i . '</h'.$_h.'>',
						'end'   => '<div style="height:.5em;">&nbsp;</div>',

						'arr'		=>
						[
							't'							=>	65,
							'cat'						=>	$this->kxtpS1[ 'cat_end' ]	,
							'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
							'search'				=>	'≫1構成≫二'.$i,
							'title_s'				=>	"￥d＄",
							'new_title'   => $this->kxtpS1[ 'title_base' ].'≫1構成≫二01',
							'new_content'	=> "＿kx_tp type＝kbig2＿",
						],
					],

					[
						'kxscp_array' =>
						[
							'search_base' =>
							[
								'name'	=>	'kx',
								'top'		=>	'<p>',
								'end'		=>	'</p>',

								'arr'		=>
								[
									't'				=>	$this->kxtpS1[ 'kx3_t' ],
									'cat'			=>	$this->kxtpS1[ 'cat_end' ],
									'tag'			=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
									'tag_not'	=>	'≫来歴≫',
									'search'	=>	'≫2構成≫〇',
									'sys'			=>	'reference_off,div_on',
								],

							],

							'contents_array' =>
							[
								[ 'w507'.$i ],
								[ 'h117'.$i ],
								[ 'w587'.$i ,'' , ''	],
								[ 'w597'.$i ,'' , ''	],
							],
						],
					],
				],
			);

		}

	}



	return $ret;

}





/**
 * 三構成・template・保存型
 * 旧・//add_shortcode('kousei3','kxsc_kousei3_format');
 * //function kx_kousei3_format_var(){	return 311;	}
 *
 * @param [type] $atts
 * @return void
 */
public function kxtpF_kousei3(){


	$ret	= '';

	//■設計三
	$ret .= kx_CLASS_SCP(
	[
		'select'	=>	$this->kxtpS1[ 'type_select' ].','. $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] ,

		//[ 'title_on'	=>	'[kx_hidden_s t=20]'],
		//[ 'title_on'	=>	'<h2>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'作品ⅲ：'	.	ucfirst($this->kxtpS1[ 'kxtt' ][ 'work_code' ] )	.	'&nbsp;'.$this->kxtpS1[ 'kxtt' ][ 'character_name' ] .'</h2>'],
		[ 'title_on'	=>	'<h2>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'作品ⅲ：'	.	$this->kxtpS1[ 'kxtt' ][ 'work_name' ] .'</h2>'],

		[ 'title_on'	=>	'<div style="font-size: 14pt;">&nbsp;'.$this->kxtpS1[ 'kxtt' ][ 'work_name' ].'&nbsp;</div>'	],

		[ 'title_on'	=>	'<p><!--more--></p>'	],
	] );



	//■進行・詳細
	if(	!empty( $this->kxtpS1[ 'SysType' ] ) )
	{
		$ret .= kx_CLASS_SCP(
		[
			[
				'name'	=>	'kx',
				'top'		=>	'<hr><h2>設計</h2>',
				'arr'		=>
				[
					't'							=>	19,
					'cat'						=>	$this->kxtpS1[ 'cat_end' ]	,
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'search'				=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫設計',
				],
			],

			[
				'name'	=>	'kx',
				'top'	=>	'<h2>来歴（sys）</h2>',
				'arr'		=>
				[
					't'							=>	65,
					'cat'						=>	$this->kxtpS1[ 'cat_end' ]	,
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'search'				=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫来',
					'title_s'				=>	'歴＄',
					'new_content'	=>	'＿raretu＿',
				],
			],


		] );

		if(	!empty( $sys_type2 ) )
		{
			//★★★多分使っていない。2023-09-10★★★
			$ret .= kx_CLASS_SCP(
			[
				[
					'arr_search'	=>
					[
						[ 'h113'	,	'<h2>試練</h2>'	,	''							,	''],
						[ 'w583'	,	''	,	''							,	''],
						[ 'w593'	,	''	,	''							,	''],
						//[ 'w513'	,	'<h2>Trick</h2>'	,	''							,	''],

						'arr_base'	=>	$this->kxtp_SAS[ 'worksKX3' ],
					]
				],
			] );
		}
	}
	else
	{
		$ret .= $this->kxtp_block_list_kousei23();

		//■■■一覧・進行-ⅲ■■■

		//echo $this->kxtpS1[ 'type_select' ];

		$ret .= kx_CLASS_SCP(
		[
			'select'	=>	$this->kxtpS1[ 'type_select' ],

			[
				'select'	=>	[ '!'	=>	'/sh/'	]	,
				//'select'	=>	[	'='	=>	'/1189/'	]	,
				'name'	=>	'kx',
				'top'		=>	'<h3>設計ⅲ</h3>',
				//'end'		=>	'</p>',
				'arr'		=>
				[
					't'							=>	19,
					'cat'						=>	$this->kxtpS1[ 'cat_end' ],
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'tag_not'	    	=>	'≫来歴≫',
					'search'				=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫設計',
					'text_c'				=>	'設計ⅲ',
				],
			],

			$this->kxtp_block_array(1,$this->kxtpS1[ 'type_select' ]),
			$this->kxtp_block_array(2,$this->kxtpS1[ 'type_select' ]),

			[
				'arr_search'	=>
				[
					[ '商品紹介'	,	'<h3>商品紹介</h3>'	,	'<p>&nbsp;</p>'],
					'arr_base'	=>	$this->kxtp_SAS[ 'worksKX19' ],
				]
			],
		] );


		if(	empty( $this->kxtpS1[ 'ShortStory' ] ) &&  empty( $this->kxtpS1[ 'BigStory' ] ) )
		{

			$ret .= '<h2>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ].'2構成（シリーズ構成）</h2>';

			if(
				$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	== 'Olf'
				|| $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	== 'Pnm'
			)
			{
				$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	= 'Ksy';
			}

			$str	= '≫2構成≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ];

			$ret .= kx_CLASS_SCP(
			[
				[
					'arr_search'	=>
					[
						[$str.'進行' , '<h3>Ⅱ進行</h3>'],

						'arr_base'	=>
						[
							'name'	=> 'kx',
							'arr'		=>
							[
								't'			  => 29,
								'cat'		  => $this->kxtpS1[ 'cat_end' ],
								'tag'		  => 'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
								'tag_not' => '≫来歴≫',
								'sys'		  => $this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ]		,
							],
						],
					],
				]
			]	);
		}

		$ret .= '<p>&nbsp;</p>';


		if(	!empty( $this->kxtpS1[ 'ShortStory' ] )	)
		{
			$ret .= $this->kxtp_block_kousei2();
		}
		else
		{
			if(	empty( $this->kxtpS1[ 'BigStory' ] )	)
			{
				$ret .= kx_CLASS_SCP(
				[
					'select'	=>	$this->kxtpS1[ 'type_select' ] . ',' .strtolower( $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] ),

					[ 'title_on'	=>	'<h3>ⅲシリーズ構成（確認）</h3>' ],

					[
						'arr_search'	=>
						[
							'arr'				=> $this->kxtp_SAS[ 'list_shiren' ],
							'arr_base'	=> $this->kxtp_SAS[ '試練○' ],
						],
					],
				] );
			}

			$ret .= $this->kxtp_block_kousei3();

		}
		$ret .='<p>&nbsp;</p>';
	}




	//■sys系・途中リターン。2023-07-04。
	if( !empty( $this->kxtpS1[ 'SysType' ] ))
	{
		return $ret;
	}


	//■登場人物・その他
	$ret .= '<div class="HTMLcssC">';
	$ret .= $this->kxtpS1[ 'etc_chara' ];

	//■演出
	//教訓title
	//$_title_precept	= 'Β≫販売戦略≫作品≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ].'≫'.$sakuhin_sets[ 'number'];

	$ret .= kx_CLASS_SCP(
	[
		[ 'title_on'	=>	'<h2>演出</h2>'],
		[ 'title_on'	=>	'<h3>演出総合</h3>'],

		[
			'top'		=>	'<p>',
			'end'		=>	'</p><p>&nbsp;</p>',
			'name'	=>	'kx',
			'arr'		=>
			[
				't'							=>	$this->kxtpS1[ 'kx6_t_en' ],
				'id'						=>	$this->kxtpS1[ 'arr_id_world' ][$this->kxtpS1[ 'kxtt' ][ 'world' ]][	'0Kousei_Visual'	],
				'new_content'	=>	'＿raretu＿',
				'text_c'				=>	'視覚表現─',
				'sys'						=>	'yomikomi2'
			],

		],

		[
			'top'		=>	'<p>',
			'end'		=>	'</p><p>&nbsp;</p>',
			'name'	=>	'kx',
			'arr'		=>
			[
				't'							=>	$this->kxtpS1[ 'kx6_t_en' ],
				'id'						=>	$this->kxtpS1[ 'arr_id_world' ][$this->kxtpS1[ 'kxtt' ][ 'world' ]][	'0Kousei_Visual_Background'	],
				'new_content'	=>	'＿raretu＿',
				'text_c'				=>	'演出・背景───',
				'sys'						=>	'yomikomi2'
			],
		],

		[ 'title_on'	=>	'<h3>題名：'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'</h3>' ],

		[
			'top'		=>	'<p>',
			'end'		=>	'</p><p>&nbsp;</p>',
			'name'	=>	'kx',
			'arr'		=>
			[
				't'							=>	$this->kxtpS1[ 'kx6_t_en' ],
				'id'						=>	$this->kxtpS1[ 'arr_id_world' ][$this->kxtpS1[ 'kxtt' ][ 'world' ]][	'0Kousei_Title'	],

				'text_c'				=>	'題名───',
				'sys'						=>	'yomikomi2'
			],
		],

		[
			'arr_search'	=>
			[
				[	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫'		,''		,'title_s'	=>	'題名＄'			],
				[	'≫'	.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫'				,'<h3>表紙：'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'</h3>'		,'title_s'	=>	'表紙＄'			],

				'arr_base'	=>
				[
					'name'	=>	'kx',
					'top'		=>	'<p>',
					'end'		=>	'</p>',
					'arr'		=>
					[
						't'							=>	19,
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
						'tag_not'	    	=>	'≫来歴≫',
						'search'				=>	'',
						'title_s'				=>	'',
					],
				],
			],
		],

		[
			'arr_search'	=>
			[

				[	'視覚表現' ,	'<h3>視覚表現</h3>', 'select'	=>	[ '!'	=>	'/800/'	]	,],

				'arr_base'	=>
				[
					'name'	=>	'kx',
					'arr'		=>
					[
						't'							=>	19,
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
						'tag_not'	    	=>	'≫来歴≫',
						'search'				=>	'≫2構成≫',
						'new_title'			=>	$this->kxtpS1[ 'title_base' ],
					],
				],
			],
		],


	]	);

	if(	!empty( $this->kxtpS1[ 'ShortStory' ] )	)
	{
		$ret .= kx_CLASS_SCP(
			[
				[
					'arr_search'	=>
					[
						[ 'Idea' ,	'<h2>アイデア</h2><p>&nbsp;</p>', 'title_s'=>'Idea＄' ],
						//[ 'memo'],

						'arr_base'	=>
						[
							'name'	=>	'kx',
							//'top'		=>	'<p>',
							//'end'		=>	'</p><p>&nbsp;</p>',

							'arr'		=>
							[
								't'							=>	14,
								'cat'						=>	$this->kxtpS1[ 'cat_end' ],
								'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
								'tag_not'	    	=>	'≫来歴≫',
								'search'				=>	'≫2構成≫',
								'new_title'			=>	$this->kxtpS1[ 'title_base' ],
								'sys'						=>	 'reference_off',
							],
						],
					],
				],
			] );
	}
	else
	{
		$ret .= kx_CLASS_SCP(
		[
			[
				'arr_search'	=>
				[
					[	'≫'	.	ucfirst($this->kxtpS1[ 'kxtt' ][ 'work_code' ] ).'≫'	,'<h2>アイディア</h2><p>'	,	'title_s'	=>	'Idea＄', 'sys'=>'reference_off'	],

					'arr_base'	=>
					[
						'name'	=>	'kx',
						'top'		=>	'<p>',
						'end'		=>	'</p>',
						'arr'		=>
						[
							't'							=>	19,
							'cat'						=>	$this->kxtpS1[ 'cat_end' ],
							'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
							'tag_not'	    	=>	'≫来歴≫',
							'search'				=>	'',
							'title_s'				=>	'',
						],
					],
				],
			],
		] );
	}


	$ret .= '</div>';

	return $ret;
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtp_block_list_chara(){

	$ret	= kx_shortcode_print([
		'name'	=>	'kx',
		//'top'		=>	'<p>',
		//'end'		=>	'</p>',
		'arr'		=>	[

			't'							=>	65,
			'cat'						=>	$this->kxtpS1[ 'cat_end'],
			'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
			'search'				=>	'"'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫2構成≫リスト＄"',
			'text_c'				=>	'リスト',
			'sys'						=>	'yomikomi2',
			'new_content'	=>	'＿kx_tp type＝list_chara_pickup＿',

		],

	] );

	return	$ret;

}





/**
 * 3構成フォーマット・リスト
 *
 * @return void
 */
public function kxtp_block_list_kousei23(){

	$ret = NULL;

	//■■■一覧・設計ⅲ■■■
	//商品価値概要

	$ret .= kx_CLASS_SCP(
	[
		'select'	=>	$this->kxtpS1[ 'type_select' ] . ',' .$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ],
		'作品'		=>	$this->kxtpS1[ 'kxtt' ][ 'work_code' ],

		[
			'arr_search'	=>
			[
				[	'a321ksy'	,	'<h3>設計・共通</h3><p>■Ksy</p>'			 , '<p></p>'						,	'/k2/'],
				[	'a341ksy'	,	''																			 , '<p>&nbsp;</p>'	,	'/k2/'],
				[	'a321ygs'	,	'<p>■Ygs</p>'													  ,	'<p></p>'			 	, '/k2/'],
				[	'a341ygs'	,	''															 	 			 , '<p></p>'				,	'/k2/'],

				'arr_base'	=>	$this->kxtp_SAS[ 'zero構成・○' ],
			]
		],

		[	'title_on'	=>	'<h3>設計・一覧</h3>'	] ,

		[
			'arr_search'	=>
			[
				[ 'search' => '∬10≫0構成≫〇a321' . $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] , 'sys'=> 'db_on' , 3 =>	'/(?=.*k3.*(ksy|ygs))/' 	],
				[ 'search' => '∬10≫0構成≫〇a341' . $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] , 'sys'=> 'db_on' , 3 =>	'/(?=.*k3.*(ksy|ygs))/' 	],

				'arr_base'	=>
				[
					'name'	=>	'kx',
					'top'		=>	'<p style="margin:0 0 -1.5em 0;">',
					'end'		=>	'</p>',
					'arr'		=>	[ 't'	=>	30,],
				],
			],
		],


		[ 'title_on'	=>	'<p>&nbsp;</p>'	],


		[
			'arr_search'	=>
			[
				'arr'				=>	$this->kxtp_SAS[ 'list_chara' ],
				'arr_base'	=>	$this->kxtp_SAS[ 'mainKX3' ],
			],
		],

	] );


	//一覧・主人公(対人)

	$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	= $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ];

	if(
		$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	== 'Olf'
		|| $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	== 'Pnm'
	)
	{
		$this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ]	= 'ksy';
	}

	if( empty( $this->kxtpS1[ 'BigStory' ]))
	{
		$ret .= kx_CLASS_SCP(
			[
				'select'	=>	$this->kxtpS1[ 'type_select' ],

				[ 'title_on'	=>	'<p>&nbsp;</p><p>■'.$this->kxtpS1[ 'kxtt' ][ 'character_yobina' ].'</p>'	],

				[
					'select'	=>	[	'='	=>	'/(?=k3|k2)/'	]	,//(?!.*sh)
					'name'		=>	'kx',
					//'top'		=>	'<p style="margin:0 0 0 0;">',
					//'end'			=>	'</p>',
					'arr'			=>
					[
						't'							=>	$this->kxtpS1[ 'kx3_t' ],
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
						'tag_not'				=>	'≫来歴≫',
						'search'				=>	'＼c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	.'≫〇p152',
						'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'. $this->kxtpS1[ 'c' ] .'≫＼c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	.'≫〇p152',
						'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 'sys_add' ],
					],
				],
			] );
	}



	return $ret;
}

/**
 * 各キャラ、シチュエーションブロック。
 *
 * @param [int] $num1
 * @param [int] $num2
 * @param [type] $name1
 * @param [type] $name2
 * @param [type] $_type
 * @return void
 */
public function kxtp_block_situation_taijin(	$num1	,$num2	,$name1	,$name2	,$_type	= null	){


	$ret = NULL;

	if( $_type	== 'taijin') // && $this->kxtpS0[ 'type' ] == 'charaW'
	{
		//対応キャラ側。2023-01-21
		$_index = $this->kxtpS1['index_t'];
		$_title = $this->kxtpS1[ 'title_taijin' ];

		$ret .= kx_shortcode_print(
		[
			'name'	=>	'kx',
			'end'		=>	'<p>&nbsp;</p>',
			'arr'		=>
			[
				't'							=>	67 ,
				'search'				=>	$this->kxtpS1[ 'title_taijin' ] ,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'tag'						=>	'c'.$num2.'',
				'tag_not'				=>	'≫来歴≫',
				'title_s'				=>	'＼c' . $num2	.	'＄',
				'text_c'				=>	$this->kxtpS1[ 'kxtt' ][ 'character_yobina' ] . '&nbsp;⇒&nbsp;' . $this->kxtpS1[ 'kxtt' ][ 'character_name' ]   . '（一覧）' ,
				'sys'						=>	$this->kxtpS1[ 'txx_sys' ],
				'new_content'	=>	'＿raretu＿',
				'new_title'			=>	$this->kxtpS1[ 'title_taijin' ] ,
			],
		] );

		//echo $num2;

		$ret .= kx_CLASS_SCP(
		[
			[ 'title_on'	=>	'<h3>' . $this->kxtp_set_CharaMark( $num1 ) .'主感情</h3>'	],

			[
				'arr_search'	=>
				[
					[
						'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫〇p152',
						'title_s'				=>	$this->kxtpS1[ 'c' ],
						'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxtpS1[ 'c' ].'≫＼c'. $this->kxtpS1[ 'kxtt' ][ 'character_number' ] .'≫〇p152',
						'sys'						=>	$this->kxtpS1[ 'txx_sys' ],	// . 'db_on'
					],

					'arr_base'	=>
					[
						'name'		=>	'kx',

						'arr'		=>
						[
							't'						=>	14,
							'cat'					=>	$this->kxtpS1[ 'cat_end' ],
							'tag'					=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	 ,
							'search'			=>	'',
							'ppp'					=>	20,
						],
					],
				],
			],
		] );
	}
	else
	{
		$_index = $this->kxtpS1['index_c'];
		$_title = $this->kxtpS1[ 'title' ].'≫＼c'.$this->kxtpS1[ 'c' ];

		//存在しない場合、非表示。DB利用。
		$DB_kx0_A1 = kx_db0( [ 'title' => $this->kxtpS1[ 'title_base' ] . '≫2構成≫A%' ] , 'Select_title'  );
		//var_dump($DB_kx0_A1);

		if( !empty( $DB_kx0_A1 ) && is_array( $DB_kx0_A1 ))
		{
			$ret .= '<h3>'. $this->kxtp_set_CharaMark( $num1 ). 'A&nbsp;世界</h3>';

			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kx',
				'top'		=>	'<p>',
				'end'		=>	'</p>',
				'arr'		=>
				[
					't'							=>	$this->kxtpS1[ 'kx2_t_bar_block' ],
					'ids'						=>	kx_db0_Template_ID( $this->kxtpS1[ 'title' ].'≫2構成≫A' , $this->kxtpS1['index'] ),
					//'new_title'			=> $this->kxtpS1[ 'title' ].'≫2構成≫設計',
					'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
				],

			] );

			/*
			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kx',
				'top'		=>	'<p>',
				'end'		=>	'</p>',
				'arr'		=>
				[
					't'							=>	$this->kxtpS1[ 'kx2_t_bar_block' ],
					'cat'						=>	$this->kxtpS1[ 'cat_end' ],
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'tag_not'				=>	'≫来歴≫',
					'search'				=>	'≫2構成≫A',
					'title_s'				=>	'￥d＄',	//★注意
					'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
					'ppp'						=>	20,
				],

			] );
			*/

			$add_A1 = 'A1';
		}
		else
		{
			$add_A1 = '世界設定：A1';
		}

		$ret .= '<p>[kxedit t=78 new_title="'.$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫2構成≫A1" new="1" css_hyouji="'.$this->kxtpS1[ 'css_hyouji' ].'" hyouji="╋'.$add_A1.'"]</p>';
	}


	//存在しない場合、非表示。DB利用。
	$DB_B2_arr = kx_db0( [ 'title' => $this->kxtpS1[ 'kxtt' ][ 'world' ] .'≫c'. $num1 . '≫＼c'. $num2 .'≫B%' ] , 'Select_title'  );

	if( !empty( $DB_B2_arr ) && is_array( $DB_B2_arr ) )
	{

		for( $i = 0; $i <= 9; $i++) :

			$DB_B_NUM = kx_db0( [ 'title' => $this->kxtpS1[ 'kxtt' ][ 'world' ] .'≫c'. $num1 . '≫＼c'. $num2 .'≫B'. $i ] , 'Select_title'  );

			if( !empty( $DB_B_NUM) && is_array( $DB_B_NUM))
			{
				$_arr_B[] = $i;
				$_arr_B_ID[$i] = $DB_B_NUM[0]->id;
			}

		endfor;


		if( count( $_arr_B ) == 1 )
		{
			$_h3_add = $_arr_B[0];
			//$_title_Badd = preg_replace ( '/（第三者視点）/', '' 		, KxSu::get('title_kx10')[ $_arr_B[0] ] );
			//$_title_Badd = '&nbsp;'.preg_replace ( '/当人視点/'			, $name1 . '視点' , $_title_Badd );
			$_title_Badd = KxSu::get('title_kx10')[ $_arr_B[0] ];
		}
		else
		{
			$_h3_add = NULL;
			$_title_Badd = NULL;
		}

		//print_r( $_arr_B);

		$ret .= '<p>&nbsp;</p>';
		$ret .= '<h3>';
		$ret .= $this->kxtp_set_CharaMark( $num1 ).'B'.$_h3_add . '&nbsp;';
		$ret .= $_title_Badd;
		$ret .= '</h3>';
		//★問題箇所

		$ret .= kx_shortcode_print(
			[
			'name'	=>	'kx',
				'arr'		=>
				[
					't'							=>	65 ,
					'cat'						=>	$this->kxtpS1[ 'cat_end' ],
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
					'tag_not'				=>	'≫来歴≫',
					'search'				=>	'≫',
					'title_s'				=>	'＼c' . $this->kxtpS1[ 'c' ]	.	'＄',
					'text_c'				=>	$this->kxtpS1[ 'kxtt' ][ 'character_name' ] . '&nbsp;⇒&nbsp;' . $this->kxtpS1[ 'kxtt' ][ 'character_yobina' ]  . '（一覧）' ,
					'sys'						=>	$this->kxtpS1[ 'txx_sys' ],
					'new_content'	  =>	'＿raretu＿',
					'top'						=> '<p>',
					'end'						=> '</p>',
				],
			] );

			$ret .= '<p>&nbsp;</p>';





		foreach( $_arr_B as $_B_num ):

			//$_title_h4 = preg_replace ( '/（第三者視点）/', '' 			, KxSu::get('title_kx10')[ $_B_num ] );
			//$_title_h4 = preg_replace ( '/当人視点/'			, $name1 . '視点' , $_title_h4);
			$_title_h4 = KxSu::get('title_kx10')[ $_B_num ] ;

			if( count( $_arr_B ) != 1 )
			{
				$ret .= '<h4>' . $this->kxtpS1[ 'CharaMark' ][ $num1 ] .$_B_num . '&nbsp;' . $_title_h4 .'：＜'	.	$name1	.	'＞</h4>';//＜'	.	$name1	.	'＞：
			}

			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kx',
				'top'		=>	'<div>',
				'end'		=>	'</div>',

				'arr'		=>
				[
					't'							=>	$this->kxtpS1[	'kx2_t_bar_block'	],
					'ids'						=>	kx_db0_Template_ID( $_title.'≫B'.$_B_num  , $_index ),
					'ppp'						=>	20,
					'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
				],
			] );

		endforeach;
		unset( $id );

		/*
		foreach( $_arr_B as $_B_num ):

			//$_title_h4 = preg_replace ( '/（第三者視点）/', '' 			, KxSu::get('title_kx10')[ $_B_num ] );
			//$_title_h4 = preg_replace ( '/当人視点/'			, $name1 . '視点' , $_title_h4);
			$_title_h4 = KxSu::get('title_kx10')[ $_B_num ] ;

			if( count( $_arr_B ) != 1 )
			{
				$ret .= '<h4>' . $this->kxtpS1[ 'CharaMark' ][ $num1 ] .$_B_num . '&nbsp;' . $_title_h4 .'：＜'	.	$name1	.	'＞</h4>';//＜'	.	$name1	.	'＞：
			}

			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kx',
				'top'		=>	'<div>',
				'end'		=>	'</div>',

				'arr'		=>
				[
					't'							=>	$this->kxtpS1[	'kx2_t_bar_block'	],
					'cat'						=>	$this->kxtpS1[ 'cat_end' ],
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'tag_not'				=>	'≫来歴≫',
					'search'				=>	$num1.'≫＼c'	.	$num2	.	'≫B'.$_B_num,
					'ppp'						=>	20,
					'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
				],
			] );

		endforeach;
		*/

		$_B2_nbsp = '<p>&nbsp;</p>';
		$add_B2 	= 'B2';

	}
	else
	{
		$add_B2		= '対人統合設定：B2';
		$_B2_nbsp	= NULL;
	}

	$ret .= '<p>[kxedit t=78 new_title="'.$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$num1.'≫＼c'	.	$num2	.	'≫B2" new="1" css_hyouji="'.$this->kxtpS1[ 'css_hyouji' ].'" hyouji="╋'.$add_B2.'"]</p>';
	$ret .= $_B2_nbsp;

	return	$ret;

}


/**
 * Situation。Ksy、Ygsの分岐。
 *
 * @param [type] $num1
 * @param [type] $num2
 * @param [type] $name
 * @param [type] $arr
 * @return void
 */
public function kxtp_block_situation_series( $num1 , $num2 , $name , $arr ){

	$ret = NULL;

	//ヒロイン・主人公判定。
	if( $this->kxtpS1[ 'kxtt' ][ 'character_number' ]	!= $num1 )
	{
		$taijin = 1;
	}

	foreach( $arr as $_v ):

		if( !empty( $taijin ) )
		{
			$CM_num 		= $this->kxtpS1[ 'c' ];
			$_DB_title 	= $this->kxtpS1[ 'title_taijin' ] .	'≫';
			$_index = $this->kxtpS1['index_t'];
		}
		else
		{
			$CM_num 		= $num1;
			$_DB_title 	= $this->kxtpS1[ 'title' ] .'≫＼c'	.	$num2	.	'≫';
			//$_DB_title 	= $this->kxtpS1[ 'title' ].'≫＼c'.$this->kxtpS1[ 'c' ];
			$_index = $this->kxtpS1['index_c'];
			//echo $this->kxtpS1[ 'title' ] .'≫＼c'	.	$num2	.	'≫';
			//echo '<br>';
		}


		if(	$_v[0] == 'O')
		{
			$_v[0]	= 'K';
			$_title_ksy_ygs = 'Ksy';
		}
		elseif(	$_v[0] == 'K')
		{
			$_title_ksy_ygs = 'Ksy';
		}
		elseif(	$_v[0] == 'Y')
		{
			$_title_ksy_ygs = 'Ygs';
		}
		else
		{
			$_title_ksy_ygs = NULL;
		}

		//Ksy・Ygsの判定
		$DB_h112_arr = kx_db0( [ 'title' => $this->kxtpS1[ 'title_base' ] .'≫2構成≫〇h112' . mb_strtolower( $_title_ksy_ygs ) ] , 'Select_title'  );


		if( empty( $title_add) )
		{
			$title_add = NULL;
		}


		if( !empty( $DB_h112_arr) && is_array( $DB_h112_arr) )
		{
			$ret .= '<h3>' . $this->kxtpS1[ 'CharaMark' ][ $CM_num ] . ' ' . $_title_ksy_ygs . $title_add .'：＜'	.	$name	.	'＞</h3>';//＜'	.	$name	.	'＞：

			$ret .= kx_CLASS_SCP(
			[
				[
					'name'	=>	'kxedit',
					'top'		=>	'<p>',
					'end'		=>	'</p>',
					'arr'		=>
					[
						'new_title'  => $this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$num1.'≫＼c'	.	$num2	.	'≫' . ucfirst($_v[0] ) . '3',
						'new' 			 => 1 ,
						'css_hyouji' => $this->kxtpS1[ 'css_hyouji' ],
					],
				],
			] );

			//echo $_DB_title.'<hr>';

			for($i = 0; $i <= 9; $i++):
				$DB_KY_NUM = kx_db0( [ 'title' => $_DB_title . $_v[0] . $i ] , 'Select_title'  );

				if( !empty( $DB_KY_NUM ) && is_array( $DB_KY_NUM ))
				{
					//$_title_h4 = preg_replace ( '/（第三者視点）/', '' 			       , KxSu::get('title_kx10')[$i] );
					//$_title_h4 = preg_replace ( '/当人視点/'			, $name . '視点' , $_title_h4 );
					//echo $_DB_title.'≫'.$_v[0].$i;
					//echo '<br>';
					$_title_h4 = KxSu::get('title_kx10')[$i];

					$ret .= '<h4>' . $this->kxtpS1[ 'CharaMark' ][ $CM_num ] .$_v[0] . $i . '&nbsp;' . $_title_h4 .'：＜'	.	$name	.	'＞</h4>';//＜'	.	$name	.	'＞：

					$ret .= kx_shortcode_print(
					[
						'name'	=>	'kx',

						'arr'		=>
						[
							't'							=>	18,
							'ids'						=>	kx_db0_Template_ID( $_DB_title.$_v[0].$i , $_index ),

							/*
							'cat'						=>	$this->kxtpS1[ 'cat_end' ],
							'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ] ,
							'tag_not'				=>	'≫来歴≫',
							'search'				=>	$num1.'≫＼c'	.	$num2	.	'≫'.$_v[0].$i ,
							*/

							//'text_add'			=>	'（'	.	$chara_name	.	'）',
							'sys'						=>	$this->kxtpS1[ 'txx_sys' ] ,
							'ppp'						=>	20,
						],
					], );
				}

			endfor;

			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kxedit',
				'top'		=>	'<p>',
				'end'		=>	'</p>',
				'arr'		=>
				[
					'new_title'  => $this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$num1.'≫＼c'	.	$num2	.	'≫' . ucfirst( $_v[0] ) . '3',
					'new' 			 => 1 ,
					'css_hyouji' => $this->kxtpS1[ 'css_hyouji' ],
				],
			] );
		}// DB

	endforeach;

	return	$ret;
}



/**
 * 物語構成。2構成。短編。
 * 2023-09-10
 *
 * @return void
 */
public function kxtp_block_kousei2(){


	$arr_plot1 =
	[
		'Ksy',
		'Ygs',
	];

	$arr_plot2 =
	[
		//[	'物語概要'     , ''		  , '概要' ],
		'w502' => [	''		         , 'w502' , ''	   ],
		'w112' => [	''		         , 'h112'	, ''	   ],
		'w582' => [	''	           , 'w582' , ''		 ],
		'w592' => [	''	           , 'w592' , ''		 ],
		'進行' => [	'進行Ⅱ'       , ''     , '進行'		 ],
		'筋書' => [	'筋書'         , ''     , '筋書' ],

		//'確認' => [	'確認' , ''     , '確認'		 ],
		//[	''             , ''     , 'A'		 ],
		//[	'B.開放・オチ' , ''     , 'B'	 	 ],
	];

	if( $this->kxtpS1[ 'type' ] == 'k3' )
	{
		unset($arr_plot2['筋書'] );

		preg_match( '/Ksy|Ygs|Olf/' , $this->kxtpS1[ 'title' ] , $matches, );

		$arr_plot1 = [ $matches[0] ];

		$_kakunin = kx_CLASS_SCP(
		[
			[
				'arr_search'	=>
				[
					[	'search' => '∬10≫0構成≫〇a911' ],
					[	'search' => '∬10≫0構成≫〇b111' ],
					[	'search' => '∬10≫0構成≫〇b311' . $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] ],

					'arr_base'	=>
					[
						'name'	=>	'kx',
						'top'		=>	'<p><div style="margin:0 0 0em 0;">',
						'end'		=>	'</div></p>',
						'arr'		=>
						[
							't'	  =>	$this->kxtpS1[ 'kx3_t' ],
							'sys'	=>	'30width70',
						],
					],
				],
			],
		] );
	}
	else
	{
		$_kakunin = '';
	}

	$ret = '';

	foreach(	$arr_plot1 as $v1	):

		$this->kxtpS1['index_SG'] = kx_db0_Template_Base(	['title' => $this->kxtpS1[ 'title_base' ].'≫'.$v1.'%%%≫進行概要' ]  );
		//var_dump($this->kxtpS1['index_SG']);


		//Ksy・Ygsの判定
		$DB_h112_arr = kx_db0( [ 'title' => $this->kxtpS1[ 'title_base' ] .'≫2構成≫〇h112' . mb_strtolower( $v1 ) ] , 'Select_title'  );

		if( !empty( $DB_h112_arr) && is_array( $DB_h112_arr) )
		{
			$ret .= '<h2>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'進行Ⅱ・'.$v1.'</h2>';

			$ret .= $_kakunin;

			foreach(	$arr_plot2 as $v2	):

				if( $v2[0] )
				{
					$ret .= '<h3>'. $this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ]  .	$v1	.	'・'.$v2[0]	.		'</h3>';
				}


				if( $v2[1] )
				{
					if( $v2[1] == 'h112' )
					{
						$_ksy_yag = mb_strtolower( $v1 );
					}
					else
					{
						$_ksy_yag = null;
					}

					$ret .= '<p>';

					$ret .= kx_shortcode_print(
					[
						'name'	=>	'kx',

						'arr'		=>
						[
							't'							=>	30,
							'cat'						=>	$this->kxtpS1[ 'cat_end' ]	,
							'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
							'tag_not'		    =>	'≫来歴≫',
							'search'				=>	'≫2構成≫〇'.$v2[1].$_ksy_yag,
						],

					] );

					$ret .= '</p>';
					$ret .= '<p></p>';
				}


				if( $v2[2] )
				{
					$_title = $this->kxtpS1[ 'title_base' ].'≫2構成≫'.$v1.'進行';
					$this->kxtpS1['index_2a-e'.$v1] = kx_db0_Template_Base(	['titles' =>
					[
						$_title.'A',
						$_title.'B',
						$_title.'C',
						$_title.'D',
						$_title.'E',
					]
				]  );
				unset( $_title);

					//$this->kxtpS1['index_a-e'] = kx_db0_Template_Base(	['title' =>$this->kxtpS1[ 'title' ].'≫a'] );

					if( $v2[0]  == '進行Ⅱ' && !empty($this->kxtpS1['index_2a-e'.$v1]) )
					{

						//foreach( [ '進行','進行A','進行B','進行C','進行D','進行E','進行F','進行G','進行H','進行I','進行J'] as $_value3):
						$ret2 ='';
						foreach($this->kxtpS1['index_2a-e'.$v1] as $value):

							$_ids_2ae[]=$value->id;
							$_title = get_the_title($value->id);
							$_title = end(explode('≫',$_title));

							$ret2 .= kx_shortcode_print(
							[
								'name'	=>	'kx',
								'top'		=>	'<h4>'. $_title .'</h4>',
								'end'		=>	'',

								'arr'		=>
								[
									't'							=>	18,
									'id'						=>	$value->id,
								],
							], );

							/*
							$DB_KY_NUM = kx_db1( [ 'title' => $this->kxtpS1[ 'title_base' ] .'≫2構成≫'.$v1.$_value3 ] , 'Select_title' );
							if( !empty( $DB_KY_NUM) && is_array( $DB_KY_NUM))
							{

								if( $_value3 != '進行')
								{
									$ret .= '<h4>'. str_replace( '進行' , 'Ⅱ' , $_value3) . '</h4>';
								}

								$ret .= kx_shortcode_print(
									[
										'name'	=>	'kx',

										'arr'		=>
										[
											't'							=>	18,
											'id'						=>	$DB_KY_NUM ['result'] [0]->id,
										],
									], );
							}*/

						endforeach;

						$ret .= '<div class="_op_a" style="text-align:right;">▽書き出し</div><div class="_op_z __background_normal" style="padding:5px;z-index:2;text-align:left;right:0;">';
						$ret .= '▽書き出し：';
						$ret .= get_the_title( $this->kxtpS1['id_sc'] );
						$ret .= '<hr>';
						$ret .= kx_render_export_text_button( $_ids_2ae ,$this->kxtpS1['id_sc'] ,null,'simple');
						$ret .= '</div>';

						$ret .= kx_CLASS_SCP(
							[
								[
									'name'	=>	'kx',
									'top'		=>	'<p>&nbsp;</p>',
									'arr'		=>	[

										't'							=>$this->kxtpS1[ 'kx2_t_bar_block' ],
										'cat'						=>	$this->kxtpS1[ 'cat_end' ],
										'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
										'tag_not'		    =>	'≫来歴≫',
										'search'				=>	'≫2構成≫'.$v1.$v2[2],
										'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
									],
								],
							]);

						$ret .= $ret2;
						unset($ret2);


						$ret .= kx_CLASS_SCP(
							[
								[
									'name'	=>	'kxedit',
									//'end'		=>	'<p>■POST確認</p>',
									'arr'		=>	[
										'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫2構成≫'.$v1.$v2[2],
										'new'						=>	1,
										'css_hyouji'		=>	$this->kxtpS1[ 'css_hyouji' ],
										'hyouji'				=>	'＋'.$v1.$v2[2],
									],
								],

								/*
								[
									'name'	=>	'kx',

									'arr'		=>	[

										't'							=>	29,//96,
										//'t'							=>$this->kxtpS1[ 'kx2_t_bar_block' ],
										'cat'						=>	$this->kxtpS1[ 'cat_end' ],
										'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
										'tag_not'		    =>	'≫来歴≫',
										'search'				=>	'≫2構成≫'.$v1.$v2[2],
										'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
									],
								],
								*/

							] );

					}

					else
					{
						$ret .= kx_CLASS_SCP(
						[
							[
								'name'	=>	'kx',
								'top'		=>	'<p>&nbsp;</p>',
								'arr'		=>	[

									't'							=>$this->kxtpS1[ 'kx2_t_bar_block' ],
									'cat'						=>	$this->kxtpS1[ 'cat_end' ],
									'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
									'tag_not'		    =>	'≫来歴≫',
									'search'				=>	'≫2構成≫'.$v1.$v2[2],
									'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
								],
							],

							[
								'name'	=>	'kxedit',
								'arr'		=>	[
									'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫2構成≫'.$v1.$v2[2],
									'new'						=>	1,
									'css_hyouji'		=>	$this->kxtpS1[ 'css_hyouji' ],
									'hyouji'				=>	'＋'.$v1.$v2[2],
								],
							],


						] );
					}



				}
			endforeach;
		}

		if( !empty($this->kxtpS1['index_SG']))
		{
			$ret .= '<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ]. $v1 . '・進行ⅲ</h3>';

			$ret2 = '';
			foreach($this->kxtpS1['index_SG'] as $value)
			{
				//$ret .= '++'.$value->id;
				//$ret .=  '<hr>';
				$_ids_SG[] = $value->id;

				$_title = get_the_title($value->id);
				preg_match('/≫((Ksy|Ygs)(\d{3}))≫/',$_title ,$matches);
				$ret2 .= kx_shortcode_print(
				[
					'name'	=>	'kx',
					'top'		=>	'<h4>'. $matches[1] .'</h4>',
					'end'		=>	'',

					'arr'		=>
					[
						't'							=>	18,
						'id'						=>	$value->id,
					],
				], );

			}
			$ret .= '<div class="_op_a" style="text-align:right;">▽書き出し</div><div class="_op_z __background_normal" style="padding:5px;z-index:2;text-align:left;right:0;">';
			$ret .= '▽書き出し：';
			$ret .= get_the_title( $this->kxtpS1['id_sc'] );
			$ret .= '<hr>';
			$ret .= kx_render_export_text_button( $_ids_SG ,$this->kxtpS1['id_sc']);
			$ret .= '</div>';
			$ret .= $ret2;
		}




	endforeach; //Ksy,Ygs


	return $ret;
}



/**
 * 物語構成。3構成。
 * 2023-09-10
 *
 * @return void
 */
public function kxtp_block_kousei3(){

	$ret = '';

	$ret .= kx_CLASS_SCP(
	[
		[ 'title_on'	=>	'<h2>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .	'〘3構成〙</h2>' ],

		[
			'arr_search'	=>
			[
				[	'search' => $this->kxtpS1[ 'kxtt' ][ 'world'].'≫0構成≫〇a911' ],
				[	'search' => $this->kxtpS1[ 'kxtt' ][ 'world'].'≫0構成≫〇b111' ],
				[	'search' => $this->kxtpS1[ 'kxtt' ][ 'world'].'≫0構成≫〇b311' . $this->kxtpS1[ 'kxtt' ][ 'work_code_top3' ] ],

				'arr_base'	=>
				[
					'name'	=>	'kx',
					'top'		=>	'<p><div style="margin:0 0 0em 0;">',
					'end'		=>	'</div></p>',
					'arr'		=>
					[
						't'	  =>	$this->kxtpS1[ 'kx3_t' ],
						'sys'	=>	'30width70',
					],
				],
			],
		],
	] );


	if(	preg_match('/^3/'	, $this->kxtpS1[ 't' ]	) )
	{
		$ret .= '短編型・二構成なし';
	}

	$ret .= '<p>&nbsp;</p>';

	$arr_plot	=
	[
		[ 'ⅲ概要'		       , 'w503'	,	''     ,''],
		[ ''				 		    , 'h113' , ''		  ,''],
		[ ''				 		    , 'w583' , ''		  ,''],
		[ ''				 		    , 'w593' , ''		  ,''],
		[ '進行概要'	      , ''		 , '進行概要' ,''],
		//[ '筋書'	          , ''		 , '筋書' ,''],

		//[ 'ⅲa' , ''     ,	'a'		 ,'<p>&nbsp;</p>'	],
		//[ 'ⅲb' , ''     ,	'b'		 ,'<p>&nbsp;</p>'	],
		//[ 'ⅲc' , ''     ,	'c'		 ,'<p>&nbsp;</p>'	],
		//[ 'ⅲd' , ''     ,	'd'		 ,'<p>&nbsp;</p>'	],
		//[ 'ⅲe' , ''     , 'e'		 ,'' ],
	];

	$this->kxtpS1['index_a-e'] = kx_db0_Template_Base(	['titles' =>
		[
			$this->kxtpS1[ 'title' ].'≫a',
			$this->kxtpS1[ 'title' ].'≫b',
			$this->kxtpS1[ 'title' ].'≫c',
			$this->kxtpS1[ 'title' ].'≫d',
			$this->kxtpS1[ 'title' ].'≫e',
		]
	]  );
	//var_dump($this->kxtpS1['index_SG']);
	//$this->kxtpS1['index_a-e'] = kx_db0_Template_Base(	['title' =>$this->kxtpS1[ 'title' ].'≫a'] );

	foreach( $arr_plot as $v ):

		if(	$v[0]	)
		{
			$ret .= '<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .$v[0].'</h3>';
		}

		if($v[1] )
		{
			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kx',
				'top'		=>	'<p>',
				'end'	=>	'</p><p></p>',
				'arr'		=>
				[
					't'							=>	$this->kxtpS1[ 'kx3_t' ],
					'cat'						=>	$this->kxtpS1[ 'cat_end' ]	,
					'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
					'tag_not'	    	=>	'≫来歴≫',
					'search'				=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫〇'.$v[1],
				],
			] );
		}


		if(	!empty( $v[2] ) )
		{
			if( empty( $v[3] ) )
			{
				$v[3] = NULL;
			}

			$ret .= kx_CLASS_SCP(
			[
				[
					'name'	=>	'kx',
					'top'		=>		$v[3].'<div style="margin:0 0 0 20px;">'		,
					'end'		=>		'</div>'		,
					'arr'		=>
					[
						'ppp'           => 20,
						't'							=>	$this->kxtpS1[ 'kx2_t_bar_block' ],
						'cat'						=>	$this->kxtpS1[ 'cat_end' ],
						'tag'						=>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,
						'tag_not'	    	=>	'≫来歴≫',
						'search'				=>	'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫'.$v[2],
						'sys'						=>	$this->kxtpS1[ 'txx_sys' ].$this->kxtpS1[ 't2x_sys' ].',floor_on',
					],
				],

				[
					'name'	=>	'kxedit',
					'arr'		=>
					[
						't'							=>	78,
						'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫'.$v[2],
						'new'						=>	1,
						'css_hyouji'		=>	$this->kxtpS1[ 'css_hyouji' ],
						'hyouji'				=>	'＋'.$v[2] ,
					],
				],
			] );
		}

	endforeach;

	$_add_a_e = kx_shortcode_print(
	[
		'name'	=>	'kxedit',
		'arr'		=>
		[
			't'							=>	78,
			'new_title'			=>	$this->kxtpS1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫'.$this->kxtpS1[ 'kxtt' ][ 'work_code' ].'≫a',
			'new'						=>	1,
			'css_hyouji'		=>	$this->kxtpS1[ 'css_hyouji' ],
			'hyouji'				=>	'＋a-e' ,
		],
	], );


	$ret .= '<h3>'.$this->kxtpS1[ 'CharaMark' ][ $this->kxtpS1[ 'kxtt' ][ 'character_number' ] ] .'進行a-e</h3>';
	//$ret .= '<h3>進行a-e</h3>';
	$ret .= $_add_a_e;

	if( !empty($this->kxtpS1['index_a-e']))
	{
		foreach($this->kxtpS1['index_a-e'] as $value)
		{
			//$ret .= '++'.$value->id;
			//$ret .=  '<hr>';
			$_title = get_the_title($value->id);
			$_title = end(explode('≫',$_title));
			$ret .= kx_shortcode_print(
			[
				'name'	=>	'kx',
				'top'		=>	'<h4>'. $_title .'</h4>',
				'end'		=>	'',

				'arr'		=>
				[
					't'							=>	18,
					'id'						=>	$value->id,
				],
			], );
		}
		$ret .= $_add_a_e;
	}
	else
	{
		$ret .= '<p>NO/a-e</p><hr>';
	}

	return $ret;
}




/**
 * Undocumented function
 *
 * @return void
 */
public function kxtp_block_array($num,$type_select = null){

	$ret = '';

	if( $num ==1 && ((!empty($type_select) && preg_match('/sh/', $type_select ) )|| empty($type_select)) )
	{

		$ret =
		[
			'select'				=>	[ '='	=>	'/sMain|sh/'	],
			'name'	=>	'kx',
			'top'		=>	'<h3>設計ⅡS</h3><p>'	,
			'end'		=>	'</p><p>&nbsp;</p>',
			'arr'		=>	[
				't'							=>	60,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'tag'						=>	'c'.	$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
				'tag_not'				=>	'≫来歴≫',
				'search'				=>	'≫2構成≫s0＠設計Ⅱ作品',
			],
		];
	}
	elseif($num == 2 && ((!empty($type_select) && preg_match('/sh/', $type_select ) )|| empty($type_select)) )
	{
		$ret =
		[
			'select'				=>	[ '='	=>	'/sMain|sh/'	],
			'name'	=>	'kx',
			//'top'		=>	'<h4>設計ⅡSR</h4><p>'	,
			'end'		=>	'<p>&nbsp;</p>',//</p>
			'arr'		=>	[
				't'							=>	19,
				'cat'						=>	$this->kxtpS1[ 'cat_end' ],
				'tag'						=>	'c'.	$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
				'tag_not'				=>	'≫来歴≫',
				'search'				=>	'≫2構成≫',
				'title_s'				=>	'Series＄',
				'new_content'	=>	'＿raretu tougou=＿',
			],
		];
	}

	return $ret;

}


/**
 * その他キャラ
 *
 * @param [type] $cs
 * @return void
 */
public function kxtp_block_chara_etc(){

	return	$this->kxtpS1[ 'etc_chara' ];
}


/**
 * DBlistの表示。
 *
 * 2022-06-09
 *
 * @return void
 */
public function kxtp_block_DB_List( $args ){

	$this->kxtpS1[ 'kxcl' ] = kx_CLASS_kxcl( $this->kxtpS1[ 'title' ] , 'kxx' );

	$_style0  =	'style="visibility:hidden;height:20px;"';

	$_style1  =	'margin-bottom:4px;height:10px;border:solid 2px ' . $this->kxtpS1[ 'kxcl' ][ 'hsla_normal'] . ';';
	$_style1 .=	'background-color: hsla(' . $this->kxtpS1[ 'kxcl' ][ '色相'] . '	,100%		,50% , .2);';
	$_style1 .=	'border-radius:5px;opacity:.4;';

	$ret = '';

	foreach( $args  as $id => $_date ):

		$title_h2 = get_the_title( $id );

		if( !empty( $id ) && !preg_match( '/00.*概要$/' , $title_h2 ) )
		{
			$ret .= '<div '.$_style0.'>';

			if( $_date != 'n/a' && empty( $_date ))
			{
				$ret .=  '<h2>'. substr($_date , 0 , 4 ) . '-' . end( explode('≫', $title_h2 ) ) .'</h2>';
			}
			else
			{
				$ret .=  '<h2>'. end( explode('≫', $title_h2 )) . '</h2>';
			}

			$ret .= '</div>';
			$ret .= '<div style="'.$_style1.'">';
			$ret .= '</div>';


			if( empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
			{
				$ret .= kx_CLASS_kxx( [
					't'  =>	12,
					'id' =>	$id ,
				] );
			}
		}

	endforeach;

	return $ret;
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpN_DB_test(){
	echo 'DB_Template';
	echo '：';
	echo $this->kxtpS1[ 'title' ];
	echo '<hr>';
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtpDB_chara_list_maru2(){

	$ret = '';
	$ret .= '<p>〇</p>';

	$ret .= kx_CLASS_kxx(
	[
		't'				=>	32,
		'cat'			=>	$this->kxtpS1[ 'cat_end' ],
		'tag'			=>	'"〇 c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'"',
		'search'	=>	'2構成≫〇',
		'ppp'			=>	'999',
		'sys'			=>	'delete',
	] );

	$ret .= '<p>&nbsp;</p>';
	$ret .= '■作品系';

	$ret .= kx_CLASS_kxx(
	[
		't'				=>	32,
		'cat'			=>	$this->kxtpS1[ 'cat_end' ],
		'tag'			=>	'"〇 c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'"',
		'search'	=>	'\w{3}\d{3,}≫〇',
		'ppp'			=>	'999',
		'sys'			=>	'delete,new_off',
	] );

	$ret .= '<p>&nbsp;</p>';
	$ret .= '■対人系(p152)';

	$ret .= kx_CLASS_kxx(
	[
		't'				=>	32,
		'cat'			=>	$this->kxtpS1[ 'cat_end' ],
		'tag'			=>	'"〇 c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'"',
		'search'	=>	'＼c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'≫〇',
		//'search'	=>	'p152',


		'ppp'			=>	'999',
		'sys'			=>	'delete,new_off',
	] );


	$ret .= '<p>&nbsp;</p>';


	$ret .= kx_CLASS_kxx(
	[
		't'				=>	90,
		'cat'			=>	$this->kxtpS1[ 'cat_end' ],
		'tag'			=>	'"〇 c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ].'"',
		'ppp'			=>	'999',
		'sys'			=>	'delete',
	] );


	//∬10≫c1zz0≫＼c001≫〇


	//return	'+++';
	return	$this->kxtpS1[ 'display'].$ret;

	//echo $ret;

}



/**
 * キャラクターファイル・一覧
 * list_chara_all
 *
 * @return void
 */
public function kxtpDB_chara_list_all2(){

	$ret  = '';

	$arr	=
	[
		'ALL'		=> [	90	,$this->kxtpS1[ 'kxtt' ][ 'world'].'≫c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,''		],
		'対人'	=> [	90	,$this->kxtpS1[ 'kxtt' ][ 'world'].'≫c.*≫＼c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ]	,''		],
		'作品'	=> [	96	,'(ksy|olf|ygs|sys)\d{3,}$'	,''		],
	];

	$_s	= 0;
	//$ret = NULL;
	foreach(	$arr as $_k => $_v):

		$_s++;

		$_SESSION[ 'Heading' ][ 'n' ][ $_s ]	=
		[
			'h_x'			=>	2,
			'daimei'	=>	$_k,
		];

		$ret .= '<h2 id=kxanchor'.$_s.'>'.$_k.'</h2>';

		$ret .= kx_CLASS_kxx(
		[
			't'			 =>	$_v[0],
			'cat'		 =>	$this->kxtpS1[ 'cat_end' ],
			'tag'		 =>	'c'.$this->kxtpS1[ 'kxtt' ][ 'character_number' ],
			'search' =>	$_v[1],
			'ppp'		 =>	'999',
			'sys'		 =>	'delete',
		] );

		$ret .= '&nbsp';

	endforeach;

	return	$this->kxtpS1[ 'display' ] . $ret;
}



/**
 * キャラクターファイル・一覧
 * list_chara_all
 *
 * @return void
 */
public function kxtpDB_raretu(){

	$kxra = new raretu;
	return $kxra->kxra_Main( $this->kxtpS1);

}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxtp_ERROR( $type , $line , $memo = NULL ){

	$this->kxtpError[ 'type' ] 	 = $type;
	$this->kxtpError[ 'string' ] = '■ERROR■'.__FUNCTION__.'■'.__LINE__.'■';

	$this->kxtpError[ 'string' ]  = kx_CLASS_error(
	[
		'type'				=>	$type,
		'Memo'				=>	$memo,
		'Title'				=>	$this->kxtpS1[ 'title' ],
		'LINE'				=>	$line ,
		'error_type'	=>	'output',
	] );
}

} //class_end