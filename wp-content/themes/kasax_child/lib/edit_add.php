<?php

use Kx\Utils\Time;

/**
 * 編集 class
 */
class kxed {

//public $kxedS0;

/**
 * null設定⇒基本設定値。
 * null以外の設定はショートコード要素に上書きされてしまうので注意。
 * 2023-09-05
 *
 * @var array
 */
public $kxedS1 =
[
	'test'					=> 'TEST_S0_BASE_OK（準備）' ,

	//↓sc値。nullのみ。
	'id'						=> '',
	'id_js'					=> '',
	'sys'						=> '',
	'title'					=> '',
	//'number'			=> '',
	'new'						=> NULL ,
	'new_title'			=> '',
	'new_content'		=> '',
	'hyouji'				=> '',
	'hyouji_style'	=> '',
	'css_hyouji'		=> NULL,
	//'css_bg'				=> '',
	//↑sc値

	'type'          => NULL,

	'width_hyouji'	=> NULL,
	'reference_on'  => NULL,
	'memo'					=> 'N/A',
	'count_content' => NULL,

	'ghost_on'      => NULL,
	'id_ghost'			=>	NULL,
	'rtl'						=> NULL,

	'kxcl'          =>
	[
		'bg_t'  => NULL,
		'bg_ga' => NULL,
		'bg_a'  => NULL,
		'bg_z'  => NULL,
	],

	'yomikomi_on'		     => 1,	//jq読み込み
	'short_code_form_on' => 0,
	'content_form_on'		 => 1,
	'content_height_on'	 => 1,
];

/**
 * 各種設定。
 *
 * @var array
 */
public $kxedSetting =
[
	'Drawer_top_style' => 'font-size:10.5pt; direction: ltr; color:#fff; z-index:4; text-align:left;',//leftwidth:900px;
	'Top_bar_style'		 => 'margin:0 0 0px 0px;',

	'style_base_a'		 => 'padding:0 5px 0 5px;margin:0 0 0 0;',	//$sb_a
	'style_base_z'		 => 'border:3px solid black;padding:4px;',	//$sb_z

	//↓一箇所だけかも。
	'style2g' 	       => 'direction:ltr;border-bottom:3px solid red;margin:0 0 0px 0px;padding:0 5px 10px 5px;',

	//↓一箇所だけかも。
	'style2g_z'        => 'padding:0 5px 0 5px;',//width:890px;

	'sbi'							 => 'height:1.33em;display:block;text-align:left;',
	//'sbi_w'	              => 'width:840px;',

	'hyouji_new'			 => '╋ADD',
	'hyouji_edit'			 => '　Edit',
	'yomikomi'         => '/^(∬|∫|κ|∮)/',	//読み込み型。

	//↓高さ。コンテンツの行数カウント。
	'count_cont'       => 45,


];


//可変設定。ベース。
public $kxedOUT	=
[
	'TEST' 													=> 'TEST_M_OK（設定作業前状態）',

	'Button_on'									=> NULL,
	'Reference'									=> NULL,

	'shortCODE_type'						=> NULL,
	'shortCODE_string'					=> NULL,

	'base_titles' 							=> NULL,

	'class_TextArea'						=> NULL,

	'url'												=> NULL,

	'MAIN_Title_hidden_class'	  => NULL,

	'MAIN_ShortCODE_class'	    => NULL,

	'class_OpenButton'					=> ' __a_hover',
	'style_OpenButton'					=> 'font-weight:bold; text-align:right; display:inline-block; direction:ltr; padding:0 0px 0 0; cursor:pointer;',

	'class_TopBAR_FloatR_all'		=> '__edit_add_top_ __float_right2 __hover_div __a_white __text_shadow_black1 __edit __text_right __color_gray66 __radius_10 __back_gray_op01',
	'style_TopBAR_FloatR_all'		=> 'width:830px;',//変更、延長。2023-10-28
	'class_TopBAR_FloatR_span'	=> '__color_white __text_shadow_black1',
	'style_TopBAR_FloatR_span'	=> 'width: 100px;text-align: right;font-size:small;',

	'class_TopBAR_Left_span'		=> NULL,
	'TopBAR_Left_name'					=> 'Err.',

	'TopBAR_LinkLIST'    				=> NULL,

	'style_main_button'					=> 'text-align:center;',	//$style3b


	'style_MAIN_Content'				=> NULL,

	'MAIN_Content_hidden_class'	=> NULL,
	'style_MAIN_Content_hidden'	=> '',

	'hyouji_add' => NULL,
];


//Judge
public $kxedJUDGE =
[
	'new_on' =>
	[
		'/./' =>
		[
			'new_attention' 	 => NULL,
			'class_OpenButton' => ' __radius_l_10',
		],


		'/1/' =>
		[
			'new_attention' 	 => '<span style="color:red;font-weight:bold;">　───　NEW　───　</span>',
			'class_OpenButton' => ' __radius_10',
		] ,
	],

	'chara_count' =>
	[ 'array' =>
		[
			'0' =>
			[
				'preg' 			=> '/./' ,
				'settings'	=>
				[
					'style_OpenButton_add' 	=> '',
				],
			],

			[
				'preg' 			=> '/(2|3)$/' ,
				'settings'	=>
				[
					'style_OpenButton_add' 	=> '',
				],
			],

			[
				'preg' 			=> '/4$/' ,
				'settings'	=>
				[
					'style_OpenButton_add' 	=> 'margin-top:3px;padding-top:3px;max-width:65px; height:1.3em; white-space: nowrap;  overflow-x: hidden; overflow-y: hidden;',
				],
			],
		],
	],
];


/**
 * エディターメイン。
 *
 * @param [type] $args
 * @return void
 */
public function kxed_Main( $args ){

	//各種設定
	$this->kxedS1 = $args + $this->kxedS1;

	$this->kxed_setting_base();
	$this->kxed_setting_color();

	if( !empty( $this->kxedS1[ 'new' ] ) )
	{
		//新規
		$this->kxed_setting_New();
	}
	else
	{
		//newではない
		$this->kxed_setting_Edit();
		$this->kxedS1[ 'new' ] =0;
	}

	$this->kxedOUT[ 'J' ][ 'new' ] = kx_Judge( $this->kxedJUDGE[ 'new_on' ]   , $this->kxedS1[ 'new' ] );

	$this->kxed_setting_OUT();

	//上段BARの設定。
	$this->kxed_setting_top();

	//参照。2023-09-06
	if( !empty( $this->kxedS1[ 'reference_on' ] ) )
	{
		$this->kxed_setting_reference();
	}

	//編集ボタン
	$this->kxed_setting_Edit_Button();




	//表示開始script。2023-09-06
	include  __DIR__ .'/jq/edit_template_form.php';


	//top_bar。'content_main'より上。2023-09-06
	 //$this->kxedOUT[ 'Reference' ] =1;
	 //echo $this->kxedOUT[ 'Reference' ] ;
	 //$this->kxedOUT[ 'Reference' ] =1;
	ob_start();
	include  __DIR__ .'/html/edit_main_topbar.php';
	$this->kxedOUT[ 'top_bar' ]	= ob_get_clean();
	//return $ret;

	//メインコンテンツ。2023-09-05
	ob_start();
	include  __DIR__ .'/html/edit_main.php';
	$this->kxedOUT[ 'content_main'] =  ob_get_clean();


	//最終出力。2023-09-06
	if( !empty( $this->kxedS1[ 'kx30_on' ] ) )
	{
		//配列型。2023-09-05
		ob_start();
		include  __DIR__ .'/html/edit_kx30a.php';
		$_kx30a = ob_get_clean();

		ob_start();
		include  __DIR__ .'/html/edit_kx30b.php';
		$_kx30b = ob_get_clean();

		return
		[
			$_kx30a ,
			$_kx30b ,
		];
	}
	else
	{
		//通常型。2023-09-05
		ob_start();
		include  __DIR__ .'/html/edit_kx10.php';
		return ob_get_clean();
	}
}



/**
 * 基本設定
 *
 * @return void
 */
public function kxed_setting_base(){

	if( empty( $this->kxedS1[ 'id' ] ) )
	{
		$this->kxedS1[ 'id' ] = get_the_ID();
	}

	//統合禁止。ghost系で書き換えられる。2023-09-06
	$this->kxedOUT[ 'id' ] = $this->kxedS1[ 'id' ];

	//タイトル。2023-09-07
	$this->kxedS1[ 'title_base' ] = get_the_title( $this->kxedS1[ 'id' ] );


	//編集番号
	if( !empty( $_SESSION[ 'add_new' ] ) )
	{
		$_SESSION[ 'add_new' ]++;
	}
	else
	{
		$_SESSION[ 'add_new' ] = 1;
	}

	$this->kxedOUT[ 'kahen' ]	= $_SESSION[ 'add_new' ];


	//アンカー・戻ってくる用
	if( !empty( $_SESSION[ 'anchor' ] )  )	// $_SESSION[ 'anchor' ]
	{
		$_SESSION[ 'anchor' ]	++;
	}
	else
	{
		$_SESSION[ 'anchor' ]	=1;
	}

	$this->kxedOUT[ 'anchor' ]	= 'anchor' . $_SESSION[ 'anchor' ];

	$str  = '';
	$str .= ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" );
	$str .= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'#' . $this->kxedOUT[ 'anchor' ];

	$this->kxedOUT[ 'url' ] = $str;
	unset( $str );


	//存在の有無をチェック。
	//要チェック。多分使っていない。2023-09-05
	if( !empty( $this->kxedS1[ 'width_hyouji' ] ) )
	{
		echo '■Error-width_hyouji：' . $this->kxedS1[ 'width_hyouji' ];
	}


	if( empty( $this->kxedS1[ 'id_js' ] ) )	//ショートコードから。
	{
		$this->kxedS1[ 'id_js' ]		= $this->kxedS1[ 'id' ];
		$this->kxedS1[ 'id_b_js' ]	= $this->kxedS1[ 'id_js' ];
	}
	else
	{
		$this->kxedS1[ 'id_b_js' ] = $this->kxedS1[ 'id' ];
	}


	if( empty( $this->kxedS1[ 'hyouji' ] ) )
	{
		if( !empty( $this->kxedS1[ 'new' ] ) )
		{
			$this->kxedS1[ 'hyouji' ] = $this->kxedSetting[ 'hyouji_new' ];
		}
		else
		{
			$this->kxedS1[ 'hyouji' ] = $this->kxedSetting[ 'hyouji_edit' ];
		}
	}

	if( preg_match('/統合概要/', $this->kxedS1[ 'hyouji' ] ) )
	{
		$this->kxedS1[ 'hyouji' ] = '❌️';
	}



	//表示追記



	if(preg_match( '/'.KxSu::get('titile_search')[ 'worksDB'].'/', $this->kxedS1[ 'title_base' ] )	)
	{
		$this->kxed_setting_db_Woks();
	}

	if( //資料・研究系の並行postの有無。2023-09-07
		preg_match( '/'.KxSu::get('titile_search')[ 'SharedTitleDB'].'/', get_the_title( $this->kxedOUT[ 'id' ] ) )
		&& preg_match( '/≫/', get_the_title( $this->kxedOUT[ 'id' ] ) )//最上位ページ排除。2023-02-25
		&& empty( $this->kxedS1[ 'new' ] )
		&& is_single()
	){
		$_db_arr = kx_db_SharedTitle(
			[
				'id' => $this->kxedOUT[ 'id' ] ,
				'title_base' => get_the_title( $this->kxedOUT[ 'id' ] )
			]  , 'select_title' );

		if (!empty($_db_arr['ids']) && is_array($_db_arr['ids']) && count($_db_arr['ids']) > 1)
		{
			ob_start();
			include __DIR__ .'/html/shared_titles_change.php';
			$this->kxedS1[ 'hyouji_ids' ] = ob_get_clean();

			//$this->kxedS1[ 'hyouji_ids' ]  = '<span style="color:darkred;" class="_op_a">'.kx_intToRoman(count( $_db_arr[ 'ids' ] )).'&nbsp;</span>';
			//$this->kxedS1[ 'hyouji_ids' ] .= '<div class="_op_z __background_normal" style="z-index:2;">'.$_ids_hyouji.'</div>';
		}
	}

	$this->kxedS1 = kx_shortcode_sys( $this->kxedS1 );


	for( $i = 0; $i <= 5; $i++):

		if( !empty( $this->kxedS1[ 'chara_count'.$i ] ))
		{
			$this->kxedOUT[ 'style_OpenButton_add' ] = kx_Judge_OLD( $this->kxedJUDGE[ 'chara_count' ]  , 'preg' , $i )[ 'settings' ][ 'style_OpenButton_add' ];

			break;
		}
		else
		{
			$this->kxedOUT[ 'style_OpenButton_add' ] = NULL;
		}

	endfor;


	//左右の表示位置。
	if(	empty( $this->kxedS1[ 'kxEdit_right' ] ) ) //if(	!preg_match(	'/kxEdit_right/' , $sys	,	$matches	)	):
	{
		$this->kxedS1[ 'rtl' ]	= '__direction_rtl';
	}

	$this->kxedOUT[ 'style_MAIN_Content' ] .= $this->kxedSetting[ 'style_base_a' ]; //$style3mc_a
	$this->kxedOUT[ 'style_main_button' ]  .= $this->kxedSetting[ 'style_base_a' ]; //$style3b
}



/**
 * カラー設定。
 * 2023-09-08
 *
 * @param [type] $color
 * @param [type] $new
 * @param [type] $this->kxedS1[ 'css_hyouji' ]
 * @return void
 */
public function kxed_setting_color(){

	//editカラーの色。2023-09-13
	if( !empty( $this->kxedS1[ 'new_title' ] ) )
	{
		//newに合わせる。2023-09-13
		$_title = $this->kxedS1[ 'new_title' ];
	}
	else
	{
		$_title = $this->kxedS1[ 'title_base' ];
	}


	//色呼び出し。2023-09-13
	$this->kxedS1[ 'kxcl0' ] = kx_CLASS_kxcl( $_title , '色相' );

	if( !empty( $this->kxedS1[ 'hue' ] ))
	{
		//raretuで使用。2023-08-12
		$_hue = (int)$this->kxedS1[ 'hue' ];
	}
	else
	{
		$_hue = $this->kxedS1[ 'kxcl0' ][ '色相' ];
	}


	if(	!empty( $this->kxedS1[ 'new' ] )	)
	{
		$_border		= 'border-left:4px solid red; border-right:6px solid red;';

		//$this->kxedOUT[ 'class_OpenButton' ] .= ' __a_white';

		if(	$this->kxedS1[ 'kxcl0' ][ 'on_off' ]	)
		{
			$this->kxedS1[ 'kxcl' ][ 'bg_t' ]		= 'background:hsla('.	$_hue	.',50%,15%,1);border-bottom:2px solid black;'.$_border;
			$this->kxedS1[ 'kxcl' ][ 'bg_a' ]		= 'background:hsla('.	$_hue	.',50%,15%,1);'.$_border;
			$this->kxedS1[ 'kxcl' ][ 'bg_ga' ]	= 'background:hsla('.	$_hue	.',25%,15%,1);'.$_border;
			$this->kxedS1[ 'kxcl' ][ 'bg_z' ]		= 'background:hsla('.	$_hue	.',50%,15%,1);'.$_border;
		}
		else
		{
			$this->kxedOUT[ 'class_OpenButton' ]		= ' __back_gray_75';
		}

	}
	else
	{
		if(	!empty( $this->kxedS1[ 'kxcl0' ][ 'on_off' ] )	)
		{
			$this->kxedS1[ 'kxcl' ][ 'bg_t' ]	 = 'background:hsla('. $_hue	.',50%,30%,1);border-bottom:2px solid black;';
			$this->kxedS1[ 'kxcl' ][ 'bg_a' ]	 = 'background:hsla('. $_hue	.',50%,40%,1);';
			$this->kxedS1[ 'kxcl' ][ 'bg_ga' ] = 'background:hsla('. $_hue	.',25%,30%,1);';
			$this->kxedS1[ 'kxcl' ][ 'bg_z' ]	 = 'background:hsla('. $_hue	.',50%,15%,1);';
		}
		else
		{
			$this->kxedS1[ 'kxcl' ][ 'bg_a' ] = 'background:hsla(0,0%,30%,1);';
			$this->kxedS1[ 'kxcl' ][ 'bg_z' ] = 'background:hsla(0,0%,15%,1);';
		}
	}

	if( !empty( $this->kxedS1[ 'kx30_on' ] ) )
	{
		$_width1 = 850;
	}
	elseif( !empty( $this->kxedS1[ 'wwr' ] ) )
	{
		$_width1 = 850;
	}
	else
	{
		$_width1 = 900;
	}

	$this->kxedS1[ 'width2' ]    = $_width1 - 10 ;
	$this->kxedS1[ 'width_sbi' ] = $_width1 - 45 ;

	$this->kxedOUT[ 'width_sbi' ] = 'width:'. $this->kxedS1[ 'width_sbi' ] .'px;';


	$this->kxedOUT[ 'Drawer_top_style' ] = 'width:'. $_width1 .'px;' . $this->kxedSetting[ 'Drawer_top_style' ] . $this->kxedS1[ 'kxcl' ][ 'bg_a' ];


	$this->kxedOUT[ 'Top_bar_style' ]    = $this->kxedSetting[ 'Top_bar_style' ]	. $this->kxedS1[ 'kxcl' ][ 'bg_t' ];	//トップ用

	$this->kxedOUT[ 'Main1_style' ] = $this->kxedSetting[ 'style_base_a' ];
	$this->kxedOUT[ 'Main2_style' ] = $this->kxedSetting[ 'style_base_z' ] . $this->kxedS1[ 'kxcl' ][ 'bg_z' ];
	$this->kxedOUT[ 'Main3_style' ] = $this->kxedSetting[ 'sbi' ] . $this->kxedOUT[ 'width_sbi' ];

	$this->kxedOUT[ 'style3mt1_a' ] = $this->kxedSetting[ 'style_base_a' ];
	$this->kxedOUT[ 'style3mt1_z' ] = $this->kxedSetting[ 'style_base_z' ] . $this->kxedS1[ 'kxcl' ][ 'bg_z' ];
	$this->kxedOUT[ 'style3mte_a' ] = $this->kxedSetting[ 'style_base_a' ];
	$this->kxedOUT[ 'style3ms_a' ]  = $this->kxedSetting[ 'style_base_a' ];
	$this->kxedOUT[ 'style3ms_z' ]  = $this->kxedSetting[ 'style_base_z' ] . $this->kxedS1[ 'kxcl' ][ 'bg_z' ];
}



/**
 * 新規追加
 *
 * @return void
 */
public function kxed_setting_New(){


	if(	!empty( $this->kxedS1[ 'new_content' ] )	)
	{
		//ショートコードに置換。2025-04-13
		$this->kxedOUT[ 'content' ] = preg_replace( '/＿(.*?)＿/' , '[$1]' , $this->kxedS1[ 'new_content' ] );
		$this->kxedOUT[ 'content' ] = str_replace( '＝' , '=' , $this->kxedOUT[ 'content' ] );
	}
	else	//空の場合。
	{
		$this->kxedOUT[ 'content' ] = '＿' . Time::format() . '＿';
	}


	if( empty( $this->kxedS1[ 'css_hyouji' ] )	)	//new
	{
		$this->kxedOUT[ 'class_OpenButton' ] .= ' '.$this->kxedS1[ 'css_hyouji' ];
		$this->kxedOUT[ 'class_OpenButton' ] .= ' __color_inversion __text_shadow_normal';
	}


	if(	!empty( $this->kxedS1[ 'hyouji_style' ] ) )	//new。追記
	{
		$this->kxedOUT[ 'style_OpenButton' ] .= $this->kxedS1[ 'hyouji_style' ];
	}
	elseif( empty( $this->kxedS1[ 'css_hyouji' ] ) )
	{
		$this->kxedOUT[ 'style_OpenButton' ]	.= 'background:hsla(0,50%,90%,.05);	line-height:0.9em;';
	}

	$this->kxedOUT[ 'shortCODE_array' ] = NULL;
	$this->kxedS1[ 'yomikomi_on' ] = 0;
}



/**
 * ghost編集。
 * 上書き編集。
 * 2023-09-06
 *
 * @return void
 */
public function kxed_setting_Edit(){

	$post = get_post( $this->kxedS1[ 'id' ] );

	if( !empty( $post->post_content ) )
	{
		$this->kxedOUT[ 'content' ]	= $post->post_content;
	}


	if(	!empty( $this->kxedS1[ 'css_hyouji' ]) )
	{
		$this->kxedOUT[ 'class_OpenButton' ]	.= ' '.$this->kxedS1[ 'css_hyouji' ];
	}


	if(	!empty( $this->kxedS1[ 'hyouji_style' ] ) )
	{
		$this->kxedOUT[ 'style_OpenButton' ]	.= $this->kxedS1[ 'hyouji_style' ];
	}

	//検出・format
	$_format = kx_format_on( $this->kxedS1[ 'id' ] );

	//'format_on'			=> 'GhostON',

	if( !empty( $_format[ 'GhostON' ] )  )
	{
		//GHOSTの場合

		$this->kxedS1[ 'ghost_on' ]			  = 1;
		$this->kxedOUT[ 'hyouji_add' ]		= '━G';

		$this->kxedOUT[ 'Ghost_style' ]   = $this->kxedSetting[ 'style2g' ] .$this->kxedS1[ 'kxcl' ][ 'bg_ga' ];
		$this->kxedOUT[ 'Ghost2_style' ]  = 'width:'. $this->kxedS1[ 'width2' ] .'px;' . $this->kxedSetting[ 'style2g_z' ] . $this->kxedS1[ 'kxcl' ][ 'bg_z' ];
		$this->kxedOUT[ 'Ghost21_style' ] = $this->kxedSetting[ 'sbi' ] . $this->kxedOUT[ 'width_sbi' ] . 'margin:0 0 10px 5px;';
		$this->kxedOUT[ 'Ghost22_style' ] = $this->kxedSetting[ 'sbi' ] . $this->kxedOUT[ 'width_sbi' ] . 'height:5em;';

		$this->kxedOUT[ 'title_g' ]		    = $this->kxedS1[ 'title_base' ];

		$_arr_title_g		                  = $this->kxed_set_title( $this->kxedOUT[ 'title_g' ] );
		$this->kxedOUT[ 'Ghost21_value' ]	= $_arr_title_g[ 0 ];
		$this->kxedOUT[ 'title_1s_g' ]		= $_arr_title_g[ 'top_s' ];
		$this->kxedOUT[ 'title_end_g' ]		= $_arr_title_g[ 'end' ];

		$this->kxedS1[ 'id_ghost' ] = $this->kxedS1[ 'id' ];



		//ショートコード設定。2023-09-06
		$this->kxedOUT[ 'template_form_html2' ]	= $this->kxed_set_content();
		$this->kxedOUT[ 'GHOST_shortCODE' ]     = $this->kxEdit_shortCODE();
		unset( $this->kxedOUT[ 'template_form_html2' ] );

		//コピー先のコンテンツ作成。
		//$this->kxedOUT[ 'content' ]の書き換え。2023-09-06
		$this->kxedOUT[ 'id' ]				= $_format[ 'GhostON' ];
		$post			= get_post( $this->kxedOUT[ 'id' ] );

		if( !empty( $post->post_content ) )
		{
			$this->kxedOUT[ 'content' ]	= $post->post_content;
		}
		else
		{
			$this->kxedOUT[ 'content' ]	= NULL;
		}
	}
	elseif( !empty( $_format[ 'BaseID' ] )  )
	{
		//データベース検索でON。参照されているリンク有りの場合。

		$str  = '';
		$str .= '<div>Base_Title</div>';
		$i= 0;

		if (is_array($_format['BaseID'])) {

			foreach( $_format[ 'BaseID' ] as $_id ):
				$i++;

				$_title = get_the_title( $_id );
				if( empty( $_title ) )
				{
					$_title = 'N/A：'. $_id . '：status：'.get_post_status( $_id );
				}

				$str .= '<div class="__a_white" style="margin-left:20px;">';
				$str .= '<a href="'.get_permalink ( $_id ).'" tabindex="-1">';
				$str .= str_pad( $i, 2, 0, STR_PAD_LEFT) .'：';
				$str .= $_id.'：';
				$str .=  $_title . '</a></div>';
				unset( $_title );

			endforeach;


			$this->kxedOUT[ 'hyouji_add' ]		= '━b'.count( $_format[ 'BaseID' ] );
			$this->kxedOUT[ 'base_titles' ]		= $str;
		}

		unset( $_id , $str , $i );

	}


	unset( $matches );


	if( !empty( $_SESSION[ 'reference_on' ] ) )
	{
		$this->kxedOUT[ 'hyouji_add' ]	.= '　🟩🟩🟩　';
	}


	if( empty( $this->kxedOUT[ 'content' ] ) )
	{
		$this->kxedOUT[ 'content' ] = NULL;
	}

	$this->kxedOUT[ 'shortCODE_array' ]  = $this->kxed_set_content();


	//作品系
	if( preg_match( $this->kxedSetting[ 'yomikomi' ] , $this->kxedS1[ 'title_base' ] ) && empty( $this->kxedS1[ 'new' ] ) )
	{
		if( preg_match(	'/\[(kx_tp|raretu).*?\]/'	, $this->kxedOUT[ 'content' ] ) )
		{
			$this->kxedS1[ 'yomikomi_on' ] 			 = 0;
			$this->kxedS1[ 'content_height_on' ] = 0;
		}
		else
		{
			$this->kxedS1[ 'yomikomi_on' ] 				= 1;
			$this->kxedS1[ 'content_height_on' ]	= 1;
		}
	}
	else
	{
		$this->kxedS1[ 'yomikomi_on' ] 				= 1;
		$this->kxedS1[ 'content_height_on' ]	= 1;
	}

	//編集部分。テキストエリア。
	$this->kxedOUT[ 'class_TextArea' ] = 'displayArea_edit' . $this->kxedOUT[ 'kahen' ] . $this->kxedOUT[ 'id' ] ;
}



/**
 * 出力関係設定。
 *
 * @return void
 */
public function kxed_setting_OUT(){

	if( empty( $this->kxedS1[ 'short_code_form_on' ] )	)
	{
		$this->kxedOUT[ 'MAIN_ShortCODE_class' ] = '_op_z';
	}

	//TextArea_style。2023-09-06
	if( !empty( $this->kxedS1[ 'content_height_on' ] ) && !empty( $this->kxedS1[ 'count_content'] ) )
	{
		$_content_min_height = $this->kxedS1[ 'count_content'];
	}
	else
	{
		$_content_min_height = 3;
	}

	$this->kxedOUT[ 'TextArea_style' ] = 'display:inline-block;	min-height:'. $_content_min_height .'em; '. $this->kxedOUT[ 'width_sbi' ];
	if(	!empty( $_SESSION[ 'reference_on' ] ) )
	{
		$this->kxedOUT[ 'TextArea_style' ] .= 'Background:hsl(60 ,40% ,80%);';
	}


	//kxed_set_content()設定要素。2023-09-06
	//contentを隠す設定関連。2023-09-06
	if( !empty( $this->kxedS1[ 'content_form_on' ] ))
	{
		$this->kxedOUT[ 'style_MAIN_Content_hidden' ]	.= $this->kxedSetting[ 'style_base_a' ];
	}
	else
	{
		$this->kxedOUT[ 'MAIN_Content_hidden_class' ]	= '_op_z';
		$this->kxedOUT[ 'style_MAIN_Content_hidden' ]	.= 'background:black;';
	}

	$this->kxedOUT[ 'class_OpenButton' ]	.= $this->kxedOUT[ 'J' ][ 'new' ][ 'class_OpenButton' ];

	//
	if(	!empty( $this->kxedS1[ 'new' ] ) && !empty( $this->kxedS1[ 'new_title' ] ) )
	{
		$this->kxedOUT[ 'title' ]	= str_replace('＞'	,'≫' , $this->kxedS1[ 'new_title' ] ) ;
	}
	else
	{
		$this->kxedOUT[ 'title' ] = get_the_title( $this->kxedOUT[ 'id' ] );
	}


	//長いタイトル補正。2024-06-22
	$_title_length = mb_strlen( $this->kxedOUT[ 'title' ] );
	$_limit = 71;

	$this->kxedOUT[ 'title_0_top' ] = mb_substr( $this->kxedOUT[ 'title' ] , 0 , $_limit );
	//echo $title_length;
	if( $_title_length > $_limit)
	{
		$this->kxedOUT[ 'title_0_top' ] .= '……';
	}

	unset( $_title_length );




	$_arr_title		= $this->kxed_set_title( $this->kxedOUT[ 'title' ] );
	$this->kxedOUT[ 'title_0' ]			= $_arr_title[0];

	if( !empty( $_arr_title['top'] ) )
	{
		$this->kxedOUT[ 'title_1' ]	= $_arr_title['top'];


		//長いタイトル補正。2024-06-22
		$_title_length = mb_strlen($this->kxedOUT['title_1']);

		$this->kxedOUT[ 'title_1' ] = mb_substr( $this->kxedOUT[ 'title_1' ] , 0 , $_limit );
		//echo $title_length;
		if( $_title_length > $_limit)
		{
			$this->kxedOUT[ 'title_1' ] .= '……';
		}


	}


	if( !empty( $_arr_title[ 'on'] ) )
	{
		$this->kxedOUT[ 'title_1s_on' ]	= $_arr_title['on'] . $_arr_title['top_s'];
	}
	else
	{
		$this->kxedOUT[ 'title_1s_on' ]	= $_arr_title['top_s'];
	}

	$this->kxedOUT[ 'title_end' ]		= $_arr_title['end'];

	if( !empty( $this->kxedS1[ 'ghost_on' ] ) )
	{
		$this->kxedOUT[ 'MAIN_Title_hidden_style' ]	= $this->kxedSetting[ 'style_base_z' ] . $this->kxedS1[ 'kxcl' ][ 'bg_z' ];
		$this->kxedOUT[ 'MAIN_Title_hidden_class' ]  = '_op_z';
	}
	else
	{
		$this->kxedOUT[ 'MAIN_Title_hidden_style' ]	= $this->kxedSetting[ 'style_base_a' ];
	}
}




/**
 * エディター。トップバー。
 *
 * @return void
 */
public function kxed_setting_top(){

	if( !empty( $this->kxedS1[ 'new' ] ) )
	{
		$_id_name	= '<span class="__color_red">╋新規</span>';
	}
	else
	{
		if(	array_key_exists( 'reference_on' , $_SESSION ) ) //  $_SESSION[ 'reference_on' ]
		{
			$_id_name	= '<span class="__color_red __xlarge">➡参照・更新</span>';
		}
		else
		{
			$_id_name	= '<span class="__color_cyan80 __xlarge">➡更新</span>';
		}


		if( !empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
		{
			if( empty( $title ))
			{
				$title = NULL;
			}

			$this->kxedS1[ 'reference_on' ] = 1;
		}
	}
	$this->kxedOUT[ 'TopBAR_Left_name' ] = $_id_name;

	$this->kxedOUT[ 'class_TopBAR_Left_span' ] = '__a_hover _op_a'.$this->kxedOUT[ 'kahen' ];
}





/**
 * 参考の表示。
 * 2023-09-06
 *
 * @param [type] $args
 * @param [type] $id
 * @param [type] $id_g
 * @param [type] $title
 * @return void
 */
public function kxed_setting_reference(){

	if(	preg_match( '/reference_off/' , $this->kxedS1[ 'sys' ]	)	)
	{
		return;
	}
	elseif( preg_match( '/∬.*(補足|来歴|c9f0)/', $this->kxedS1[ 'title_base' ] ) )
	{
		return;
	}


	if( !empty( $this->kxedS1[ 'title_base' ] ) && preg_match(	'/^(∬\d{1,})≫(c00\d).*＼c(\d\w{1,}\d)(.*)/i'	,	$this->kxedS1[ 'title_base' ]	,$matches	)	)
	{

		//対人型。2023-09-06
		//主人公型。2024-09-05
		$sample_on	= 1;
		$_chara_num	= NULL;

		if( $matches[1] == '∬10')
		{
			$_world = '∬10';
			if(preg_match(	'/^1z/'	,	$matches[3] ))
			{
				//主人公。2024-08-05
				$_chara_num	= 'c9f0';
			}
			elseif(preg_match(	'/^[1-2]/'	,	$matches[3] ))
			{
				$_chara_num	= 'c991';
			}
			elseif(preg_match(	'/^3/'	,	$matches[3] ))
			{
				$_chara_num	= 'c993';
			}
			elseif(preg_match(	'/^998/'	,	$matches[3] ))
			{
				//スルー
				$sample_on	= 0;
			}
			else
			{
				$_chara_num	= 'c9f0';
			}


			//$category_san			= end(	get_the_category( $id )	);
			$category_san			= end(	get_the_category( $this->kxedS1[ 'id' ] )	);

			$category_id	= $category_san->cat_ID;
		}
		else
		{
			$_world = '∬00';
			$_chara_num	= 'c9f0';
			$category_id	= 1168;
		}
		//echo $_chara_num;


		$tag					= $matches[2];
		$search				= $_world .'≫'.$matches[2]. '≫＼' .$_chara_num . $matches[4];

	}
	elseif( !empty( $this->kxedS1[ 'title_base' ] ) &&	preg_match(	'/^(∬\d{1,})≫c(\d)(\w{1,})(.*)/i'	, $this->kxedS1[ 'title_base' ] , $matches	)	)
	{
		//通常型
		$sample_on	= 1;

		//$category_san = end(	get_the_category($id)	);

		if( $matches[1]	== '∬10' )
		{
			$category_san			= end(	get_the_category( $this->kxedS1[ 'id' ] )	);
			$category_id	= $category_san->cat_ID;

			if( $matches[2]	== 1 ||	$matches[2]	== 2 )
			{
				if( $matches[3]	== 'zz0')
				{
					$tag	= 'c9f0';
				}
				else
				{
					$tag	= 'c991';
				}
			}
			elseif($matches[2]	== 3)
			{
				$tag	= 'c993';
			}
			elseif($matches[2]	== 4)
			{
				$tag	= 'c994';
			}
			elseif($matches[2]	== 6)
			{
				$tag	= 'c996';
			}
			elseif($matches[2]	== 8)
			{
				$tag	= 'c998';
			}
			elseif($matches[2]	== 9	)
			{
				if(	$matches[3]	== 'f'	)
				{
					$sample_on	= 0;
				}
				else
				{
					$tag= 'c9f0';
				}
			}
			else
			{
				$tag	= 'c9f0';
			}
		}
		else
		{
			$tag = 'c9f0';
			$category_id	= 1170;
		}

		$search		= $matches[4];

	}


	if( !empty( $search ) )
	{

		$search		= preg_replace(	'/('.KxSu::get('titile_search')[ 'work_Platform' ].')\d{3,}/i'	,'${1}000'	,	$search	);
	}
	else
	{
		$search		= NULL;
	}


	if( !empty( $search ) && preg_match(	'/〇\w\d{2}7\d{2}$/i'	,	$search ))
	{
		$search = preg_replace( '/\d$/' , 1  ,$search) ;

	}
	elseif( !empty( $search ) && preg_match(	'/≫1構成≫二\d{2}/i'	,	$search ))
	{
		$search = preg_replace( '/二\d{2}/' , '二01'  ,$search) ;
	}


	//軽量化
	if( !empty( $this->kxedS1[ 'title_base' ] ) &&	preg_match(	'/^∬\d{1,}≫.*〇/i'	,	$this->kxedS1[ 'title_base' ] ) && !empty( $tag ) &&	empty( preg_match(	'/^c9/i'	,	$tag ))	)
	{
		$tag = '〇 ' . $tag;
	}



	if(	!empty( $sample_on ) && empty( $_SESSION[ 'reference_on' ] ) )
	{
		$_SESSION[ 'reference_on' ]	= $this->kxedS1[ 'id' ];

		$ret	= kx_CLASS_kxx(
		[
			't'					=>	10,
			'cat' 			=>	$category_id	,
			'tag' 			=>	$tag	,
			'search'		=>	$search,
			'title_s'		=>	$search.'$'	,
			'sys'				=>	'basu_full,db_on'	,
		] );

		unset(	$_SESSION[ 'reference_on' ]	);
	}
	else
	{
		$ret = NULL;
	}

	$this->kxedOUT[ 'Reference' ] = $ret;
}




/**
 * Undocumented function
 *
 * @return void
 */
public function kxed_setting_db_Woks(){

	$_db_arr = kx_db_Woks(
	[
		'id' => $this->kxedOUT[ 'id' ] ,
		'title' => $this->kxedS1[ 'title_base' ]
	]  , 'select_title' );

	if( empty( $_db_arr ))
	{
		return;
	}

	//$_title = ()$this->kxedS1[ 'title_base' ]

	$_title = preg_replace( '/'.KxSu::get('titile_search')[ 'SharedTitleDB'].'/', '', $this->kxedS1[ 'title_base' ] );


	$items = [
			'感性' => ['id' => $_db_arr->id_sens, 'symbol' => 'γ'],
			'研究' => ['id' => $_db_arr->id_study, 'symbol' => 'σ'],
			'資料' => ['id' => $_db_arr->id_data, 'symbol' => 'δ']
	];

	$ret = '';

	foreach ($items as $name => $data) {
		if ($data['id'] != $this->kxedS1['id'] && !preg_match('/^'.$data['symbol'].'/',$this->kxedS1[ 'title_base' ]))
		{
			$ret .= '<span style="font-weight:bold; color:red;">' . $name . '</span>';

			if (!empty($data['id']) && $data['id'] != $this->kxedS1['id'])
			{
				$ret .= kx_CLASS_kxx(
				[
					't'  => 65,
					'id' => $data['id']
				]);
			}
			else
			{
				$ret .= kxEdit_light($data['symbol'] . $_title);
			}
			$ret .= '<hr>';
		}

	}


	$this->kxedOUT[ 'Reference' ] = $ret;

}



/**
 * h_editから入力。
 *
 * @param [type] $id
 * @return void
 */
public function kxed_setting_Edit_Button(){

	$class = NULL;
	if( empty( $this->kxedS1[ 'new' ] ) )
	{
		$class	=  '_j_s' . $this->kxedS1[ 'id_js' ] . '_' . $this->kxedOUT[ 'kahen' ] . ' _j_b_s'	.	$this->kxedS1[ 'id_b_js' ] . $this->kxedOUT[ 'kahen' ];			//不使用。.' _j_b_e'
	}

	$ret = NULL;

	$ret .= '<div style="text-align: center;">';

	if( empty( $this->kxedS1[ 'header_bar'] ) )
	{
		$ret .= '<span style="margin:0 50px;">';
		$ret .= '<input type="submit" name="back"		value="───　✔　───"	class="_op_a'.$this->kxedOUT[ 'kahen' ].' __btn_form1 '.$class.'">';//✅
		$ret .= '</span>';
	}

	$ret .= '<span style="margin:0 50px;">';
	$ret .= '<input type="button" name="" value="×" class="_op_a'.$this->kxedOUT[ 'kahen' ].' __btn_form2 __btn_close" style="border-radius: 20px 20px 20px 20px / 20px 20px 20px 20px;">';
	$ret .= '</span>';

	$ret .= '<span style="margin:0 50px;">';
	$ret .= '<input type="submit" name="reload"	value="───　⟳　───"	class="_op_a'.$this->kxedOUT[ 'kahen' ].' __btn_form1">';//✔↺	⟳	↻	⟲🔄🔃
	$ret .= '</span>';

	$ret .= '</div>';

	$this->kxedOUT[ 'EditButton' ] =  $ret;
}




/**
 * Undocumented function
 *
 * @param [type] $content
 * @return void
 */
public function kxed_set_content(){

	if(preg_match('/(\[)(kx_format)(.*?)(id=)(\d{1,})(.*?\])/',$this->kxedOUT[ 'content' ]	,	$matches ))
	{
		$this->kxedS1[ 'content_form_on' ]			= 0;
		$this->kxedS1[ 'short_code_form_on' ]		= 1;
		$_type_format					= 1;
		$_sc_arr_on						= 1;

		$this->kxedOUT[ 'GHOST_content' ]= str_replace(	$matches[0]	,''	,$this->kxedOUT[ 'content' ]);
	}
	elseif( preg_match( '/(\[.*?)(kx_tp|raretu)(.*)(\])/i' , $this->kxedOUT[ 'content' ]	,	$matches ) )
	{
		$this->kxedS1[ 'content_form_on' ]			= 0;
		$this->kxedS1[ 'short_code_form_on' ]		= 1;

		$this->kxedOUT[ 'content' ]			= str_replace(	$matches[0]	,''	, $this->kxedOUT[ 'content' ] );
	}
	else
	{
		$this->kxedS1[ 'content_form_on' ]			= 1;
		$this->kxedS1[ 'short_code_form_on' ]		= 0;
	}


	if( !empty( $_sc_arr_on ) )
	{
		//配列化
		for($i = 0; $i < count(	$matches	); ++$i) :

			$sc_arr[$i]['value']	= $matches[$i];


			if(	$i	== 2	)
			{
				$sc_arr[$i]['on']	= 1;
				$sc_arr[$i]['name']	= 'Type';	$sc_arr[$i]['width']	= 400;
				$sc_arr[$i]['f']	= '<div></div>';
			}
			else
			{
				$sc_arr[$i]['on']	= NULL;
			}


			if(	!empty( $_type_format ) || !empty( $_type_base_format )	)
			{
				if(	$i	== 5	)
				{
					$sc_arr[$i]['on']	= 1;
					$sc_arr[$i]['name']	= 'ID';
					$sc_arr[$i]['width']	= 550;
					$sc_arr[$i]['f']	= '<div></div>';
				}
				else
				{
					$sc_arr[$i]['on']	= NULL;
				}
			}
			else
			{
				//$sc	= $matches[1];
				$sc_arr[$i]['on']	= NULL;
			}

		endfor;

		unset($sc_arr[0] );
	}
	else
	{
		if( empty( $matches[0] ) )
		{
			$matches[0] = NULL;
		}

		$sc_arr[0]['value']	= $matches[0];

		$sc_arr[0]['on']		= 1;


		if( array_key_exists( 2 , $matches ))
		{
			$sc_arr[0][ 'name' ]	= $matches[2];
		}
		else
		{
			$sc_arr[0][ 'name' ] = NULL;
		}

		$sc_arr[0]['width']	= 800;
	}


	//contents・高さ。2024-02-13
	$_count_cont1	= substr_count( $this->kxedOUT[ 'content' ] ,"\n");

	$_count_cont2	= 0;

	foreach(	explode("\n", $this->kxedOUT[ 'content' ] ) as $value):

		if( mb_strlen( $value ) > $this->kxedSetting[ 'count_cont' ] )
		{
			$_count_cont2 = $_count_cont2	+	1;
		}

	endforeach;
	unset( $value );


	$_count_cont0	= $_count_cont1	+	$_count_cont2;
	$_count_cont0	= $_count_cont0 * 1.6;


	if( $_count_cont0	>	$this->kxedSetting[ 'count_cont' ] )
	{
		$_count_cont0	= $this->kxedSetting[ 'count_cont' ];
	}
	else
	{
		$_count_cont0	= $_count_cont0	+3;

		if( $_count_cont0	>	$this->kxedSetting[ 'count_cont' ] )
		{
			$_count_cont0	= $this->kxedSetting[ 'count_cont' ];
		}
	}

	$this->kxedS1[ 'count_content']  =  $_count_cont0;

	if( is_array( $matches ) )
	{
		if( array_key_exists( 2 , $matches ) )
		{
			$this->kxedOUT[ 'shortCODE_type' ]	= $matches[2];
		}

		if( array_key_exists( 0 , $matches ))
		{
			$this->kxedOUT[ 'shortCODE_string' ]		= $matches[0];
		}
	}


	return $sc_arr;
}



/**
 * Undocumented function
 *
 * @param [type] $title
 * @return void
 */
public function kxed_set_title( $title ){

	$_array = explode( '≫' , $title );

	$_title_end = end( $_array );

	//末尾を消す。ただし、strバージョンだと同じ並びがあると上も消える。
	//$ret[0]	= str_replace( $_title_end	,''	,$title);	//2021-03-14下に変更。
	$ret[ 0 ]	= preg_replace( '/' . $_title_end . '$/' , '' , $title );

	if( preg_match(	'/(.*)(＠)(.*)/' , $_title_end , $matches ) )
	{
		$_t_end_array[ 1 ]     = $matches[1];
		$ret[ 'top' ]	= $matches[1];
		$ret[ 'end' ] = $matches[3];

		unset( $matches );

		if( preg_match( '/(.*?)(_.*_.*)/' , $_t_end_array[1] , $matches ) )
		{
			//プロット複数

			$_t_end_array[1]		= $matches[1];
			$_t_end_array[20]	= $matches[2];

			unset( $matches );


			//順番入れ替えと、ダブり排除。2024-06-19
			$_plot_array = explode( '_' , $_t_end_array[20] );
			sort( $_plot_array ) ;
			$_plot_array = array_unique( $_plot_array ) ;

			$_plot = NULL;
			$_c  = 0;
			foreach( $_plot_array as $_num_plor):

				if( $_c == 0 )
				{
					$_plot .= $_num_plor;
				}
				else
				{
					$_plot .= '_'.$_num_plor;
				}

				$_c++;

			endforeach;

			$_t_end_array[20] = $_plot;
		}
		elseif(preg_match('/(.*?)(_\w)(\d{1,})(.*)/'	,$_t_end_array[1]		,$matches	)	)
		{
			$_t_end_array[1]	= $matches[1];
			$_t_end_array[21]	= $matches[2];
			$_t_end_array[22]	= $matches[3];
			$_t_end_array[23]	= $matches[4];

			unset($matches);
		}
		else
		{
			//
		}


		//if( preg_match('/(\w{1,}-\w{2}|\w{1,})(\w|)(\d|)(\d|)(\d|)(\d|)(\d|)/' , $_t_end_array[1]	 , $matches ) )
		if( preg_match('/(\w{1,}(-\w{1,2}|))(\w{1,2}|)(\d{1,}|)/' , $_t_end_array[1]	 , $matches ) )//(\d|)(\d|)(\d|)(\d|)
		{
			foreach($matches as $_k => $_v):

				$_t_end_array['1'.$_k]	= strval($_v);

			endforeach;

			unset($matches	,$_t_end_array[10]	);
		}

		$_t_end_array[90]		= '＠';
	}
	else
	{
		$ret['top']	= NULL;
		$ret['on']	= NULL;
		$ret['end']	= $_title_end;
		$_t_end_array = NULL;
	}

	$_type20 = NULL;
	if( !empty( $_t_end_array[20] ) && strlen( $_t_end_array[20] ) > 40 )
	{
		$_type20 = 1;
	}


	if(preg_match(	'/^∬.*(来歴|wws|wwr)/i'	,$title	)		)
	{
		$plot_on	= 'Plot<br>';

		$base_arr	=[ 11=>'ヾ',13=>'ヾ',14=>'ヾ',21=>'ヾ',22=>'ヾ',23=>'ヾ',90=>'ヾ']; //,31=>'ヾ'14=>'ヾ',15=>'ヾ',16=>'ヾ',17=>'ヾ',

		if(is_array( $_t_end_array ) &&	is_array(	$base_arr))
		{
			$_t_end_array	= $_t_end_array + $base_arr;
		}
	}

	if( !empty($_t_end_array) && array_key_exists( 1 , $_t_end_array) )
	{
		$ret[1]	= $_t_end_array[1];
	}


	if( !empty( $plot_on) )
	{
		$ret['on']	= $plot_on;
	}


	unset($_k	, $_v );

	if( !empty( $_t_end_array ) )
	{
		$_array	= $_t_end_array;

		if( array_key_exists( 1 , $_t_end_array ) )
		{
			unset( $_t_end_array[1] );
		}
	}


	$str = NULL;

	if( is_array( $_array ) )
	{
		ksort( $_array );
	}


	if(	!empty( $_array )	&& !empty( $plot_on ) )
	{
		$_t = NULL;
		$_e = NULL;
		//$_h = 25;

		foreach( $_array as $_k => $_v):

			if(			$_k==11 ){ $_w=70;	$_t='tel';$_n='Time';}
			elseif(	$_k==13 ){ $_w=40;	$_t='tel';}
			elseif(	$_k==14 ){ $_w=60;	$_t='tel';		$_e='<p></p>';}
			//elseif(	$_k==12 ){ $_w=40;	$_t='select16';}
			//elseif(	$_k==12 ){ $_w=40;	$_t='select_n';}
			//elseif(	$_k==13 ){ $_w=40;	$_t='select_n';$_e='&nbsp;&nbsp;&nbsp;';}
			//elseif(	$_k==14 ){ $_w=40;	$_t='select_n';}
			//elseif(	$_k==15 ){ $_w=40;	$_t='select_n';}
			//elseif(	$_k==16 ){ $_w=40;	$_t='select_n';}
			//elseif(	$_k==17 ){ $_w=40;	$_t='select_n';		$_e='<p></p>';}

			elseif(	$_k==20 && !empty( $_type20 ) ){ $_w=200; $_t='text';     $_n='Plot'; $_e='<p></p>';	$_21off=1;}	//プロット複数。$_h=100;
			elseif(	$_k==20 ){                       $_w=550;	$_t='tel';      $_n='Plot'; $_e='<p></p>';	$_21off=1;}	//プロット複数
			//elseif(	$_k==31 ){ $_w=100;	$_t='select31';		$_n='キャラ';}
			elseif(	$_k==90 ){                       $_w=10;  $_t='hidden';   $_e='<p></p>';}
			elseif(	$_k==21 && empty( $_21off ) ){   $_w=50;  $_t='select21'; $_n='Plot';}
			elseif(	$_k==22 && empty( $_21off ) ){   $_w=150; $_t='tel';}
			elseif(	$_k==23 && empty( $_21off ) ){   $_w=60;  $_t='select23'; $_e='<p></p>';}


			if( $_v == 'ヾ' )
			{
				$_v= NULL;
			}


			if( !empty( $_n ))
			{
				$str	.= '<div style="display: inline-block;width:100px;">';
				$str	.= $_n;
				$str	.= '：';
				$str	.= '</div>';
			}


			if( !empty( $_t ) && $_t	== 'hidden'	)
			{
				//最後の：を追加。2024-06-19
				//$str	.= $_v;
				$str	.= '<input type="'.$_t.'" name="title'.$_k.'" value="'.$_v.'" min="0" max="9">';
			}
			elseif( !empty( $_t ) && $_t == 'number' )
			{
				$str	.= '<input type="number" name="title'.$_k.'" value="'.$_v.'"	class="__edit"	style="width:'.$_w.'px;margin:0 10px 5px 0px;height:25px;">';
			}
			elseif( !empty( $_t ) && $_t	== 'select_n')
			{
				$str	.= '<select name="title1'.$_k.'" style="width:'.$_w.'px;margin:0 10px 5px 0px;height:25px;" class="__small">';//width:60px;
				$str	.= '<option>'.strval($_v).'</option>';
				$str	.= '<option value="">-</option>';

				foreach(range('0', '9') as $az):

					$str	.= '<option>'.$az.'</option>';

				endforeach;
				$str	.= '</select>';
			}
			elseif( !empty( $_t ) && $_t	== 'select16')
			{
				$str	.= '<select name="title1'.$_k.'" style="width:'.$_w.'px;margin:0 10px 5px 0px;height:25px;" class="__small">';//width:60px;
				$str	.= '<option>'.$_v.'</option>';
				$str	.= '<option value="">-</option>';

				foreach( range( 'a' , 'z' ) as $az ):

					$str	.= '<option>'.$az.'</option>';

				endforeach;

				$str	.= '</select>';
			}
			elseif( !empty( $_t ) && $_t	== 'select21'	)
			{
				//プロット
				$str	.= '<select name="title'.$_k.'" style="width:'.$_w.'px;margin:0 10px 5px 0px;height:25px;" class="__small">';//width:60px;
				$str	.= '<option>'.$_v.'</option>';
				$str	.= '<option value="">-</option>';
				$str	.= '<option value="_k">_k</option>';
				$str	.= '<option value="_y">_y</option>';
				$str	.= '<option value="_p">_p</option>';
				$str	.= '<option value="_s">_s</option>';
				$str	.= '<option value="_o">_o</option>';
				$str	.= '</select>';
			}
			elseif( !empty( $_t ) && $_t	== 'select23')
			{
				$str	.= '<select name="title'.$_k.'" style="width:'.$_w.'px;margin:0 10px 5px 0px;height:25px;" class="__small">';//width:60px;
				$str	.= '<option>'.$_v.'</option>';
				$str	.= '<option value="">-</option>';
				//$str	.= '<option value="-0">_k</option>';
				$str	.= '<option value="-1">-1</option>';
				$str	.= '<option value="-2">-2</option>';
				$str	.= '<option value="-3">-3</option>';
				$str	.= '<option value="-4">-4</option>';
				$str	.= '<option value="-5">-5</option>';
				$str	.= '<option value="-6">-6</option>';
				$str	.= '</select>';

				//$str	.= '追加';
			}
			elseif( $_k == 20   && !empty( $_type20 ) )
			{
				$str .= '<textarea name="title'.$_k.'" rows="4" cols="50">';
				$str .= $_v;
				$str .= '</textarea>';

				//$str	.= '<input type="'.$_t.'" name="title'.$_k.'" value="'.$_v.'"	class="__edit" style="width:'.$_w.'px;height:'.$_h.'px;margin:0 10px 5px 0px;display:inline-block;white-space: normal;">';
			}
			elseif( !empty( $_t ) )
			{
				$str	.= '<input type="'.$_t.'" name="title'.$_k.'" value="'.$_v.'"	class="__edit" style="width:'.$_w.'px;height:25px;margin:0 10px 5px 0px;display:inline-block;">';
			}
			elseif( !empty( $_21off )	)
			{
				//
			}
			else
			{
				//
			}

			if( !empty( $_e ))
			{
				$str	.= $_e;
			}

			unset( $_w , $_t , $_e , $_n );

		endforeach;
	}
	elseif(	$_array )
	{

		if( array_key_exists( 11 , $_array ))
		{
			$str	.= '<input type="tel" name="title20" value="'. $_array[11] . '" style="display:inline-block;width:100px;">';
		}

		$str	.= '<input type="hidden" name="title90" value="＠" style="display:inline-block;width:100px;">';
	}


	$ret['top_s']	= $str;
	unset($_k ,$_v);

	if( empty( $ret[ 'on' ] ) )
	{
		$ret[ 'on' ] = NULL;
	}

	return $ret;
}




/**
 * $matches[1]がなにか悪さする。
 *
 * @return void
 */
public function kxEdit_shortCODE(){
	ob_start();
	include  __DIR__ .'/html/edit_template_form2.php';
	return ob_get_clean();


}



/**
 * button
 *
 * @param [type] $style
 * @param [type] $new
 * @return void
 */
public function kxEdit_input_button_submit1( $style ){

	$ret = NULL;

	$ret .= '<input ';

	$ret .= 'class="';

	if(	empty( $this->kxedS1[ 'new' ] )	)
	{
		$ret .= ' _j_s'	.		$this->kxedS1[ 'id_js' ] . '_' . $this->kxedOUT[ 'kahen' ];
		$ret .= ' _j_b_s'	.	$this->kxedS1[ 'id_b_js' ] . $this->kxedOUT[ 'kahen' ];
	}

	$ret .= ' _op_a'	.	$this->kxedOUT[ 'kahen' ];
	$ret .= ' __btn_s2';
	$ret .= '"';

	$ret .= ' type="submit"';
	$ret .= ' name="back"';
	$ret .= ' value="✔"';
	$ret .= ' style="'.$style.'"';
	$ret .= '>';

	return $ret;
}


/**
 * 更新
 *
 * @param [type] $style
 * @return void
 */
public function kxEdit_input_button_submit2( $style ){

	$ret = NULL;

	//$ret .= '<input type="submit" name="reload"	value="⟳"	class="_op_a'.$this->kxedOUT[ 'kahen' ].'">';

	$ret .= '<input ';

	$ret .= 'class="';
	if(	empty( $this->kxedS1[ 'new' ] )	)
	{
		$ret .= ' _j_s'	.		$this->kxedS1[ 'id_js' ] . '_' . $this->kxedOUT[ 'kahen' ];
		$ret .= ' _j_b_s'	.	$this->kxedS1[ 'id_b_js' ] . $this->kxedOUT[ 'kahen' ];
	}
	$ret .= ' _op_a'	.	$this->kxedOUT[ 'kahen' ];
	$ret .= ' __btn_s2';
	$ret .= '"';

	$ret .= ' type="submit"';
	$ret .= ' name="reload"';
	$ret .= ' value="⟳"';
	$ret .= ' style="'.$style.'"';
	$ret .= '>';

	return $ret;
}






/**
 * コメント欄作成
 * 2024-01-29
 *
 * @return void
 */
public function kxEdit_coment(){

	//ポストセット。2024-01-29
	global $post;
	$post = get_post( $this->kxedS1[ 'id_js' ] );
	setup_postdata( $post );

	//$post_id = $this->kxedOUT[ 'id' ];

	//comment_form( $args, $post_id );//コメント欄追記

	$args = array(
		// タイトルの「コメントを残す」の文字列を変更
		'title_reply'          => get_the_title(),
		'title_reply_to'       => '%s に返信する',
		// 返信を押した後の「コメントをキャンセル」の文字列を変更
		'cancel_reply_link'    => '取り消す',
		// 送信ボタンの「コメントを送信」の文字列を変更
		'label_submit'         => '送信する',

		'id_form'              => '',
		'id_submit'            => '',

		//'comment_field'        =>  '<p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
		'comment_field'        =>  '<p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
		'must_log_in'          => '',
		'logged_in_as'         => '',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'fields'               => apply_filters( 'comment_form_default_fields', array(
			'author' => '',
			'email'  => '',
			'url'    => '',
			)
		),
	);


	//$ret = comment_form( $args );
	$ret = comments_template();

	wp_reset_postdata();

	return $ret;

}


} //class


?>