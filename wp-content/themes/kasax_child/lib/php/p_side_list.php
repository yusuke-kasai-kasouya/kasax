<?php
  /**
   * スクリプト表示。シンプルタイプ。
   */

  require_once ('../../../../../wp-blog-header.php');



  $_SESSION[ 'add_new' ]	=1299;
  //$id           =  $_GET[ 'id' ] ;
  $tag          =  $_GET[ 'tag' ] ;
  $type         =  $_GET[ 'type' ] ;

  $title      = get_the_title( $_GET[ 'id' ] );

  preg_match( '/∬\d{1,}≫c(\d)\w{1,}\d/'                , $title  , $matches );

  if(preg_match( '/∬\d{1,}≫c\d\w{1,}\d.*≫(\w{3}\d{1,})/' , $title  , $matches_sakuhin ))
  {
    $_type_sakuhin = '：'.$matches_sakuhin[1];
    $_name = $type.$_type_sakuhin;
  }
  else
  {
    $_name = $type;
  }

  $categorys	= get_the_category( $_GET[ 'id' ] );
  $category		= end(	$categorys	);

  $post = get_post( $_GET[ 'id' ] );
  $post_content = $post->post_content;

  $kxtp = new kxtp;

  //$type =  'chara,c' . $matches[1] . '00' ;
  $str = '';
  foreach( $kxtp->kxtp_SAS[ 'list_chara' ] as $arr ):

    if( empty( $arr[3] ) )
    {
      $arr[3] = '/.*/';
    }

    if( !empty( $arr[ 'title' ] ) && preg_match( $arr[3]  , $type ) )
    {

      $_title = $arr[ 'title' ] ;
      $str .= preg_replace( '/(＿kxtt)(.*)(＊＿)/' , '<div style="margin:0 0 0 20px;opacity: 0.2;">■$2</div>' , $_title);
    }
    elseif( preg_match( $arr[3]  , $type ) )
    {
      if( !empty( $arr[ '作品' ] ) )
      {
        $add_search = $matches_sakuhin[1].'≫';
      }
      else
      {
        unset( $add_search );
      }

      if( !empty(  $arr[1] ) )
      {
        $str .= $arr[1];
      }

      if( !empty( $add_search ) && !empty( $arr[0] ) )
      {
        $_search = $add_search.$arr[0];
      }
      elseif( !empty( $arr[0] ) )
      {
        $_search = $arr[0];
      }


      $str .= '<p><div>';
      $str .= kx_CLASS_kxx( [
        't'							=>	30,
        'cat'						=>	$category->cat_ID,
        'tag'						=>	$tag,
        'search'				=>	$_search ,
        'sys'						=>	'link_off,h2_off,yomikomi,error_navi_off',
        //'new_content'	=>	$new_content,
        //'ScCountOFF'    =>  1,
      ] );
      $str .= '</div></p>';
      $str .= $arr[2];
    }

  endforeach;
  unset($arr);


  $str = preg_replace( '/(＿kxtt)(.*)(＊＿)/' , '<div style="margin:0 0 0 20px;opacity: 0.2;">■$2</div>'            , $str );
  $str = preg_replace( '/〚(.*)〛/' , '<div style="margin:0 0 0 20px;opacity: 0.2;">■$1</div>'                      , $str );

  $style_css   =  '<style type="text/css">';
  $style_css  .=  '<!-- ';
  $style_css  .=  '::-webkit-scrollbar{ width:7px;}';
  $style_css  .=  ' -->';
  $style_css  .=  '</style>';

?>
<html>

  <head>

  </head>

    <?php echo $style_css; ?>


    <div style="margin:0 0 0 20px;opacity: 0.2;">

      <?php echo $_name; ?>

    </div>

    <div class="">

      <?php echo $str; ?>

    </div>



  </body>

</html>