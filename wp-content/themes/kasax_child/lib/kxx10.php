<?php
/**
 * class　＝　KX10
 */
class kx10 {

//設定の事前準備。エラー対策。2023-03-01
public $kx10S_base =
[
	'test' 				 =>	'TEST_S_base',
	'kxEdit_right' =>	NULL,
	's_cut' 			 => 'N/A(kx10)',
] ;

//基本設定。2023-03-01。
public $kx10S1;

//各id。個別設定。
public $kx10Sxx;

//public $set;
//public $kx10FormatON_ARR;

//htmlに出力される要素。2023-03-01
public $kx10out	=
[
	0 						       =>	'TEST_kx10H',
	'class_MainContents' =>	NULL,
	'style_MainContents' =>	NULL,
	'main_name_bar' 		 =>	NULL,
	'center_option_top'	 =>	NULL,
	'center_option_end'	 =>	NULL,
	'edit_new'					 =>	NULL,

] ;	//空の配列準備


//kx10の$t分岐、設定割付。2021-08-07
public $kx10JUDGE =
[
	'main' =>
	[
		'/./'  =>
		[
			'class12'					=>	NULL,
			'style12'					=>	NULL,
		],

		//all(normal-10)
		'/^[1-2]\d$/' =>
		[
			'class_top_left'	=>	'__white_space_nowrap __a_white',
			'style_top_left'	=>	'display:inline-block;font-size:medium;',

			'style12'					=>	'text-align:right;float:right;',
			'class2'					=>	'__kx10_excerpt __edit_js_back __margin_right2 __margin_left2',

			'h2_on'						=>	0,

			'hr_on'						=>	1,
			'nbsp_on'					=>	1,

			'edit_on'					=>	0,

			'top_on'					=>	1 ,

			'edit_on'					=>	1,
			'edit_on_title'		=>	1,
		] ,


		'/^[1-2]1$/'  =>
		[
			'class12'					=>	'__xsmall',
			'style_top_left'	=> 'display:inline-block;font-size:small;line-height:100%;',
			'title_border_off'	=> 1,
		] ,

		//12　大型
		'/^[1-2]2$/'  =>
		[
			'style_top_left'	=> 'display:inline-block;font-size:x-Large;line-height:130%;',
		] ,

		//13 引き出し用
		'/^[1-2]3$/'  =>
		[
			'style_top_left'	=> 'display:block;font-size:medium;',
			'title_full'			=>	1,
		] ,

		//14　Blockタイトル・ほぼ組み込み用
		'/^[1-2]4$/'  =>
		[
			'style_top_left'	=> 'display:block;font-size:Large;font-weight:bold;line-height: 3px;',// width: 600px;
			'title_bar_slim_on'			=>	1,
		] ,

		//15 引き出し型
		'/^[1-2]5$/'  =>
		[
			'class12'						=>	'__xsmall',
			//'style_top_left'		=> 'display:block;font-size:small;line-height:3px;',
			'style_top_left'		=> 'display:inline-block;width:90%;font-size:small;line-height:3px;',
			'title_border_off'	=> 1,
			'hr_on'							=> 0,
			'title_bar_slim_on'	=>	1,
			'reference_off'			=>	1,
			'hikidashi_on'			=>	1,
		] ,


		//16 ページ内ページ用
		'/^[1-2]6$/'  =>
		[
			'class12'						=>	'__xsmall',
			//'style_top_left'		=> 'display:block;font-size:small;line-height:3px;',
			'style_top_left'		=> 'display:inline-block;width:90%;font-size:small;line-height:3px;',
			'title_border_off'	=> 1,
			'hr_on'							=> 0,
			'title_bar_slim_on'	=>	1,
			'reference_off'			=>	1,
		] ,


		//'no_17'タイトル非表示
		'/^[1-2]7$/' =>
		[
			'edit_on_title'		=>	0,
		] ,


		//no_18・組み込み用・タイトル非表示
		'/^[1-2]8$/' =>
		[
			'edit_on_title'		=>	0,
		] ,

		//no_19・組み込み用
		'/^[1-2]9$/' =>
		[
			//無い。
		] ,
	]
];


/**
 * kx10メインプログラム
 *
 * @param array $kxxS1  ショートコード設定。
 * @param array $kx10Sxx 各タイプ用の追加設定。2023-02-28
 * @return void
 */
public function kx10_main( $kxxS1 , $kx10Sxx ){



	$this->kx10S1  	= $kxxS1;
	$this->kx10Sxx	= $kx10Sxx;
	//$this->kx10Sxx[ 'kxcl' ]		  = $kx10Sxx[ 'kxcl' ];

	$this->kx10_setting();

	//各種設定実行。2023-02-28
	$this->kx10_top_right();
	$this->kx10_top_left();
	$this->kx10_center();
	$this->kx10_edit_new();
}


/**
 * セッティング。
 *
 * @return void
 */
public function kx10_setting(){

	$this->kx10S1	= $this->kx10S1 + $this->kx10S_base;

	$this->kx10out = kx_Judge( $this->kx10JUDGE[ 'main' ] , $this->kx10S1[ 't' ] , $this->kx10out  );

	//FormatON
	$this->kx10Sxx[ 'FormatON_ARR' ] = kx_format_on( $this->kx10Sxx[ 'id' ] );

	if( !empty($this->kx10Sxx[ 'FormatON_ARR' ][ 'GhostON' ]) )
	{
		$this->kx10out[ 'id_js' ]	= $this->kx10Sxx[ 'FormatON_ARR' ]['GhostON'];
	}
	else
	{
		$this->kx10out[ 'id_js' ]	= $this->kx10Sxx[ 'id' ];
	}

	if( !empty( $this->kx10S1[ 'hr_off' ] ) )
	{
		unset( $this->kx10out[ 'hr_on' ] );
	}

	//オプション・引き出し
	//if( (!empty( $this->kx10S1[ 'sys' ] ) && preg_match( '/hikidashi/' , $this->kx10S1[ 'sys' ]	)) || !empty( $this->kx10out[ 'hikidashi_on' ] ) )
	if( (!empty( $this->kx10S1[ 'hikidashi' ] ) ) || !empty( $this->kx10out[ 'hikidashi_on' ] ) )
	{
		$this->kx10out[ 'center_option_top' ]  = '<div class="__hidden_box"><input type="checkbox" class="option-input01"><div>';
		$this->kx10out[ 'center_option_end' ]  = '</div></div>';
	}


	//text系
	if( !empty( $this->kx10S1[ 'title_end' ] ) )
	{
		$this->kx10S1[ 'text' ]	= end(explode(	'≫'	,$title	)	);
	}

	if(	preg_match(	'/2[7-9]/' , $this->kx10S1[ 't' ] ) )
	{
		//アウトライン追加。2021-08-02

		$_title_outline0	= end(	explode(	'≫'	 ,	$this->kx10Sxx[ 'title' ] )	) ;
		$_title_outline		= end(	explode(	'・'	,	 $_title_outline0)	) ;

		$_SESSION[ 'Heading' ][ 'n' ][ $this->kx10Sxx[ 'id' ] ] =
		[
			'h_x'			=>	2,
			'daimei'	=>	$_title_outline,
			'daimei0'	=>	$_title_outline0,
			'id_js'		=>	$this->kx10Sxx[ 'id' ],
		];

		$this->kx10out[ 'id_anchor' ]			= 'kxanchor' . $this->kx10Sxx[ 'id' ];

		if(	preg_match(	'/2[7-8]/' , $this->kx10S1[ 't' ] )  )
		{
			$this->kx10out[ 'bar' ]	= $_title_outline;

			$_style  .= 'background-color:hsla('.	$this->kx10Sxx[ 'kxcl' ][ '色相' ]	.	',100%,50% , .33  );';
			$_style  .= 'border:solid 3px hsla('.	$this->kx10Sxx[ 'kxcl' ][ '色相' ]	.	',100%,50% , .33  );';
			$_style  .= 'padding:7px 30px;font-size:Large;';
			$_class	.= '__radius_25';
			$_class	.= ' js_target_title'. $this->kx10out[ 'id_js' ] .'_'	.	$_title_outline0;

			$this->kx10out[ 'style_bar' ] = $_style;
			$this->kx10out[ 'class_bar' ] = $_class;
		}
	}

	$this->kx10_setting_reload_js();


	//wwr
	if( !empty( $this->kx10S1[ 'auto' ] ) && preg_match(	'/ww\w/i' , $this->kx10S1[ 'auto' ] ) )
	{
		$this->kx10_setting_wwx();
	}
}



/**
 * リロード。
 *
 * @return string	リロードhtml。
 */
public function kx10_setting_reload_js(){

	//読み込みjs
	if(	(	!empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) && (KxDy::get('trace')['kxx_sc_count'] ?? null ) <= 1	)	|| !empty( $_SESSION[ 'reference_on' ] ) )
	{
		if( !empty( $_SESSION[ 'reference_on' ] ) )
		{
			$_more = 1;
		}
		else
		{
			$_more = 0;
		}

		kx_kxx_jq_main( $this->kx10out[ 'id_js' ] , 'main' );

		$_width	= 'width:auto;';
		$_style	= 'color:hsla(	'.$this->kx10Sxx[ 'kxcl' ][ '色相' ].'	,	100%,50%	,	1	);';
		$_url		= 'wp-content/themes/kasax_child/lib/php/p_hyouji.php';

		$str = NULL;


		$str	.= '<span class="_kxjq_yomi_main'.$this->kx10out[ 'id_js' ].' __float_right2" style="display: inline-block;" tabindex="-1">';
		$str	.= '<input type="hidden" class="id" value="'.$this->kx10Sxx[ 'id' ].'">	';
		$str	.= '<a style="'.$_style.'" href="'.$_url.'?id='.$this->kx10Sxx[ 'id' ].'&type=reload&more='.$_more.'&width_hyouji='.$_width.'" tabindex="-1" >';
		$str	.= '🗘</a>';
		$str	.= '</span>';


		$this->kx10out[ 'reload' ]	= $str;
	}
	else
	{
		$this->kx10out[ 'reload' ]	= NULL;
	}
}


/**
 * wwx。heading用の設定。
 *
 */
public function kx10_setting_wwx(){

	//羅列呼び出し。2022/04/20
	$kxra	= new	raretu;

	//barのカラー表示制御に必要。2023-08-01
	if( preg_match( '/∬\d{1,}≫c/' , get_the_title( $this->kx10Sxx[ 'id' ] ) ) )
	{
		$kxra->kxraS1[ 'kxra_type' ][ 't' ] = 'chara';
	}

	//羅列のpost設定構築。2022/04/20
	$kxra->kxra_Setting_Post( $this->kx10Sxx[ 'id' ] );
	$this->kx10S1[ 'kxraS_post' ] = $kxra->kxraS_post;

	//タイトル文字の装飾変更。2023-08-01
	$this->kx10out[ 'plot_on' ]	= 1;


	if( empty( $this->kx10S1[ 'id_Heading' ] ) )
	{
		echo '■ERROR LINE=kxx10.php-'. __LINE__.'■';
	}


	//id取得。2023-08-01
	if( !empty( $this->kx10S1[ 'arr_wws' ]['raretu_id_base'] ))
	{
		$_id_base  = $this->kx10S1[ 'arr_wws' ]['raretu_id_base'] ;
	}
	else
	{
		$_id_base  = get_the_ID();
	}


	//見出しの数字呼び出し。2023-08-01
	$_h_x  = $kxra->kxra_Heading(
	[
		'id' 		=> $_id_base ,
		'type'	=> $this->kx10S1[ 'auto' ] ,
		'damei' => $kxra->kxraS_post['daimei']  ,
		't2' 		=> $this->kx10S1[ 'arr_wws' ]['raretu_t2']
	])[ 'h_x' ];


	if( empty( $kxra->haeding_title_add ))
	{
		$kxra->haeding_title_add = NULL;
	}


	if( empty( $kxra->haeding_plot_on ))
	{
		$kxra->haeding_plot_on = NULL;
	}


	//heading制御。作品来歴用・同一タイム排除。2023-08-01
	if(
		!empty( $_SESSION[ 'h2_check' ][ 'kxx10' ][ 'type' ] )
		&& $_SESSION[ 'h2_check' ][ 'kxx10' ][ 'type' ] == 'wwx'
		&& !empty( $_SESSION[ 'h2_check' ][ 'kxx10' ]['time_full'] )
		&& $_SESSION[ 'h2_check' ][ 'kxx10' ]['time_full'] == $kxra->kxraS_post[ 'time_full' ]
	){
		$_on = 'off';
	}
	else
	{
		$_SESSION[ 'h2_check' ][ 'kxx10' ]['time_full'] = $kxra->kxraS_post[ 'time_full' ];
		$_on = 0;
	}


	kx_session_raretu_Heading(
	[
		'id'            	=>  $this->kx10S1[ 'id_Heading' ] ,
		'id_js'         	=>  $this->kx10Sxx[ 'id' ],
		'type'          	=>  $this->kx10S1[ 'auto' ]	,
		'raretu_count'		=>  $this->kx10S1[ 'arr_wws' ]['raretu_count'] ,
		'h_x'           	=>  $_h_x,
		'daimei'        	=>  $kxra->kxraS_post[ 'daimei' ],
		'daimei_add'    	=>  $kxra->haeding_title_add,
		'haeding_plot_on' =>  $kxra->haeding_plot_on,
		'on-off' 					=>  $_on,
	] );

	unset( $kxra->haeding_title_add );

	if( empty( $this->kx10out[ 'class_bar' ] ) )
	{
		$this->kx10out[ 'class_bar' ] = NULL;
	}

			//アンカー。
	if( !empty( $_SESSION[ 'Heading_count' ][ $this->kx10S1[ 'id_Heading' ] ][ $this->kx10S1[ 'auto' ] . $_h_x ] ) )
	{
		$this->kx10out[ 'id_anchor' ] = 'kxanchor' . $_h_x . '_' . $_SESSION[ 'Heading_count' ][ $this->kx10S1[ 'id_Heading' ] ][ $this->kx10S1[ 'auto' ] . $_h_x ];
	}


	//class設定。2023-08-01。
	if(	$this->kx10S1[ 'auto' ] == "wws"  || $this->kx10S1[ 'auto' ] == "wwr" 	)
	{
		//wwt以外は、スルー。クラス設定は不要。
	}
	elseif(	$_h_x	== 2)
	{
		$this->kx10out[ 'class_bar' ]					 .= ' __h2';
		$this->kx10out[ 'class_MainContents' ] .= ' __h2';
	}
	else
	{
		$this->kx10out[ 'class_bar' ]					 .= ' __h3';
		$this->kx10out[ 'class_MainContents' ] .= ' __h3';
	}

	//style設定。2023-08-01。

	$this->kx10out[ 'style_bar' ] = '';


	$this->kx10out[ 'style_MainContents' ]	 = 'border-left:2px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100% , 66%   ,1);';
	$this->kx10out[ 'style_MainContents' ]	.= 'border-right:1px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,50%  ,.5);';


	$this->kx10out[ 'style_MainContents_add' ] = 'background-color:hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,50%,.03);';



	//■wws・wwr・設定
	$this->kx10out[ 'bar' ] = NULL;

	/*
	if(	$this->kx10S1[ 'auto' ]	== 'ww_time_table')
	{
		//style_MainContentsリセット。
		//$this->kx10out[ 'style_MainContents' ]	 = $_style5000_chara;
		$this->kx10out[ 'style_MainContents' ]	.= $this->kx10out[ 'style_MainContents_add' ];
		if( $wwr_name ):
			//class_MainContentsリセット。
			$this->kx10out[ 'class_MainContents' ]	 = '__bg_100_25_'. $this->kx10Sxx[ 'kxcl' ][ '色相' ];
			$this->kx10out[ 'style_MainContents' ]	 = 'text-align:right;	font-size:small;';
			$this->kx10out[ 'style_MainContents' ]	.= 'margin:0px 0px 0 0;	padding:0 0 0 0;';
			$this->kx10out[ 'style_MainContents' ]	.= 'height: 20px;	color:white;	">';
			$this->kx10out[ 'main_name_bar' ]  .= $wwr_name.$wwr_name_sa;
		endif;
	}
	else
	*/



	if(	$this->kx10S1[ 'auto' ]	== 'wws')
	{
		//多分使っていない。2023-08-01
		$this->kx10_setting_wws();


		//bar設置。同一日付排除。2023-08-01
		if(
			empty( $_SESSION[ 'kxx' ][ 'wwx time_Memory' ] )
			|| $_SESSION[ 'kxx' ][ 'wwx time_Memory' ] != $kxra->kxraS_post['time_nendo'] . $kxra->kxraS_post['time_month'] . $kxra->kxraS_post['time_day']
		)
		{
			$_SESSION[ 'kxx' ][ 'wwx time_Memory' ] = $kxra->kxraS_post['time_nendo'] . $kxra->kxraS_post['time_month'] . $kxra->kxraS_post['time_day'];

			$kxra->kxra_bar( $this->kx10Sxx[ 'id' ] );
			$this->kx10out[ 'bar' ] = $kxra->kxraM[ 'bar' ];
		}


		//$sa = NULL; //不明php8.0 2022-01-26
		//$css_plus_c  = '';
		$this->kx10out[ 'main_name_bar' ] = $kxra->kxra_bar_name(
		[
			'name' => $kxra->kxraS_post[ 'chara_name' ] ,
			'kxcl' => $this->kx10Sxx[ 'kxcl' ] ,
			'sa'   => NULL, //$sa ,
			'time' => $kxra->kxraS_post[ 'time_full' ],
			'auto' => $this->kx10S1[ 'auto' ],
		] );
	}
	elseif(	$this->kx10S1[ 'auto' ]	== 'wwr')
	{
		//■WWR
		$this->kx10out[ 'style_MainContents' ]	.= $this->kx10out[ 'style_MainContents_add' ];

		$_sa = kx_gakunen(
			$this->kx10S1[ 'ra_post_set' ][ 'time_sa' ],
			$kxra->kxraS_post[ 'arr_character' ][ 'character_gaku' ],
		);



		$this->kx10out[ 'main_name_bar' ]  = $kxra->kxra_bar_name(
		[
			'name'     => $kxra->kxraS_post[ 'chara_name' ]	,
			'kxcl'     => $this->kx10Sxx[ 'kxcl' ] ,
			'sa'       => $_sa,
			'time'     => $this->kx10S1[ 'ra_post_set' ]['time_full'], //$_time_full
			'auto'     => $this->kx10S1[ 'auto' ],
		] );


	}
	//elseif(	$this->kx10S1[ 'auto' ]	== 'wws')
	//{}
	//スルー。2023-08-01
	//elseif(	$this->kx10S1[ 'auto' ]	== 'wwr'):
	elseif(	$this->kx10S1[ 'auto' ]	== 'wwt')
	{
		//幅。
		//要素追加。上にheading設定がある。
		$this->kx10out[ 'class_MainContents' ]	.= ' __kxra_single_set__';
		$this->kx10out[ 'style_MainContents' ]	= NULL;

		$this->kx10out[ 'class_bar' ]	 .= ' __kxra_single_set__';
		$this->kx10out[ 'style_bar' ]  .=   'background-color:'. $this->kx10Sxx[ 'kxcl' ][ 'hsla_normal' ] .';';

		$this->kx10out[ 'bar' ]  = '&nbsp;';

		/*
		if( $_h_x  ==  2 )
		{
			$this->kx10out[ 'style_bar' ]  .=   'background-color:'. $this->kx10Sxx[ 'kxcl' ][ 'hsla_normal' ] .';';
		}
		elseif( $_h_x  ==  3 )
		{
			$this->kx10out[ 'style_bar' ]  .=   'background-color:'. $this->kx10Sxx[ 'kxcl' ][ 'hsla_normal' ] .';';
		}
		elseif( $_h_x  >  3 )
		{
			$this->kx10out[ 'style_bar' ]  .=   'background-color:'. $this->kx10Sxx[ 'kxcl' ][ 'hsla_normal' ] .';';
		}
		elseif( $this->kx10S1[ 'arr_wws' ]['wwl'] )
		{
			$this->kx10out[ 'bar' ]	 = '<hr class="__wwl">';
		}
		else
		{
			$this->kx10out[ 'bar' ]	.= '<div class="__bg_100_80_270 __color_white __padding_right10 __padding_left10 __radius_10 __margin_left10 __margin_right30">';
			$this->kx10out[ 'bar' ]	.= $kxra->kxraS_post['time'];
			$this->kx10out[ 'bar' ]	.= '</div>';
		}
		*/
	}
	else
	{
		echo '■■■■■kx10wwx関係のエラー■■■■■';
	}
}



/**
 * wws要設定。
 * 多分使っていない。
 * 2023-08-01
 *
 * @return void
 */
public function kx10_setting_wws(){

	//停止中。2023-09-07
	return;



	$_title = get_the_title( $this->kx10Sxx[ 'id' ] );

	preg_match(	'/∬\d{1,}≫(c\d\w{1,}\d)/i'	,	$_title	,	$matches_wws);

	if( !preg_match(	'/^(.*?)(_.*|)(:.*|)＠/i'	,	end( explode('≫'	,	$_title)	)	,	$matches_wws_end))
	{
		kx_CLASS_error( '■ERROR■注意■日付入りポストなし■■' );

		$matches_wws_end[2]  = NULL;
	}


	if( !empty( $_SESSION[ 'arr_wws' ] ) && is_array( $_SESSION[ 'arr_wws' ] )  )
	{
		$_SESSION[ 'arr_wws' ] 	+= array(	$matches_wws[1]	=>	$matches_wws[1]	);
	}
	else
	{
		$_SESSION[ 'arr_wws' ]	= array(	$matches_wws[1]	=>	$matches_wws[1]	);
	}


	$_s_wws	= 0;
	foreach( $_SESSION[ 'arr_wws' ]	as $_value ):

		if( preg_match(	'/∬\d{1,}≫'. $_value .'/i'	,	$_title	,	$matches_wws1) )
		{
			break;
		}
		else
		{
			$_s_wws++;
		}

	endforeach;
	unset( $_value );


	if( $matches_wws[1]	== 'c989' )
	{
		//読者視点・指定。
		$_s_wws	= 989;
	}


	$_vvv_code	= str_replace('_' , '' , $matches_wws_end[2] );

	if( preg_match('/.*-(\w)(\d|)/' , $_vvv_code,$matches_vvv_sx) ):
		$_vvv_code_sx	= $matches_vvv_sx[1];
	else:
		$_vvv_code_sx	= NULL;
	endif;


	$_vvv_code_sd_on	= '__kxra_s_code_w1_on';

	if( (!empty( $_vvv_code_sx ) &&  !empty( $_SESSION['vvv_code_sx_old'] ) && $_vvv_code_sx	== $_SESSION['vvv_code_sx_old'] ) || empty( $_vvv_code_sx ) ):

		$_vvv_code_sx_on = '';

		if( !empty( $_SESSION['vvv_sd'] )):
			$_SESSION['vvv_sd']++;
		else:
			$_SESSION['vvv_sd'] =  1;
		endif;


		if( $_s_wws	== 0 ):

			if( !empty( $_SESSION[ 'vvv_sd2' ] )):

				$_SESSION[ 'vvv_sd2' ]++;

			else:

				$_SESSION[ 'vvv_sd2' ]=  1;

			endif;

		endif;

	else:


		$_vvv_code_sx_on ='1';
		$_SESSION['vvv_sd']=0;

		if($_s_wws	== 0):

			$_SESSION[ 'vvv_sd2' ]=1;

		endif;

	endif;

	if($_SESSION['vvv_sd'] > 5 && $_s_wws	== 0 ):

		$_vvv_code_sx_on ='1';
		$_vvv_code_sd_on ='__kxra_s_code_w1_on_s';

		if(!$_vvv_code_sx):

			$_vvv_code_sx_on ='';
			$_vvv_code_sd_on ='';

		else:

			$_SESSION['vvv_sd']=0;

		endif;

	endif;

	$_s_code_w1	= strtoupper($_vvv_code_sx);

	$_vvv_sx_color	= $this->kx10S1[ 'kxraS_post' ][ 'c_sikisou_raretu_sx' ];

	if( $_vvv_code_sx_on ):

		//追記。2022-08-06
		if( empty( $_SESSION[ 'vvv_sd2' ] )):
			$_SESSION[ 'vvv_sd2' ] = NULL;
		endif;

		$_vvv_code_sx_on  = '<div class="zindex2">';
		$_vvv_code_sx_on .= '<span class=" __bg_100_33_'.$_vvv_sx_color.' '.$_vvv_code_sd_on.'">+++';
		$_vvv_code_sx_on .= $_s_code_w1.$_SESSION[ 'vvv_sd2' ];
		$_vvv_code_sx_on .= '</span>';
		$_vvv_code_sx_on .= '</div>';

	else:

		$_vvv_code_sx_on = NULL;

	endif;


	if($_vvv_code_sx):

		$_SESSION['vvv_code_sx_old']	= $_vvv_code_sx;

	endif;

	$this->kx10out[ 'main_name_bar' ]  =  $_vvv_code_sx_on;

	$this->kx10out[ 'style_MainContents' ]	.=  $this->kx10out[ 'style_MainContents_add' ];


	if(	!empty( $_s_wws) && $_s_wws	== 0 && $this->kx10S1[ 'arr_wws' ][ 'chara_count' ]	== 0	&& $this->kx10S1[ 'auto' ]	== 'wws')
	{

		//キャラ一人。
		//★チェック。$_vvv_sx_color。多分使っていない。2021/09/21
		$this->kx10out[ 'class_MainContents' ] .= ' __bg_100_97_'.$_vvv_sx_color.' __kxra_wws_0';

		//elseif($_s_wws || $_s_wws == 0):
		//$this->kx10out[ 'class_MainContents' ] .= ' __bg_100_97_'.$_vvv_sx_color;

	}


	if( !empty( $_s_wws ) )
	{
		if( !empty( $_title ) && preg_match(	'/≫c989/i'	,	$_title) )
		{
			$this->kx10out[ 'class_MainContents' ]	= '__bg_100_98_'. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .' __kxra_width_989 __kxra_wws_989';
			$this->kx10out[ 'style_MainContents' ]	= 'border-left:5px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,75%,1);';
			$this->kx10out[ 'main_name_bar' ]  .= $css_plus_c;
		}
		elseif( $_s_wws	=== 0)
		{

			//wws・通常型
			$_width_wwx  = 700;

			$this->kx10out[ 'style_bar' ]  =   'width:'.$_width_wwx.'px;';

			$this->kx10out[ 'style_MainContents' ]	 = 'width:'.$_width_wwx.'px;';
			//$this->kx10out[ 'style_MainContents' ]	.= $_style5000_chara;
			$this->kx10out[ 'style_MainContents' ]	.=  $this->kx10out[ 'style_MainContents_add' ];

			$this->kx10out[ 'main_name_bar' ]  = $css_plus_c;

			//$css_plus1 = '</div>';
		}
		elseif( $_s_wws	== 1)
		{
			//★★★★
			//wws・階段型
			//Q：$_s_wws==0 以外は使っていない？2020/07/20
			//A：階段状にする場合のに使う。2020-07-20

			$this->kx10out[ 'class_MainContents' ]	 = '__kxra_width_0 __kxra_wws_1';
			$this->kx10out[ 'style_MainContents' ]	 = 'border-left:5px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,75%,1);border-right:1px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,25%,1);';
			$this->kx10out[ 'style_MainContents' ]	.= 'background-color:hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,50%,.05);';
			$this->kx10out[ 'main_name_bar' ]  .= $css_plus_c;
			//$css_plus1 = '</div>';
		}
		elseif( $_s_wws	== 2)
		{

			$this->kx10out[ 'class_MainContents' ]	= '__bg_100_98_'. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .' __kxra_width_0 __kxra_wws_2';
			$this->kx10out[ 'style_MainContents' ]	= 'border-left:5px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,75%,1);border-right:1px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,25%,1)';
			$this->kx10out[ 'main_name_bar' ]  .= $css_plus_c;

		}
		elseif( $_s_wws	>	2)
		{
			$this->kx10out[ 'class_MainContents' ]	= '__bg_100_98_'. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .' __kxra_width_3 __kxra_wws_3"';
			$this->kx10out[ 'style_MainContents' ]	= 'border-left:5px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,75%,1);border-right:1px solid hsla('. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .',100%,25%,1);';
			$this->kx10out[ 'main_name_bar' ]  .= $css_plus_c;
		}
	}
}




/**
 * 上段左。
 * 元ret11
 *
 * @return string	リロードhtml。
 */
public function kx10_top_left(){

	$ret = '';

	// 見出し（リンク）
	if( !empty( $this->kx10out[ 'edit_title' ] ) )
	{
		if( !empty( $this->kx10S1['works_TEMPLATE'] ) )
		{


			foreach( KxSu::get('title_kx10') as $_key => $_value ):

				if( preg_match( '/^〇\w\d{3}$/', $_key) )
				{
					$_pattern_add  = '|^' . $_key .'('. KxSu::get('titile_search')[ 'work_Platform' ] .'|)'. '$';
				}
				else
				{
					$_pattern_add  = NULL;
				}

				$_pattern  = '/';
				$_pattern .= '^' . KxSu::get('titile_search')[ 'work_template_short' ] . $_key . '$';
				$_pattern .= '|^' . $_key . KxSu::get('titile_search')[ 'work_template_short' ] . '$';
				$_pattern .= $_pattern_add ;
				$_pattern .= '/';

				//echo $_pattern;
				//echo '<br>';


				if( preg_match( $_pattern , $this->kx10out[ 'edit_title' ] ) )
				{
					if( !empty( $_pattern_add ) )
					{
						$this->kx10out[ 'edit_title' ] = $_value.'　'.$this->kx10out[ 'edit_title' ];
					}
					else
					{
						$this->kx10out[ 'edit_title' ] = $this->kx10out[ 'edit_title' ] .'　'. $_value;
					}
					unset( $_pattern_add );
				}
			endforeach;
		}

		$ret	= $this->kx10out[ 'edit_title' ];
	}
	elseif( $this->kx10out[ 'top_on' ] )
	{
		echo '<spna sytle="color:red;">使っていないA。kxx10.php'.__LINE__.'：'.$this->kx10out[ 'edit_title' ].'</span>';
	}


	//追記
	if( !empty( $_SESSION[ 'reference_on' ] ) )
	{
		$ret .= '(ref)';
	}
	elseif( !empty( $this->kx10out[ 'title_full'] ) )
	{
		$ret .= '<span style="opacity: 0.5;font-size:small;margin-left:20px;">';
		$ret .= $this->kx10Sxx[ 'title' ];
		$ret .= '</span>';
	}


	$this->kx10out[ 'top_left' ] = kx_CLASS_kxTitle(
	[
		'type'    => 'kx10',
		'title'   => $this->kx10Sxx['title'] ,
		'content' => $ret,
	] )[ 'content' ];
}



/**
 * 上段右
 * 右上リンク ret12
 *
 * @return string	リロードhtml。
 */
public function kx10_top_right(){

	if( !empty( $this->kx10out[ 'edit_on' ] ) )
	{
		$_title_edit	= preg_replace( '/.*＠(.*)/' , '$1', str_replace( '∌' , '' , end( explode( '≫' , get_the_title( $this->kx10Sxx[ 'id' ] ) ) ) ) );


		if( !empty( $this->kx10S1[ 'text' ] ) )
		{
			$this->kx10out[ 'edit_title' ]	= $this->kx10S1[ 'text' ];
		}
		else
		{
			$this->kx10out[ 'edit_title' ]	= $_title_edit;
		}


		if( !empty( $this->kx10S1[ 'arr_wws' ]['raretu_id_base'] ))
		{
			//wwrの場合。
			$_hyouji = '　' . 'Edit';
		}
		else
		{
			$_hyouji = '　' . $_title_edit;
		}

		$_sys = 'foo';


		if( !empty( $this->kx10S1[ 'kxEdit_right' ] ) )
		{
			$_sys	.= ',kxEdit_right';
		}


		if( !empty( $edit_chara ) )
		{
			$_sys	.= ',edit_chara';
		}


		if( !empty( $this->kx10S1[ 'sys' ] ) )
		{
			if( preg_match(	'/reference_off/' , $this->kx10S1[ 'sys' ] ) )
			{
				$_sys	.= ',reference_off';
			}

			if( preg_match(	'/chara_count\d/' , $this->kx10S1[ 'sys' ] , $matches ) )
			{
				$_sys	.= ','.$matches[0];
				unset( $matches);
			}
		}


		$in	=
		[
			'id'						=>	$this->kx10Sxx[ 'id' ],
			'id_js'					=>	$this->kx10out[ 'id_js' ],
			'hyouji'				=>	$_hyouji,
			'hyouji_style'	=>	'background-color:hsla('.	$this->kx10Sxx[ 'kxcl' ][ '色相' ]	.',100%,66%,.33);line-height: 10px;',
			'css_hyouji'		=>	'__text_shadow_normal '.' js_target_title'. $this->kx10out[ 'id_js' ]	.	'_'.$_title_edit. ' __a_inversion',
			'memo'					=>	's_cut：' . $this->kx10S1[ 's_cut' ] ,
			'sys'						=>	$_sys,
		];


		if( !empty( $this->kx10out[ 'edit_on_title' ] ) )
		{
			//表示タイトル省略
			if( mb_strlen( $_title_edit ) > 6 )
			{
				$in[ 'hyouji' ]	= '　Edit';
			}

			$class11  = NULL;
			$style11  = NULL;
			$style11b = NULL;

			if( !empty( $this->kx10out[ 'plot_on' ] ) )
			{
				$style11	.= 'border-radius: 0px 0px 100px 0px / 0px 0px 50px 0px;';
				$style11	.= 'margin:0px 0px 5px 0px;padding:0px 50px 2px 7px;';
			}
			elseif( !empty( $this->kx10out[ 'title_bar_slim_on' ] ) )
			{
				$style11	.= 'border-radius: 15px 15px 15px 15px / 15px 15px 15px 15px;';
				$style11	.= 'margin:0px 0px 15px 0px;padding:0px 15px 0px 10px;';
				$style11	.= 'text-shadow:hsla(180,0%,0%,1) 2px 2px 0px,hsla(180,0%,0%,1) -2px 2px 0px,';
				$style11	.= 'hsla(180,0%,0%,1) 2px -2px 0px,hsla(180,0%,0%,1)  -2px -2px 0px;';
			}
			else
			{
				$style11	.= 'border-radius: 15px 15px 15px 15px / 15px 15px 15px 15px;';
				$style11	.= 'margin:0px 0px 5px 0px;padding:0px 15px 0px 15px;';
			}

			$class11	 .= ' __color_white';
			$class11	 .= ' __font_weight_bold' ;
			$class11	 .= ' js_target_title'. $this->kx10out[ 'id_js' ] .'_'.$_title_edit;

			//$style11	 .= 'background-color:hsla('.	$this->kx10Sxx[ 'kxcl' ][ '色相' ]	.	',100%,25%,.75);';
			$style11	 .= 'background-color:' . $this->kx10Sxx[ 'kxcl' ][ 'hsla_light' ] . ';';
			$style11	 .= 'white-space: nowrap;text-overflow: ellipsis;';

			if(	empty( $this->kx10out[ 'title_border_off' ] )	)
			{
				$style11	 .= 'border:2px solid ' . $this->kx10Sxx[ 'kxcl' ][ 'hsla_normal' ] . ';';
				$style11	.= 'margin:0px 0px 15px 0px;';

				if( $this->kx10S1['t'] == 24 || $this->kx10S1['t'] == 14 )
				{
					$style11	.= 'margin:15px 0px 15px 0px;';

					$style11b  = '';
					$style11b  = 'border:2px solid hsla(' . $this->kx10Sxx[ 'kxcl' ][ '色相' ] . ',100%,50%,.5);';
					//$style11b	.= 'background:hsla(' . $this->kx10Sxx[ 'kxcl' ][ '色相' ] . ',100%,15%,1);';
					$style11b	.= 'background-color: hsl(0,0%,7.5% );';
					//$style11b	.= 'background:black;';
					$style11b	.= 'border-radius: 15px 15px 15px 15px / 15px 15px 15px 15px;';
					$style11b	.= 'margin:0px 0px 5px -15px;padding:0px 15px 0px 15px;';
				}
			}
		}
		else
		{
			$this->kx10out[ 'style_top_left' ]	= 'display:none;';
			$style11 = NULL;
			$class11 = NULL;
			$style11b = NULL;
		}

		$this->kx10out[ 'edit' ]	= kxEdit( $in );

		$this->kx10out[ 'style_top_left' ]	.= $style11;
		$this->kx10out[ 'style_top_left2' ]	= $style11b;
		$this->kx10out[ 'class_top_left' ]	.= $class11;
	}

	$this->kx10out[ 'top_right' ]	= $this->kx10out[ 'edit' ];
}



/**
 *
 * @return string	リロードhtml。
 */
public function kx10_center(){

	$this->kx10out[ 'kx10_class_center' ] = NULL;

	if( !empty( $this->kx10S1[ 'sys' ] ) && !preg_match( '/js_id_no/' , $this->kx10S1[ 'sys' ] ) )
	{
		$this->kx10out[ 'kx10_class_center' ]		.= ' displayArea3' . $this->kx10out[ 'id_js' ];
	}

	//　時間差。近接時間アップデート表示
	if(	kx_time_modified( $this->kx10Sxx[ 'id' ] )[ 'sa' ] < 60 ||
		(
			!empty( $this->kx10Sxx[ 'FormatON_ARR' ]['GhostON'] ) &&
	 		kx_time_modified( $this->kx10Sxx[ 'FormatON_ARR' ]['GhostON'] )[ 'sa' ] < 60
		)
	)
	{
		$this->kx10out[ 'kx10_class_center' ]		.= ' __time_sa';
	}
}



/**
 *
 * @return string	リロードhtml。
 */
public function kx10_edit_new(){

	//編集・新規
	if( !empty( $this->kx10S1[ 'sys' ] ) && preg_match('/new_on/'	,	$this->kx10S1[ 'sys' ] ))
	{
		$sys_add	='';

		if( !empty( $this->kx10S1[ 'sys' ] ) &&preg_match('/kxEdit_right/'	,	$this->kx10S1[ 'sys' ] ) )
		{
			$sys_add	.= ',kxEdit_right';
		}

		if( !empty( $this->kx10S1[ 'sys' ] ) &&preg_match('/edit_chara/'	,	$this->kx10S1[ 'sys' ] ) )
		{
			$sys_add	.= ',edit_chara';
		}

		if( !empty( $this->kx10S1[ 'arr_wws' ]['raretu_id_base'] ))
		{
			//wwrの場合。
			$sys_add	.= ',wwr';
		}

		$this->kx10out[ 'edit_new' ]	.= kxEdit(
		[
			'new'						=>	1,
			't'							=>	75,
			'hyouji'				=>	'&nbsp;╋&nbsp;',
			'hyouji_style'	=>	'background:hsla(	'. $this->kx10Sxx[ 'kxcl' ][ '色相' ] .'	,100%,50%,.15);font-size:xx-small;line-height: 1em;width:20px;',
			'css_hyouji'		=>	'__kxEdit_rareut_plot',
			'sys'						=>	$this->kx10S1[ 'kxEdit_right' ] . $sys_add,
			'new_title'			=>	$this->kx10Sxx['title'] ,

		] );
	}
}

} //class end ?>