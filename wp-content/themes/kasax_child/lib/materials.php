<?php


/**
 * Undocumented function
 *
 * @param [type] $title_array
 * @param [type] $count
 * @param [type] $chara_name
 * @param [type] $character_number
 * @return void
 */
function kxm_title_h1($id) {

	$_arr1 =  KxDy::get('content')[$id];
	var_dump($_arr1);

	$_arr2 =  KxDy::get('work');
	//var_dump($_arr2);

	if ( !empty($_arr1['title_type']) && $_arr1['title_type']== 'character')
	{
		$_name = $_arr2[$_arr1['title_array'][0] ][$_arr1['title_array'][1]]['name'];
	}



  //$test = kxm_title_h1_small($title_array, $count, $chara_name,$character_number);


}





/**
 * タイトルの階層を生成する関数
 *
 * @param array $title_array タイトルの階層を格納する配列
 * @param int $count 階層の深さ（タイトルの個数）
 * @param string|null $chara_name キャラクター名（オプション）
 * @param int|null $character_number キャラクター識別番号（オプション）
 * @return string 整形されたタイトル階層のHTML文字列
 */
function kxm_title_h1_small($title_array, $count, $chara_name = null, $character_number = null) {
	// 階層の最大値を計算
	$_max = ($count >= 1 && $count <= 2) ? $count : $count - 1;

	// タイトルの追加情報取得
	$_add0 = !empty(KxSu::get('titile_name')[$title_array[0]])
			? KxSu::get('titile_name')[$title_array[0]]['name']
			: null;

	// タイトル階層の作成
	$ret = '';
	for ($i = 0; $i < $_max; ++$i) {
			$ret .= $title_array[$i];

			if ($i == 0) {
					$ret .= $_add0;
			}

			if ($i != $_max - 1) {
					$ret .= '：';
			}
	}

	// キャラクター名を追加（オプション）
	if (!empty($character_number)) {
			$ret .= '（' . $chara_name . '）';
	}

	// 階層の棒を作成
	$str = str_repeat('|', $count);

	return $ret . '<span style="opacity:.25;">&nbsp;&nbsp;' . $str . '</span>';
}



/**
 * Undocumented class
 */
class kxcl { //*** *** *** *** *** *** kxcl*** *** ***  *** *** ***

public $kxclS1; //基本設定。

public $kxclOUT = //最終出力要素
[
	'on-off'									=>	0,
	'Type濃度'								=>	'non',
	'Type文字色'							=>	'non',
	'色相'										=>	'non',
	'彩度'										=>	'non',
	'明度'										=>	'non',
	'薄型'										=>	'non',
	'hsla_normal'							=>	'non',
	'hsla_light'							=>	'non',
	'text_class'							=>	'non',
	'background_normal_style'	=>	'non',
	'background_light_style'	=>	'non',
	'border_class'						=>	'non',
	'kxx30_class'							=>	'non',
	'kxx30_style'							=>	'non',
	'memo'										=>	'MEMO-non',
];



public $kxclSetting = //* 各種設定
[
	'base' =>
	[
		'薄い'			=> ['彩度'=>'70',		'明度'=>'90',	'薄型'=>'0.4',	'文字'=>'黒' ] ,
		'濃い'			=> ['彩度'=>'100',	'明度'=>'20',	'薄型'=>'0.25',	'文字'=>'白' ] ,

		'彩度20'		=> ['彩度'=>'20',		'明度'=>'40',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度35'		=> ['彩度'=>'100',	'明度'=>'35',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度25'		=> ['彩度'=>'100',	'明度'=>'25',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度15'		=> ['彩度'=>'100',	'明度'=>'15',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'無し'			=> ['彩度'=>'0',		'明度'=>'20',	'薄型'=>'0.25',	'文字'=>'白' ] ,

		'原色'			=> ['彩度'=>'100',	'明度'=>'50',	'薄型'=>'0.24',	'文字'=>'白' ] ,

		'明度A_L'		=> ['彩度'=>'100',	'明度'=>'75',	'薄型'=>'0.25',	'文字'=>'白' ] ,//ビビット
		'明度B_L'		=> ['彩度'=>'100',	'明度'=>'35',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度C_L'		=> ['彩度'=>'100',	'明度'=>'25',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度D_L'		=> ['彩度'=>'100',	'明度'=>'15',	'薄型'=>'0.25',	'文字'=>'白' ] ,

		'明度A_D'		=> ['彩度'=>'75',		'明度'=>'32',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度B_D'		=> ['彩度'=>'50',		'明度'=>'32',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度C_D'		=> ['彩度'=>'33',		'明度'=>'32',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'明度D_D'		=> ['彩度'=>'33',		'明度'=>'15',	'薄型'=>'0.25',	'文字'=>'白' ] ,
		'Error'			=> ['彩度'=>'100',	'明度'=>'50',	'薄型'=>'0.24',	'文字'=>'黒' ] ,
	],


	'arr_text' =>
	[
		'黒' =>
		[
			'class' => '__a_black',
		],

		'白' =>
		[
			'class' => '__a_white __font_weight500 __text_shadow_black1_01',
		],
	],


	'character' =>
	[
		//作品番号	=>
		//30度刻み+45、315。2023-12-18
		'04'	 =>
		[
			'/./' => 45,
		],

		'10'	 =>
		[
			'/^00\d$/'									=>240,
			'/^0[1-8]\d$/'							=>210,
			'/^09\d$/'									=>30,
			'/^[1-2]\w{1,}\d$|^991$/'		=>330,
			'/^3\w{1,}\d$|^993$/'				=>300,
			'/^4\w{1,}\d$|^994$/'				=>180,
			'/^5\w{1,}\d$/'							=>45,
			'/^6\w{1,}\d$|^996$/'				=>270,
			'/^7\w{1,}\d$/'							=>60,
			'/^8\w{1,}\d$|^998$/'				=>90,
			'/^988$/'										=>0,
			'/^989$/'										=>0,
			'/^9\w{1,}\d$/'							=>30,
		],

		'14'	 =>
		[
			'/^00\d$/'									=>240,
			'/^0[1-8]\d$/'							=>210,
			'/^09\d$/'									=>30,
			'/^[1-2]\w{1,}\d$|^991$/'		=>330,
			'/^3\w{1,}\d$|^993$/'				=>300,
			'/^4\w{1,}\d$|^994$/'				=>180,
			'/^5\w{1,}\d$/'							=>45,
			'/^6\w{1,}\d$|^996$/'				=>270,
			'/^7\w{1,}\d$/'							=>60,
			'/^8\w{1,}\d$|^998$/'				=>90,
			'/^988$/'										=>0,
			'/^989$/'										=>0,
			'/^9\w{1,}\d$/'							=>30,
		],

		'ETC'	 =>
		[
			'/^00\d$/'									=>240,
			'/^0[1-8]\d$/'							=>210,
			'/^09\d$/'									=>30,
			'/^[1-2]\w{1,}\d$|^991$/'		=>330,
			'/^3\w{1,}\d$|^993$/'				=>300,
			'/^4\w{1,}\d$|^994$/'				=>180,
			'/^5\w{1,}\d$/'							=>45,
			'/^6\w{1,}\d$|^996$/'				=>270,
			'/^7\w{1,}\d$/'							=>60,
			'/^8\w{1,}\d$|^998$/'				=>90,
			'/^988$/'										=>0,
			'/^989$/'										=>0,
			'/^9\w{1,}\d$/'							=>30,
		],

		//'etc'	 =>	45,
	],


	//タイトル別color
	'separation_title_color' =>
	[
		//上優先
		'x'	 => [ '/./'	 => [ 0		 , '原色'		 ], ],
		'κ'	=> [ '/./'	=> [ 0		,	'濃い'		], ],
		'Μ' => [ '/./'	=> [ 30	  , '濃い'		], ],
		'Β'	=> [ '/./'	=> [ 60		,	'濃い'	], ],
		'γ'	=> [ '/./'	=> [ 300	,	'濃い'	], ],
		'σ'	=> [ '/./'	=> [ 180	,	'濃い'	], ],
		'δ'	=> [ '/./'	=> [ 120	,	'濃い'	], ],
		'λ'	=> [ '/./'	=> [ 90		,	'濃い'		], ],

		'∮'	=> [ '/./'	=> [ 240	, '明度C'		], ],

		'∫'	=>
		[
			'/∫≫(T|M)/'			=> [ 240	, '明度C' ],
			'/∫≫X/'					=> [ 240	, '明度C' ],
			'/∫≫Y/'					=> [ 240	, '明度C' ],
			'/∫≫登場人物/'	=> [ 240	, '明度C' ],
			'/./'							=> [ 240	, '明度C' ],
		],

		'∬'	=>
		[
			'/〇a3(1|2)1/'				=> [ 240 ,'明度35' ],
			'/〇a3(3|4)1/'				=> [ 330 ,'明度35' ],

			'/0構成.*〇/'					 => [ 45  ,'明度35' ],
			'/.*(作業|共通)ww/'		 => [ 45  ,'明度35'	],//削除用


			'/^∬.*?(Ksy|Ygs)(A|B)(\d|)/'            => [60 , '明度B' ],
			'/^∬.*?進行$/'                          => [180 , '明度A' ],
			'/^∬.*?進行(A|B|C|D|E|F|G|H|I|J)(\d|)/' => [90 , '明度C' ],


			'/∬10header/' 	=> [180 , '明度C' ],
			'/∬13header/'   => [290 , '明度C' ],
			'/∬14header/'   => [290 , '明度C' ],
			'/∬15header/'   => [290 , '明度C' ],

			'/∬\w{1,}≫c0\w{1,}|≫c0\w{1,}\d.*来歴/'					=> [	'ヾキャラ1ヾ'	,'明度A'		],
			'/∬\w{1,}≫c[1-3]\w{1,}|≫c[1-3]\w{1,}\d.*来歴/'	=> [	'ヾキャラ1ヾ'	,'明度A'	],
			'/∬\w{1,}≫c[4-8]\w{1,}|≫c[4-8]\w{1,}\d.*来歴/'	=> [	'ヾキャラ1ヾ'	,'明度A'		],
			'/∬\w{1,}≫c9\w{1,}|≫c9\w{1,}\d.*来歴/'					=> [	'ヾキャラ1ヾ'	,'明度A'		],

			'/Idea/' 							  => [145	,	'明度C'	],
			'/^∬.*?1構成/'				 => [180 , '明度B' ],
			'/^∬.*?2構成/'				 => [210 , '明度B' ],

			'/∬\w{1,}≫c(5|7|8)/'	=> [150	,'明度A'	],
			'/Ksy\d{3}|Ygs\d{3}/'		=> [270	,'明度A'	],
			'/Ksy/'									=> [240	,'明度A'	],
			'/Olf/'									=> [270	,'明度A'	],
			'/Ygs/'									=> [300	,'明度A'	],
			'/.c$/'									=> [270	,'明度35'	],

			'/^∬/'								=> [180 ,'明度B' 		],

			//'/〇(p152|p172)/'	=> [ 240 ,'彩度C'		],
			//'/≫〇/'							 => [30	 , 	'ビビット'	],
			//'/0構成≫世界観/'		 	 => [115 , '明度B' ],
			//'/題材/'					 			=> [130 ,	'明度B'	],
			//'/商品構成/'			 			=> [150	,	'明度B'	],
			//'/演出/'								=> [150	,	'明度B'	],
			//'/≫設定/'				 			 => [90 , '明度B' ],
			//'/∬\w{1,}≫c0/'				=> [240	,'明度35'		],
			//'/∬\w{1,}≫c[1-2]/'		=> [330	,'明度35'		],
			//'/∬\w{1,}≫c3/'				=> [300	,'明度35'		],
		],

		'^ζ'						 => ['明度A'			,210	],	//？？2020/03/17
		'^INDEX'					=> ['無し'			,0		],
		'Error'						=> ['原色'			,0		],
		'.'							  => ['原色'			,0		],

		//'ζ' 	=> ['/./'	=> [210	,'明度A'		],	],
		//'ω' 					 => [ '/./'	=> [ 240	, '原色'		], ],
	],


	//border追加
	'separation_title_class_border' =>
	[
		'__border_0'      =>  '/エラー/',
		//'__border_180'    =>  '/〇/',
		//'__border_270'    =>  '/商品構成/',
		//'__border_pickup' =>  '/≫製作中作品kxst記載≪/',機能停止
	],
];



/**
 * color設定。メイン。
 * 2023-09-08
 *
 *
 * @param [type] $title
 * @param string $type
 * @return void
 */
public function kxcl_Main( $title	= null , $type = null ){

	$this->kxclS1[ 'type' ] = $type;

	$_lv = NULL;

	if( $this->kxclS1[ 'type' ] == 'header' && preg_match('/∬(10|13)/' , get_the_title() ,$matches))
	{
		$title = '∬'.$matches[1].'header';
	}
	elseif( $this->kxclS1[ 'type' ] == 'array')
	{
		//配列のみ出力。2023-09-08

		if( $title == 'character' )
		{
			$this->kxclOUT = $this->kxclSetting[ 'character' ];
		}
		elseif( $title == 'base' )
		{
			$this->kxclOUT = $this->kxclSetting[ 'base' ];
		}

		return;
	}
	elseif(	$this->kxclS1[ 'type' ] == 'error')
	{
		$this->kxclS1[ 'title' ] = 'Errorヾpattern';
	}
	elseif(	$this->kxclS1[ 'type' ] == '色相' )
	{
		$_lv = 1;
	}
	elseif(	$this->kxclS1[ 'type' ] == 'text'	)
	{
		$_lv = 2;
	}
	elseif(	$this->kxclS1[ 'type' ] == 'kxx' || $this->kxclS1[ 'type' ] == 'kx30' )
	{
		$_lv = 9;
		$_lv_name = '＿'.$this->kxclS1[ 'type' ];
	}
	elseif(	!$this->kxclS1[ 'type' ] )
	{
		$_lv = 3;

		$this->kxclS1[ 'type' ] = 'base';
	}


	if(	$title	)
	{
		$this->kxclS1[ 'title' ]	= $title;
	}
	else
	{
		$this->kxclS1[ 'title' ]	= get_the_title();
	}


	if( !empty( $_lv_name ) && !empty( $_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ]['Lv'] ) && $_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ]['Lv'] > $_lv )
	{
		$this->kxclOUT   = $_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ][ 'kxclOUT' ];

		$_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ]['count']++;

		return;
	}


	$this->kxclOUT[ 'memo' ] = $this->kxclS1[ 'title' ];

	//基本セット
	$this->kxcl_separation_title();

	if(	$this->kxclS1[ 'type' ] == '色相'	)
	{
		//スルー
	}
	elseif(	$this->kxclS1[ 'type' ] == 'text'	)
	{
		$this->kxcl_text();
	}
	else
	{
		$this->kxcl_pattern();
		$this->kxcl_text();
		$this->kxcl_border();

		//追加要素
		if(	$this->kxclS1[ 'type' ] == 'kxx')
		{
			$this->kxcl_kxx();
		}
		elseif(	$this->kxclS1[ 'type' ] == 'kx30'	)
		{
			$this->kxcl_kx30();
		}
	}

	if( empty( $_lv_name ))
	{
		$_lv_name = NULL;
	}


	$_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ][ 'kxclOUT' ]	= $this->kxclOUT;
	$_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ]['Lv'] 		= $_lv;
	$_SESSION[ 'color' ][ $this->kxclS1[ 'title' ].$_lv_name ]['count']	= 1;
}


/**
 * 色相・濃さ
 *
 * @param [type] $title
 * @return void
 */
public function kxcl_separation_title(){

	$_title_top = mb_substr(	$this->kxclS1[ 'title' ]	,	0	,1	);

	if( !empty($this->kxclSetting[ 'separation_title_color' ][ $_title_top ] )	)	//キーがあるか否か。
	{
		foreach(	$this->kxclSetting[ 'separation_title_color' ][ $_title_top ] as $pattern => $arr1):

			if(	preg_match(	$pattern	,	$this->kxclS1[ 'title' ]	,$matches	))
			{

				$num	= NULL;
				if( preg_match(	'/^∬\w{1,}≫c(\d\w{1,}\d)/',	$matches[0]	,$matches0 ) ) // $matches0 2022-01-26
				{
					$num	= $matches0[1];
				}
				unset( $matches0 );	//2022-01-26


				if(	$arr1[0]	=== 'ヾキャラ1ヾ' 	)
				{
					preg_match('/∬(\w{1,})/'	,$this->kxclS1[ 'title' ]	,$matches1	);

					if( !empty( $this->kxclSetting[ 'character' ][	$matches1[1]	] ) &&  is_array(	$this->kxclSetting[ 'character' ][	$matches1[1]	]		)	)
					{
						foreach(	$this->kxclSetting[ 'character' ][	$matches1[1]	]	as $_k =>	$_v	):

							if( !empty( $num )  && preg_match(	$_k	,$num	) )
							{
								$arr1[0]	= $_v;

								break;
							}
							else
							{
								$arr1[0]	= '0';
							}

						endforeach;
					}
					else
					{
						foreach(	$this->kxclSetting[ 'character' ]['ETC']	as $_k =>	$_v	):

							if( !empty( $num )  && preg_match(	$_k	,$num	) )
							{
								$arr1[0]	= $_v;

								break;
							}
							else
							{
								$arr1[0]	= '0';
							}

						endforeach;
					}
				}

				$this->kxclOUT[ 'on_off' ] = 1;
				$this->kxclOUT[ '色相' ] 	= $arr1[0];
				$this->kxclOUT[ 'Type濃度' ] = $arr1[1];

				//★リターン
				return;
			}
			else
			{
				$memo	= 'NG1?';
			}

		endforeach;
	}
	else
	{
		$memo	= 'NG2?';
		$this->kxclS1[ 'title' ] = 'Error';
		$matches[1] = NULL;
	}

	//上記でリターンできなかったパターン。
	$on = NULL;
	$sikisou = NULL;
	foreach(	$this->kxclSetting[ 'separation_title_color' ] as $pattern => $arr_iro2):

		if(	preg_match(	'/'.$pattern.'/'	,	$this->kxclS1[ 'title' ] ) )
		{
			$sikisou	= $arr_iro2[1];
			$on	= 1;
			$memo	.= $matches[1].'→OK';

			break;
		}

	endforeach;

	$this->kxclOUT[ 'on_off' ] = $on;
	$this->kxclOUT[ '色相' ] 	 = $sikisou;
	$this->kxclOUT[ 'Type濃度' ] = $arr_iro2[0];
	$this->kxclOUT[ 'memo' ]  .= $memo;
}



/**
 * ベース色
 *
 * @return void
 */
public function kxcl_pattern( $args = null  ){

	if(	$args && !$this->kxclOUT[ 'Type濃度' ]	)
	{
		$this->kxclOUT[ 'Type濃度' ]	= $args[ 'kosa' ];
	}


	if(	$this->kxclOUT[ 'Type濃度' ] 	== '明度A'	|| $this->kxclOUT[ 'Type濃度' ] == 'ビビット')
	{

		if(	KxSu::get('display_colors_css')	== 'd')
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度A_D' ]	;
		}
		else
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度A_L' ]	;
		}
	}
	elseif(	$this->kxclOUT[ 'Type濃度' ] 	== '明度B')
	{
		if(	KxSu::get('display_colors_css')	== 'd'	)
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度B_D' ]	;
		}
		else
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度B_L' ]	;
		}
	}
	elseif(	$this->kxclOUT[ 'Type濃度' ] 	== '明度C')
	{
		if(KxSu::get('display_colors_css')	== 'd')
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度C_D' ]	;
		}
		else
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度C_L' ]	;
		}
	}
	elseif(	$this->kxclOUT[ 'Type濃度' ] 	== '明度D')
	{
		if(KxSu::get('display_colors_css')	== 'd')
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度D_D' ]	;
		}
		else
		{
			$_array	= $this->kxclSetting[ 'base' ][ '明度D_L' ]	;
		}
	}
	elseif(	$this->kxclOUT[ 'Type濃度' ] 	== '彩度C')
	{
		$_array	= $this->kxclSetting[ 'base' ][ '彩度20' ]	;
	}
	else
	{
		$_array	= $this->kxclSetting[ 'base' ][ $this->kxclOUT[ 'Type濃度' ] ];
	}

	$this->kxclOUT[	'彩度'	]				= $_array[	'彩度'	];
	$this->kxclOUT[	'明度'	]				= $_array[	'明度'	];
	$this->kxclOUT[	'薄型'	]				= $_array[	'薄型'	];
	$this->kxclOUT[	'Type文字色'	]	= $_array[	'文字'	];

	$this->kxclOUT[ 'hsla_normal' ]	= 'hsla('.$this->kxclOUT[ '色相' ].','.$this->kxclOUT[ '彩度' ].'%,'.$this->kxclOUT[ '明度' ].'%,1)' ;
	$this->kxclOUT[ 'hsla_light' ]		= 'hsla('.$this->kxclOUT[ '色相' ].','.$this->kxclOUT[ '彩度' ].'%,'.$this->kxclOUT[ '明度' ].'%,'.$this->kxclOUT[ '薄型' ].')' ;
}



/**
 * テキスト色
 *
 * @param array $args
 * @return $this->kxclOUT[	'text_class'	]
 */
public function kxcl_text(  $args = null ){

	if(	$args && !$this->kxclOUT[ 'Type濃度' ]	)
	{
		$this->kxclOUT[ 'Type文字色' ]	= $args[	'文字' ];
	}


	if(	$this->kxclOUT[ 'Type文字色' ] == '黒' )
	{
		$class  = $this->kxclSetting[ 'arr_text' ]['黒']['class'];
	}
	else
	{
		$class  = $this->kxclSetting[ 'arr_text' ]['白']['class'];
	}

	$this->kxclOUT[	'text_class'	] = $class;
}



/**
 * border追加
 *
 * @param [type] $this->kxclS1[ 'title' ]
 * @return void
 */
public function kxcl_border(){

	$_arr = $this->kxclSetting[ 'separation_title_class_border' ];


	//$_arr[ '__border_pickup' ] = $kxst->working_title;
	//機能停止。2023-11-13

	foreach( $_arr as $key => $value  ):

		if( preg_match( $value , $this->kxclS1[ 'title' ] ))
		{
			$this->kxclOUT[	'border_class'	] = $key;
		}

	endforeach;
}


/**
 * kxx用
 *
 * @return void
 */
public function kxcl_kxx(){

	//ショートカット
	if( !empty( $_SESSION[ 'color2' ][	$this->kxclOUT[ 'on_off' ]	 . $this->kxclS1[ 'type' ] . $this->kxclOUT[ '色相' ]	.	$this->kxclOUT[ 'Type濃度' ]	]  ) )
	{
		$_SESSION[ 'color2' ][	$this->kxclOUT[ 'on_off' ]	. $this->kxclS1[ 'type' ] . $this->kxclOUT[ '色相' ]	.	$this->kxclOUT[ 'Type濃度' ]	]['count']++;
		$this->kxclOUT					= $_SESSION[ 'color2' ][	$this->kxclOUT[ 'on_off' ]	. $this->kxclS1[ 'type' ] . $this->kxclOUT[ '色相' ] . $this->kxclOUT[ 'Type濃度' ]	][ 'kxclOUT' ];

		return;
	}


	//準備
	$_s 						= $this->kxclOUT[ '彩度' ] ;
	$_m							= $this->kxclOUT[ '明度' ] ;
	$_u							= $this->kxclOUT[ '薄型' ] ;

	$this->kxclOUT[ 'hsla_normal' ]	= 'hsla('.$this->kxclOUT[ '色相' ].','.$_s.'%,'.$_m.'%,1)' ;
	$this->kxclOUT[ 'hsla_light' ]		= 'hsla('.$this->kxclOUT[ '色相' ].','.$_s.'%,'.$_m.'%,'.$_u.')' ;
	$this->kxclOUT[ 'background_normal_style' ]	= 'background-color:'.	$this->kxclOUT[	'hsla_normal'	]	.';';
	$this->kxclOUT[ 'background_light_style' ]		= 'background-color:'.	$this->kxclOUT[	'hsla_light'	]	.';';

	$this->kxclOUT[ 'background_class_normal' ]	= '__bg_'.$_s.'_'.$_m.'_'.$this->kxclOUT[ '色相' ] ;
	$this->kxclOUT[ 'background_class_light' ]		= '__bg_'.$_s.'_'.$_m.'_'.$this->kxclOUT[ '色相' ].'u' ;

	//echo $this->kxclOUT[ 'background_class_normal' ] .'<br>';

	$this->kxclOUT[ 'background_class_u50' ]		= '__bg_100_50_'.$this->kxclOUT[ '色相' ].'u50' ;

	$this->kxclOUT[ 'c_sdw_ue' ]				= '__box_shadow_ue_'.$_s.'_'.$_m.'_'.$this->kxclOUT[ '色相' ];
	$this->kxclOUT[ 'c_sdw_sita' ]			= '__box_shadow_sita_'.$_s.'_'.$_m.'_'.$this->kxclOUT[ '色相' ];

	$_SESSION[ 'color2' ][	$this->kxclOUT[ 'on_off' ]	. $this->kxclS1[ 'type' ].	$this->kxclOUT[ '色相' ]	.	$this->kxclOUT[ 'Type濃度' ]	][ 'kxclOUT' ]	= $this->kxclOUT;
	$_SESSION[ 'color2' ][	$this->kxclOUT[ 'on_off' ]	. $this->kxclS1[ 'type' ].	$this->kxclOUT[ '色相' ]	.	$this->kxclOUT[ 'Type濃度' ]	]['count']	= 1;
}


/**
 * kx30用
 *
 */
public function kxcl_kx30(){



	if(	$this->kxclOUT[ 'Type濃度' ]	== 'ビビット')
	{
		if(KxSu::get('display_colors_css')	== 'd')
		{
			$kosa	= '__shadow_50_60_';
		}
		else
		{
			$kosa	= '__shadow_50_50_';
		}
	}
	elseif(	$this->kxclOUT[ 'Type濃度' ]	== '彩度D')
	{
		if(KxSu::get('display_colors_css')	== 'd')
		{

			$kosa	= '__shadow_15_70_';
		}
		else
		{
			$kosa	= '__shadow_15_40_';
		}
	}
	else
	{
		if(KxSu::get('display_colors_css')	== 'd' )
		{
			$kosa	= '__shadow_50_80_';
		}
		else
		{
			$kosa	= '__shadow_50_30_';
		}
	}

	//style型
	$arr0 = [

		[1,1,2,','],
		[-1,1,2,','],
		[1,-1,2,','],
		[-1,-1,2,';'],

	];

	if(KxSu::get('display_colors_css')	== 'd')
	{
		//echo  $this->kxclOUT[ '明度' ];

		if( $this->kxclOUT[ '明度' ]  > 30)
		{
			$_s = 40;
			$_l = 60;
		}
		elseif( $this->kxclOUT[ '明度' ]  > 20)
		{
			$_s = 30;
			$_l = 60;
		}
		else
		{
			$_s = 20;
			$_l = 60;
		}

		if( $this->kxclOUT[ '色相' ]  > 180 && $this->kxclOUT[ '色相' ]  < 310)
		{
			$_l = $_l +10;
		}

	}

	$style_block = NULL;
	foreach( $arr0 as $arr):

		$style_block .= 'hsla(' . $this->kxclOUT[ '色相' ] . ','.$_s.'%,'.$_l.'%,1) '.$arr[0].'px '.$arr[1].'px '.$arr[2].'px'.$arr[3].'';

	endforeach;

	$this->kxclOUT[ 'kxx30_style' ] = 'font-weight:bold;	color:#111;	text-shadow:'.$style_block;

	//色
	$this->kxclOUT[ 'kxx30_class' ]	= $kosa	.	$this->kxclOUT[ '色相' ];

}
}//*** *** *** *** *** *** kxcl *** *** *** *** *** ***


