<?php
/**
 * class　＝　KX30
 */
class kx30 {

  //基本設定。2023-03-01。
  public $kx30S1;

  //各タイプ設定。2023-03-01
  public $kx30Sxx;

  //htmlに出力。2023-03-01
  public $kx30out;



  //tの分岐、設定割付。2023-08-27
  public $kx30JUDGE =
  [
    'kx30' =>
    [
      //all
      '/./' =>
      [
        'display0'						=> '',
        'display1'						=> 'display:inline-block;',
        'display2'						=> 'display:inline-block;',
        'display_center_plus'	=> 'display:inline-block;',
        'style0'							=> 'font-size:small;',
        'style1'							=> 'text-align:right;margin:0 8px 0 0;',
        'style11'							=> '',
        'style2'							=> '',
        'style_center_plus'		=> 'margin:0 0 0 4px;',
        'css0'								=> '',
        //'css1'								=> '',
        'css11'								=> '',
        'css_center'					=> ' __line1',  // __color_normal
        'css_center_plus'			=> '',

        'plus3_on'						=>  0,
        'setting_text_count'	=>  4,
      ],


      //plus_on
      '/^3[0-6]$/' =>
      [
        'plus1_on' => 1,
        'p1_font'	 => 8.5,
        'edit_on'	 =>	'1',
      ],


      //'plus1_width'
      '/^3[0-2]$/' =>
      [
        'style0'							=> 'font-size:small;',
        'css2'								=> ' __color_normal __line1 ',

        //plusの幅
        'p1_width_arr'		=>
        [
          '/./'								 => 200,
          '/∬.*0構成/'				=> 70,
          '/∬.*0構成.*脚本/'	=> 80	,
          '/∬.*1構成/'				=> 145,
          '/∬.*c\d\w{1,}\d/'	=> 135	,
          '/^κ/'							=> 90	,
        ],
      ],


      '/^30$/' =>
      [
        'display0'						=> 'display:block;',
      ],


      '/^31$/' =>
      [
        'display0'						=> 'display:inline-block;',
        'p_on'								=> 1,
        'style11'							=> 'white-space: nowrap;overflow:hidden;padding:0 0px 0 3px;',
      ],


      '/^32$/' =>
      [
        'display0'						=> 'display:block;',
      ],


      '/^33$/' =>
      [
        'display0'						=> 'display:block;',
        'style0'							=> 'margin:0 0 0 20px;',
      ],

      //段落型	'danraku'
      '/^3[4-6]$/' =>
      [
        'display0'						=> 'display:block;',
        'display1'						=> 'display:block;',
        'p1_width'					  => '',
      ],


      '/^34$/' =>
      [
        'display2'						=> 'display:inline;',
        'style0'							=> 'font-size:small;	margin:0 0px 0 0px;',
        'style1'							=> 'text-align:left;	margin:8px 0px 0px 0px;',
        'style11'							=> 'padding:1px 5px 1px 5px; margin:0px; background:hsla(270,100%,50%,.25);border: 2px solid hsla(270,100%,50%,.5);',
        'style2'							=> 'margin:0px 0px 0px 0px;',
        'css11'			  				=> '__radius_05',
        'css_center'          => '',
      ],


      '/^35$/' =>
      [
        'style0'							=> 'font-size:small;margin:0 0 0 5px;',
        'style1'							=> 'text-align:left;	margin:8px 0px 5px 0px;',
        'style11'							=> 'padding:1px 10px 1px 10px;',
        'style2'							=> 'margin:0px 0px 5px 0px;',
      ],


      '/^36$/' =>
      [
        'style0'							=> 'font-size:small;margin:0 0 0 20px;',
        'style1'							=> 'text-align:left;	margin:8px 0px 5px 0px;',
        'style11'							=> 'padding:1px 10px 1px 10px;',
        'style2'							=> 'margin:0px 0px 5px 5px;',
      ],


      //表示だけ
      '/^3[7-9]$/' =>
      [
        'style0'				=> 'font-size:small;margin:0 0 0 15px;',
      ],
    ],
  ];




  /**
   * kx30メインプログラム
   *
   * @param array $inx  ショートコード設定。
   * @param array $stt　kxx系の追加設定。
   * @param string $basu　抜粋内容。
   * @return void
   */
  public function kx30_Main( $kxxS1 , $kxxSxx ){

    $this->kx30S1    = $kxxS1;
		$this->kx30Sxx   = $kxxSxx;
		//$this->kx30_basu = $this->kx30Sxx[ 'ExcerptA' ] ;

    $this->kx30_setting();

    //コンテンツ
    $this->kx30_left();
    $this->kx30_center();
    $this->kx30_center_plus();
    $this->kx30_right_edge();

  }

  /**
   * セッティング。
   *
   * @return void
   */
  public function kx30_setting(){

    //t設定
    $this->kx30out[ 'judge' ] = kx_Judge( $this->kx30JUDGE[ 'kx30' ] , $this->kx30S1[ 't' ] );



    $this->kx30Sxx[ 'FormatON_ARR' ] = kx_format_on( $this->kx30Sxx[ 'id' ] );

    //print_r($this->kx30Sxx[ 'FormatON_ARR' ]);

    $this->kx30_number_arr( $this->kx30Sxx[ 'title' ] );



		if(KxSu::get('display_colors_css') == 'd' )
    {
			$this->kx30out[ 'p1_font']		= 9;
		}

    /*
		if( !empty( $this->session_count ))
    {
      $this->session_count++;
    }
    else
    {
      $this->session_count = 1;
    }
    */


		//P1幅

		if( !empty( $this->kx30out[ 'judge' ][ 'p1_width_arr' ] ) )
    {
			foreach(	$this->kx30out[ 'judge' ][ 'p1_width_arr' ]	as $key =>	$value ):

				if(preg_match	(	$key	,$this->kx30Sxx[ 'title' ] ))
        {
					$this->kx30out[ 'judge' ][ 'p1_width' ]	= $value;
        }

			endforeach;
		}

    unset( $key , $value );

		//sys系
		if( preg_match( '/30width(\d{1,})/' , $this->kx30S1[ 'sys' ]	, $matches  )	)
    {
			$this->kx30out[ 'judge' ][ 'p1_width' ]	= $matches[1];	//ない場合、ｔ設定。
		}
		unset($matches);


		if(	preg_match('/no_edit/'	,	$this->kx30S1[ 'sys' ]	)	):

			unset( $this->kx30out[ 'judge' ][ 'edit_on' ] );

		endif;


		//plusA・背景色
		if(preg_match('/plus_a_bg/i'	,	$this->kx30S1[ 'sys' ]	)	):

			if( empty($this->kx30out[ 'css11' ]) ):
        $this->kx30out[ 'css11' ] = NULL;
      endif;
      $this->kx30out[ 'css11' ] 		.= ' __back_gray_33 __radius_10';

		endif;


		//plusAのフォント
		if(preg_match('/plus1_f(\d{1,})/i'	,	$this->kx30S1[ 'sys' ]	,	$matches)):

			$this->kx30out[ 'p1_font']	= $matches[1];
			unset( $matches );

		endif;

		//■ p1 left margin
		if(preg_match('/p1_left_m(\d{1,})/i'	,	$this->kx30S1[ 'sys' ]	,	$matches)):

			$this->kx30out[ 'style0']	.= 'margin-left:'.$matches[1].'px;';

			unset(	$matches	);

		endif;

		//Plus系
    if( preg_match ( '/plus_off/' , $this->kx30S1[ 'sys' ] ) ):

			$this->kx30out[ 'judge' ][ 'plus1_on' ]	= '';
			$this->kx30out[ 'judge' ][ 'plus2_on' ]	= '';

		endif;

		if(	!empty( $this->kx30out[ 'judge' ][ 'plus1_on' ] ) ):

			$this->kx30_number_arr( $this->kx30Sxx[ 'title' ] );

		endif;


    //エディタ
    $this->kx30_editor();


    //ID設定。ゴースト絡み。
    if( !empty( $this->kx30Sxx[ 'FormatON_ARR' ][ 'GhostON' ] ) )
    {
      $this->kx30out[ 'id_js' ]	= $this->kx30Sxx[ 'FormatON_ARR' ][ 'GhostON' ];
    }
    else
    {
      $this->kx30out[ 'id_js' ]	= $this->kx30Sxx[ 'id' ] ;
    }



    //時間関係
    global $post;
    $post	 = get_post( $this->kx30out[ 'id_js' ] );

    setup_postdata( $post );
    $modified_date 	= get_post_modified_time( 'U' , true ) ;
    wp_reset_postdata();


    //時間のカラー表示呼び出し。
    $_time_color = kx_time_color( $modified_date );

    $this->kx30out[ 'time_color_h' ] = $_time_color[ 'h' ];
    $this->kx30out[ 'time_color_s' ] = $_time_color[ 's' ];
    $this->kx30out[ 'time_color_l' ] = $_time_color[ 'l' ];
    $this->kx30out[ 'time_color_a' ] = $_time_color[ 'a' ];

    //時間差呼び出し。
    $this->kx30out[ 'time' ]	 = kx_time_human_diff($modified_date).'前' ;

  }



  /**
   * editorー取得。
   *
   * @return void
   */
  public function kx30_editor(){

		//エディット取得
    $this->kx30Sxx[ 'time_sa' ]	= NULL;



		if(	$this->kx30S1['level']	&& !empty( $this->kx30out[ 'judge' ][ 'edit_on' ] ) && $_SESSION[ 'add_new' ]	< 1000):

			//更新・時間差
			if(
        kx_time_modified( $this->kx30Sxx[ 'id' ] )['sa']<60 ||
        (
          !empty( $this->kx30Sxx[ 'FormatON_ARR' ][ 'GhostON' ] ) &&
          kx_time_modified( $this->kx30Sxx[ 'FormatON_ARR' ][ 'GhostON' ] )['sa']<60
        )
       )
       {
				$this->kx30Sxx[ 'time_sa' ]	= ' __time_sa_1line';
      }

			$_in =[
				'id'		=>	$this->kx30Sxx[ 'id' ]	,
				'kx30_on'		=>	1	,
				'memo'	=>	$this->kx30S1['s_cut']	,
			];



			if(preg_match('/kxEdit_left/'	, $this->kx30S1[ 'sys' ] ) ):

				$_in['sys']	= NULL;

			else:

				$_in['sys']	= 'kxEdit_right';

			endif;

			if( preg_match('/reference_off/' , $this->kx30S1['sys'] )  ){ $_in['sys']	.= ',reference_off';}

			$_edit	= kxEdit( $_in );

			$this->kx30out[ 'edit0' ]	= $_edit[0];
			$this->kx30out[ 'edit1' ]	= $_edit[1];

		else:

      $this->kx30out[ 'edit0' ]	= NULL;
			$this->kx30out[ 'edit1' ]	= NULL;

    endif;

  }


  /**
   * 左コンテンツ。
   *
   * @return void
   */
  public function kx30_left(){

    if( !empty(  $this->kx30out[ 'judge' ][ 'p1_width' ] ) )
    {
			$this->kx30out[ 'judge' ][ 'p1_width' ]	= $this->kx30out[ 'judge' ][ 'p1_width' ] . 'px';
    }
		else
    {
			$this->kx30out[ 'judge' ][ 'p1_width' ]	= 'auto';
    }


		if( !empty( $this->kx30out[ 'judge' ]['kx30_text'] ) )
    {
			if( preg_match( '/plus30_w/' , $this->kx30S1[ 'sys' ] ) )
      {
				//作品ネーム付与型

        $_p1_title	= kx_CLASS_kxTitle( [
          'type'  => 'work',
          'title' => $this->kx30Sxx[ 'title' ],
        ])[ 'work_code' ];

        if( empty( $_p1_title ))
        {
          $_p1_title = $this->kx30Sxx[ 'title' ];
        }
      }
			else
      {
				$_p1_title	 = $this->kx30out[ 'judge' ]['kx30_text'];
        $_p1_title	.= '　';

        if( empty( $this->kx30out[ 'judge' ][ 'setting_text_count' ] ))
        {
          $this->kx30out[ 'judge' ][ 'setting_text_count' ] = NULL;
        }

        $_p1_title	.= '<span>' . mb_substr(	$this->kx30out[ 'judge' ][ 'kx30_name' ]	,	0	,	$this->kx30out[ 'judge' ][ 'setting_text_count' ]	) . '</span>';
			}
    }
		else
    {
			$_p1_title	= '<span class="__color_normal">▽LINK</span>';
		}


    if( empty( $this->kx30out[ 'judge' ][ 'css11' ] ))
    {
      $this->kx30out[ 'judge' ][ 'css11' ]		  = NULL;
    }

    $this->kx30out[ 'judge' ][ 'css11' ]		  .= ' __color_inversion __line1_plus ';


    if( empty( $this->kx30out[ 'judge' ][ 'style11' ] ))
    {
      $this->kx30out[ 'judge' ][ 'style11' ]	= NULL;
    }


    if( !empty( $this->kx30out[ 'judge' ][ 'kxx30_style' ] ))
    {
      $this->kx30out[ 'judge' ][ 'style11' ]	.= $this->kx30out[ 'judge' ][ 'kxx30_style' ];
    }


    $this->kx30out[ 'left' ]	= $_p1_title;
  }


  /**
   * センターコンテンツ。
   *
   * @return void
   */
  public function kx30_center(){

    $this->kx30out[ 'width_hyouji' ]   = 'width:auto;';

    kx_kxx_jq_main(  $this->kx30out[ 'id_js' ] , 'main' );

		//__line1
    $this->kx30out[ 'class_center' ] = $this->kx30Sxx[ 'time_sa' ] . ' e'. $this->kx30Sxx[ 'id' ] .' displayArea3'.$this->kx30out[ 'id_js' ];

		$this->kx30out[ 'center' ]	= $this->kx30Sxx[ 'ExcerptA' ];

    //kx_kxx_jq_main( $this->kx30out[ 'id_js' ] , 'main' );

    $_style	= 'color:hsla(' . $this->kx30out[ 'time_color_h' ] . ', '.$this->kx30out[ 'time_color_s' ].'% , '.$this->kx30out[ 'time_color_l' ].'% , .'.$this->kx30out[ 'time_color_a' ].'	); display:inline-block;';
    $_url		= 'wp-content/themes/kasax_child/lib/php/p_hyouji.php';

    $str = NULL;
    $str	.= '<span class="_kxjq_yomi_main' . $this->kx30out[ 'id_js' ] . ' __float_right2" style="display: inline-block;" tabindex="-1">';
    $str	.= '<input type="hidden" class="id" value="'.$this->kx30Sxx[ 'id' ].'">	';
    $str	.= '<a style="' . $_style . '" href="' . $_url . '?id=' . $this->kx30out[ 'id_js' ] . '&type=reload&more=0&width_hyouji=width:auto;" tabindex="-1" >';
    $str	.= '<span class="" style="font-size:10px;">';
    $str	.= $this->kx30out[ 'time' ];
    $str	.= '</span>';
    $str	.= '</a>';
    $str	.= '</span>';

    $this->kx30out[ 'Reload' ] = $str;
  }



  /**
   * センターコンテンツ。追加要素。
   * 主に削除ボタン。
   * 2021-08-06
   *
   * @return void
   */
  public function kx30_center_plus(){



    //■削除ボタン
		if(	!empty( $this->kx30S1['delete'] ) && ( KxDy::get('trace')['kxx_sc_count'] ?? null )	== 1):


			if( !empty(  $this->kx30out[ 'judge' ]['kx30_text'] ) ):

				$text	= $this->kx30out[ 'judge' ]['kx30_text'];

			else:

				$text	= '不使用ポスト';

			endif;

			$this->kx30out[ 'center_plus_on' ]		= 1;
			$this->kx30out[ 'center_plus' ]	  = kx_delete($this->kx30Sxx[ 'id' ]	,	'kx30'	,	$text	);



		endif;

  }


  /**
   * 右端コンテンツ。主にフォーマット関係の表示。
   *
   * @return void
   */
  public function kx30_right_edge(){

		if(	!empty($this->kx30Sxx[ 'FormatON_ARR' ][ 'GhostON' ]) && !preg_match( '/plus3_off/' ,$this->kx30S1['sys'] ) )
    {

			$str	 = '<div ';
      $str	.= ' style="user-select: none;	opacity:.1;	float: right;	display:block;	text-align:right;	margin:0 0 0 auto;">';
      $str .= '<span class="_op_a">G';
      //$str	.= substr( $this->kx30Sxx[ 'FormatON_ARR' ][ 'format_on' ] , 0, 1);



      if( !empty($this->kx30Sxx[ 'FormatON_ARR' ]['BaseID']) && is_array( $this->kx30Sxx[ 'FormatON_ARR' ]['BaseID'] ))
      {
        if( !empty( $this->kx30Sxx[ 'FormatON_ARR' ]['BaseID'] ))
        {
          $str	.= count( $this->kx30Sxx[ 'FormatON_ARR' ]['BaseID'] );
        }
        else
        {
          $str .= 'ERROR';

        }

      }

      $str	.= '&nbsp;';
      $str .= '</span>';


      if( !empty( $this->kx30Sxx[ 'FormatON_ARR' ]['BaseID'] ) )
      {
        $str .= '<div class="_op_z" style="text-align: left;width:100px;">';

        if( empty($this->kx30Sxx[ 'FormatON_ARR' ]['BaseID'] ))
        {
          echo 'base_id_ERROR_RELOAD！';
          $str .= 'base_id_ERROR';
        }
        else
        {

          foreach($this->kx30Sxx[ 'FormatON_ARR' ]['BaseID'] as $id_base):

            $str .= '<div>Link:<a href=' . get_permalink( $id_base ) . '>'.$id_base;
            $str .= '</a></div>';

          endforeach;

        }


        $str .= '</div>';
      }

      $str	.= '</div>';
    }
		else
    {
      $str = NULL;
    }

    $this->kx30out[ 'right_edge' ] = $str;

  }


  /**
	 * kxx関係の補足設定。
   * 2021-08-06
	 *
	 * @param string $title
	 * @return void
	 */
	public function kx30_number_arr(	$title = null	){

		if(	!$title	)
    {
			$title	= get_the_title();
		}

		if( preg_match(	'/^∬\w{1,}≫c\d/'	,	$title	) )
    {
      $_kxtt_arr_character = kx_CLASS_kxTitle(
      [
        'type'             => 'character',
        'title'            => $title,
        'character_number' => '',
      ] );

      $_name	= $_kxtt_arr_character[ 'character_name' ];

      if( mb_strlen( $_name ) > $this->kx30out[ 'judge' ][ 'setting_text_count' ] && !empty( $_kxtt_arr_character[ 'character_name_s' ] ) )
      {
        $_name	= $_kxtt_arr_character[ 'character_name_s' ];
      }
    }
    else
    {
      $_name = NULL;
    }

		//Title分析
		if(	preg_match( '/^(κ)≫.*〇([a-z]+)\d{1,}$/i' , $title , $matches ) )
    {
      //スルー。2023-08-05
    }
		else
    {
      preg_match( '/(.*)≫〇(\w{1,}$)/i' , $title , $matches );
      //echo $matches[1];
    }


    $_kxcl = kx_CLASS_kxcl(	$title	,	'kx30'	);

		//文字


		foreach( KxSu::get('title_kx30') as $key => $arr):	//作品∬番号


      if( !empty( $matches[1] ) && preg_match(	$key	,	$matches[1] ) )	//作品∬番号

      {
        foreach( $arr as $key2 => $arr2):

					if(
            $key2	== strtolower($matches[2] ) ||
            preg_match(	'/'.$key2.'\d/'	,	$matches[2] ) //big用。2024-09-04
            )	//小文字化
          {
            $this->kx30out[ 'judge' ]['kxx30_style']	= $_kxcl[ 'kxx30_style' ];
            $this->kx30out[ 'judge' ]['kx30_text']		= $arr2[0];
            $this->kx30out[ 'judge' ]['kx30_name']		= $_name;

						$arr2['kxx30_style']	= $_kxcl[ 'kxx30_style' ];
						$arr2['name']					= $arr2[0].$_name;

						return	$arr2;
					}

				endforeach;

			}

		endforeach;
	}
}
?>