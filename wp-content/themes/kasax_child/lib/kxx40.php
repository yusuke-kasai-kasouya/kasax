<?php
/**
 * class　＝　KX40
 * 60系	リンクオンリー型
 * x0	段落型・汎用	inline型
 * x1	文中型・小型・editなし	マージン無し・エディット短縮
 * x2	文中型・通常・editなし	マージン無し
 * x3	文中型・r	マージン無し・エディット短縮
 * x4	block型・小型・editなし
 * x5	block型・<p></p>と一緒に使うのが基本。2023-03-24
 * x6	block型・プログラム内型	block型。
 * x7	∇エンドのみ	文中型・endのみ表示
 * x8	∇ミニ・Link表示	段落型
 * x9	∇ミニ・Link表示	文中型・marginなし
 *
 *
 *
 */
class kx40 {

//基本設定。2023-03-01
public $kx40S1;

//public $kx40Sa;

public $kx40Sxx;


//kxxからの入力値。2023-08-26
public $kx40arr_id;

//メイン出力。
public $kx40out = [
  'hikidashi' => NULL,
];


public $kx40error;


//public $kxxExcerptX;
//public $session_count;


/**
 * kx10の$t分岐、設定割付。
 * 2021-08-07
 *
 * 'navi_on'の機能削除中。2023-03-01
 *
 * @var array
 */
public $kx40JUDGE	=
[
  'main' =>
  [
    //基本形
    '/./' =>
    [
      'display_general'			=> 'display:inline-block;',
      'display_left'				=> 'display:inline-block;',
      'display_time'				=> 'display:inline-block;',
      'display_center'			=> 'display:inline-block;',
      'display_right'				=> 'display:inline-block;',

      'style_general'				=> 'margin:0px 0px;font-size:small; white-space:nowrap; line-height:2em;',
      'style_left'					=> 'margin:0 0px 0 0;',
      'style_right'					=> 'margin:0 5px 0 2px;',

      'style_center'				=> 'padding:0px 6px;line-height:1.5em;',

      //'css_general'					=> '',
      'css_left'						=> '',
      'css_center'    			=> '',
      //'css_right'						=> '',
      'css_js'							=> '__js_hover1_a',

      'left_on'       =>  0,
      'right_on'      =>  0,
      'mini_on'       =>  0,
      'time_on'       =>  0 ,
      'link_on'       =>  1,
      'edit_link_on'  =>  0,
      'end_on'        =>  0,

      'link_long'     =>  20, //?
    ] ,


    //文中型
    '/^[4-6][1-3|7|9]$/' =>
    [
      'display_general' => 'display:inline;',
      'style_general'		=> 'font-size:small;',
      'right_on'        =>  NULL,
    ],

    //段落型。<p></p>と一緒に使うのが基本。2023-03-24
    '/^[4-6][4-6]$/' =>
    [
      'display_general'	=> 'display:block;',
      'style_general'		=> 'margin:0px 0px 0px 20px;font-size:small; white-space:nowrap; line-height:2em;',
      'right_on'        =>  NULL,
    ],


    //エンド型
    '/^[4-6]7$/' =>
    [
      'end_on'  =>  1,
      'right_on'      =>  NULL,
    ],

    //mini型
    '/^[4-6][8-9]$/' =>
    [
      'style_general'			      => 'font-size:8pt;  white-space: nowrap;line-height: 1.5em;',
      'mini_on'           =>  '━',
      'mini'		=> 1 ,  //古い
      'right_on'      =>  NULL,
    ],


    //'small'
    '/^[4-6][1|4]$/' =>
    [
      'style_general'		=> 'font-size:8pt;  white-space: nowrap;',
      'css_link_n'			=> '__xsmall',
      'css_basu_navi'		=> 'basu_ul',
      'edit_off'				=> '1',
      'right_on'        =>  NULL,
    ],


    '/^[4-6]2$/' =>
    [
      'style_general'		=> 'white-space: nowrap;',
      //'css_link_n'			=> '__xsmall',
      'css_basu_navi'		=> 'basu_ul',
      'edit_off'				=> '1',
      'right_on'        =>  NULL,
    ],


    //'all40' 	//40系全+7
    '/^([4-6]|[7-8] )\d$|7/' =>
    [
      'css_margin'		=>  '__margin_left9 __margin_bottom7 __margin_top5' ,
      'div'						=> 'div',
      'css_link_n'		=> '__kx40_a_cnt' ,
      'css_link_e'		=> '__edit' ,
    ] ,


    //'jyoui'
    '/^[7-8]$/' =>
    [
      'jyoui'	=>  '1' ,
      'right_on'      =>  1,
      //'sentou'	=>  '▲▲' ,
    ],


    //'normal型リンク
    '/^[4-8]\d$/' =>
    [
      'normal'	=>  '1' ,
    ],


    //'short'
    '/^[4-6](5|8)$/' =>
    [
      'edit_off'	=>  'on' ,
      'right_on'      =>  1,
    ],


    //'navi'
    '/^[4|7]\d$/' =>
    [
      'navi_on'	=>  1 ,
      //'sentou'	=>  '▽' ,
      'add_top'	=>  '▽&nbsp;' ,
      'css_navi'	=> '__navi_back_l2' ,
      'right_on'      =>  1,

    ],


    //'navi_plus'
    '/^[5|8]\d$/' =>
    [
      'navi_on'		=>  1 ,
      'sentou_h'	=>  '&nbsp;&nbsp;▼&nbsp;' ,
      //'sentou'		=>  '' ,
      'css_navi'	=> '__navi_back_l2' ,
      'right_on'      =>  1,
    ],


    //'t59'
    '/^5[7-9]$/' =>  [
        'title_59'		=>  '.' ,
        //'sentou'		=>  'Link' ,
        'right_on'      =>  1,
      ],

    //■　List　7-9　■
    '/^[7-9]\d$/' =>
    [
      'list_on'   =>  1,
      'comma'	    =>  '.' ,
      'style_left'		=> 'margin:0px 0px 0 0;padding:0 0px 0px 0px;text-align:center;width:18px;',


      'css_table_list'	=>  'kx40_list' ,
      'right_on'      =>  1,
    ],

    '/^([4-5]|[7-9] )\d$/' =>
    [
      'left_on'       =>  1,
      'right_on'      =>  1,
    ],


    //リスト型
    '/^9\d$/' =>
    [
      'display_general'						=>  'display:block;',

      't9x'			  		=>  '1' ,
      'css_table_9x'	=>  '__margin_bottom2 __white_space_nowrap' ,
      'css_td_x'			=>  '__td_right' ,
      'css_td_time'		=>  '__td_right __color_gray __xxsmall' ,
      'td_x'					=>  'width="35px"' ,	// height="10px"
      'td_ma'					=>  'width="3px" ' ,
      'td_time'				=>  'width="54px" ' ,
      'css_td_9x'			=>  '__white_space_nowrap' ,
      'left_on'       =>  1,
      'right_on'      =>  1,
    ],


    //'t9_normal'
    '/^9[0|8|9]$/' =>
    [
      't9_normal'	=>  '1' ,
      'right_on'      =>  1,
    ],

    //'t9_trans'
    '/^9[1-3|6-7]$/' =>
    [
      't9_trans'	=>  '1' ,
      'right_on'      =>  1,
    ],


    //'time'
    '/^9[1-4]$/' =>
    [
      'time_on'	=>  1 ,
      'style_time' => 'font-size:x-small;width:40px;text-align:right;margin:0 2px;',
      'right_on'      =>  1,
    ],


    '/^97$/' =>
    [
      'normal'	=>  '1' ,
      'end_on'  =>  1,
      'right_on'      =>  NULL,
    ],


    //'x0'
    '/^\d0$/' =>
    [
      'css_link_e'	=>  '__edit' ,

    ],


    //'x8'
    '/^\d8$/' =>
    [

      'title_text'	=>  'last' ,

    ],


    //'x9'
    '/^\d9$/' =>
    [
      'css_link_n'			=> '__xsmall',
      'css_basu_navi'		=> 'basu_ul',
    ],
  ],
];


/**
 * Undocumented function
 *
 * @param [type] $inx
 * @param [type] $stt
 * @return void
 */
public function kx40_main( $kxxS1 , $kxxSxx , $error ){

  $this->kx40S1         = $kxxS1;
  $this->kx40Sxx        = $kxxSxx;
  $this->kx40error      = $error;

  //$this->kxcl           = $this->kx40Sxx[ 'kxcl' ] ;
  //$this->session_count  = $this->kx40S1[ 'session_count' ] ;
  //$this->kx40Sxx[ 'ExcerptX' ]    = $basu_x;

  $this->kx40_setting();

  $this->kx40_left();
  $this->kx40_center();
  $this->kx40_right();

  kx_db0(	['id'=>$this->kx40Sxx[ 'id' ]] , 'id'  );
}



/**
 * セッティング。
 *
 * @return void
 */
public function kx40_setting(){

  $this->kx40out[ 'judge' ] = kx_Judge( $this->kx40JUDGE[ 'main' ] , $this->kx40S1[ 't' ] );

  $this->kx40_title();
  $this->kx40_time();


  //linkのURLを取得。2023-03-01
  $this->kx40out[ 'link' ]	= get_permalink ( $this->kx40Sxx[ 'id' ] ) ;


  //マウスホバー文字の制御。2023-03-01
  if( empty( $this->kx40S1[ 'no_hover_title' ] ) )
  {
    //機能カットをしていない場合。2023-03-01
    $this->kx40out[ 'ret2_js' ]  = $this->kx40out[ 'title_original' ];
  }
  else
  {
    //機能カットの場合。文字列とcssを削除。2023-03-01
    $this->kx40out[ 'ret2_js' ]  = NULL;
    $this->kx40out[ 'judge' ][ 'css_js' ] = NULL;
  }


  //先頭部
  if ( !empty( $this->kx40out[ 'judge' ][ 'list_on' ] ) ) :

    $this->kx40out[ 'sentou' ] = $this->kx40S1[ 'session_count' ];

    if ( !empty( $this->kx40S1[ 'color_on' ] ) ) :

      $this->kx40out[ 'judge' ][ 'css_left' ] .= '__kx40_1_maru __text_shadow_black1';
      $this->kx40out[ 'judge' ][ 'style_left' ]   .= 'background:' . $this->kx40Sxx[ 'kxcl' ][ 'hsla_normal' ] . ';';

    endif;

    $this->kx40out[ 'comma_off' ] = 1;

  else:

    $this->kx40out[ 'sentou' ] = NULL;

  endif;


  //削除オプション
  if(	!empty( $this->kx40S1['delete'] ) ):

    $this->kx40out[ 'delete' ]	= kx_delete( $this->kx40Sxx[ 'id' ]	,	'kx40');

  endif;

  $this->kx40_hikidashi();
  $this->kx40_edit_link();
  $this->kx40_css_style();
  $this->kx40_raretu_check();

}


/**
 * css
 *
 * @return string
 */
public function kx40_css_style(){

  if( !array_key_exists( 'style_time'  , $this->kx40out[ 'judge' ] )):
    $this->kx40out[ 'judge' ][ 'style_time' ] = NULL;
  endif;

  $this->kx40out[ 'judge' ][ 'style_general' ] = $this->kx40out[ 'judge' ][ 'display_general' ] . $this->kx40out[ 'judge' ][ 'style_general' ];
  $this->kx40out[ 'judge' ][ 'style_left' ]    = $this->kx40out[ 'judge' ][ 'display_left' ]    . $this->kx40out[ 'judge' ][ 'style_left' ];
  $this->kx40out[ 'judge' ][ 'style_time' ]    = $this->kx40out[ 'judge' ][ 'display_time' ]    . $this->kx40out[ 'judge' ][ 'style_time' ];
  $this->kx40out[ 'judge' ][ 'style_center' ]  = $this->kx40out[ 'judge' ][ 'display_center' ]  . $this->kx40out[ 'judge' ][ 'style_center' ];
  $this->kx40out[ 'judge' ][ 'style_right' ]   = $this->kx40out[ 'judge' ][ 'display_right' ]   . $this->kx40out[ 'judge' ][ 'style_right' ];

}


/**
 * 時間。
 * 素材・時間
 *
 * @return string
 */
public function kx40_time(){

  if( !empty( $this->kx40out[ 'judge' ][ 'time_on' ] ) ):

    global $post;
    $post	 = get_post( $this->kx40Sxx[ 'id' ] );

    setup_postdata( $post );
    $modified_date 	= get_post_modified_time( 'U' , true ) ;
    wp_reset_postdata();

    //echo $modified_date;

    //$this->kx40out[ 'time' ]	      = human_time_diff( $modified_date, $to ).'前' ;
    $this->kx40out[ 'time' ]	      = human_time_diff( $modified_date ).'前' ;
    //echo $this->kx40out[ 'time' ];

  endif;

}


/**
 * 引き出し機能。
 *
 * @return string
 */
public function kx40_hikidashi(){

  //■■■■■表示開始■■■■■

  //■引き出し部

  if( !empty( $this->kx40error['type'] ) ):

    //スルー

  elseif(	!empty( $this->kx40S1[ 'yomikomi2' ] ) ):

    kx_kxx_jq_main( $this->kx40Sxx[ 'id' ] , 'yomikomi2' );

    $ret_y1	 = '';

    $ret_y1	 .= '<div id="gnavi2'. $this->kx40Sxx[ 'id' ] .'" class="question" style="display: inline-block;">';
    $ret_y1	.= '<input type="hidden" class="id" value="'. $this->kx40Sxx[ 'id' ] .'">	';

    $ret_y1	 .= '<a href="wp-content/themes/kasax_child/lib/php/p_hyouji.php?id='. $this->kx40Sxx[ 'id' ] .'" class="" >';
    $ret_y1	 .= '<input value="" class="__btn0" style="height:2px;width:90px;background-color:hsla('. $this->kx40Sxx[ 'kxcl' ][ '色相' ] .',100%,50%,1);">';
    $ret_y1	 .= '</a>';
    $ret_y1	 .= '</div>';


    $ret_y1	 .= '<div class="answer">';
    $ret_y1	 .= '<div class="displayArea'. $this->kx40Sxx[ 'id' ] .'">';
    $ret_y1	 .= '</div>';

    $ret_y1	 .= '<div class="question">';
    $ret_y1	 .= '<input type="submit" value="" class="__btn0" style="width:600px;background-color:hsla('. $this->kx40Sxx[ 'kxcl' ][ '色相' ] .',100%,50%,1);">';
    $ret_y1	 .= '</div>';

    $ret_y1	 .= '</div>';

    $this->kx40out[ 'hikidashi' ]	= $ret_y1;

  elseif( !empty( $this->kx40S1[ 'sys' ] ) &&	(preg_match(	'/yomikomi_r/'	, $this->kx40S1[ 'sys' ] ) )		) :

  elseif( !empty( $this->kx40S1[ 'sys' ] ) &&	(preg_match(	'/yomikomi/'		, $this->kx40S1[ 'sys' ] ) )		) :

    preg_match(	'/yomikomi_(\d{1,})/'		, $this->kx40S1[ 'sys' ] ,	$matches ) ;

    if( !empty( $matches ) ):

      $_width  = $matches[1];

    else:

      $_width 			 							= 200;
      //$link_on 									= 0;
      $this->kx40out[ 'ret2_js' ]  = 'jQuery';

    endif;

    $ret  = '';

    $ret .= '<form method="post" class="gnavi" onClick="return false;" style="display: inline-block;">';

    $ret .= '<input type="hidden" class="text" name="text" value="TEXT'. $this->kx40Sxx[ 'id' ] .'">	';
    $ret .= '<input type="hidden" class="id" value="'. $this->kx40Sxx[ 'id' ] .'">	';

    $ret .= '<a href="wp-content/themes/kasax_child/lib/php/p_hyouji.php?id='. $this->kx40Sxx[ 'id' ] .'&type=button_close_on">';
    $ret .= '<input type="submit" value="" class="__btn0 __text_center" style="height:5px;width:'.$_width.'px;background-color:hsla('. $this->kx40Sxx[ 'kxcl' ][ '色相' ] .',100%,50%,1);">';
    $ret .= '</a>';

    $ret .= '</form>';

    $this->kx40out[ 'hikidashi' ]	= $ret;

  elseif( ( $this->kx40S1[ 't' ] >= 50 and  $this->kx40S1[ 't' ]  < 60) or ( $this->kx40S1[ 't' ]  >= 80 and  $this->kx40S1[ 't' ]  < 90) ):

    $ret	= 	'';
    $ret .= '<span class="question __kx40_hidden_cnt question_content">';
    $ret .= '<a style="cursor:pointer;">'. $this->kx40out[ 'judge' ]['sentou_h'] .'</a>';
    $ret .= '</span>';

    $ret .= '<div class="answer">';

    $ret .= '<HR>';

    $ret .= '<div class="__back_white __padding_left7">';
    $ret .= $this->kx40Sxx[ 'ExcerptX' ];
    $ret .= '</div>';
    $ret .= '<HR>';

    $ret .= '<div class="__color_red __text_center">';
    $ret .= '───　▲▲　OPEN　▲▲　───';
    $ret .= '</div>';

    $ret .= '</div>';

    $this->kx40out[ 'hikidashi' ]	= $ret;

  endif;

}



/**
 * Undocumented function
 *
 * @return void
 */
public function kx40_raretu_check(){

  if( !empty( $this->kx40arr_id[0] ))
  {
    $_title0  = get_the_title( $this->kx40arr_id[0] );
  }
  else
  {
    $_title0  = get_the_title();
  }

  $_title   = get_the_title( $this->kx40Sxx[ 'id' ] );

  $str = NULL;

  if( !empty( $this->kx40S1[ 'sys' ] ) &&	(preg_match(	'/raretu_check/'	, $this->kx40S1[ 'sys' ] ) ) && $_title != $_title0 ) :

    //headingcheck。
    $post	   = get_post( $this->kx40Sxx[ 'id' ] );

    if( preg_match('/<h(\d).*<\/h\d/' , $post->post_content , $matches)  ):

      $_on = 'yellow';

      $str .= 'H'.$matches[1];

    endif;


    //上位ポストチェック。
    $_title_Tops = preg_replace(  '/≫' . end( explode( '≫' , $_title) ).'$/' , '' ,$_title  );

    foreach( $this->kx40arr_id as $_id  ):

      if( $_title_Tops ==  get_the_title( $_id ) ):

        unset( $_title_Tops_NO );

        $post	   = get_post( $_id );

        if( !preg_match('/\[.*raretu.*\]/' , $post->post_content ) && !preg_match('/\[.*kx_tp type=list_DB.*\]/' , $post->post_content )  ):

          $_on = 'purple';

          $str .= '羅列なし：' . $_title_Tops;

        endif;

        break;

      else:

        $_title_Tops_NO  = $_title_Tops;

      endif;

    endforeach;

    if( !empty( $_title_Tops_NO ) ):

      $_on = 'red';

      $str .= '上位：' . $_title_Tops_NO;

    endif;

    if( !empty( $_on ) ):

      $this->kx40out[ 'raretu_check' ] = '<span style="color:'. $_on .'"; >RCheck：'. $str.'</span>';

    endif;

  endif;
}


/**
* 編集リンクret3
*
* @return void
*/
public function kx40_title(){

  $kxx = new kxx;
  $kxx->kxxS1 = $this->kx40S1;

  $_title = get_the_title( $this->kx40Sxx[ 'id' ] );
  $this->kx40out[ 'title_original' ] = $_title;

  //■タイトル系
  $this->kx40out[ 'sentou' ] = NULL;
  if( !empty( $this->kx40error['type'] ) )
  {
    //Errorの場合。

    $this->kx40out[ 'sentou' ]	= '<span style="color:red;font-weight:bold;">E</span>' ;
    $_title_trans 	        = get_the_title( $this->kx40Sxx[ 'id' ] ) ;
  }
  elseif( !empty( $this->kx40out[ 'judge' ][ 'normal' ] ) )
  {
    if(
      (
        !empty( $this->kx40out[ 'judge' ][ 'title_text' ]  )
        && $this->kx40out[ 'judge' ][ 'title_text' ]  ==  'last'
      )
      || !empty( $this->kx40out[ 'judge' ][ 'end_on' ] )
    )
    {
      $_title_trans = kx_CLASS_kxTitle(
      [
        'type'             => 'TitleReplace',
        'title'  => get_the_title( $this->kx40Sxx[ 'id' ] ),
        'string' => end(explode('≫', $_title ) ),
      ] )[ 'TitleReplace_html' ];

    }
    else
    {
      $_title_trans = kx_CLASS_kxTitle(
      [
        'type'             => 'TitleReplace',
        'title'  => get_the_title( $this->kx40Sxx[ 'id' ] ),
      ] )[ 'TitleReplace_html' ];
    }
  }
  elseif( !empty( $this->kx40out[ 'judge' ][ 't9x' ] ) )
  {
    if( !empty( $this->kx40out[ 'judge' ][ 't9_normal' ] ) )
    {
      $_title_trans			 = $_title;
    }
    elseif( !empty( $this->kx40out[ 'judge' ][ 't9_trans' ] ) )
    {
      $_title_trans = kx_CLASS_kxTitle(
      [
        'type'             => 'TitleReplace',
        'title'  => get_the_title( $this->kx40Sxx[ 'id' ] ),
      ] )[ 'TitleReplace_html' ];
    }
    else
    {
      $_title_trans			= $_title;
    }
  }
  else
  {
    $this->kx40out[ 'sentou' ] = NULL;
    $_title_trans				 = get_the_title( $this->kx40Sxx[ 'id' ] ) ;
  }




  if( $this->kx40out[ 'judge' ][ 'mini_on' ] )
  {
    $this->kx40S1[ 'text' ]	 =  $mini_on;
    $this->kx40S1[ 'text_c' ] =  $mini_on;
  }

  if( !empty(  $this->kx40S1[ 'text' ] ) )
  {
    if ( $this->kx40S1[ 'text_c' ] )
    {
      $this->kx40out[ 'judge' ][ 'css_center' ]	  .= $this->kx40Sxx[ 'kxcl' ][ 'text_class' ].' ';
      $this->kx40out[ 'judge' ][ 'css_center' ]	  .= '__radius_10';

      $this->kx40out[ 'judge' ][ 'style_center' ]	 .= $this->kx40Sxx[ 'kxcl' ][ 'background_normal_style' ];
    }

    $this->kx40out[ 'title_main' ]		 =  $this->kx40S1[ 'text' ] ;
  }
  else
  {
    $this->kx40out[ 'title_main' ]			 =  $_title_trans;
  }
}



/**
 * 編集リンクret3
 *
 * @return void
 */
public function kx40_edit_link(){

  $ret = NULL;

  if( $this->kx40S1[ 'level' ] == 10 && !empty( $this->kx40S1[ 'edit_link_on' ] ) ):

    //echo $this->kx40S1[ 'auto' ];

    if( empty( $this->kx40out[ 'judge' ][ 'css_link_e' ] )):
      $this->kx40out[ 'judge' ][ 'css_link_e' ] = NULL;
    endif;

    $ret  .=  '<span class="__a_gray __edit __xxsmall">';//⑥
    $ret  .=  '<a href="'. $this->kx40Sxx['link_edit'] .'" class="' . $this->kx40out[ 'judge' ][ 'css_link_e' ].'">';

    if( !empty( $this->kx40S1['auto'] ) ):

      $ret  .= '<span class="__xsmall __color_gray03">';	//w1+
      $ret  .= ' AUTO：';
      $ret  .= $this->kx40S1['auto'];
      $ret  .= ' ';
      $ret  .= '</span>';	//w1+

    endif;

    $ret .= 'ID：'. $this->kx40Sxx[ 'id' ];
    $ret .= '</a>';
    $ret .= '</span>';

    $this->kx40out[ 'edit_link_html' ]  = $ret;


  endif; 	//LV10-edit

}


/**
* left
*
* @return void
*/
public function kx40_left(){

  if( !empty( $this->kx40out[ 'comma_off' ] ) || empty( $this->kx40out[ 'judge' ][ 'comma' ] ) ):

    $this->kx40out[ 'judge' ][ 'comma' ] = NULL;

  endif;

  $this->kx40out[ 'left' ]     =  $this->kx40out[ 'sentou' ]  . $this->kx40out[ 'judge' ][ 'comma' ];

}



/**
* center
*
* @return void
*/
public function kx40_center(){

  $content     = $this->kx40out[ 'title_main' ]	;

  if( $this->kx40out[ 'judge' ][ 'link_on' ] )
  {
    $ret  = '<a href="' . $this->kx40out[ 'link' ] . '">';
    $ret .= $content;
    $ret .= '</a>';
  }
  else
  {
    $ret = $content;
  }

  $this->kx40out[ 'center' ] = $ret;

}


/**
* right
*
* @return void
*/
public function kx40_right(){

  if( empty( $this->kx40out[ 'edit_link_html' ] )):
    $this->kx40out[ 'edit_link_html' ] = NULL;
  endif;

  if( empty( $this->kx40out[ 'delete' ] )):
    $this->kx40out[ 'delete' ] = NULL;
  endif;

  if( empty( $this->kx40out[ 'raretu_check' ] )):
    $this->kx40out[ 'raretu_check' ] = NULL;
  endif;

  $this->kx40out['right'] = $this->kx40out[ 'edit_link_html' ] . $this->kx40out[ 'delete' ] . $this->kx40out[ 'raretu_check' ] ;

}

}?>