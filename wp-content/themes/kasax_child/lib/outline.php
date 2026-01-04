<?php
/**
 * outlineクラス class
 * 23	旧型
 * 24	通常用
 * 25	サイドバー用
 * 70	装飾少しだけ。margin10。トップ用。
 * 71	装飾少しだけ。margin0。文中用
 * 80	上限999型。margin10。トップ用。
 * 90	ページトップ用・主にraretu用
 *
 * sys	head_no	ヘッドなし。
 * sys	title_end_off	indeのタイトル表示。エンドのみを解除（リンク字）
 *
 * _h	階層
 */
class kxol{

public $kxolS_base	=  //基本は途中代入用。
[
	0				=> 'TEST_S_BASE',
	's_cut'	=> 'N-A',
	'tag'		=> NULL,
	'order'	=> NULL,
	'h'			=> NULL,
	'max'		=> NULL,
	'array_name1' => NULL,
	'sys'		=> 'N-A',	//Error対策で必要。理由不明。2022-01-26
];

public $kxolS0	= [ 0 => 'TEST_S0_OK' ] ;	//初期入力配列。空の配列準備
public $kxolS1	= [ 0 => 'TEST_S1_OK' ] ;	//空の配列準備

//出力系。2023-08-23
public $kxol_str;

//中核の配列。2023-08-23
public $kxol_Array_SESSION;




//public $kxolSh;
//public $judge;
//public $h2; コメントアウト。2023/01/21
//public $outline;
//public $kxol_Nstr;
//public $kxol_Sstr;


//設定
public $kxol_SET=
[
	'LIMIT' =>
	[
		'max'			 => 32 ,
		'max_25'	 => 100,
		'max_8x'	 => 999 ,
		'max_h2'	 => 50 ,
	]
];

/**
 * outline設定
 *
 * @var array
 */
public $kxolJUDGE =
[
	'Main' =>
	[
		'array' =>
		[
			//all
			0 =>
			[
				'preg' 		 => '/./' ,
				'settings' => 	[
					'title_no'					=> '-　no outline　-',
					'title_top'					=> 'outline',
					'css_content'				=> '__menu_ul10',
					'hani'							=> '2-6',
					'css_title'	 				=> 'n-a',
					'outline_Control_start' => '',
					'outline_Control_end' 	=> '',
					'class_outline_Main0'		=> '__kxol_box_div200',
					'id_outline_Main0'			=> '',
					'class_outline_Main1'		=> '',
					'id_outline_Main1'			=> '',
					'class_outline_Main2'		=> '',
				] ,
			] ,

			'get_outline_info' =>
			[
				'preg' 		 => '/^2[3-5]$|^[7-8][0-1]$/',
				'settings' =>
				[
					'goi_on'					=> 1 ,
				],
			],

			'23kei' =>
			[
				'preg' 			=>  '/^2[3-4]$/' ,
				'settings' =>
				[
					'title_index2'	=> 'outline',
					'margin'		 		=> '__margin_left25 __margin_right25',
					'class_outline_Main2'		 		=> '__margin_left25 __margin_right25',
					'css_title'	 		=> 'kx_index_ue',
				] ,
			] ,

			//サイド用25
			'Side25' =>
			[
				'preg' 		 => '/^25$/' ,
				'settings' =>
				[
					'css_content'						=> '__kxol_side',
					'id_outline_Main0'			=> 'outline',
					'outline_Control_start'	=> '</div><div class="__kxol_side_box __kxol_240" id="outline"><div>',
					'outline_Control_end'		=> '</div></div>',
				] ,
			] ,

			//データベース系
			'db' =>
			[
				'preg' 			=> '/^6\d$/' ,
				'settings' =>
				[
					'outline_Control_start'	=>	'<div class="__kxol_box"><div class="__kxol_box_db __kxol_400"><div>',
					'outline_Control_end'		=>	'</div></div></div>',
					'class_outline_Main0'		=> '__kxol_box',
					'class_outline_Main1'		=> '__kxol_box_db __kxol_400',
				] ,
			] ,

			//主に羅列のトップ用。基本使用。2023-03-23
			'70' =>
			[
				'preg' 		 =>  '/^[7-8]0$/' ,
				'settings' =>
				[
					'margin'								=> '__margin_left10 __margin_right1',
					'class_outline_Main2'		=> '__margin_left5 __margin_right1',
					'css_title'							=> 'kx_index_ue',
				] ,
			] ,


			'71' =>
			[
				'preg' 		 => '/^71$/' ,
				'settings' =>
				[
					'margin'			=> '__margin_left5 __margin_right1',
					'class_outline_Main2'		=> '__margin_left0 __margin_right1',
					'css_title'	=> 'kx_index_ue',
				] ,
			] ,


			'8x' =>
			[
				'preg' 			=> '/^8\d$/' ,
				'settings' =>
				[
					'outline_Control_start'	=>	'<div class="__kxol_box"><div class="__kxol_box_t8x __kxol_400"><div>',
					'outline_Control_end'		=>	'</div></div></div>',
					'class_outline_Main0'		=> '__kxol_box',
					'class_outline_Main1'		=> '__kxol_box_t8x __kxol_400',
				] ,
			] ,
		]
	],
] ;



/**
 * Outlineの調整。
 *
 * @var array
 */
public $kxol_title_replace =
[
	//'/(■|◆|▼|◇|●|○|◎)(.*)(■|◆|▼|◇|●|○|◎)/'	=>	'$2'	,
	//'/(∵|“)(.*)(∵|”)/'																=>	'$2'	,
	'/〚(.*)〛/'																					=>	'$1'	,	//キャラFORMAT系
	'/(〘)(.*)(〙)/'																			=>	'$2'	,	//キャラFORMAT系
	'/：＜(.*?)＞/'																				=>	''		,	//キャラFORMAT系
	'/∌/'																									=>	''		,	//汎用系
];



/**
 * outlineメインプログラム
 *
 * @return void
 */
public function kxol_Main( $args ){

	$this->kxolS0 = $args;

	$this->kxol_setting0();
	$this->kxol_setting_raretu();
	$this->kxol_setting_Decoration();
	$this->kxol_setting_link();


	if( $this->kxolS1[ 'type' ] == 'Not_outline' )
	{
		//outline不要。検索系のページなど。2023-08-23

		$this->kxol_str[ 'outline_str' ] = $this->kxol_type_Not_outline();
	}
	elseif( $this->kxolS1[ 'type' ] == 'SESSION_ID' || $this->kxolS1[ 'type' ] == 'SESSION_n' )
	{
		//SESSION型

		if(	$this->kxolS1[ 'type' ] == 'SESSION_ID' )
		{
			$this->kxol_Array_SESSION  = $_SESSION[ 'Heading' ][ $this->kxolS1[ 'id' ] ];
			$this->kxol_type_SESSION_ID();
		}
		elseif(	$this->kxolS1[ 'type' ] == 'SESSION_n' )
		{
			$this->kxol_Array_SESSION  = $_SESSION[ 'Heading' ][ 'n' ];
			$this->kxol_type_SESSION_n();
		}



		ob_start();
		include __DIR__ .'/html/h_outline_session.php';
		$this->kxol_str[ 'outline_str' ] = ob_get_clean();

	}
	else
	{
		//ポスト取得
		global $post;
		$post = get_post( $this->kxolS1[ 'id' ] );
		setup_postdata($post);
		$content = $post->post_content;
		$content = kx_change_any_texts1st( $content );
		$content =	kx_markdownToHtml($content );

		//echo $this->kxolS1[ 'type' ].'<br>';
		//print_r($this->kxolS1);
		//Normal型
		$this->kxol_type_Normal_H($content);
		$this->kxol_type_Normal_Set($content);
		$this->kxol_type_Normal();
	}

	ob_start();
	include __DIR__ .'/html/outline.php';
	return ob_get_clean();
}


/**
 * 入力値の設定調整
 *
 * @return void
 */
public function kxol_setting0(){

	$this->kxolS1 = $this->kxolS0 + $this->kxolS_base;

	//id
	if( empty( $this->kxolS1[ 'id' ] ) )
	{
		$this->kxolS1[ 'id' ]	= get_the_ID();
	}

	$this->kxolS1[ 'id_sc' ] = get_the_ID();


	//t
	if(	empty( $this->kxolS1[ 't' ] ) )
	{
		$this->kxolS1[ 't' ]		= 20;
	}
	elseif(	$this->kxolS1[ 't' ]	== 'side')
	{
		$this->kxolS1[ 't' ]		= 25;
	}

	//URLタイプ判定。2023-08-23
	$this->kxolS1[ 'url_type' ] = kx_Judge_URL();


	//出力タイプ
	if(
		$this->kxolS1[ 'url_type' ] == 's'
		|| $this->kxolS1[ 'url_type' ] == 'tag'
		|| $this->kxolS1[ 'url_type' ] == 'cat'
	)
	{
		//検索ページなど。2023-08-23
		$this->kxolS1[ 'type' ] = 'Not_outline';
	}
	elseif(	!empty( $_SESSION[ 'Heading' ][ $this->kxolS1[ 'id' ] ] ) )
	{
		//基本形。2023-08-23
		$this->kxolS1[ 'type' ] = 'SESSION_ID';
	}
	elseif(	!empty( $_SESSION[ 'Heading' ][ 'n' ] ) && empty( KxDy::get('trace')['kxx_sc_count'] ?? null ) )
	{
		//テンプレートのmenuページなど。2023-08-23
		$this->kxolS1[ 'type' ] = 'SESSION_n';
	}
	else
	{
		//htmlページ内の見出し。2023-08-23
		$this->kxolS1[ 'type' ] = 'Normal';

		//kx_format対策。2023-08-28
		$_post = get_post();

		if( preg_match( '/kx_format.*id=(\d{1,})/' , $_post->post_content , $matches ))
		{
			if( !empty( $_SESSION[ 'Heading' ][ $matches[1] ] ))
			{
				//echo 'TEST+'.$matches[1];
				$this->kxolS1[ 'type' ] = 'SESSION_ID';
				$this->kxolS1[ 'id' ] = $matches[1];
				$this->kxolS1[ 'head_before' ] 	= '<spna style="color:hsl(60,100% , 80% );">';
				$this->kxolS1[ 'head_after' ] 	= '&nbsp;G</span>';
			}

		}
		unset( $matches );
	}


	if( preg_match( '/^8\d$/'	,	$this->kxolS1[ 't' ] ) )
	{
		$this->kxolS1[ 'max' ]	= $this->kxol_SET[ 'LIMIT' ][ 'max_8x' ];
	}



	$this->kxolS1[ 'judge' ] = kx_Judge_OLD( $this->kxolJUDGE[ 'Main' ] , 'preg' , $this->kxolS1[ 't' ] )[ 'settings' ];
	//print_r($this->kxolS1[ 'judge' ]);

	$this->kxol_str[ 'bottom_left' ]	= NULL;
	$this->kxol_str[ 'bottom_right' ]	= NULL;
}



/**
 * 羅列設定
 *
 * @return void
 */
public function kxol_setting_raretu(){
	global $post;
	$post = get_post( $this->kxolS1[ 'id' ] );

	if(
		$this->kxolS1[ 't' ] == 25
		&&!empty( $post->post_content ) && preg_match(	'/\[raretu.*?.*?\]/' , $post->post_content )
	)
	{
		$this->kxolS1[ 'max' ] 	= $this->kxol_SET[ 'LIMIT' ][ 'max_25' ];
	}

	if( !empty( $post->post_content ) && preg_match(	'/\[raretu.*?(?:db\=.+?|table_name\=.+?)\]/' , $post->post_content ) )
	{
		$this->kxolS1[ 'head_before' ] 	= '<spna style="color:hsl(0,100% , 85% );">';
		$this->kxolS1[ 'head_after' ] 	= '&nbsp;DB</span>';
	}
	elseif( empty( 	$this->kxolS1[ 'head_before' ] ) )
	{
		$this->kxolS1[ 'head_before' ] 	= null;
		$this->kxolS1[ 'head_after' ] 	= null;
	}
}


/**
 * 装飾系
 *
 * @return void
 */
public function kxol_setting_Decoration(){

	$this->kxolS1[ 'kxcl' ] = kx_CLASS_kxcl(	get_the_title( $this->kxolS1[ 'id' ] )	,	'kxx'		);

	if(
		!empty($_SESSION[ 'Heading_count' ][$this->kxolS1[ 'id' ] ][ 'raretu_count' ] )
		&& $_SESSION[ 'Heading_count' ][ $this->kxolS1[ 'id' ] ][ 'raretu_count' ]	== 1
		&& $this->kxolS1[ 't' ]	!= 'side' && $this->kxolS1[ 't' ]	!= 25
	)
	{
		$this->kxol_str[ 'class_ALL' ]	= '__kxol_box_raretu_master';
	}
	elseif(	!empty( $_SESSION[ 'Heading_count' ][$this->kxolS1[ 'id' ]][ 'raretu_count' ] ) && $_SESSION[ 'Heading_count' ][ $this->kxolS1[ 'id' ] ][ 'raretu_count' ]	&& $this->kxolS1[ 't' ]	!= 'side' && $this->kxolS1[ 't' ]	!= 25	)
	{
		$this->kxol_str[ 'class_ALL' ]	= '__kxol_box_raretu_slave';
	}
	elseif(	$this->kxolS1[ 't' ]	== 'side' || $this->kxolS1[ 't' ]	== 25	)
	{
		$this->kxol_str[ 'class_ALL' ]	= '__kxol_box_raretu_side';
	}
	else
	{
		$this->kxol_str[ 'class_ALL' ]	= '__kxol_box';
	}


	//head0
	$this->kxol_str[ 'style_Head0' ]			= 'background:' . $this->kxolS1[ 'kxcl' ][ 'hsla_light' ] . ';';

	//head・class
	$this->kxol_str[ 'style_head_LINK' ] = NULL;
	if( $this->kxolS1[ 't' ] == 23 || $this->kxolS1[ 't' ] == 24 )
	{
		$this->kxol_str[ 'class_Head0' ] = $this->kxolS1[ 'judge' ][ 'css_title' ] .' '. $this->kxolS1[ 'judge' ][ 'margin' ];
	}
	elseif( $this->kxolS1[ 't' ] == 25 ) 	//★★サイドバー用★★
	{
		$this->kxol_str[ 'class_Head0' ]			= NULL;
	}
	elseif(preg_match(	'/^[7-8]0$/'	,	$this->kxolS1[ 't' ] ) )
	{
		$this->kxol_str[ 'class_Head0' ] = $this->kxolS1[ 'judge' ][ 'css_title' ] .' '. $this->kxolS1[ 'judge' ][ 'margin' ];
	}
	elseif( $this->kxolS1[ 't' ] == 71 )
	{
		$this->kxol_str[ 'class_Head0' ]	 = $this->kxolS1[ 'judge' ][ 'css_title' ] .' '. $this->kxolS1[ 'judge' ][ 'margin' ];
	}
	else
	{
		$this->kxol_str[ 'class_Head0' ]			= NULL;
	}

	//head1
	$this->kxol_str[ 'class_Head1' ]			= $this->kxolS1[ 'kxcl' ][ 'text_class' ];
	$this->kxol_str[ 'style_Head1' ]			= 'background:'.$this->kxolS1[ 'kxcl' ][ 'hsla_normal' ].';';


	$this->kxol_str[ 'class9000' ]	= '__radius_bottom ' . $this->kxolS1[ 'kxcl' ][ 'text_class' ];
	$this->kxol_str[ 'style9000' ]	= 'font-size: 9pt; margin-bottom:10px; background:' . $this->kxolS1[ 'kxcl' ][ 'hsla_light' ] . ';';

	$this->kxol_str[ 'class9200' ]	= '__font_weight_bold';
	$this->kxol_str[ 'style9400' ]	= 'font-size: 8pt;';

	//タイトル系
	$_title	= get_the_title( $this->kxolS1[ 'id' ] );

	$replace	= $this->kxol_title_replace;

	$_title = str_replace( array_keys( $replace ) , $replace , $_title );

	$this->kxolS1[ 'index_title' ]	= end(explode( '≫' , $_title ) );
}



/**
 * 【kxx_outline_link】
 *
 *
 * @param [type] $_haiti
 * @param [type] $id
 * @return string
 */
public function kxol_setting_link(){

	$_title_base	= get_the_title( $this->kxolS1[ 'id' ] );

	//outlineのヘッド。タイトル文字列形成。2023-03-23
	if( preg_match(	'/^[6-8]0$|^25$/'	,	$this->kxolS1[ 't' ] ) )
	{
		$this->kxol_str[ 'head' ]	= kx_CLASS_kxTitle(
		[
			'type'  => 'kxtt_kxol',
			'title' => $_title_base,
		] )[ 'kxtt_kxol' ];
	}
	else
	{
		$this->kxol_str[ 'head' ] = $this->kxolS1[ 'judge' ][ 'title_top' ];
	}



	//echo( $_SESSION[ 'Heading_count' ][$this->kxolS1[ 'id' ]][ 'outline_only' ]);

	$this->kxol_str[ 'link_on' ] 		= 'LINK';
	$this->kxol_str[ 'Head_link' ]	= get_permalink( $this->kxolS1[ 'id' ] );
	if( $this->kxolS1[ 't' ] == 23 )
	{
		$this->kxol_str[ 'head' ] = $this->kxolS1[ 'index_title' ];
	}
	elseif( $this->kxolS1[ 't' ] == 24 )
	{
		$this->kxol_str[ 'head' ] = $this->kxolS1[ 'index_title' ];
	}
	elseif( $this->kxolS1[ 't' ] == 25 ) 	//サイドバー用
	{
		$this->kxol_str[ 'link_on' ] = "△Page_top";
		$this->kxol_str[ 'Head_link' ] = '#kx_page_top_link';
	}
	elseif(	!empty( $_SESSION[ 'Heading_count' ][ $this->kxolS1[ 'id' ]][ 'outline_only' ] ) )
	{
		$this->kxol_str[ 'link_on' ] 				 = '─outline_only─';
		$this->kxol_str[ 'style_head_LINK' ] = 'opacity: 0.5;font-size:x-small;';
	}
	elseif(preg_match(	'/^[7-8]0$/'	,	$this->kxolS1[ 't' ] ) )
	{
		//echo get_the_title();
		$this->kxol_str[ 'head' ]		=  $this->kxolS1[ 'index_title' ];
	}
	elseif( $this->kxolS1[ 't' ] == 71 )
	{
		$this->kxol_str[ 'head' ]		= $this->kxolS1[ 'index_title' ];
	}
	elseif(	!empty( $_SESSION[ 'Heading_count' ][$this->kxolS1[ 'id' ]]['wwt'] )	&& $_SESSION[ 'Heading_count' ][ $this->kxolS1[ 'id' ] ][ 'raretu_count' ]	>	1		)
	{
		$this->kxol_str[ 'link_on' ] = 'WWT';
	}
	elseif(	!empty( $_SESSION[ 'Heading_count' ][$this->kxolS1[ 'id' ]]['wwr'] )	&& $_SESSION[ 'Heading_count' ][ $this->kxolS1[ 'id' ] ][ 'raretu_count' ]	>	1		)
	{
		$this->kxol_str[ 'link_on' ] = 'WWR';
	}
	else
	{
		$this->kxol_str[ 'link_on' ] = NULL;
		$this->kxol_str[ 'style_head_LINK' ] = NULL;

		$this->kxol_str[ 'head' ] = 'N/A';
		$this->kxol_str[ 'head' ] = 'OUTLINE（OLD TYPE）';
	}


	if(	!empty( $this->kxolS1[ 'head_no'] ) )
	{
		$this->kxol_str[ 'head' ]	= NULL;
	}


	if( $this->kxolS1[ 't' ] == 25  )
	{
		//スルー
	}
	elseif( $this->kxolS1[ 'id' ] == $this->kxolS1[ 'url_type' ] )
	{
		$this->kxol_str[ 'link_on' ] = NULL;
		$this->kxol_str[ 'head' ] .= '&nbsp;▷';
	}
	else
	{
		$_text = str_replace( '≫'. $this->kxol_str[ 'head' ] , '' ,$_title_base );
		$_text_count1 = mb_strlen( $_text );
		$_text_count0 = mb_strlen( $this->kxol_str[ 'head' ] );

		$_max = 30;

		$_text_count = $_text_count0 + $_text_count1;

		$_max = $_max - $_text_count0;

		if( $_text_count > $_max )
		{
			$_text_add = '･･･';
		}
		else
		{
			$_text_add = '──';
		}

		$this->kxol_str[ 'link_on' ] = '　'.mb_substr( $_text , 0 , $_max ).$_text_add;
		$this->kxol_str[ 'style_head_LINK' ] = 'opacity: 0.5;font-size:x-small;';
	}
	$this->kxol_str[ 'head' ] = $this->kxolS1[ 'head_before' ] . $this->kxol_str[ 'head' ] . $this->kxolS1[ 'head_after' ];
}




/**
 * Undocumented function
 *
 * @return void
 */
public function kxol_type_SESSION_ID(){

	if( preg_match( '/∫≫(T|M)$/' , get_the_title( $this->kxolS1[ 'id' ] ) ) )
	{
		foreach( $this->kxol_Array_SESSION as $key_S => $value ):
			if( preg_match( '/^\d{1,}$/' , $value[ 'daimei' ] ) )
			{
				$this->kxol_Array_SESSION[ $key_S ][ 'daimei' ] = kx_CLASS_kxTitle(
				[
					'type'   => 'kxtt_work',
					'title'  => get_the_title( $this->kxolS1[ 'id' ] ) .'≫' . $value[ 'daimei' ] ,
				] )[ 'work_name'];
			}
		endforeach;
	}
	elseif( preg_match( '/∫$/' , get_the_title( $this->kxolS1[ 'id' ] ) ) )
	{
		foreach( $this->kxol_Array_SESSION as $key_S => $value ):

			$_array_name1 =  kx_CLASS_kxTitle(
			[
				'type'   => 'kxtt_kxol',
				'title'  => get_the_title( $this->kxolS1[ 'id' ] ) .'≫' . $value[ 'daimei' ] ,
			] )[ 'array_name' ][1];

			if( !empty( $_array_name1 ))
			{
				$this->kxol_Array_SESSION[ $key_S ][ 'daimei' ] .= '-' . $_array_name1;
			}

		endforeach;
	}
	elseif( !empty( $_SESSION[ 'raretu' ][ $this->kxolS1[ 'id' ] ][ 'db_ON' ] )  )
	{
		//Sample作品用。2023-08-27
		foreach( $this->kxol_Array_SESSION as $key => $value ):

			$_title = get_the_title( $value[ 'id_js' ] );

			if( preg_match( '/∫≫(T|M)≫\d{1,}$/' , $_title ) )
			{
				$this->kxol_Array_SESSION[ $key ][ 'daimei' ] = kx_CLASS_kxTitle(
				[
					'type'   => 'kxtt_work',
					'title'  => $_title,
				] )[ 'work_name'];
			}

		endforeach;
	}
}



/**
 * Undocumented function
 *
 * @return void
 */
public function kxol_type_SESSION_n(){

	$this->kxol_str[ 'head' ]	= '──　Outline ──';

	$this->kxol_str[ 'link_on' ] = NULL;
	//$this->kxol_Sstr[ 'class_ALL' ]				 = NULL;
	//$this->kxol_Sstr[ 'class_Heading1' ]	 = NULL;
	//$this->kxol_Sstr[ 'style_Heading1' ]	 = NULL;
	//$this->kxol_Sstr[ 'class_Heading2' ]	 = NULL;
	//$this->kxol_Sstr[ 'style_Heading2' ]	 = NULL;
	$this->kxol_str[ 'style_head_LINK' ]	 = NULL;
	//$this->kxol_Sstr[ 'class_Index_main' ] = NULL;
}


/**
 * hの範囲を設定。基本ノーマル用。
 *
 * @return array
 */
public function kxol_type_Normal_H($content){

	// h2～h6までcount。
	$_h_count_all = 0 ;
	for ( $i = 2; $i < 6 ; $i++ ):
		//2～6。

		$_h_count[$i]	 = substr_count( $content , '</h'.$i ) ;

		if(	!empty( $_h_count[$i] ) )
		{
			$hx	= $i;
		}

		$_h_count_all = $_h_count_all + $_h_count[ $i ];

		//echo $_h_count_all.'+';//確認用

		if( $i == 2 )
		{
			//h2のとき
			$this->kxolS1[ 'over' ]	= $_h_count_all - $this->kxol_SET[ 'LIMIT' ][ 'max_h2' ];
		}
		else
		{
			$this->kxolS1[ 'over' ]	= $_h_count_all - $this->kxol_SET[ 'LIMIT' ][ 'max' ];
		}

		//echo $over.'+';

		//超過判断
		if ( $this->kxolS1[ 'over' ] > 0 )
		{
			//超過

			//超過数
			$_max_plus 				 	= $_h_count_all - $this->kxol_SET[ 'LIMIT' ][ 'max' ];
			$this->kxolS1['over_count']	= $_max_plus;

			$i_h = $i - 1 ;

			if ( $i_h < 3 )
			{
				$this->kxolS1[ 'h_range' ]		= '2' ;		//正規表現

				$_text				 		= '　2';
			}
			else
			{
				$this->kxolS1[ 'h_range' ]		= '2-' . $i_h;		//正規表現
				$_text				 		= '　2-'.$i_h ;
			}

			$this->kxolS1[ 'hyouji' ]	 = ''. $_text .'（max'. $this->kxolS1[ 'max' ] .'：h'. $i .'-over'.$_max_plus.'）';

			//echo $this->kxolS1[ 'h_range' ];
			//停止
			break;
		}
		elseif( $_h_count[2] > $this->kxol_SET[ 'LIMIT' ][ 'max' ] )
		{
			//h2の段階でオーバー。
			$hx_plus	= '-TEST';
			$_h_count_all	 = $_h_count[2] ;
		}


		if( !empty( $hx ) && $hx != 2 )
		{
			$hx_plus = '-' . $hx;
		}

		if( empty( $hx_plus ) )
		{
			$hx_plus = NULL;
		}

		$this->kxolS1[ 'hani_text' ]	= '2' . $hx_plus;
		$this->kxolS1[ 'count_h' ]	 	= $_h_count_all ;

	endfor;

	//オーバータイプ
	if(	$_h_count[2] > $this->kxol_SET[ 'LIMIT' ][ 'max_h2' ]	)
	{
		$this->kxolS1[ 'h_range' ]		= '2' ;
		//echo $_h[2];
		//$ret[ 'count_h' ]	 = $_h[2] ;
		$this->kxolS1[ 'over' ]	 = $_h_count[2] ;
	}

	$this->kxolS1[]	= 'n-a';
}



/**
 * Normal要設定。
 *
 * @return void
 */
public function kxol_type_Normal_Set( $content ){

	//オーバー
	if( !empty( $this->kxolS1[ 'h' ] ) )
	{
		$this->kxolS1[ 'h_range' ]	= 	$this->kxolS1[ 'h' ];
		$this->kxol_str[ 'head' ]	.= '-'.$this->kxolS1[ 'h' ];
	}
	elseif( $this->kxolS1[ 'over' ] > 0 )
	{
		$_hyouji_over 	 = '<span class="_op_a">-▲' . $this->kxolS1[ 'over' ] .'-</span>';
		$_hyouji_over 	.= '<div class="_op_z __background_normal" style="width:200px;">';
		$_hyouji_over 	.= '<p>h'.$this->kxolS1[ 'h_range' ].'まで表示</p>';
		$_hyouji_over 	.= '<p>超過数'.$this->kxolS1[ 'over' ].'</p>';
		$_hyouji_over 	.= '</div>';

		$this->kxol_str[ 'head' ]	.= $_hyouji_over;
	}
	elseif(preg_match(	'/\[raretu.*?chara_ww.*?\]/'	,$content	))
	{
		$this->kxolS1[ 'h_range' ]	= 	'2-6';
		$this->kxol_str[ 'head' ]	.= '【R・CWW】';
	}
	elseif(preg_match(	'/\[raretu.*?chara_w.*?\]/'	,$content	))
	{
		$this->kxolS1[ 'h_range' ]	= 	'2';
		$this->kxol_str[ 'head' ]	.= '【R・CW・H2】';
	}
	elseif(preg_match(	'/\[raretu.*?\]/'	,$content	))
	{
		$this->kxolS1[ 'h_range' ]	= 	'2';
		$this->kxol_str[ 'head' ]	.= '- R -';
	}
	else
	{
		$this->kxolS1[ 'h_range' ]	= 	'2-6';
		$this->kxol_str[ 'head' ]	.= '-';
	}



	if ( !empty( $this->kxolS1[ 'h_range' ] ) )
	{
		//指定有り。
		$this->kxol_str[ 'head' ]	.= '［H'. $this->kxolS1[ 'h_range' ] .'］';

	}

	//outline取得
	if( !empty( $this->kxolS1[ 'judge' ][ 'goi_on']  ) )
	{
		$outline_info = kxol_get_outline_info( $content , $this->kxolS1[ 'h_range' ] , $this->kxolS1[ 't' ] , $this->kxolS1[ 'id' ] ,$this->kxolS1);
		$this->kxol_str[ 'outline' ] = $outline_info[ 'outline' ];

	}
}


/**
 * 	//wp_reset_postdata();	//必要
 * 	//SESSION以外
 *
 * @return void
 */
public function kxol_type_Normal(){

	$css_content	 = NULL;
	if( empty($this->kxolS1[ 'count_h' ]))
	{
		$css_content	 = '__hidden';

		$this->kxolS1[ 'title_top' ]	 = $this->kxolS1[ 'judge' ][ 'title_no' ];
	}
	elseif( $this->kxolS1[ 'count_h' ]	== 0	)
	{
		$css_content	 = '__hidden';

		$this->kxolS1[ 'title_top' ]	 = $this->kxolS1[ 'judge' ][ 'title_no' ];
	}

	//var_dump($this->kxol_str[ 'outline' ]);
	//ob_start
	//echo $this->kxol_str[ 'outline' ];
	//echo '+';
	ob_start();

	//var_dump($this->kxolS1[ 'judge' ]);
	//print_r($this->kxolS1[ 'judge' ][ 'goi_on']);

	if( !empty( $this->kxolS1[ 'judge' ][ 'goi_on']  ) )
	{

		echo $this->kxol_str[ 'outline' ];
	}
	else
	{
		$this->kxolS1[ 'judge' ][ 'outline_Control_start' ] = NULL;
		$this->kxolS1[ 'judge' ][ 'outline_Control_end' ] = NULL;
		echo $this->kxol_type_Index1();
	}


	$ob	= ob_get_clean();

	//表示開始



	if( empty( $c_text1 ) ):

		$c_text1 = NULL;

	endif;





	if( empty( $this->kxolS1[ 'judge' ][ 'margin2' ] ) )
	{
		$this->kxolS1[ 'judge' ][ 'margin2' ] = NULL;
	}




	$str = NULL;
	if(	!empty( $this->kxolS1[ 'judge' ][ 'goi_on' ] ) )
	{
		$str .= '<span class="__kxol '. $css_content .'">';	//__kxol多分不要。2020-07-19
		$str .= $ob;
		$str .= '</span>';
	}
	else
	{
		$str .= '<ol>';
		$str .= $ob;
		$str .= '</ol>';
	}

	$this->kxol_str[ 'outline_str' ]  = $str;
	unset( $str );


	if( empty( $this->kxolS1[ 'head_no'] ) ):

		if( empty( $margin ) ):
			$margin = NULL;
		endif;

		if( empty( $c_text1 ) ):
			$c_text1 = NULL;
		endif;

		if( empty( $c_bg_u ) ):
			$c_bg_u = NULL;
		endif;



		if( empty( $this->kxolS1[ 'title_index2' ] ) ):

			$this->kxolS1[ 'title_index2' ] = NULL;

		endif;

		$this->kxol_str[ 'bottom_left' ]	= $this->kxolS1[ 'title_index2' ];

		$this->kxol_str[ 'style9400' ]	= 'font-size: 8pt;';

		if( empty( $title ) ):

			$title = NULL;

		endif;

		$this->kxol_str[ 'bottom_right' ]	= $title;

	endif;



}


/**
 * h2ベース
 * 旧型。
 * function kxx_index1()
 *
 * @return string
 */
public function kxol_type_Index1(){

	global $post;	//グローバル変数を使う為の宣言

	//マッチングで<h>タグを取得する
	preg_match_all('/<h2>(.*?)<\/h2>/', $post->post_content, $matches);
	//取得した<h>タグの個数をカウント
	$matches_count = count($matches[0] );

	if( empty( $matches ) ){        //<h>タグがない場合の出力

	echo '<span>Sorry no index</span>';

	}else{        //<h>タグが存在する場合に<h>タグを出力

		for ($i = 0; $i < $matches_count; $i++){
			$title = $matches[0][$i];
			$title = str_replace('<h2>','<li>',$title);
			$title = str_replace('</h2>','</li>',$title);
			echo $title;
		}
	}
}





/**
 * outline外
 *
 * @return void
 */
public function kxol_type_Not_outline(){

	$this->kxol_str[ 'head' ] = 'N/A';

	//検索系ページ。2023-08-23
	if( empty( $_SESSION[ 'kensaku' ] ))
	{
		$_SESSION[ 'kensaku' ] = NULL;
	}

	$ret = NULL;
	if( $this->kxolS1[ 'url_type' ] == 's')
	{
		$ret .="<HR>\n\n";
		$ret .='<div class="__text_center">';
		$ret .=" --検索結果--\n";
		$ret .= $_SESSION[ 'kensaku' ] .'件';
		$ret .="\n\n";
		$ret .='<div class="__font_weight_bold">';
		$ret .='”　';
		$ret .='<span class="__font_weight_bold __f_size13">';
		$ret .= get_search_query ();
		$ret .='</span >　”';
		$ret .='</div >';
		$ret .='</div >';
		$ret .="\n\n<HR>";

		return nl2br($ret);
	}
	elseif( $this->kxolS1[ 'url_type' ] == 'tag' || $this->kxolS1[ 'url_type' ] =='cat')
	{
		$ret .="\n\n";
		$ret .= '<HR><BR><div class="__text_center">';
		$ret .= get_the_archive_title();
		$ret .="\n\n";
		$ret .= $_SESSION[ 'kensaku' ].'件';
		$ret .='</div >';
		$ret .="\n<HR>";

		return nl2br($ret);
	}
}



}	//class

add_filter('the_content', 'kxol_add_outline');
/**
 * 関連。content改変。
 *
 * 目次を作成します。
 * フィルター
 * 元データを改良・一部削除。2019/04/16
 *
 * @param [type] $content
 * @return string
 */
function kxol_add_outline( $content ){

	if( !is_single() && !is_page() )
	{
		// 個別記事ページと固定ページ以外には目次を表示させません。
		return $content;
	}
	elseif(strtolower(get_post_meta(get_the_ID(), 'disable_outline', true)) == 'true')
	{
		// カスタムフィールド（disable_outline）にtrueが設定されている場合、目次を表示しません。
		return $content;
	}

	return kxol_get_outline_info( $content )['content'];
}


add_action( 'wp_enqueue_scripts', 'kxol_add_js_outline' );
/**
 * 関連jsファイル追加
 *
 * @return null
 */
function kxol_add_js_outline() {
	wp_enqueue_script(
		'outline',
		get_stylesheet_directory_uri().'/../kasax_child/js/outline.js',
		 array( 'jquery' ),
		'1.0',
		true
	);
}



/**
 * Outline
 * 目次に関する情報を取得します。
 * * 元データを改良・パラメーター追加。2019/04/16
 * フックが掛かっているので、クラス内には入れづらい。
 *
 * @param string $content 記事本文
 * @return array content: 見出し用更新後の記事本文、outline: 目次
 */
function kxol_get_outline_info( $content , $_h = null , $t = null, $id = null , $ino = null ){


	// 目次のHTMLを入れる変数を定義します。
	$outline = NULL;


	// 記事内のh1〜h6タグを検索します。

	if ( !$_h )
	{
		$_h = '2-6';	//hの階層指定。｛181118｝
	}


	if( preg_match_all( '/<h(['.$_h.'])>(.*?)<\/h\1>/' , $content , $matches ,  PREG_SET_ORDER) )
	{

		// 記事内で使われているh1〜h6タグの中の、1〜6の中の一番小さな数字を取得します。
		// ※以降ソースの中にある、levelという単語は1〜6のことを表します。
		$min_level = min(array_map(function($m) { return $m[1]; }, $matches));
		// スタート時のlevelを決定します。
		// ※このレベルが上がる毎に、<ul></li>タグが追加されていきます。
		$current_level = $min_level - 1;
		// 各レベルの出現数を格納する配列を定義します。
		$sub_levels = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0);
		// 記事内で見つかった、hタグの数だけループします。

		foreach( $matches as $m ){
			$level	= $m[1];  // 見つかったhタグのlevelを取得します。
			$text		= $m[2];  // 見つかったhタグの、タグの中身を取得します。
			// li, ulタグを閉じる処理です。2ループ目以降に中に入る可能性があります。
			// 例えば、前回処理したのがh3タグで、今回出現したのがh2タグの場合、
			// h3タグ用のulを閉じて、h2タグに備えます。

			//テキスト置換
			if(preg_match(	'/\[kxsc_title_id.*\]/'	,$text		,$matches	)	)
			{
				$text	= do_shortcode($matches[0] );
				//調整中。未使用。
			}
			else
			{
				$kxol	= new kxol;
				foreach(	$kxol->kxol_title_replace	as	$key	=>	$v	):
					$text	= preg_replace(	$key	,	$v	,	$text	);
				endforeach;
			}

			if ($t == 25):

				//テキスト文字数変更。サイドバー専用
				$ret	 = '<div class="test">';
				$ret .= $text;
				$ret .= '</div>';

				//if ( $m[1]==2 and mb_strlen ($text) > 14):
					//$text =mb_substr($text  ,0,14 ).'…';

				//elseif ( $m[1] == 3 and mb_strlen ($text) > 12):
					//$text =mb_substr($text  ,0,12 ).'…';

				//elseif ( $m[1] == 4 and mb_strlen ($text) > 10):
					//$text =mb_substr($text  ,0,10 ).'…';

				//endif;

			endif;



			while ($current_level > $level) {
					$current_level--;
					$outline .= '</li></ul>';
			}
			// 同じlevelの場合、liタグを閉じ、新しく開きます。
			if ($current_level == $level) {
					$outline .= '</li><li>';
			} else {
					// 同じlevelでない場合は、ul, liタグを追加していきます。
					// 例えば、前回処理したのがh2タグで、今回出現したのがh3タグの場合、
					// h3タグのためにulを追加します。
					while ($current_level < $level) {
							$current_level++;
							$outline .= sprintf('<ul class="indent_%s"><li>', $current_level);
					}
					// ※2016/1/13追加
					// 見出しのレベルが変わった場合は、現在のレベル以下の出現回数をリセットします。
					for ($idx = $current_level + 0; $idx < count($sub_levels); $idx++) {
							$sub_levels[$idx] = 0;
					}
			}
			// 各レベルの出現数を格納する配列を更新します。
			$sub_levels[$current_level]++;
			// 現在処理中のhタグの、パスを入れる配列を定義します。
			// 例えば、h2 -> h3 -> h3タグと進んでいる場合は、
			// level_fullpathはarray(1, 2)のようになります。
			// ※level_fullpath[0]の1は、1番目のh2タグの直下に入っていることを表します。
			// ※level_fullpath[1]の2は、2番目のh3を表します。
			$level_fullpath = array();
			for ($idx = $min_level; $idx <= $level; $idx++) {
					$level_fullpath[] = $sub_levels[$idx];
			}
			$target_anchor = '#outline_' . implode('_', $level_fullpath);
			// ※2016/1/13修正
			// 目次に、<a href="#outline_1_2">1.2 見出し</a>のような形式で見出しを追加します。
			//$link = get_permalink($id);

			if( !empty( $ino['format'] ) )
			{
				//Format型。スルー。整備中。無効化中。2019/04/28
			}
			elseif( $id != get_the_ID() )
			{
				$link = get_permalink( $id );
			}
			elseif(!preg_match ('/(p|page_id)='.$id.'/' , $_SERVER["REQUEST_URI"]  ) )
			{
				//javaに影響。2020/02/20
				$link = get_permalink($id);
			}
			else
			{
				//同ページ内。
				$link = NULL;
			}

			$format = '<a href="' . $link . '%s" tabindex="-1">%s. %s</a>';
			$_m2 = implode('.', $level_fullpath);
			$outline .= sprintf($format , $target_anchor ,$_m2 , $text);
			// 本文中の見出し本体を、<h3>見出し</h3>を<h3 data-outline="#outline_1_2">見出し</h3>
			// のような形式で置き換えます。



			$target_anchor = str_replace('#', '', $target_anchor); //★★★#を消す。｛180113｝追記。★★★

			$content = preg_replace('/<h(['.$_h.'])>/', '<h\1 id="' . $target_anchor . '">', $content, 1);


    }

		// hタグのループが終了後、閉じられていないulタグを閉じていきます。
		while( $current_level >= $min_level ){
			$outline .= '</li></ul>';
			$current_level--;
		}
	}



	return array( 'content' => $content, 'outline' => $outline );

}