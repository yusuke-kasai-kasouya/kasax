<?php

use Kx\Utils\Time;

/**
 * class。タイトル系。
 */
class kxtt {

public function __construct( $args) {
	$this->kxttS0    = $args;
	$this->kxtt_main();
}

public function get(){
	return $this->kxttOUT;
}


private $kxttS0 = //初期値。入力用。2023-08-05
[
	'type'             => NULL,
	'title'            => NULL,
];


private $kxttS1; ////作業値。2023-08-11


// 出力用配列。2023-08-05
public $kxttOUT =
[
	'character_number'   => NULL,
	'character_name'     => 'キャラ名：未登録',
	'character_yobina'   => 'キャラ呼び名：未登録',
	'counterpart_number' => NULL,
	'work_code'				   => NULL,
	'work_code_top1'     => NULL,
	'work_code_top3'     => NULL,
	'work_code_number'   => NULL,
	'work_code_number_s' => NULL,
	'work_name'          => '作品名キャラ呼び名：未登録',
	'array_name' 				 =>
	[
		1 => NULL
	]
];




/**
 * メインプログラム。
 * 2023-08-05
 *
 * @return void
 */
public function kxtt_Main(){

	//$this->kxttS0 = $args;

	$this->kxtt_setting();

	switch ($this->kxttS1['type'])
	{
	case 'character':
		$this->kxtt_character();
		break;

	case 'work':
		$this->kxtt_character();
		if (!empty($this->kxttOUT['work_code'])) {
				$this->kxtt_work();
		}
		break;

	case 'kx10':
		$this->kxtt_kx10();
		break;

	case 'h1':
		$this->kxtt_h1_kxol();
		$this->kxtt_h1_small();
		break;

	case 'kxtt_kxol':
		//一箇所。2023-08-09
		$this->kxtt_h1_kxol();
		break;

	case 'kxtt_work':
		$this->kxtt_work();
		break;

	case 'TitleReplace':
		$this->kxtt_TitleReplace();
		break;

	default:
		echo kx_CLASS_error('タイトル名の呼び出しエラー:type違い');
		break;
	}


}




/**
 * 設定。
 * 2023-08-05
 *
 * @param [type] $title
 * @return void
 */
public function kxtt_setting(){

	$this->kxttS1 = $this->kxttS0;

	if( empty( $this->kxttS1[ 'type' ]))
	{
		echo kx_CLASS_error('タイトル名の呼び出しエラー:typeなし');
	}


	//title
	$this->kxttS1['title'] = empty($this->kxttS1['title']) ? get_the_title() : $this->kxttS1['title'];

	$this->kxttS1[ 'title_array' ]  = explode( '≫' , $this->kxttS1[ 'title' ] );
	$this->kxttS1[ 'count' ]			  = count( $this->kxttS1[ 'title_array' ] );


	$this->kxttOUT['title0_name'] =
	!empty(KxSu::get('titile_name')[$this->kxttS1['title_array'][0]]['name'])
	? KxSu::get('titile_name')[$this->kxttS1['title_array'][0]]['name']
	: NULL;


	//キャラクター関連データの場合。2023-08-06
	//キャラナンバー生成。2023-08-06

	if( !empty( $this->kxttS1[ 'character_number' ]  ) )
	{
		//キャラナンバー出力。2023-08-05
		$this->kxttOUT[ 'character_number' ] = $this->kxttS1[ 'character_number' ];
	}
	elseif( empty( $this->kxttS1[ 'character_number' ] ) && preg_match(	'/∬\w{1,}≫c(\d\w{1,}\d)/i'	,	$this->kxttS1[ 'title' ]	,	$matches	) )
	{
		$this->kxttOUT[ 'character_number' ] = $matches[ 1 ];
		//$this->kxttOUT[ 'world' ]	= $matches[1];
	}

	unset( $matches);

	//world出力。2023-08-06
	$this->kxttOUT[ 'world' ]	=  $this->kxttS1[ 'title_array' ][ 0 ];
	$this->kxttOUT[ 'world_num' ]	=  preg_replace( '/∬/','',  $this->kxttS1[ 'title_array' ][ 0 ]);



	if( preg_match(	'/∬\w{1,}≫c\d\w{1,}\d≫('.KxSu::get('titile_search')[ 'work_Platform' ].')(\d{1,})/i'	,	$this->kxttS1[ 'title' ]	,	$matches	) )
	{
		//作品ファイル系
		$this->kxttOUT[ 'work_code' ]	         = $matches[1] . $matches[2];
		$this->kxttOUT[ 'work_code_top1' ]	   = substr(	$matches[1]	,0	,1	);
		$this->kxttOUT[ 'work_code_top3' ]	   = $matches[1];
		$this->kxttOUT[ 'work_code_number' ]   = $matches[2];

		if(
			strtolower( $this->kxttOUT[ 'work_code_top1' ] ) == 'k'
			|| strtolower( $this->kxttOUT[ 'work_code_top1' ] ) == 'y'
			|| strtolower( $this->kxttOUT[ 'work_code_top1' ] ) == 'o'
			|| strtolower( $this->kxttOUT[ 'work_code_top1' ] ) == 'n'
		)
		{
			$this->kxttOUT[ 'work_code_number_s' ] = preg_replace(	'/^00|^0/'	,''	,$matches[2] );
		}
		else
		{
			//主にSys系の場合。2023-08-09
			$this->kxttOUT[ 'work_code_number_s' ] = $matches[2];
		}
	}
	elseif(	preg_match(	'/^∬\w{1,}≫c\d\w{1,}\d.*≫(＼|)c(\d\w{1,}\d)(≫来歴|)$/i' , $this->kxttS1[ 'title' ] ,	$matches	)	)
	{
		$this->kxttOUT[ 'counterpart_number' ] = $matches[2];

	}
	elseif(	preg_match(	'/^∫≫(T|M)≫(\d{1,})/i' , $this->kxttS1[ 'title' ] ,	$matches	)	)
	{
		$this->kxttOUT[ 'work_code' ]          = 'sample';
		$this->kxttOUT[ 'work_code_top1' ]     = $matches[1];
		$this->kxttOUT[ 'work_code_top3' ]     = 'sample';
		$this->kxttOUT[ 'work_code_number' ]   = $matches[2];
	}
	unset( $matches);
}



/**
 * ナンバーからキャラクター名の呼び出し。
 *
 * @return void
 */
public function kxtt_character( $number = null ){

	$_arr      = kx_json_arr( get_stylesheet_directory() . "/data/json/chara.json" );

	if( empty( $number ) )
	{
		$_number = $this->kxttOUT[ 'character_number' ];
	}
	else
	{
		$_number =  $number;
	}


	if( !empty( $_arr[ $this->kxttS1[ 'title_array' ][0] ][ $_number ] ) )
	{

		//キャラクター配列。2023-08-05
		$_character_array  = $_arr[ $this->kxttS1[ 'title_array' ][0] ][ $_number ];

		//名前。2023-08-05
		$_character_name = $_character_array[0];

		//呼び名。2023-08-05
		$_character_yobina = $_character_array[1];

		//年齢差。2023-08-05
		if( !empty( $_character_array[2]) )
		{
			$_character_age_sa = $_character_array[2];
		}
		else
		{
			$_character_age_sa = NULL;
		}

		//学歴。2024-06-13
		if( !empty( $_character_array[3]) )
		{
			$_character_gaku = $_character_array[3];
		}
		else
		{
			$_character_gaku = 'off';
		}


		//短縮名。2023-08-05
		if( !empty( $_character_array[4]) )
		{
			$_character_name_s = $_character_array[4];
		}
		else
		{
			$_character_name_s = NULL;
		}

		//info。2023-08-05
		if( !empty( $_character_array[5]) )
		{
			$_character_info = $_character_array[5];
		}
		else
		{
			$_character_info = NULL;
		}
	}

	if(
		!empty( $number )
		&& !empty( $this->kxttOUT[ 'counterpart_number' ] )
		&&  $number == $this->kxttOUT[ 'counterpart_number' ]
		&& !empty( $_arr[ $this->kxttS1[ 'title_array' ][0] ][ $_number ] )
	)
	{
		$this->kxttOUT[ 'counterpart_array']    = $_character_array;
		$this->kxttOUT[ 'counterpart_name' ]    = $_character_name;
		$this->kxttOUT[ 'counterpart_name_s']   = $_character_name_s;
		$this->kxttOUT[ 'counterpart_yobina' ]  = $_character_yobina;
		$this->kxttOUT[ 'counterpart_age_sa']   = $_character_age_sa;
		//$this->kxttOUT[ 'character_gaku']       = $_character_gaku;
		$this->kxttOUT[ 'counterpart_info' ]    = $_character_info;
	}
	elseif(
		empty( $number )
		&& !empty( $this->kxttOUT[ 'character_number' ] )
		&& !empty( $_arr[ $this->kxttS1[ 'title_array' ][0] ][ $_number ] )
	)
	{
		//通常
		$this->kxttOUT[ 'character_array']    = $_character_array;
		$this->kxttOUT[ 'character_name' ]    = $_character_name;
		$this->kxttOUT[ 'character_name_s']   = $_character_name_s;
		$this->kxttOUT[ 'character_yobina' ]  = $_character_yobina;
		$this->kxttOUT[ 'character_age_sa']   = $_character_age_sa;
		$this->kxttOUT[ 'character_gaku']     = $_character_gaku;
		$this->kxttOUT[ 'character_info' ]    = $_character_info;
	}
	elseif( !empty( $number ) )
	{
		if( !empty( $_character_array ) )
		{
			$this->kxttOUT[ 'etc_character_array']   = $_character_array;
			$this->kxttOUT[ 'etc_character_name']    = $_character_name;
			$this->kxttOUT[ 'etc_character_name_s']  = $_character_name_s;
			$this->kxttOUT[ 'etc_character_yobina' ] = $_character_yobina;
			$this->kxttOUT[ 'etc_character_age_sa']  = $_character_age_sa;
			//$this->kxttOUT[ 'character_gaku']       = $_character_gaku;
			$this->kxttOUT[ 'etc_character_info' ]   = $_character_info;
		}
		else
		{
			echo 'エラーだと思われる。C-Num'.$number.'<br>';
			$this->kxttOUT[ 'etc_character_array']   = [];
			$this->kxttOUT[ 'etc_character_name']    = '未登録';
			$this->kxttOUT[ 'etc_character_name_s']  = '未登録';
			$this->kxttOUT[ 'etc_character_yobina' ] = '未登録';
			$this->kxttOUT[ 'etc_character_age_sa']  = '未登録';
			//$this->kxttOUT[ 'character_gaku']       = $_character_gaku;
			$this->kxttOUT[ 'etc_character_info' ]   = '未登録';
			$this->kxttOUT[ 'counterpart_name' ]    = '未登録';
		}

	}
}


/**
 * 作品配列からの呼び出し。
 *
 * @return void
 */
public function kxtt_work(){

	$_arr_json = kx_json_arr(	get_stylesheet_directory() . "/data/json/sakuhin.json"	);

	if( !empty( $_arr_json[ strtolower( $this->kxttOUT[ 'work_code_top3' ] ) ][ $this->kxttOUT[ 'work_code_number' ] ] ) )
	{
		$_array = $_arr_json[ strtolower( $this->kxttOUT[ 'work_code_top3' ] ) ][ $this->kxttOUT[ 'work_code_number' ] ] ;
		//$this->kxttOUT[ 'work_array'] = $_arr[ strtolower( $this->kxttOUT[ 'work_code_top3' ] ) ][ $this->kxttOUT[ 'work_code_number' ] ] ;
		//$this->kxttOUT[ 'work_name']  = $this->kxttOUT[ 'work_array'][0];

		if( !empty( $_array[0] ) )
		{
			$this->kxttOUT[ 'work_name']  = $_array[0];
		}

		if( !empty( $_array[1] ) )
		{
			$this->kxttOUT[ 'work_count_chara']  = $_array[1];
		}

		if( !empty( $_array[2] ) )
		{
			$this->kxttOUT[ 'work_charas' ] = $_array[2];
			//echo '<hr>';
		}

		if( !empty( $_array[3] ) )
		{
			$this->kxttOUT[ 'work_plot_time_min' ] = $_array[3];
			//echo '<hr>';
		}

		if( !empty( $_array[4] ) )
		{
			$this->kxttOUT[ 'work_plot_time_max' ] = $_array[4];
			//echo '<hr>';
		}
	}
}



/**
 * kx10用
 * 2023-08-07
 *
 * @param [type] $text
 * @param [type] $title
 * @return void
 */
public function kxtt_kx10(){

	//対人postの場合。2023-08-07
	if( preg_match( '/^＼c(\d\w{1,}\d)$/i' ,$this->kxttS1[ 'content'] , $matches0 ) )
	{
		$this->kxtt_character();
		$this->kxtt_character( $this->kxttOUT[ 'counterpart_number' ] );
		$this->kxttOUT[ 'content' ]	  = $this->kxttOUT[ 'character_name' ] .'&nbsp;＼c' . $this->kxttOUT[ 'counterpart_number' ] . '（' . $this->kxttOUT[ 'counterpart_name' ] .'）';
	}
	elseif( preg_match( '/∫≫(T|M)≫\d{1,}$/' , $this->kxttS1[ 'title'] ) )
	{
		$this->kxtt_work();

		$this->kxttOUT[ 'content' ] = $this->kxttS1[ 'content'] .'-'. $this->kxttOUT[ 'work_name'];
	}
	else
	{
		$this->kxttOUT[ 'content' ]	= $this->kxttS1[ 'content'];
	}
}



/**
 * outline用
 * h1用
 * 2023-08-10
 *
 * @return void
 */
public function kxtt_h1_kxol(){

	$this->kxttOUT[ 'h1_title' ][0] = NULL;

	if( !empty( $this->kxttOUT[ 'work_code' ] )) //作品ポスト。2023-08-11
	{
		$this->kxtt_character();
		$this->kxtt_work();

		if( preg_match( '/来歴$/' , $this->kxttS1[ 'title']))
		{
			//来歴。2024-06-19
			if( !empty( $this->kxttOUT[ 'work_code' ] ) )
			{
				if( !empty( $this->kxttOUT[ 'work_code_top1' ]  ) && $this->kxttOUT[ 'work_code_top1' ] == 'S' )
				{
					$this->kxttOUT[ 'kxtt_kxol' ] = $this->kxttOUT[ 'work_name' ] ;
				}
				else
				{
					$this->kxttOUT[ 'kxtt_kxol' ] = $this->kxttOUT[ 'work_code' ] .'-'. end( $this->kxttS1[ 'title_array' ] ) ;
				}

				$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ 0 ] . $this->kxttOUT[ 'title0_name' ];
				$this->kxttOUT[ 'h1_title' ][1]	= 'C'. $this->kxttOUT[ 'character_number' ].'&nbsp;' . $this->kxttOUT[ 'character_name' ];
				$this->kxttOUT[ 'h1_title' ][ 'main' ]	= $this->kxttOUT[ 'work_name'] . '&nbsp;&nbsp;-&nbsp;&nbsp;' .end( $this->kxttS1[ 'title_array' ] );
			}
			else
			{
				$this->kxttOUT[ 'kxtt_kxol' ] = $this->kxttOUT[ 'work_code' ] .'-'. end( $this->kxttS1[ 'title_array' ] ) ;

				$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ 0 ] . $this->kxttOUT[ 'title0_name' ];
				$this->kxttOUT[ 'h1_title' ][1]	= 'C'. $this->kxttOUT[ 'character_number' ].'&nbsp;' . $this->kxttOUT[ 'character_name' ];
				$this->kxttOUT[ 'h1_title' ][ 'main' ]	= $this->kxttOUT[ 'work_code' ].end( $this->kxttS1[ 'title_array' ] );
			}
		}
		elseif( $this->kxttOUT[ 'work_code' ]  == 'sample' && preg_match( '/'.$this->kxttOUT[ 'work_code_number' ].'$/' , $this->kxttS1[ 'title' ] ) )
		{
			//Sample作品。トップ
			$this->kxttOUT[ 'kxtt_kxol' ] = $this->kxttOUT[ 'work_code_number' ] .'-' . $this->kxttOUT[ 'work_name' ];

			$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttOUT[ 'work_code_top1' ];
			$this->kxttOUT[ 'h1_title' ][1]	= $this->kxttOUT[ 'work_code_number' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	= $this->kxttOUT[ 'work_name' ];
		}
		elseif( $this->kxttOUT[ 'work_code' ]  == 'sample' )
		{
			//Sample作品下位ファイル。
			$this->kxttOUT[ 'kxtt_kxol' ] = end( $this->kxttS1[ 'title_array' ] ) . '-Sample';

			$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttOUT[ 'work_code_top1' ].$this->kxttOUT[ 'work_code_number' ];
			$this->kxttOUT[ 'h1_title' ][1]	= $this->kxttOUT[ 'work_name' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	= end( $this->kxttS1[ 'title_array' ] );
		}
		else
		{
			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ] .'-'. $this->kxttOUT[ 'work_code' ] ;

			$this->kxttOUT[ 'h1_title' ][1]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-2];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	= end( $this->kxttS1[ 'title_array' ] );
		}
	}
	elseif( !empty( $this->kxttOUT[ 'character_number' ] ) )
	{
		$this->kxtt_character();
		//キャラクターポスト。2023-08-11
		if( preg_match( '/2構成$/' , $this->kxttS1[ 'title' ] ))
		{
			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ] .'-2構成';

			$this->kxttOUT[ 'h1_title' ][0]	= 'C'. $this->kxttOUT[ 'character_number' ] ;
			$this->kxttOUT[ 'h1_title' ][1]	= $this->kxttOUT[ 'character_name' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	= '2構成';
		}
		elseif( preg_match( '/^∬\w{1,}≫c\d\w{1,}\d.*≫(＼|)c(\d\w{1,}\d)/i', $this->kxttS1[ 'title' ] ) )
		{
			$this->kxtt_character( $this->kxttOUT[ 'counterpart_number' ] );


			$_counterpart_name = !empty($this->kxttOUT['counterpart_name']) ? $this->kxttOUT['counterpart_name'] : 'N/A';


			$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-3] ;
			$this->kxttOUT[ 'h1_title' ][1]	= 'C'. $this->kxttOUT[ 'character_number' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	=  $this->kxttOUT[ 'character_name' ] .'⇒'.$_counterpart_name;

			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ].'⇒'.$this->kxttOUT[ 'counterpart_number' ];

		}
		elseif( preg_match( '/c\d\w{1,}\d$/' , $this->kxttS1[ 'title' ] ))
		{
			$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-2] ;
			$this->kxttOUT[ 'h1_title' ][1]	= 'C'. $this->kxttOUT[ 'character_number' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	=  $this->kxttOUT[ 'character_name' ] ;

			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ].'-'. $this->kxttOUT[ 'h1_title' ][ 'main' ];
		}
		elseif( preg_match( '/c\d\w{1,}\d≫0Main$/' , $this->kxttS1[ 'title' ] ))
		{
			$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-3] ;
			$this->kxttOUT[ 'h1_title' ][1]	= 'C'. $this->kxttOUT[ 'character_number' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	=  $this->kxttOUT[ 'character_name' ] ;
			$this->kxttOUT[ 'h1_title' ][ 'add' ]	=  '　C0Main';


			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ].'-'. $this->kxttOUT[ 'h1_title' ][ 'main' ];
		}
		elseif( preg_match( '/∬\d{1,}≫c\d\w{1,}\d≫W$/' , $this->kxttS1[ 'title' ] ) )
		{
			//キャラのW型。
			$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-3] ;
			$this->kxttOUT[ 'h1_title' ][1]	= 'C'. $this->kxttOUT[ 'character_number' ];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	=  $this->kxttOUT[ 'character_name' ] .'&nbsp;+W';

			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ].'-'. $this->kxttOUT[ 'h1_title' ][ 'main' ];
		}
		else
		{
			$this->kxttOUT[ 'kxtt_kxol' ] = 'C'. $this->kxttOUT[ 'character_number' ] .'-' . $this->kxttOUT[ 'character_name' ];

			//$this->kxttOUT[ 'h1_title' ][0]	= $this->kxttS1[ 'title_array' ][ 0 ] ;
			$this->kxttOUT[ 'h1_title' ][1]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-2];
			$this->kxttOUT[ 'h1_title' ][ 'main' ]	= end( $this->kxttS1[ 'title_array' ] );
		}
	}
	elseif( $this->kxttS1[ 'count' ] == 1 )
	{
		$this->kxttOUT[ 'kxtt_kxol' ]  = end( $this->kxttS1[ 'title_array' ] );
		$this->kxttOUT[ 'kxtt_kxol' ] .= $this->kxttOUT[ 'title0_name' ];

		$this->kxttOUT[ 'h1_title' ][ 'main' ]	= $this->kxttOUT[ 'kxtt_kxol' ];
	}
	elseif( $this->kxttS1[ 'count' ] == 2 )
	{
		$this->kxttOUT[ 'kxtt_kxol' ] = end( $this->kxttS1[ 'title_array' ] );

		$this->kxttOUT[ 'h1_title' ][1]	 = $this->kxttS1[ 'title_array' ][0];
		$this->kxttOUT[ 'h1_title' ][1] .= $this->kxttOUT[ 'title0_name' ];
		$this->kxttOUT[ 'h1_title' ][ 'main' ]	= $this->kxttOUT[ 'kxtt_kxol' ];
	}
	else
	{
		$this->kxttOUT[ 'kxtt_kxol' ] = end( $this->kxttS1[ 'title_array' ] );

		//$this->kxttOUT[ 'h1_title' ][0]	 = $this->kxttS1[ 'title_array' ][0];
		//$this->kxttOUT[ 'h1_title' ][0] .= $this->kxttOUT[ 'title0_name' ];
		$this->kxttOUT[ 'h1_title' ][1]	= $this->kxttS1[ 'title_array' ][ $this->kxttS1[ 'count' ]	-2];
		$this->kxttOUT[ 'h1_title' ][ 'main' ]	= end( $this->kxttS1[ 'title_array' ] );
	}

	//下位ネームがある場合の追記。2023-08-27
	if(
		!empty( $this->kxttS1[ 'title_array' ][ 1 ] )
		&& !empty( KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ][ 1 ][ $this->kxttS1[ 'title_array' ][ 1 ]  ] )
	)
	{
		$this->kxttOUT[ 'h1_title' ][0]   .=  KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ][ 1 ][ $this->kxttS1[ 'title_array' ][ 1 ] ];
		$this->kxttOUT[ 'array_name' ][1]  =  KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ][ 1 ][ $this->kxttS1[ 'title_array' ][ 1 ] ];
	}
	else
	{

	}
}


/**
 * H1タイトル。上部の小さい部分。
 * 2023-09-04
 *
 * @param [type] $title
 * @return void
 */
public function kxtt_h1_small(){

	if(	$this->kxttS1[ 'count' ] >= 1 && $this->kxttS1[ 'count' ] <= 2)
	{
		$_max	= $this->kxttS1[ 'count' ];
	}
	else
	{
		$_max	= $this->kxttS1[ 'count' ]	-	1;
	}


	if( !empty( KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ] ) )
	{
		$_add0 = KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ][ 'name' ];
	}
	else
	{
		$_add0 = NULL;
	}


	//スタート。2023-08-07
	$ret = '';

	//タイトルの階層を記載。2023-09-04
	for( $i = 0; $i < $_max; ++$i ) :

		$ret .= $this->kxttS1[ 'title_array' ][ $i ]	;

		if( $i == 0 )
		{
			$ret .= $_add0;
		}


		if(	$i	!= $_max-1	)
		{
			$ret .= '︙';
		}

	endfor;

	if( !empty( $this->kxttOUT[ 'character_number' ] ))
	{
		$ret .= '（' . $this->kxttOUT[ 'character_name' ] . '）';
	}

	//階層の棒を作成。2023-09-04
	$str = '';
	for ($i = 1; $i <= $this->kxttS1[ 'count' ] ; $i++):

		$str .= '|';

	endfor;

	$ret .= '<span style="opacity:.25;">&nbsp;&nbsp;' . $str .'</span>';

	$this->kxttOUT[ 'h1_small' ] = $ret;

	return;
}



/**
 * タイトル置換。html出力。
 * 2023-08-09
 *
 * @return void
 */
public function kxtt_TitleReplace(){

	//カラー呼び出し。2024-06-25
	$this->kxttS1[ 'kxcl' ] = kx_CLASS_kxcl( $this->kxttS1[ 'title' ] 	,	'kxx'	);

	//カラー設定の下に置く。2023-08-10
	if( !empty( $this->kxttS1[ 'string' ] ) )
	{
		//文字指定型で使用。2023-08-09
		$this->kxttS1[ 'title' ] = $this->kxttS1[ 'string' ];
	}

	$_right_on	= 1;

	$this->kxttOUT[ 'html' ][ 'style_All' ]	= 'background-color:' . $this->kxttS1[ 'kxcl' ][ 'hsla_normal' ]. ';';
	$this->kxttOUT[ 'html' ][ 'class0' ]	  = '__title_tikan '. $this->kxttS1[ 'kxcl' ][ 'border_class' ] .' '. $this->kxttS1[ 'kxcl' ]['text_class'];
	$this->kxttOUT[ 'html' ][ 'class1' ]	  = 'kx_title_tikan_left';
	$this->kxttOUT[ 'html' ][ 'class2' ]	  = '__title_tikan_white';
	$this->kxttOUT[ 'html' ][ 'class21' ]   = '__ra ';
	$this->kxttOUT[ 'html' ][ 'class3' ]	  = '__title_tikan3';


	if( !empty( $this->kxttS1[ 'string' ] ) )
	{
		$_right_on	= 0;
		$this->kxttOUT[ 'html' ][ 'class2']  = NULL;
		$this->kxttOUT[ 'html' ][ 'class21'] = NULL;
	}

	$this->kxtt_TitleReplace_setting();

	if( empty( $_right_on ) )
	{
		$this->kxttOUT[ 'title_change_top' ] = NULL;
	}

	ob_start();
	include  __DIR__ .'/html/hyouji_title_tikan.php';
	$this->kxttOUT[ 'TitleReplace_html' ] = ob_get_clean();
}





/**
 * 主にkx40系のタイトル置換。
 * サーチページでも使用。
 * 2023-08-14
 *
 * @param string $title
 * @return string
 */
public function kxtt_TitleReplace_setting(){

	$_title1       = NULL;
	$_title3       = NULL;
	$_style_top    = NULL;
	$_style_center = NULL;

	/*
	.__kxtt_monospace_105
	{
		font-family: 'Kosugi Maru';
		//M PLUS 1 Code,Source Han Code JP,Noto Sans Mono CJK JP,IBM Plex Mono JP,Kosugi Maru
		font-size: 10.5pt;
	}

	.__kxtt_monospace_100
	{
		font-family: 'Kosugi Maru';
		font-size: 10pt;
	}
	*/

	if(	preg_match(	'/^(∬\w{1,})≫c((\d)\w{1,}\d)$/' , $this->kxttS1[ 'title' ] , $matches) 	)
	{
		//キャラの場合。kxx40系統で使っている。2023-08-10

		$this->kxtt_character();
		$_title1 = KxSu::get('titile_name')[ $this->kxttOUT[ 'world' ] ][ 'short' ] . '&nbsp;C' . $this->kxttOUT[ 'character_number' ];
		$_title2 = $this->kxttOUT[ 'character_name' ];

		$_style_top    = "font-family:'Kosugi Maru';font-size: 10pt;";
		$_style_top   .= 'display: inline-block;';
		$_style_center = "font-family:'Kosugi Maru';font-size: 10.5pt;";

		if( $matches[3] == 1 || $matches[3] == 2 || $matches[3] == 4 )
		{
			$_style_top   .= 'width:80px;';
		}
		elseif( $matches[3] == 8  )
		{
			$_style_top   .= 'width:100px;';
		}
		elseif( $matches[3] == 5  || $matches[3] == 6 )
		{
			$_style_top   .= 'width:120px;';
		}
		else
		{
			$_style_top   .= 'width:80px;';
		}
	}
	elseif(	!empty( $this->kxttOUT[ 'counterpart_number' ] ) )
	{
		//対人関係の場合。counterpart。

		$this->kxtt_character();
		$this->kxtt_character( $this->kxttOUT[ 'counterpart_number' ] );

		$_title1	= KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][0] ][ 'short' ] . '&nbsp;c' . $this->kxttOUT[ 'character_number' ];
		$_title2	= $this->kxttOUT[ 'character_name' ] . ' × ' . $this->kxttOUT[ 'counterpart_name' ];
		$_title3	= '対人関係：' . $this->kxttOUT[ 'character_number' ] . ' × ' . $this->kxttOUT[ 'counterpart_number' ];
	}
	elseif(	!empty( $this->kxttOUT[ 'work_code' ] ) && !empty( $this->kxttOUT[ 'world' ] )	)
	{
		$this->kxtt_character();
		$this->kxtt_work();

		$_title1	= KxSu::get('titile_name')[ $this->kxttOUT[ 'world' ] ][ 'short' ] . '&nbsp;c' . $this->kxttOUT[ 'character_number' ];
		$_title2	= $this->kxttOUT[ 'work_code' ]  . '&nbsp;&nbsp;' . $this->kxttOUT[ 'work_name'];
		//$_title3	= $this->kxttOUT[ 'character_number' ];

		if(strtolower( $this->kxttOUT[ 'work_code_top1' ] ) == 's')
		{
			//sys省略用。追記。2024-10-07
			$_world = str_replace( '∬','',  $this->kxttOUT[ 'world' ]);
			//$_world = sprintf("%03d", $_world);
			//echo $_world;
			$_title2a = preg_replace(	'/Sys'. sprintf("%03d", $_world) . $this->kxttOUT[ 'character_number' ] .'/'	,''	,$_title2 );

			$_title2 = 'S' . $_world . '&nbsp;' .$_title2a;

		}

		$_style_top    = 'display: inline-block;width:70px;';
		$_style_top   .= "font-family:'Kosugi Maru';font-size: 10pt;";
		$_style_center = "font-family:'Kosugi Maru';font-size: 10.5pt;";
	}
	/*
	elseif(	preg_match(	'/^(∬\w{1,})≫c(\d\w{1,}\d)≫2構成≪不使用2024-06-16≪$/i'	, $this->kxttS1[ 'title' ]  )	)
	{
		//2構成の場合

		$this->kxtt_character();
		$_title1	= KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][0] ][ 'short' ].'─c' . $this->kxttOUT[ 'character_number' ] ;
		$_title2	= 'Ⅱ '. $this->kxttOUT[ 'character_name' ];

		$_style_top = 'display: inline-block;width:90px;';
	}
	*/
	else
	{
		if(
			!empty( $this->kxttS1[ 'title_array' ][ 1 ] )
			&& !empty( KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ][ 1 ][ $this->kxttS1[ 'title_array' ][ 1 ]  ] )
		)
		{
			$this->kxttS1[ 'title_array' ][ 1 ] = $this->kxttS1[ 'title_array' ][ 1 ] . KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][ 0 ] ][ 1 ][ $this->kxttS1[ 'title_array' ][ 1 ] ];
		}

		for($i = 0; $i < count( $this->kxttS1[ 'title_array' ] )-1; ++$i):

			if( $i == 0 )
			{
				$_title1	= $this->kxttS1[ 'title_array' ][0] . KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][0] ][ 'name' ];
			}
			elseif( $i == 1 )
			{
				$_title1	.= '&nbsp;'. $this->kxttS1[ 'title_array' ][$i] ;
			}
			else
			{
				$_title1	.= '︙'. $this->kxttS1[ 'title_array' ][$i] ;
			}

		endfor;

		$_title2	= end( $this->kxttS1[ 'title_array' ] );

		//最上位の場合
		if( !$_title1 && !empty( KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][0] ] ))
		{
			$_title1	= $this->kxttS1[ 'title_array' ][0] . KxSu::get('titile_name')[ $this->kxttS1[ 'title_array' ][0] ][ 'name' ];
		}
	}
	unset( $matches );

	$this->kxttOUT[ 'title_change_top' ]		      = $_title1;
	$this->kxttOUT[ 'title_change_main' ]	        = $_title2;
	$this->kxttOUT[ 'title_change_end' ]		      = $_title3;
	$this->kxttOUT[ 'title_change_style_top' ]    = $_style_top;
	$this->kxttOUT[ 'title_change_style_center' ] = $_style_center;
}

}//********** ********** ********** kxtt ********** ********** **********





/**
 * ★★サイドフロート用クラス
 * ヘッダバーから読み込み。
 */
class kxft {

public $kxft_S1 =
[
	'ShortStory' => NULL,
];

public $W_title;
public $db2;
public $edit;


/**
 * メインプログラム
 * 出力は配列型。
 *
 * @param [type] $args
 * @return array
 */
public function kxft_Main( $args ){
	//echo $args['id'];

	$this->kxft_S1 = $args + $this->kxft_S1;

	if(
		preg_match( '/'.KxSu::get('titile_search')[ 'kx_0_ft' ].'/' , $args[ 'title_base' ] , $matches )
		&& is_single( $args['id'] )
	){
		$ret = [ 'type' => 'KX0DB' , 'content' => $this->kxft_kx_0_DB( $args ) ];
	}
	elseif( preg_match( '/^∬/' , $args[ 'title_base' ] ) )
	{
		$ret = $this->kxft_SS_writing( $args );
	}
	elseif(
		is_single( $args['id'] )
		&& preg_match( '/≫/' , $args[ 'title_base' ] )
		&& preg_match( '/'.KxSu::get('titile_search')[ 'SharedTitleDB' ].'/' , $args[ 'title_base' ] , $matches )
	){
		//基本設定。
		$this->kxft_S1[ 'title_top' ]  = $matches[0];
		$this->kxft_edit();

		if( preg_match( KxSu::get('title_preg')['worksDB'] , $args[ 'title_base' ] ) )
		{
			//$ret = $this->kxft_works( $args );
			$ret = [ 'type' => '資料作品' , 'content' => $this->kxft_works( $args ) ];
		}
		else
		{
			$ret = [ 'type' => '資料' , 'content' => $this->kxft_shared_title( $args ) ];
		}
	}
	else
	{
		$ret = [ 'type' => 'Normal' , 'content' => $this->kxft_normal() ];
		//var_dump(KxDy::get('content')[$this->kxft_S1['id']]);
	}

	return $ret;
}



/**
 * SS・作品制作用。サイドフロート
 *
 * @param [type] $args
 * @return void
 */
public function kxft_SS_writing( $args ){

	$cat_arr  = kx_get_category( );
	$cat_top  = $cat_arr['cat_top'];
	$cat_end  = $cat_arr['cat_end'];

	$sys = 'new_off,error_navi_off';
	$_t  = '65';

	//kxtt
	$this->kxft_S1[ 'kxtt' ] = kx_CLASS_kxTitle(
	[
		'type'             => 'character',
		'title'            => $args[ 'title_base' ],
	] );

	//print_r($this->kxft_S1[ 'kxtt' ]);


	if(
		!empty( $this->kxft_S1[ 'kxtt' ][ 'character_info' ] )
		&& preg_match( '/ShortStorySystem/' , $this->kxft_S1[ 'kxtt' ][ 'character_info' ] )
	){
		$this->kxft_S1[ 'ShortStory' ] = 1;
	}
	elseif	(
		!empty( $this->kxft_S1[ 'kxtt' ][ 'character_info' ] )
		&& preg_match( '/BigStorySystem/' , $this->kxft_S1[ 'kxtt' ][ 'character_info' ] )
	){
		$this->kxft_S1[ 'BigStory' ] = 1;
	}

	preg_match( '/^(.*?)≫(.*?)$/' , $args[ 'title_base' ] , $matches );

	$type 		= NULL;
	if( preg_match( '/^∬.*?≫.*?来歴/' , $args[ 'title_base' ] ) )
	{
		$cat     =  NULL;
		$tag     =  NULL;
		$tag_not =  NULL;
	}
	elseif( !empty( $matches[1] ) && preg_match( '/∬/' , $matches[1] ) &&  preg_match( '/c\d\w{1,}\d/' , $matches[2] ) )
	{
		$cat     =  $cat_end;
		$tag     =  'c'.$this->kxft_S1[ 'kxtt' ][ 'character_number' ]	;
		$tag_not =  '≫来歴≫';

		if( preg_match( '/('. KxSu::get('titile_search')[ 'work_Platform'  ].')\d{1,}/i' , $matches[2]  , $matches2 ) )
		{
			$type = 'Type:Ⅲ';

			$_arr[0] =
			[
				'search'				=>	''	,
				'title_s'				=>	'≫c'.$this->kxft_S1[ 'kxtt' ][ 'character_number' ] . '$',
				'text_c'				=>	'キャラ',
				'sys'           =>  $sys,
			];

			$_arr[1] =
			[
				'search'				=>	''	,
				'title_s'				=>	$this->kxft_S1[ 'kxtt' ][ 'character_number' ] . '≫W＄',
				'text_c'				=>	'キャラW',
				'sys'           =>  $sys,
			];

			if( !empty( $this->kxft_S1[ 'BigStory' ] ))
			{
				$_arr[2] =
				[
					'search'				=>	''	,
					'title_s'				=>	'1構成＄',
					'text_c'				=>	'1構成',
					'sys'           =>  $sys,
				];
			}
			elseif( empty( $this->kxft_S1[ 'ShortStory' ] )  )
			{
				$_arr[2] =
				[
					'search'				=>	''	,
					'title_s'				=>	'2構成＄',
					'text_c'				=>	'2構成',
					'sys'           =>  $sys,
				];
			}

			if( !empty( $this->kxft_S1[ 'BigStory' ] ))
			{
				preg_match( '/(^∬\d{1,}≫c)\w{1,}(≫.*$)/',$args[ 'title_base' ] , $matches );

				$_title= $matches[1] . '988' .$matches[2];

				unset( $matches );

				$_arr[3] =
				[
					'search'				=>	$_title . '≫来歴'	,
					'sys'           =>  $sys . ',db_on',
					'text_c'				=>	'来歴'.$matches2[0],
				];

			}
			else
			{
				preg_match( '/(^∬\d{1,}≫c)\w{1,}(≫.*$)/',$args[ 'title_base' ] , $matches );

				$_title= $matches[1] . '988≫' .$this->kxft_S1[ 'kxtt' ]['work_code_top3'].$this->kxft_S1[ 'kxtt' ]['work_code_number'];

				//echo $_title;

				unset( $matches );

				/*
				$_arr[3] =
				[
					'tag'           => 'c988',
					'search'				=>	$_title .'≫来歴',
					//'sys'           =>  $sys . ',db_on',
					'sys'           =>  $sys ,
					'text_c'				=>	'来歴'.$matches2[0],
					//'new_title'	=>	$_title.'来歴',
				];
				*/

				$_arr[3] =
				[
					'search'				=>	$args[ 'title_base' ] . '≫来歴'	,
					//'tag_not'       => '≫来歴≫',
					'sys'           =>  $sys . ',db_on',
					'text_c'				=>	'来歴'.$matches2[0],
				];

			}



			unset(  $matches2 );

		}
		else
		{
			$type = 'Type:chara';

			//$_raireki_off = 1;

			$_arr[0] =
			[
				'search'				=>	$this->kxft_S1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxft_S1[ 'kxtt' ][ 'character_number' ]	.'≫0Main',
				'title_s'				=>	$this->kxft_S1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxft_S1[ 'kxtt' ][ 'character_number' ].'≫0Main＄'	,
				'text_c'				=>	'c'.$this->kxft_S1[ 'kxtt' ][ 'character_number' ],
				'sys'           =>  $sys,
			];

			$_arr[1] =
			[
				'search'				=>	'2構成'	,
				'title_s'				=>	'2構成$',
				'text_c'				=>	'2構成',
				'sys'           =>  $sys,
			];

			if( empty( $_raireki_off ) )
			{
				$_arr[2] =
				[
					'search'				=>	$this->kxft_S1[ 'kxtt' ][ 'world' ].'≫c'.$this->kxft_S1[ 'kxtt' ][ 'character_number' ]	.'≫来歴',
					'title_s' => '来歴$',
					//'sys'           =>  $sys.',db_on',
					'text_c'				=>	'来歴',
					'sys'           =>  $sys,
					//$tag_not =  null,
				];
			}
		}
	}
	elseif( !empty( $matches[1] ) && preg_match( '/∬/' , $matches[1] ) &&  preg_match( '/0構成≫/' , $matches[2] ) )
	{
		$type = '0構成';
		$cat  = $cat_top;
		$tag     =  NULL;
		$tag_not =  NULL;

		$_arr =
		[
			['search'=>'∬'	  , 'title_s'=> '^∬￥d{1,}＄' , 'text_c'=>'TOP'  , 'post_type' => 'post', ],
			['search'=>'0構成' , 'title_s'=> '0構成＄'      , 'text_c'=>'0構成' ],
		];
	}
	else
	{
		$cat     =  NULL;
		$tag     =  NULL;
		$tag_not =  NULL;
		$type 		= NULL;
	}


	if( !empty( $_arr ) && is_array( $_arr ) )
	{
		$str = NULL;
		foreach( $_arr as $value ):

			if( empty( $value['post_type'] ))
			{
				$value['post_type'] = NULL;
			}


			if( empty( $value[ 'sys' ] ))
			{
				$value[ 'sys' ] = NULL;
			}


			if( empty( $value['title_s'] ))
			{
				$value['title_s'] = NULL;
			}

			if( empty( $value['tag'] ))
			{
				$value['tag'] = $tag;
			}


			$str .= kx_CLASS_kxx(
			[
				't'             =>  $_t,
				'cat'						=>	$cat,
				'tag'	    			=>	$value['tag'],
				'tag_not'	 			=>	$tag_not,
				'search'				=>	$value[ 'search' ],
				'title_s'				=>	$value['title_s'],
				'text_c'				=>	$value['text_c'],
				'post_type'			=>	$value['post_type'],
				'sys'	    			=>	$value['sys'],
			] );

		endforeach;
	}


	if( empty( $str ) )
	{
		$str = NULL;
	}

	return
	[
		'type' 		=> $type,
		'content' => $str,
	];
}



/**
 * 既存作品資料関連。
 *
 * @param [type] $args
 * @return void
 */
public function kxft_works( $args ){

	$kxdbW = new kxdbW;
	$kxdbW->kxdbW_Main( ['title' => $args['title_base'] , 'order'=> 'select_title' ] , 'select_title' );

	if( !empty( $kxdbW->select->title ))
	{
		$this->W_title = $kxdbW->select->title;
	}
	else
	{
		$this->W_title = 'N/A(DB)';
	}


	//var_dump($this->result[0]);


	ob_start();
	include __DIR__ . '/html/float_works.php';
	$ret = ob_get_clean();
	$ret .= $this->kxft_normal();

	return $this->kxft_shared_title( $args ) . $ret ;

}

/**
 * shared title
 *
 * @param [type] $args
 * @return void
 */
public function kxft_shared_title( $args ){

	ob_start();
	include __DIR__ . '/html/float_SharedTitle.php';
	$ret = ob_get_clean();

	$ret .= $this->kxft_kx_0_DB( $args );
	$ret .= $this->kxft_normal();

	return $ret;
}

/**
 * DBテーブル。kx_0用。サイドフロート
 *
 * @param [type] $args
 * @return void
 */
public function kxft_kx_0_DB( $args ){

	ob_start();
	include __DIR__ . '/html/float_kx_0_DB.php';
	$ret = ob_get_clean();
	$ret .= $this->kxft_normal();

	return $ret;
}


/**
 * Undocumented function
 *
 * @return void
 */
public function kxft_normal(){

	ob_start();
	include __DIR__ . '/html/float_normal.php';
	$ret = ob_get_clean();

	return $ret;
}




/**
 * 編集ボタン
 *
 * @param [type] $args
 * @return void
 */
public function kxft_edit(){

	if( preg_match( '/≫芸術・作品/' , $this->kxft_S1[ 'title_base' ]) )
	{
		$new_title = $this->kxft_S1[ 'title_top' ].'≫芸術・作品≫list≫';
		$new_content = 'Date：**：**';
		$new_content .= "\n".'作品登録パターン。統合型は◆';
	}
	else
	{
		$new_title = $this->kxft_S1[ 'title_top' ].'≫◆≫';

		$new_content = 'タグ：**';
	}

	$this->edit = kxEdit( [
		'new' 				=>	1,
		'new_title' 	=>	$new_title,
		'new_content'	=>	$new_content,
		'hyouji'      =>  '╋DB',
	]);
}


}//********** ********** ********** kxft ********** ********** **********





require_once get_stylesheet_directory() . '/lib/Parsedown.php';
require_once get_stylesheet_directory() . '/lib/ParsedownExtra.php';

/**
 * KxParsedownクラス
 * ParsedownExtraを拡張し、カスタムMarkdown処理を追加する。
 *
 * 主な機能:
 * - 太字テキストのカラー設定
 * - 見出しのスタイル変更
 *
 * @extends ParsedownExtra
 */
class KxParsedown extends ParsedownExtra {

    /**
     * Markdownテキストを処理し、カスタム前処理を適用した後に
     * ParsedownExtraのtextメソッドを呼び出す
     *
     * @param string $text 処理対象のMarkdownテキスト
     * @return string 処理後のHTMLテキスト
     */
    public function text($text) {
        $text = $this->customPreprocessing($text); // カスタム処理を追加
        return parent::text($text);
    }

    /**
     * テキストのカスタム前処理を行う
     * - 太字（**text**）のスタイルを変更
     * - 見出し（# で始まる行）のスタイルを変更
     * - Markdownの表には適用しないよう考慮
     *
     * @param string $text 処理対象のMarkdownテキスト
     * @return string 処理後のテキスト
     */
    private function customPreprocessing($text) {
        // すべての行を処理し、Markdownの表には適用しない

        $text = preg_replace('/\*\*(.*?)\*\*/', '<span style="color: hsl(ヾ色相ヾ, 50%, 70%);font-weight:bold;">$1</span>', $text);

			$lines = explode("\n", $text);
    		foreach ($lines as &$line) {
                // Markdownの見出しを判別（# で始まる行を対象）
                if (preg_match('/^#([^#].*)/', $line, $matches)) {
                $line = '<h1 style="color: hsl(ヾ色相ヾ, 50%, 70%); font-weight: bold;border: 1px solid hsla(ヾ色相ヾ,100%,80%,.5);">' . $matches[1] . '</h1>';
                }
    		}

        return implode("\n", $lines);//$text;
    }


}


/**
 * テスト。
 * 2025-04-07
 */
class kxscp2 {

	private $kxscpS1; //設定用配列
	private $output;

	public function __construct($args) {
		$this->kxscpS1 = $args;
		$this->output = $this->kxscp_Main();
	}

	public function get() {
		return $this->output;
	}


	private function kxscp_Main(  ){

	return $this->kxscpS1.'++';

}


}//




/**
 * ショートコードプリント。配列型。
 * 2023-09-01
 *
 * このクラスはWordPressのショートコード処理を目的としたものです。
 * 配列データを操作し、設定や選択条件に基づいて適切なコンテンツを表示します。
 *
 * 機能概要：
 * - `$kxscpS1` 配列：入力データの保持用
 * - `$kxscpArray` 配列：処理用のデータ
 * - `kxscp_Main($args)`: メイン処理関数。データの展開とショートコードの組み立てを行う
 * - `kxscp_setting()`: 初期設定用関数。不要なキーを削除して処理をスムーズにする
 * - `kxcp_TypeArr_search($args)`: `arr_search` 型のデータを処理し、検索条件に基づく内容を取得
 * - `kxscp_select($args)`: 条件に応じてデータの選抜を行い、表示の可否を決定
 *
 * このクラスを用いることで、柔軟にショートコードを扱うことが可能になります。
 */
class kxscp {

private $kxscpS1; //設定用配列
private $kxscpArray; //展開用配列。2023-09-01
private $output;

public function __construct( $args) {
	$this->kxscpS1    = $args;
	$this->output     = $this->kxscp_Main();
}

public function get() {
	return $this->output;
}


/**
 * メイン
 * 2023-09-01
 *
 * @param [type] $args
 * @return void
 */
public function kxscp_Main(){

	//$this->kxscpS1    = $args;
	//$this->kxscpArray = $args;

	$this->kxscp_setting();


	//表示開始。2023-09-01
	$ret = '';

	//関数入力配列の展開。2023-09-01
	foreach( $this->kxscpArray as $value ):
		//print_r( $value);

		//$value['select']	,	$this->kxscpS1[ 'select' ]
		if( !empty( $this->kxscp_select( $value ) ) )
		{
			if( !empty( $value[ 'title_on'	] ) )
			{
				//タイトル型。2023-09-01
				$ret .= $value[ 'title_on' ];
			}
			elseif(
				!empty( $value[ 'kxscp_array' ] )
				&& !empty( $value[ 'kxscp_array' ][ 'search_base' ] ) )
			{
				//arr_search型。連続型。2023-09-01
				//2023年からの改良型。

				$ret .= $this->kxcp_TypeArr_search( $value );
			}
			elseif(
				!empty( $value[ 'arr_search' ] )
				&& !empty( $value[ 'arr_search' ]['arr_base'] ) )
			{
				//arr_search型。連続型。
				//旧型、可能なら削除してゆく。

				$ret .= $this->kxcp_TypeArr_search( $value );
			}
			elseif( !empty( $value[ 'arr']) )
			{
				$ret .= kx_shortcode_print(	$value );
			}
			/*
			elseif(
				!empty( $value[ 'select' ] )
				&& !empty( $this->kxscpS1['select'] )
				&&	$this->kxscp_select(	$value['select']	,	$this->kxscpS1[ 'select' ]	)	)
			{
				//セレクト型。2023-09-01
				$ret .= kx_shortcode_print(	$value	);
			}
			elseif( !empty( $value[ 'name' ] ))
			{
				//通常型。特に設定のない単独型。2023-09-01
				$ret .= kx_shortcode_print(	$value	);
			}
			*/
		}

	endforeach;

	return $ret;
}


/**
 * kxscp設定
 *
 * @return void
 */
public function kxscp_setting(){
	$this->kxscpArray = $this->kxscpS1;

	if( !empty( $this->kxscpS1[ 'select' ] ))
	{
		//$_select_base	= $this->kxscpS1[ 'select' ];
		unset(	$this->kxscpArray[ 'select' ]	);
	}

	if( !empty( $this->kxscpS1[ '作品' ] ) )
	{
		unset( $this->kxscpArray[ '作品' ] );
	}
}


/**
 * タイトル型の摘出関数。
 * 長くなるので別記載。
 * 2023-09-01
 *
 * @param [type] $arr
 * @param [type] $select_base
 * @return void
 */
public function kxcp_TypeArr_search( $args ){


	if( empty( $args[ 'kxscp_array' ]) )
	{
		//旧型補助。2023-09-01
		$args[ 'kxscp_array' ][ 'search_base' ] =   $args[ 'arr_search' ][ 'arr_base' ];
		unset( $args[ 'arr_search' ][ 'arr_base' ] );
		if( !empty( $args[ 'arr_search' ][ 'arr' ] ) )
		{
			$args[ 'kxscp_array' ][ 'contents_array' ]	= $args[ 'arr_search' ][ 'arr' ];
		}
		else
		{
			$args[ 'kxscp_array' ][ 'contents_array' ]	= $args[ 'arr_search' ];
		}
	}

		//$_arr_base = $args[ 'kxscp_array' ][ 'search_base' ];
		//$_array	   = $args[ 'kxscp_array' ][ 'contents_array' ];

	$ret = '';
	foreach( $args[ 'kxscp_array' ][ 'contents_array' ]	as $value	):

		if( !empty( $value[ 3 ] )  )
		{
			$value[ 'select' ] = [	'='	=>	$value[3]	];
			$_on = $this->kxscp_select( $value	);
			//[	'='	=>	$value[3]	]	,	$this->kxscpS1[ 'select' ]
		}
		elseif( !empty( $value[ 'select' ] )  )
		{
			//追記。追記を忘れていた。2024-08-26
			$_on = $this->kxscp_select( $value	);
		}
		else
		{
			$_on = 1;
		}

		//print_r( $value[ 'select' ]);

		if( !empty( $_on ))
		{
			if( !empty( $value[ '作品' ] ) && !empty( $this->kxscpS1[ '作品' ] ) )
			{
				$value[0]	= $this->kxscpS1[ '作品' ] .'≫'.$value[0];
				unset( $value[ '作品' ] );
			}


			if(	!empty( $value[ 'title' ] ) )
			{
				//使っている。＿kxtt目的＊＿など。2023-09-01。
				$ret .= $value[ 'title' ];
			}
			else
			{
				$_arrSCP	= $args[ 'kxscp_array' ][ 'search_base' ];

				if(	!empty( $value[ 'id' ] ) )
				{
					$_arrSCP[ 'id' ] = $_id;
				}

				//0
				if( !empty( $value[0] ) )
				{
					if( !empty( $_arrSCP['arr'][	'search'	] ) )
					{
						$_arrSCP['arr'][	'search'	]	.= $value[0];
					}
					else
					{
						$_arrSCP['arr'][	'search'	]	= $value[0];
					}
				}

				//1
				if( !empty( $value[1] ) )
				{
					if( !empty( $_arrSCP[ 'top' ] ) )
					{
						$_arrSCP['top']	.= $value[1];
					}
					else
					{
						$_arrSCP['top']	= $value[1];
					}
				}


				if( !empty( $_arrSCP['arr'][	'new_title'	] ) )
				{
					$_arrSCP['arr']['new_title']		.= $_arrSCP['arr'][	'search'	]	;
				}

				/*
				if( empty( $value['top-end0'][0] ) )
				{
					$value[ 'top-end0' ][0] = NULL;
				}

				if( empty( $value['top-end0'][1] ) )
				{
					$value['top-end0'][1] = NULL;
				}
				*/

				//2
				if( !empty( $value[2] ))
				{
					if( !empty( $_arrSCP[ 'end' ] ) )
					{
						$_arrSCP[ 'end' ]	.= $value[2];
					}
					else
					{
						$_arrSCP[ 'end' ]	= $value[2];
					}
				}

				/*
				$_arrSCP['top0']							= $value['top-end0'][0];
				$_arrSCP['end0']							= $value['top-end0'][1];
				*/

				unset( $value[0]	,	$value[1] , $value[2]	);

					foreach( $value as $_k2 => $_v2 ):

						if( !is_array( $_v2 ))
						{
							$_arrSCP['arr'][ $_k2 ]		= $_v2;
						}

					endforeach;

				//print_r( $_arrSCP );
				$ret .= kx_shortcode_print(	$_arrSCP	);
			}
		}

	endforeach;

	return $ret;
}


/**
 * セレクター。
 * 2023-09-01
 *
 * @param [type] $args $value
 * @param [type] $select_base
 * @return void
 */
public function kxscp_select( $args ){ //	$arr	,	$select_base


	if( empty( $args[ 'select'] ) || empty( $this->kxscpS1[ 'select' ]  )  )
	{
		//選抜なし。on。
		$_on	= 1;
	}
	elseif(
		!empty( $args[ 'select']['!'] )
		&& !preg_match( $args[ 'select']['!'] , $this->kxscpS1[ 'select' ] )
	)
	{
		//on。2023-09-01。
		$_on	= 2;
	}
	elseif(
		!empty( $args[ 'select'][ '=' ] )
		&& preg_match(	$args[ 'select']['='] , $this->kxscpS1[ 'select' ] )
	)
	{
		//on。2023-09-01。
		$_on	= 3;
	}
	else
	{
		//off。2023-09-01
		$_on	= NULL;
	}

	/*
	if( !empty( $arr['!'] )	)
	{
		echo $arr['!'] ;
		echo '+';
		echo $select_base;
		echo '+';
		echo $on;
		echo '<br>';
	}
	*/


	return	$_on;

}



}//********** ********** ********** kxscp ********** ********** **********











/**
 * ********** ********** ERROR ********** **********
 * ★★Error用クラス。
 */
class kxer {

	//初期値
	public $kxerS0;

	public $kxerS1 =
	[
		'kxerType'   => 'NoType',
		'error_type' => 'N-A(kxerS1-Default)',
		'table'   => NULL,
		'kxxErrS1'   => NULL,
	];


	public $kxerOUT =
	[
		'Return_String' => NULL,
		//'new_content'   => NULL,
		'comment'       => NULL,
		'err_num'       => NULL,
	];

	public $kxer_kxx_array;


	//設定用。2023-08-23
	public $kxerSET=
	[
		'hidden_hr' =>
		[
			'0',
			'type',
			'file',
			'search',
			'id',
			'リンク',
		]
	];

	//Judge用。
	public $kxerJUDGE =
	[
		'kxx' =>
		[
			'array' =>
			[
				'normal' =>
				[
					'preg' 		 => '/./',
					'settings' =>
					[
						'type'      				    => 'ETC',
						'error_word'				    => 'ERROR',
						'new_on'	              => NULL,
						'css_error_color'		    => '__a_red',
						'css_error_border'	    => '__border_red2',
						'css_error_border_waku'	=> '__border_red2',
						'css_error_main'		    => '__error_main_red',
						'css_error_table'		    => ' __text_center __margin_left20 __margin_right20 __edit',
						'css_title_top'			    => NULL,

						'head'		              => '▼',
						'left'		              => '▼▼▼　',
						'right'		              => '▼▼▼　',
						'end'			              => '▲',
						'ma'			              => '　　',
					] ,
				] ,


				'basu' =>
				[
					'preg' 			=> '/basu/',
					'settings' =>
					[
						'type'      				=> 'basu',
						'error_word'				=> 'Alert Infinite loop-basu',
						'css_error_color'		=> '__a_red',
						'css_error_border'	=> '__border_2_0',
						'css_error_main'		=> NULL,
						'css_error_table'		  => ' __text_center __bg_100_95_60 __margin_left20 __margin_right20 __border_2_60',
						'css_title_top'			=> NULL,
					] ,
				] ,


				'ppp' =>
				[
					'preg' 		 => '/ppp/',
					'settings' =>
					[
						'type'      				=> 'ppp',
						'error_word'				=> 'CAUTION-ERROR-PPP' ,
						'css_error_color'		=> '__a_blue',
						'css_error_border'	=> '__border_blue2',
						'css_error_main'		=> '__error_main_blue',
						'css_error_table'		  => NULL,
						'css_title_top'			=> NULL,

						'left'		=> '▼　' ,
					] ,
				] ,



				'post0' =>
				[
					'preg' 		 => '/post0/',
					'settings' =>
					[
						'type'      				    => 'post0',
						'error_word'				    => 'N/A（post0）',
						'css_error_color'		    => '__a_darkviolet',
						'css_error_border'	    => NULL,
						'css_error_border_waku'	=> '__border_darkviolet',
						'css_error_main'		    => '__error_main_darkviolet',
						'css_error_table'		    => ' __edit __margin_left10 __margin_right10',
						'css_title_top'			    => NULL,

						'head'		=> '▽' ,
						'end'			=> '△',
						'left'		=> '▽ ',
						'ma'			=> '　',
						'new_on'	=> 1,
						'error_right'				=> '➕N' ,
					] ,
				] ,


				'update' =>
				[
					'preg' 		 => '/update/',
					'settings' =>
					[
						'type'      				=> 'update',
						'error_word'				=> 'ERROR-update',
						'css_error_color'		=> '__a_gray',
						'css_error_border'	=> NULL,
						'css_error_main'		=> NULL,
						'css_error_table'		  => NULL,
						'css_title_top'			=> NULL,

						'left'							=> '【U】 ' ,
						'head'							=> '【U】',
						'end'								=> '【U】',
						'ma'								=> '　',
					] ,
				] ,


				'plus' =>
				[
					'preg' 		 => '/plus/',
					'settings' =>
					[
						'type'      				=> 'plus',
						'error_word'				=> 'ERROR-plus',
						'css_error_color'		=> '__a_darkviolet',
						'css_error_border'	=> NULL,
						'css_error_main'		=> NULL,
						'css_error_table'		  => NULL,
						'css_title_top'			=> '__xsmall' ,

						'error_right'				=> '（error / New）' ,	//あとから代入
						'error_right_a'			=> 1 ,
						'error_word'				=> '' ,
						'error_comment'			=> '' ,
						'left'							=> '' ,
						'head'							=> '▼▽' ,
						'end'								=> '▲△',
						'ma'								=> '',
					] ,
				] ,


				'sc_count' =>
				[
					'preg' 		 => '/sc_count/',
					'settings' =>
					[
						'type'      				=> 'sc_count',
						'error_word'				=> 'Alert Infinite loop-sc_count',
						'css_error_color'		=> '__a_red',
						'css_error_border'	=> NULL,
						'css_error_main'		=> '__text_center __bg_100_90_60',
						'css_error_table'		  => NULL,
						'css_title_top'			=> NULL,
					] ,
				] ,


				't' =>
				[
					'preg' 		 => '/’t’/',
					'settings' =>
					[
						'type'      				=> 't',
						'error_word'				=> 'Attention-ERROR-t' ,
						'css_error_color'		=> '__a_darkviolet',
						'css_error_border'	=> '__border_blue2',
						'css_error_main'		=> '__error_main_darkviolet',
						'css_error_table'		  => NULL,
						'css_title_top'			=> NULL,
					] ,
				] ,
			],
		],
	] ;




	/**
	 * Errorメイン
	 *
	 * @param [type] $args Error元のエラー関連要素。
	 * @return void
	 */
	public function kxer_Main( $args ){

		$this->kxerS0 = $args;

		//2023-08-17
		$this->kxer_setting();


		if( $this->kxerS1[ 'kxerType' ] == 'kxx' )
		{
			//echo $this->kxerS1[ 'kxerType' ];
			$this->kxer_Type_kxx_Main();
			//return;
		}
		else
		{
			//array型。2023-08-18
			$this->kxer_Type_Array();
		}


		//■出力

		//echo top 配列型？。旧型流用中
		if( !empty( $this->kxerS1[ 'ON' ][ 'OUT_echo_top' ] ) )
		{
			$this->kxer_OUT_top_echo();
		}



		//黒と黄色のストライプで、右下に浮き上がるバージョン。旧型流用中
		if(	!empty( $this->kxerS1[ 'ON' ][ 'OUT_echo_fixed' ] )	)
		{
			$this->kxer_OUT_echo_fixed();
		}


		//左側のスライド表示。2023-08-18
		if( !empty( $this->kxerS1[ 'ON' ][ 'LeftBottom_Right_slide' ] ) )
		{
			$this->kxer_OUT_Right_slide();
		}


		if(
			!empty( $this->kxerS1[ 'ON' ][ 'Return_String' ] )
			&& $this->kxerS1[ 'kxerType' ] != 'kxx'
		)
		{
			$this->kxer_OUT_Return_String();
		}

		unset( $this->kxerS1[ 'ON' ] );
	}


	/**
	 * S1設定
	 *
	 * @return void
	 */
	public function kxer_setting(){

		//ErrorCOUNT。2023-08-23
		if( !empty( $_SESSION[ 'kxError' ][ 'count' ] ) )
		{
			$_SESSION[ 'kxError' ][ 'count' ]++;
		}
		else
		{
			$_SESSION[ 'kxError' ][ 'count' ]= 1;
		}



		if( $_SESSION[ 'kxError' ][ 'count' ]	!= 'no'	)
		{
			$this->kxerOUT[ 'err_num' ]	= $_SESSION[ 'kxError' ][ 'count' ];
		}
		else
		{
			$this->kxerOUT[ 'err_num' ] = NULL;
		}



		if( empty( $_SESSION[ 'kxError' ][ 'count_kxx' ] ) )
		{
			$_SESSION[ 'kxError' ][ 'count_kxx' ] = 0;
		}


		//print_r( $this->kxerS0 );
		//print_r( $this->kxerS0[ 'kxxErrS1' ][ 'search' ] );

		if( !empty( $this->kxerS0[ 'kxxErrS1' ][ 'search' ] ) )
		{
			$_SESSION[ 'kxError' ][ 'type' ][] = 'Kxx：'.$this->kxerS0[ 'kxxErrS1' ][ 'search' ] ;
		}
		elseif( !empty( $this->kxerS0[ 'kxxErrS1' ][ 'tag' ] ) )
		{
			$_SESSION[ 'kxError' ][ 'type' ][] = 'Kxx：'.$this->kxerS0[ 'kxxErrS1' ][ 'tag' ] ;
		}
		elseif( !empty( $this->kxerS0[ 'kxxErrS1' ][ 'cat' ] ) )
		{
			$_SESSION[ 'kxError' ][ 'type' ][] = 'Kxx：'.$this->kxerS0[ 'kxxErrS1' ][ 'cat' ] ;
		}
		elseif( is_string(( $this->kxerS0 )) )
		{
			$_SESSION[ 'kxError' ][ 'type' ][] = 'String：'.$this->kxerS0;
		}
		else
		{
			//print_r( $this->kxerS0 );
			//echo '++';
			$_SESSION[ 'kxError' ][ 'type' ][] = '不明';
		}


		$this->kxerS1[ 'ON' ][ 'OUT_echo_top' ] = 1;


		if( is_string( $this->kxerS0 ) )
		{
			//入力：ストリング型。2023-08-18

			$this->kxerS1[ 'kxerType' ] = 'string';

			$this->kxerS1[ 'string' ]  = $this->kxerS0;
			$this->kxerOUT[ 'string' ] = $this->kxerS0;
			$this->kxerOUT[ 'left_slide_Button' ] = 'STR';
		}
		else
		{
			//入力：配列型。2023-08-18

			$this->kxerS1 = $this->kxerS0 + $this->kxerS1;

			if( !empty( $this->kxerS1[ 'string' ] ) )
			{
				//stringがある場合。2023-08-18
				$this->kxerS1[ 'kxerType' ] = 'string';
			}
			elseif( !empty( $this->kxerS1[ 'kxxErrS1' ] ) && is_array( $this->kxerS1[ 'kxxErrS1' ] ) )
			{
				$this->kxerS1[ 'kxerType' ] = 'kxx';
				if( !empty( $_SESSION[ 'kxError' ][ 'count_kxx' ] ) )
				{
					$_SESSION[ 'kxError' ][ 'count_kxx' ]++;
				}
				else
				{
					$_SESSION[ 'kxError' ][ 'count_kxx' ]= 1;
				}

				$this->kxerS1[ 'ON' ][ 'OUT_echo_top' ] = NULL;
			}
			else
			{
				$this->kxerS1[ 'kxerType' ] = 'etcArray';

				$str	= '';
				$str .= '<div style="border:solid 5px red;">';
				$str .= $this->kxer_table0( $this->kxerS1[ 'table' ] );
				$str .= '</div>';

				$this->kxerOUT[ 'string' ] = $str;
				$this->kxerOUT[ 'left_slide_Button' ] = 'Array';
			}
		}

		//ON OFF

		if(	!empty( $this->kxerS1[ 'OUT_echo_fixed' ] )	)
		{
			$this->kxerS1[ 'ON' ][ 'OUT_echo_fixed' ] = 1;
		}

		$_SESSION[ 'kxError' ][ 'count_B' ] =  $_SESSION[ 'kxError' ][ 'count' ] -  $_SESSION[ 'kxError' ][ 'count_kxx' ];



		//表示テーブル作成。2023-08-23
		if( !empty( $this->kxerS1[ 'table' ] ) )
		{
			$this->kxerS1[ 'table' ] =  $this->kxer_table0( $this->kxerS1[ 'table' ] );
		}
		else
		{
			//テーブルがない場合。2023-08-23。
			$this->kxerS1[ 'table' ] = kx_table_navi(	$this->kxerS1	);
		}
	}


	/**
	 * 通常、配列型。
	 * 2023-08-18
	 *
	 * @return void
	 */
	public function kxer_Type_Array(){

		$this->kxerS1[ 'ON' ][ 'Return_String' ] = 1;
		$this->kxerOUT[ 'Return_String' ] = $this->kxerOUT[ 'string' ];

		$this->kxerS1[ 'ON' ][ 'LeftBottom_Right_slide' ] = 1;
		$this->kxerOUT[ 'LeftBottom_Right_slide' ]  = $this->kxerS1[ 'table' ];
	}



	/**
	 * Error。kxx系統
	 *
	 * @return void
	 */
	public function kxer_Type_kxx_Main(){

		$this->kxerS1[ 'code' ] = '#Old';

		if( !empty( $this->kxerS0[ 'kxxErrS1' ][ 'sys'] ) && preg_match( '/error_navi_off/' , $this->kxerS0[ 'kxxErrS1' ][ 'sys'] ) )
		{
			//エラー非表示。「error_navi_off」2023-05-30
			$this->kxerS1[ 'code' ]	 .= '_off';

			$this->kxerS1[ 'ON' ][ 'Return_String' ] = 1;
			$this->kxerOUT[ 'Return_String' ] = '<div style="opacity:.1;">n/a:kxer' . $_SESSION[ 'kxError' ][ 'count' ]  . '</div>';
			return;
		}

		$this->kxer_kxx_setting();

		//新規タイトル。2023-08-22
		$this->kxer_kxx_new_title();

		//新コンテンツ。2023-08-22
		$this->kxer_kxx_new_content();


		$this->kxer_kxx_right();
		$this->kxer_kxx_hidden();

		ob_start();
		include	__DIR__ .'/html/error_kx30.php';
		$this->kxerOUT[ 'Return_String' ] = ob_get_clean();
		$this->kxerS1[ 'ON' ][ 'Return_String' ] = 1;


		if(
			!empty( $this->kxerS0[ 'type' ]  )
			&& !preg_match( '/post0/' ,  $this->kxerS0[ 'type' ]  ) //post0ではない。2023-08-22
		)
		{
			$this->kxerS1[ 'ON' ][ 'LeftBottom_Right_slide' ] = 1;
			$this->kxerOUT[ 'LeftBottom_Right_slide' ] = $this->kxerOUT[ 'kxx_content_hidden' ];
			$this->kxerOUT[ 'left_slide_Button' ] = 'kxx';
		}
	}



	/**
	 * Error設定の補助プログラム
	 *
	 * @return array
	 */
	public function kxer_kxx_setting(){

		unset( $this->kxerS1[ 'table' ] );
		//print_r($this->kxerS1) ;

		if( empty( $this->kxerS1[ 'kxxErrS1' ][ 't' ] ) )
		{
			$this->kxerS1[ 'kxxErrS1' ][ 't' ] = NULL;
		}

		if( !empty( $this->kxerS1['comment'] ))
		{
			$this->kxerOUT['comment'] = $this->kxerS1['comment'];
		}

		$_SESSION[ 'anchor' ]	--;
		$this->kxerOUT[ 'url' ]	 = (empty($_SERVER["HTTPS"] ) ? "http://" : "https://") ;
		$this->kxerOUT[ 'url' ]	.= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'#'.'anchor'.$_SESSION[ 'anchor' ];


		//Error要素の新旧補正。
		//foreach($this->error_narabi as $v):
		foreach( kx_json_arr( get_stylesheet_directory() . "/data/json/kx_error_narabi.json" ) as $value ):

			if( empty( $this->kxerS1[ $value ] ) )
			{
				if( !empty( $this->kxerS1[ 'kxxErrS1' ][ $value ] ) )
				{
					$_err2[ $value ] = $this->kxerS1[ 'kxxErrS1' ][ $value ];
				}
				else
				{
					unset( $this->kxerS1[ $value ] );
				}

			}
			else
			{
				$_err2[ $value ] = $this->kxerS1[ $value ];
				unset( $this->kxerS1[ $value ] );
			}
		endforeach;
		unset( $value );


		if( is_array ( $_err2 ) && is_array ( $this->kxerS1 ) )
		{
			$this->kxerS1 = $_err2 + $this->kxerS1;
		}
		elseif( is_array ( $_err2 ) )
		{
			$this->kxerS1 = $_err2;
		}


		//Judge_kxx
		$this->kxerOUT[ 'Judge_kxx' ] = kx_Judge_OLD( $this->kxerJUDGE[ 'kxx' ] , 'preg' , $this->kxerS1[ 'type' ] )[ 'settings' ];

		if(preg_match ('/post0/' , $this->kxerS1[ 'type' ] )&& !preg_match ('/update/' , $this->kxerS1[ 'type' ] ) )
		{
			if( !empty( $this->kxerS1[ 'kxxErrS1' ][ 'error_Generalization' ] ) )
			{
				$this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ]		= '__a_0_0_50_02 ';
				//$this->error_right_style	= '';
			}
		}


		//設定
		$this->kxerOUT[ 'kxx' ][ 'new_off' ]	= NULL;

		if(preg_match ('/post0/' , $this->kxerS1[ 'type' ] )&& !preg_match ('/update/' , $this->kxerS1[ 'type' ] ) )
		{
			if(
				!empty( $this->kxerS1[ 'kxxErrS1' ][ 'cat' ] )
				&& empty( $this->kxerS1[ 'kxxErrS1' ]['update'] )
				&& preg_match( '/^1\d$|^[3-6]\d$/' ,$this->kxerS1[ 'kxxErrS1' ][ 't' ] )
			)
			{
				$_right	 = '　';
				$_right	.= '<span style="cursor:pointer;">';
				//$_right	.= '<a class="__edit" style="cursor:pointer;">';
				$_right	.= 'New╋';
				$_right	.= $this->kxerOUT[ 'err_num' ];
				//$_right	.= '</a>';
				$_right	.= '</span>';

				$this->kxerOUT[ 'Judge_kxx' ][ 'right' ]		= $_right;
			}
			elseif( preg_match( '/^(2|[7-9] )\d/' , $this->kxerS1[ 'kxxErrS1' ][ 't' ] ) )
			{
				$this->kxerOUT[ 'Judge_kxx' ][ 'right' ]	 = 'List/no-match';
				$this->kxerOUT[ 'Judge_kxx' ][ 'right' ]	.=  $this->kxerOUT[ 'err_num' ];
				$this->kxerOUT[ 'kxx' ][ 'new_off' ]	= 1;
			}
		}
	}


	/**
	 * 編集用タイトル。
	 * @return
	 */
	public function kxer_kxx_new_title(){

		if( !empty( $this->kxerS1[ 'kxxErrS1' ][ 'new_title' ] ) )
		{
			$ret		= str_replace('＞','≫',$this->kxerS1[ 'kxxErrS1' ][ 'new_title' ] );
		}
		else
		{
			//置換用

			$p =
			[
				'＄',
				' ',
			];


			$p2	= [
				'＞'	=>	'≫',
			];


			if(	!empty( $this->kxerS1[ 'kxxErrS1' ][ 'tag' ] )	)
			{
				$cxxx	= preg_replace( '/^c| c|〇 c|〇/' , '' , $this->kxerS1[ 'kxxErrS1' ][ 'tag' ]	);

				$arr_tag	= explode( ' ' , $this->kxerS1[ 'kxxErrS1' ][ 'tag' ]	);
				$p	= $p + $arr_tag;
			}


			if( !empty( $this->kxerS1[ 'kxxErrS1' ][ 'cat' ] ) )
			{
				$ret		 = get_the_category_by_ID( $this->kxerS1[ 'kxxErrS1' ][ 'cat' ]	);

				if(!preg_match( '/≫/' , $ret ) )
				{
					$ret		 .= '≫';
				}
			}
			else
			{
				$ret		 = '';
			}


			if( empty( $cxxx ) )
			{
				$cxxx = NULL;
			}

			$ret		.= $cxxx;

			if( !empty( $this->kxerS1[ 'kxxErrS1' ][ 'search' ] ) )
			{
				$ret		.= str_replace ( $p , '' , $this->kxerS1[ 'kxxErrS1' ][ 'search' ] );
			}

			//endif;
			$ret		= str_replace ( array_keys($p2), array_values($p2) ,	$ret	);
		}

		$this->kxerOUT[ 'new_title' ]	= $ret;
	}



	/**
	 * 新規の本文
	 *
	 * @return void
	 */
	public function kxer_kxx_new_content(){

		if( !empty($this->kxerS1[ 'kxxErrS1' ][ 'new_content' ] ) )
		{
			$this->kxerOUT[ 'new_content' ]	= $this->kxerS1[ 'kxxErrS1' ][ 'new_content' ];

			if( preg_match('/＿(.*)＿/' , $this->kxerOUT[ 'new_content' ] , $matches ) )
			{
				$_replace	=
				[
					'＝'	=>	'=',
				];

				$this->kxerOUT[ 'new_content' ]	= '[' . str_replace( array_keys( $_replace ) , $_replace , $matches[1] ) . ']';
			}
		}
		elseif(
			!empty( $this->kxerS1[ 'kxxErrS1' ][ 't' ] )
			&& preg_match( '/^3\d/' , $this->kxerS1[ 'kxxErrS1' ][ 't' ] )
		)
		{


			foreach( KxSu::get('title_kx30') as $key	=>	$arr2 ):

				if (preg_match ( $key , get_the_title() ) )
				{
					foreach( $arr2 as $key	=>	$value	):

						if (preg_match( '/' . $key . '/' , $this->kxerS1[ 'kxxErrS1' ][ 'search' ] ) )
						{
							$this->kxerOUT[ 'new_content' ]	= '＿'.Time::format().'＿〈'.$value[0].'〉';
							$this->kxerOUT[ 'making_temporary' ] = $value[0];
						}

					endforeach;
				}


				if( empty( $this->kxerOUT[ 'new_content' ] ) )
				{
					$this->kxerOUT[ 'new_content' ] = '＿'. Time::format() .'＿';
				}

			endforeach;
		}
		else
		{
			$this->kxerOUT[ 'new_content' ] = '＿'. Time::format() .'＿';
		}
	}




	/**
	 * Errorの内容表示
	 * メインコンテンツ内の隠し。
	 * 2023-08-17
	 *
	 * @return string
	 */
	public function kxer_kxx_hidden(){

		if( !empty($this->kxerS1[ 'kxxErrS1' ][ 'sys'] ) && preg_match( '/error_navi_off/' , $this->kxerS1[ 'kxxErrS1' ][ 'sys'] ) )
		{
			return;
		}

		//	memo配列
		if( !empty( $this->kxerS1['memo'] ) )
		{
			if( is_array($this->kxerS1['memo'] ) )
			{
				$str	= '';

				foreach( $this->kxerS1['memo'] as $v ):

					$str	.= '<div>';
					$str	.= $v;
					$str	.= '</div>';

				endforeach;

				$this->kxerS1['memo'] = $str;
				unset( $str );
			}

			if( !empty( $this->kxerS1['sys'] ) )
			{
				$str = NULL;
				foreach( explode(',' ,  $this->kxerS1['sys'] ) as $v ):

					$str	.= '<div>';
					$str	.= $v;
					$str	.= '</div>';

				endforeach;

				$this->kxerS1['sys'] = $str;
				unset( $str );
			}
		}

		//着色
		$_change_color = [ 'memo' , 'comment' ];	//一番上


		if( $this->kxerS1[ 'type' ] == 'post0')
		{
			$_change_color[] = 'type';
		}


		if( empty( $this->kxerS1[ 'count_post' ] ) )
		{
			$_count_post	= 'ZERO';

			$this->kxerS1['count_post']	= $_count_post;

			$_change_color[] = 'count_post';

			if( !empty( $this->kxerS1[ 'search' ] ) )
			{
				$_change_color[] = 'search';
			}
		}



		if( preg_match ('/basu/' , $this->kxerS1[ 'type' ] ))
		{
			unset( $this->kxerS1[ 'id' ] );
			unset( $this->kxerS1[ 'taisaku' ] );
			unset( $this->kxerS1[ 'taisaku2' ] );
			unset( $this->kxerS1['SESSION_count'] );
		}


		//色
		if( !empty( $this->kxerS1[ 'cat'] ) )
		{
			$this->kxerS1[ 'catnames' ] = get_the_category_by_ID( $this->kxerS1[ 'cat' ] );

			if( !empty( $type ) && preg_match ( '/post0.*title/' , $type ) )
			{
				//スルー
			}
			elseif( !empty( $type ) && preg_match ('/post0/' , $type ) )
			{
				$_change_color[] = 'search';
				$_change_color[] = 'cat';
				$_change_color[] = 'catnames';
				$_change_color[] = 'tag';
			}
		}


		if( !empty( $this->kxerS1[ 'search' ] ) && !empty( $this->kxerS1[ 'title_s' ] ) )
		{
			$this->kxerS1[ 'search' ]	= str_replace( $this->kxerS1[ 'title_s' ], '', $this->kxerS1[ 'search' ] );
			$_change_color[]			= 'search';
			$_change_color[]			= 'title_s';
		}


		if( preg_match( '/’t’/' , $this->kxerS1[ 'type' ] ) )
		{
			$_change_color[] = 't';
		}


		$_array_S1 = $this->kxerS1;

		//並び替え最終
		foreach( kx_json_arr( get_stylesheet_directory() . "/data/json/kx_error_narabi.json" ) as $_v ):

			if( !empty( $_array_S1[$_v] ) )
			{
				$this->kxer_kxx_array[$_v][ 'content' ]		= $_array_S1[$_v];

				if( array_search(	$_v	, $_change_color ) )
				{
					$this->kxer_kxx_array[$_v][ 'color_on_style' ] = 'color:red;font-weight: bold;';
				}

				$this->kxer_kxx_array[ $_v ][ 'hr_on' ] = array_search(	$_v	, $this->kxerSET['hidden_hr'] );

				unset( $_array_S1[ $_v] );
			}

		endforeach;
		unset($_v);

		foreach( $_array_S1 as $key => $value):

			//不要な要素を削除。
			if( $key != 'kxxErrS1' )
			{
				$this->kxer_kxx_array[][ 'content' ]	= $value;
			}

		endforeach;
		unset( $key , $value);


		//$this->kxer_kxx_array = $_err2;
		//print_r($_err2);


		if( !$this->kxer_kxx_array )
		{
			$this->kxer_kxx_array =
			[
				'ERROR' 	=>     [ 'content' =>      'N/A',    ]
			];
		}


		if( empty( $this->kxer_kxx_array[ 'output' ][ 'content' ] ) )
		{
			$this->kxer_kxx_array[ 'output' ][ 'content' ] = NULL;
		}

		ob_start();
		include  __DIR__ .'/html/error_kxx.php';
		$this->kxerOUT[ 'kxx_content_hidden' ]  = ob_get_clean();
	}


	/**
	 * Undocumented function
	 * Error下段。
	 * @return
	 */
	public function kxer_kxx_right() {

		if( !empty( $this->kxerOUT[ 'Judge_kxx' ][ 'error_right_a' ] ) )
		{
			$str  = '<a>';
			$str .= $this->kxerOUT[ 'Judge_kxx' ][ 'right' ];
			$str .= $this->kxerOUT[ 'err_num' ];
			$str .= '</a>';

			$this->kxerOUT[ 'Judge_kxx' ][ 'right' ] = $str;
			unset( $str );
		}


		$this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ]		 .= ' __font_weight_bold';


		if( empty( $this->kxerOUT[ 'making_temporary' ] ) )
		{
			$this->kxerOUT[ 'making_temporary' ] = '▼';
		}

		if( !empty( $this->kxerS1[ 'kxxErrS1' ][ 'sys' ] ) && ( preg_match( '/new_off/' , $this->kxerS1[ 'kxxErrS1' ][ 'sys' ] ) ) )
		{
			$this->kxerOUT[ 'new_off_on' ] = 1;
		}
		else
		{
			$this->kxerOUT[ 'new_off_on' ] = NULL;
		}
	}






	/**
	 * table。
	 *
	 * @return void
	 */
	public function kxer_table0( $args ){

		if( !is_array( $args ) )
		{
			$args = [ $args ] ;
		}

		$ret = '';
		foreach( $args as $key => $value	):

			//valueが配列ではない場合は配列化。2023-08-22
			if( !is_array( $value ) )
			{
				$value =
				[
					'unity' =>$value ,
					'style'=> 'text-align: center;'
				];
			}

			//keyがない場合。
			if( empty( $key ) )
			{
				$key = 'NO_KEY';
			}


			if( empty( $value[ 'style' ] ) )
			{
				$value[ 'style' ] = NULL;
			}


			$ret  .= '<div class="__error_output_list" style="'. $value[ 'style' ] .'">';

			if( !empty( $value[ 'hr_on' ] ) )
			{
				$ret  .= '<hr>';
			}


			if( !empty( $value[ 'unity' ] ) )
			{
				$ret .= '<div style="display:block;background:hsla(0,0%,0%,.5);margin-top:15px;">';
				$ret  .= $key;
				$ret  .= '</div>';

				$ret .= '<div style="display:block;">';
				$ret  .= $value[ 'unity' ];
				$ret  .= '</div><hr>';
			}
			else
			{
				$ret .= '<div class="__err1">';
				$ret  .= $key;
				$ret  .= '</div>';

				$ret .= '<div class="__err2">';
				$ret  .= '：';
				$ret  .= '</div>';

				$ret .= '<div class="__err3">';

				if( !empty( $value[0] ) )
				{
					$ret  .= $value[0];
				}

				$ret  .= '</div>';
			}

			$ret  .= '</div>';

		endforeach;

		return $ret;
	}





	/**
	 * echo。fixed。
	 * 黒と黄色のストライプ。
	 * 配列で入力。
	 * 2023-08-18
	 *
	 * @return void
	 */
	public function kxer_OUT_echo_fixed(){

		$ret	 = '<div class="__error_output __js_click_reload2">';
		$ret 	.= $this->kxer_table0( $this->kxerS1[ 'OUT_echo_fixed' ] );
		$ret  .= '</div>';

		echo $ret;
	}





	/**
	 * echo型。
	 * トップ表示。
	 *
	 * @return void
	 */
	public function kxer_OUT_top_echo(){

		$ret  = '';
		$ret .= '<div style="border:solid 2px red;">';
		$ret .= '<div class="__switch_start" style="color:red;">■error-count-B：' . $_SESSION[ 'kxError' ][ 'count_B' ] . '■';

		$ret .= '<div class="__naviERROR__">';

		$ret .= '<div style="color:red;">ErrCountB'.$_SESSION[ 'kxError' ][ 'count_B' ].'内容</div>';

		if( !empty( $this->kxerS1[ 'OUT_echo_top' ] ) )
		{
			$ret .= $this->kxer_table0( $this->kxerS1[ 'OUT_echo_top' ] );
		}
		elseif( !empty( $this->kxerS1[ 'table' ] ) )
		{
			$ret .= $this->kxerS1[ 'table' ];
		}
		else
		{
			$ret .= 'N/A';
		}
		$ret .= '</div>';

		$ret .= '</div>';

		$ret .= '</div>';

		echo $ret;
	}



	/**
	 * echo型。
	 * 右サイドのスライド表示型。
	 * スイッチは、左下。
	 * 2023-08-18
	 *
	 *
	 * @return void
	 */
	public function kxer_OUT_Right_slide(){

		echo '<div class="__switch_start">';	//---section--
		echo '<div class="__error_fixed_left_bottom__">ErrCountB.'.$_SESSION[ 'kxError' ][ 'count_B' ].'&nbsp;'. $this->kxerOUT[ 'left_slide_Button' ] .'</div>';
		echo '<div class="__naviERROR__ __border_red">';
		echo '<div style="color:red;">ErrCountB'.$_SESSION[ 'kxError' ][ 'count_B' ].'内容</div>';
		echo '<hr>';
		echo $this->kxerOUT[ 'LeftBottom_Right_slide' ];
		echo '</div>';
		echo '</div>';

	}



	/**
	 * return用。
	 *
	 * @return void
	 */
	public function kxer_OUT_Return_String(){

		$ret = NULL;

		$ret .= '<div style="color:red;font-weight:bold;font-size:Large;">';

		$ret .= '<div>';
		$ret .= '■&nbsp;ERROR&nbsp;' . $_SESSION[ 'kxError' ][ 'count' ];
		$ret .= '&nbsp;■';
		$ret .= '</div>';

		$ret .= '<div>';
		$ret .= $this->kxerOUT[ 'Return_String' ];
		$ret .= '</div>';

		$ret .= '</div>';

		$this->kxerOUT[ 'Return_String' ] = $ret;
	}
} //********** ********** end kxer ********** **********



/*
class kxrtt は、タイムテーブルやキャラクターの関連データを管理・補正するためのクラスです。
このクラスは、特定のキャラクターや関連するデータを整理し、必要に応じてデータを追加・削除・更新する処理を行います。

主な機能
データの初期設定 (kxrtt_setting)

キャラクターや関連データを取得し、内部で管理する配列に整理します。
特定のキャラクター番号や関連するポスト（投稿）を抽出し、タイトルやコードを解析します。
作品やキャラクターの関連性を基に、必要なコードやデータを準備します。
データの補正

コードの追加 (kxrtt_add_code)
不足しているコード（例: _sXXXXXX の形式）を追加します。
未使用コードの削除 (kxrtt_remove_UnusedCode)
使用されていないコードを削除します。
無効なキャラクターコードの削除 (kxrtt_remove_InactiveCharaCode)
関連性のないキャラクターコードを削除します。
メインのタイムテーブルに不足コードを追加 (kxrtt_add_MissingCodes_ToMainTermTableM と kxrtt_add_MissingCodes_ToMainTermTableN)
日付やキャラクターの関連性に基づいて、必要なコードをメインのタイムテーブルに追加します。
データの更新 (kxrtt_update_post)

補正されたデータを基に、WordPressの投稿タイトルを更新します。
更新が必要な場合、投稿のタイトルを再構築して保存します。
データのチェック (kxrtt_check)

現在のデータ構造やキャラクターの関連性を確認し、問題がないかをチェックします。
主な用途
このクラスは、以下のような用途で使用されると考えられます：

キャラクターや作品のタイムラインを管理するシステム。
WordPressの投稿データを基に、キャラクターや作品の関連性を整理・補正する。
タイムテーブルやキャラクター間の関係性を正確に保つためのデータ補正。
想定されるシナリオ
例えば、あるキャラクターが特定の作品やイベントに関連付けられている場合、そのキャラクターのタイムラインや関連データを自動的に補正し、
必要な情報を追加・削除・更新することで、データの一貫性を保つことができます。このクラスは、そのようなデータ管理を効率的に行うためのツールです。
*/

/**
 *
 * 羅列補正。タイムテーブル用
 */
class kxrtt {

	//初期値
	public $kxrttS0;

	public $kxrttS1=	[	];

	//foreach。一時記録。2024-06-22
	public $kxrttT;

	//基本配列。2024-06-21
	public $kxrttArrID;

	public $kxrttOUT;

	/**
	* RTTメイン
	*
	* @param [type] $args 引数の説明
	* @return string 結果の説明
	*/
	public function kxrtt_Main( $args ){

		$this->kxrttS0 = $args;

		$this->kxrtt_setting();

		//各キャラを展開。2024-06-22
		foreach( $this->kxrttArrID as $_num => $_array ):

			$this->kxrttT[ 'num' ] = $_num;
			$this->kxrttT[ 'array' ] = $_array;

			//各ポストを展開。2024-06-22
			foreach( $this->kxrttT[ 'array' ] as $_key => $_NA):

				$this->kxrttT[ 'key' ] = $_key;

				$this->kxrtt_add_code();
				$this->kxrtt_remove_UnusedCode();
				$this->kxrtt_remove_InactiveCharaCode();
				$this->kxrtt_add_MissingCodes_ToMainTermTableM();
				$this->kxrtt_add_MissingCodes_ToMainTermTableN();
			endforeach;

		endforeach;

		$this->kxrtt_update_post();


		$this->kxrtt_check();
		//$this->kxrtt_add_code0();
		//$this->kxrtt_remove_UnusedCode0();
		//$this->kxrtt_remove_InactiveCharaCode0();
		//$this->kxrtt_add_MissingCodes_ToMainTermTable0();

		// 書き出し。
		$ret = '';
		foreach( $this->kxrttOUT[ 'str_array' ] as $str ):

			$ret .= $str;

		endforeach;

		return $ret;

	}



	/**
	 * 設定
	 *
	 * @return void
	 */
	public function kxrtt_setting(){

		$this->kxrttS1 = array_merge( $this->kxrttS0, $this->kxrttS1 );

		foreach( explode( ',' , $this->kxrttS1[ 'ss' ] ) as $_ss ):

			//echo $_ss;
			//echo '<br>';

			preg_match( '/(\d{1,})_(\d{1,})/' , $_ss , $matches );

			$this->kxrttS1[ 'world' ]  = $matches[1];
			$this->kxrttS1[ 'main_c' ] = $matches[2];

			unset( $matches );



			$this->kxrttS1[ 'array_kxst' ] = KxSu::get('title_raretu_wwr_time_table')[ '∬'. $_ss ];

			//cat取得
			$this->kxrttS1[ 'cat' ] = 510; //★SS10専用要素で運用。2024-06-20

			//c800≫来歴の取得。2024-06-21
			$_tag = 'c'.$this->kxrttS1[ 'main_c' ]. '+来歴';

			$_array_kxx = kx_CLASS_kxx(
			[
				'cat'    => $this->kxrttS1[ 'cat' ],
				'tag'    => 'c'.$this->kxrttS1[ 'main_c' ]. '+来歴',
				'search' => '≫c'.$this->kxrttS1[ 'main_c' ].'≫来歴≫',
				'title_s' => '＠',
			] , 'array_ids' );

			//echo count( $_array_kxx[ 'array_ids'] );
			//echo '<br>';

			foreach( $_array_kxx[ 'array_ids'] as $_id ):

				$_array_title = $this->kxrtt_setting_title( get_the_title( $_id ));

				$this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ][]=
				[
					'id'         => $_id,
					'title'      => get_the_title( $_id ),
					'top'        => $_array_title[ 'top' ],
					'time'       => $_array_title[ 'time' ],
					's'          => $_array_title[ 's' ],
					'last'       => $_array_title[ 'last' ],
					'new'        => NULL,
				];

			endforeach;
			unset( $tag ,$_id , $_array_kxx , $matches  );


			//＼c800≫来歴≫を持っているキャラの取得。2024-06-21
			$_array_kxx = kx_CLASS_kxx(
			[
				'cat'    => $this->kxrttS1[ 'cat' ],
				'tag'    => 'c'.$this->kxrttS1[ 'main_c' ]. '+来歴',
				'search' => '＼c'.$this->kxrttS1[ 'main_c' ].'≫来歴≫',
				'title_s' => '＠',
			] , 'array_ids' );

			foreach( $_array_kxx[ 'array_ids'] as $_id ):

				$_title = get_the_title( $_id );

				$_array_title = $this->kxrtt_setting_title( $_title );

				preg_match( '/∬10≫c(\d\w{1,}\d)/' , $_title , $matches );

				$this->kxrttArrID[ $matches[1] ][ ]=
				[
					'id'         => $_id,
					'title'      => get_the_title( $_id ),
					'top'        => $_array_title[ 'top' ],
					'time'       => $_array_title[ 'time' ],
					's'          => $_array_title[ 's' ],
					'last'       => $_array_title[ 'last' ],
					'new'        => NULL,
				];

				//$_array_chara_num[ $matches[1] ] = 1;

			endforeach;
			//print_r( $this->kxrttArrID );
		endforeach;

		unset( $_array_kxx , $_id );



		//SysXXXXXのポストidを抽出。2024-06-20
		$_array_kxx = kx_CLASS_kxx(
		[
			'cat'    => $this->kxrttS1[ 'cat' ],
			'tag'    => 'c'.$this->kxrttS1[ 'main_c' ],
			'search'  => 'c'.$this->kxrttS1[ 'main_c' ] . '≫Sys',
			'title_s' => '\d$'
		] , 'array_ids' );

		//_sのリストをpregで制作。2024-06-20

		$_arr = kx_json_arr( get_stylesheet_directory() . "/data/json/sakuhin.json"	);
		//print_r($_arr['sys']);

		//$_list = ''; //check用。2024-06-22
		foreach( $_array_kxx[ 'array_ids' ] as $_id ):

			preg_match( '/Sy(s(\w{8}\d))/', get_the_title( $_id ) , $matches );
			$this->kxrttS1[ 'array_all_s' ][]= '_'.$matches[1];
			//$_list .= '_'.$matches[1].',';//check用。2024-06-22

			if( !empty( $_arr['sys'][ $matches[2] ][2] ))
			{
				$this->kxrttS1[ 's_chara_list' ][ $matches[2] ] =  $_arr['sys'][ $matches[2] ][2];

				foreach( explode( ',' ,$_arr['sys'][ $matches[2] ][2] ) as $_chara ):

					$this->kxrttS1[ 'add_code' ][ $_chara ][] = $matches[2];

				endforeach;
			}

		endforeach;


		//echo '<p>';
		//echo $_list;//check用。2024-06-22
		//echo '</p>';


		//$this->kxrttS1[ 'add_code' ] = array_merge( $this->kxrttS1[ 'array_kxst' ][ 'add_code' ] , $this->kxrttS1[ 'add_code' ] );
		/*
		print_r( $this->kxrttS1[ 'array_kxst' ][ 'add_code' ] ) ;
		echo '<hr>';
		print_r( $this->kxrttS1[ 'add_code' ] ) ;
		echo '<hr>';
		*/

		$this->kxrttS1[ 'add_code' ] = $this->kxrttS1[ 'array_kxst' ][ 'add_code' ]  + $this->kxrttS1[ 'add_code' ] ;

	}


	/**
	 * タイトル抽出
	 *
	 * @return void
	 */
	public function kxrtt_setting_title( $title ){

		$_title_array = explode( '≫' , $title );

		$_title_end = end( $_title_array );

		$_title_last      = preg_replace( '/^.*＠/' ,'＠', $_title_end  );

		$_title_time_code = str_replace( $_title_last , '' , $_title_end );
		$_title_time      = preg_replace( '/_.*$/' ,'', $_title_time_code  );
		$_title_s         = preg_replace( '/^'.$_title_time.'/' , '' , $_title_time_code );

		//echo $_title_s;
		//echo '<br>';

		$_title_top       = preg_replace( '/'.$_title_end.'/' ,'', $title );

		//echo $_title_top;
		//echo $_title_time.$_title_s.$_title_last;
		//echo '<br>';
		return
		[
			'top'  => $_title_top,
			'time' => $_title_time,
			's'    => $_title_s,
			'last' => $_title_last,
		];
	}


	/**
	 * 事前調査。2024-06-20
	 *
	 * @return void
	 */
	public function kxrtt_check(){

		//＼c800を持っているキャラの取得。2024-06-21
		foreach( $this->kxrttArrID as $key => $_array ):

			$_array_chara_num[ $key ] = 1;

		endforeach;

		$ret  = '';

		$ret .= 'LIST：c800≫来歴≫：件数：';
		$ret .= count( $_array_chara_num );
		$ret .= '<hr>';

		$ret .= '＼c800≫来歴≫：存在キャラ。';
		$ret .= '<br>';

		//キャラナンバー表示。2024-06-21
		foreach( $_array_chara_num as $_key => $value ):

			$ret .= $_key;
			$ret .= '<br>';

		endforeach;

		$ret .= '<hr>';

		$this->kxrttOUT[ 'str_array' ][0] = $ret;
	}


	/**
	 * 1
	 *
	 * @return void
	 */
	public function kxrtt_add_code(){

		if( !empty( $this->kxrttS1[ 'add_code' ][ $this->kxrttT[ 'num' ] ]) )
		{
			//$_array_kxst = $this->kxrttS1[ 'add_code' ][ $this->kxrttT[ 'num' ] ];

			foreach( $this->kxrttS1[ 'add_code' ][ $this->kxrttT[ 'num' ] ]  as  $_s ):

				$_s = '_s'.$_s;

				/*
				echo $_num;
				echo '-';
				echo $_s;
				echo '-';
				echo $_post_array[ 'title' ];
				echo '<hr>';
				*/

				if( !preg_match( '/'. $_s .'/' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's' ] ) )
				{

					/*
					echo $_s;
					echo '<br>';
					echo $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's' ];
					echo '<br>';
					echo $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'title'] ;
					echo '<br>';
					*/


					$_new_s = $_s . $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'];

					$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] = $_new_s;

					$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'new'] .= '🟥1st（不足_sの追加：'.$_s.'）';
					//$this->kxrttArrID[ $num ][ $_key ];
				}

			endforeach;
		}


	}


	/**
	 * 2
	 *
	 * @return void
	 */
	public function kxrtt_remove_UnusedCode(){

		//不使用_sの抽出。使用中の_sを削除。2024-06-22
		//$_s =  preg_replace( $this->kxrttS1[ 'preg_all_s' ] , '' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] );

		//$_base_s = $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'];
		$_s = $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'];



		foreach( $this->kxrttS1[ 'array_all_s' ] as $_s_base ):

			foreach( explode( '_' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] ) as $_s_single ):

				if( '_'.$_s_single == $_s_base )
				{
					$_s = preg_replace( '/'.$_s_base.'/' , '', $_s );
				}

			endforeach;

			//$_s = preg_replace( '/'.$_s_base.'/' , '' , $_s );

		endforeach;

		if( !empty( $_s ) && preg_match( '/s\w{8}\d/' , $_s )){

			/*
			echo '<p>';
			echo $_base_s;
			echo '</p>';
			echo '<p>';
			echo $_s;
			echo '</p>';

			echo '<br>';
			*/

			//使っていない_sの排除。2024-06-22
			$_new_s = preg_replace( '/'.$_s.'/' , '' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] );

			$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] = $_new_s;
			$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'new'] .= '🟨2nd（不使用_sの削除：'.$_s.'）';

			//echo $_new_s;
			//echo '<hr>';
		}

	}



	/**
	 * 3
	 *
	 * @return void
	 */
	public function kxrtt_remove_InactiveCharaCode(){

		foreach( $this->kxrttS1[ 's_chara_list' ] as $_s_num => $_chara_list ):

			$_chara_list = $this->kxrttS1[ 'main_c' ] . ','. $_chara_list;

			if( preg_match( '/_s'. $_s_num .'/' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] ))
			{

				$_pattern =  '/'.preg_replace( '/,/', '|' , $_chara_list ) . '/';

				//if( $_chara_num != $this->kxrttT[ 'num' ] )
				if( !preg_match( $_pattern , $this->kxrttT[ 'num' ]  ))
				{
					$_new_s = preg_replace( '/_s'.$_s_num.'/' , '' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] );
					/*
					echo $_pattern;
					echo '<br>';
					echo $this->kxrttT[ 'num' ];
					echo '<br>';

					echo $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'];
					echo '<br>';
					echo $_new_s;
					echo '<br>';

					echo $_s_num;
					echo '<br>';
					echo get_the_title(  $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'id'] );
					echo '<br>';
					echo $_chara_list;
					echo '<hr>';
					*/
					$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'] = $_new_s;
					$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'new'] .= '🟩3rd（不必要_sの削除）';
				}
			}
		endforeach;
	}


	/**
	 * 4
	 *
	 * @return void
	 */
	public function kxrtt_add_MissingCodes_ToMainTermTableM(){
		//$this->kxrttS1[ 's_chara_list' ][ $_s_S ];

		//echo $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'];
		//echo '<br>';

		//メイン系。2024-06-22
		foreach( explode( '_s' , $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's']  ) as $_s ):
			if( !empty( $_s ))
			{
				//echo $_s;
				//echo '<br>';
				foreach( $this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ]  as $_key => $_array_chara ):

					if(
						$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'time'] == $_array_chara[ 'time'] &&
						!preg_match( '/'.$_s.'/' , $_array_chara[ 's'] )
					)
					{
						/*
						echo $this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ][ $_key ][ 's'];
						echo '<br>';
						echo $this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ][ $_key ][ 's'] . '_s'.$_s;
						echo '<br>';
						*/

						$this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ][ $_key ][ 's']   = $this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ][ $_key ][ 's'] . '_s'.$_s;
						$this->kxrttArrID[ $this->kxrttS1[ 'main_c' ] ][ $_key ][ 'new'] .= '🟦4th(日にち同期の追加：'.$_s.')';
					}

				endforeach;
			}

		endforeach;
		unset( $_s , $_key , $_array_chara );
		//echo $this->kxrttS1[ 's_chara_list' ][ $_s_S ];


	}


	/**
	 * 4
	 *
	 * @return void
	 */
	public function kxrtt_add_MissingCodes_ToMainTermTableN(){

		if( !empty( $this->kxrttS1[ 'array_kxst' ][ 'MissingCodes_ToMainTermTable'][ $this->kxrttT[ 'num' ] ] ) )
		{
			foreach( $this->kxrttS1[ 'array_kxst' ][ 'MissingCodes_ToMainTermTable'][ $this->kxrttT[ 'num' ] ] as $_chara_num => $_s ):

				/*
				echo $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 's'];
				echo '<br>';
				echo $_s_preg;
				echo '<br>';
				*/

				foreach( $this->kxrttArrID[ $_chara_num ]  as $_key => $_array_chara ):

					if(
						$this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'time'] == $_array_chara[ 'time'] &&
						!preg_match( '/'.$_s.'/' , $_array_chara[ 's'] )
					)
					{
						$this->kxrttArrID[ $_chara_num ][ $_key ][ 's']   = $this->kxrttArrID[ $_chara_num ][ $_key ][ 's'] . $_s;
						$this->kxrttArrID[ $_chara_num ][ $_key ][ 'new'] .= '🟫5th(日にち同期の追加：'.$_s.')';

						//echo '+';
						//echo '<hr>';

						/*
						echo '<hr>';
						//echo $_chara_num;
						echo $this->kxrttArrID[ $this->kxrttT[ 'num' ] ][ $this->kxrttT[ 'key' ] ][ 'time'];
						echo '<br>';
						//$_s = $this->kxrttArrID[ $_chara_num ][ $_key ][ 's'];
						echo '<p>';
						echo $this->kxrttArrID[ $_chara_num ][ $_key ][ 's'];
						echo '</p>';
						echo '<p>';
						echo $_new_s;
						echo '</p>';
						echo '<hr>';
						*/
					}

				endforeach;

				//echo '<hr>';


			endforeach;

		}
	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function kxrtt_update_post(){

		$_reload = 0;

		$_c = 0;

		foreach( $this->kxrttArrID as $_num => $_array ):

			foreach( $_array as $_key => $_NA):
				$ret = '';

				if( !empty( $this->kxrttArrID[ $_num ][ $_key ][ 'new'] ) )
				{
					$_c++;

					$_array_s = explode( '_' ,  $this->kxrttArrID[ $_num ][ $_key ][ 's'] );

					sort( $_array_s );

					//print_r($_array_s);
					//echo '<br>';

					$_s_new = '';
					foreach(  $_array_s as $_s ) :

						if( !empty( $_s ) && empty( $_check[ $_s ] ) && preg_match( '/s\w{8}\d/', $_s ) )
						{
							$_s_new .= '_'.$_s;
						}

						$_check[ $_s ] = 1;

					endforeach;

					unset($_check);

					//echo $_s_new;
					//echo '<br>';

					$str = '';
					$str .= $this->kxrttArrID[ $_num ][ $_key ][ 'top'];
					$str .= $this->kxrttArrID[ $_num ][ $_key ][ 'time'];
					$str .= $_s_new;
					$str .= $this->kxrttArrID[ $_num ][ $_key ][ 'last'];

					$_new_title = $str;

					$ret .= '<p>';

					$ret .= kx_CLASS_kxx(
						[
							't'      => 65 ,
							'id'     => $this->kxrttArrID[ $_num ][ $_key ][ 'id'],
							'text_c' => $this->kxrttArrID[ $_num ][ $_key ][ 'id'],
						] );
					$ret .= '</p>';
					$ret .= '<p>';
					$ret .= $this->kxrttArrID[ $_num ][ $_key ][ 'id'];
					$ret .= '：'.$this->kxrttArrID[ $_num ][ $_key ][ 'new'];
					$ret .= '</p>';
					$ret .= '<p>';
					$ret .= get_the_title( $this->kxrttArrID[ $_num ][ $_key ][ 'id'] );
					$ret .= '</p>';
					$ret .= '<p>';
					$ret .= $_new_title;
					$ret .= '</p>';
					$ret .= '<hr>';


					$_id = $this->kxrttArrID[ $_num ][ $_key ][ 'id'];

					if( !empty( $this->kxrttS1[ 'update' ] )   )
					{
						$my_post = array(
							'ID'						=> $_id ,
							'post_title'		=> $_new_title,
						) ;
						wp_update_post( $my_post ) ;

						$this->kxrttOUT[ 'str_array' ][5] ='update_OK<br>'.$ret;


						$_reload++;

						if( $_reload == 8 )
						{
							$_reload = 0;
							echo '<script type="text/javascript">window.location.reload();</script>';
							return;
						}
					}
					elseif( !empty( $this->kxrttArrID[ $_num ][ $_key ][ 'new']) )
					{
						echo $_c.':updateなし：';
						echo $ret;

					}
				}
			endforeach;
		endforeach;
	}
}