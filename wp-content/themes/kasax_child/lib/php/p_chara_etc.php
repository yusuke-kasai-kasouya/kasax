<?php
  /**
  * スクリプト表示。シンプルタイプ。
  */

  require_once ('../../../../../wp-blog-header.php');

  $_SESSION[ 'add_new' ]	= 1300;
  $_SESSION['memo']['etc_chara']  = 'on';

  $id     = $_GET[ 'id' ] ;
  $num    = $_GET['num'] ;
  //$num_cs = $_GET['numcs'] ;
  $cat    = $_GET['cat'] ;
  $_GET['newtitle'] ;

  if( !empty( $_GET['numcs'] )):

    $_arr = [
      [60 ,''                 , '≫c\w{1,}$' , '＿kx_tp type＝chara＿'],
      //[19 ,'≫2構成≫〇j152'  , ''               , '' , 'text_c'=>  '目的'],
      [19 ,'≫2構成≫〇w502'    , ''               , '' , 'text_c'=>  '目的'],
      [19 ,'≫2構成≫設計'        , ''        , ''],
      [19 ,'≫2構成≫概要'        , ''        , ''],
      [29 ,'≫＼c'	.	$num .'≫B' , ''              , ''  , 'head_no,foot_no,floor_on,reference_off,new_off',],
    ];

    $ret = '';
    foreach( $_arr as $v ):

      $new_content ='';
      $text_c = '';
      $sys = '';
      if( !empty( $v[3] ) ):

        $new_content = $v[3];

      endif;


      if( !empty( $v[4] ) ):

        $sys = $v[4];

      endif;


      if( !empty( $v['text_c'] ) ):

        $text_c = $v['text_c'];

      endif;


      $ret  .=  kx_CLASS_kxx( [
        't'							=>	$v[0],
        'cat'						=>	$cat,
        'tag'						=>	'c' . $_GET['numcs'],
        'search'				=>	$v[1] ,
        'title_s'       =>	$v[2] ,
        'text_c'        =>	$text_c ,
        'new_content'	  =>	$new_content ,
        'sys'						=>	$sys ,
      ] );

    endforeach;

    $ret  .=  kxEdit([
      't'						=>	78,
      'new_title'		=>	$_GET['newtitle'] ,
      'new'					=>	1,
      //'css_hyouji'	=>	$css_hyouji,
    ] );

    echo $ret;

  else:

    echo '登録なし';

  endif;





?>