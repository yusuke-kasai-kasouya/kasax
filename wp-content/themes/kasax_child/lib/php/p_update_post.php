<?php

use Kx\Utils\Time;

  /**
  * post上書き保存、新規保存。
  */

  //wpのシステム読み込み
  require_once( '../../../../../wp-blog-header.php' );

  //エラー排除
  if( empty( $_POST ) ) {

    //echo "<a href='database1.html'>database1.html</a>←こちらのページからどうぞ";
    echo  'Post無しError';

    return;

  }


  //content
  $title      = NULL;
  $content    = NULL;
  $short_code = NULL;
  $post       = [];
  foreach( $_POST as $key => $volume ):

    if(     preg_match('/title/'      ,$key ) ):

      $title  .=  $volume;

    elseif( preg_match('/short_code/' ,$key ) ):

      $short_code .=  $volume;

    elseif( preg_match('/content/'      ,$key ) ):

      $content    .=  $volume;


    endif;

  endforeach;


  if( !empty( $_POST[ 'format_off' ] ) )
  {
    $content    = '■format_off■'.$content;
  }
  elseif( !empty( $_POST[ 'delete_on' ] ) )
  {
    //$timestamp = time() + (9 * 60 * 60);

    $content    = '<div style="color:red;font-size:12pt;">delete_on<br>Time：'.Time::format().'<br>ID：'.$_POST[ 'id' ] .'</div><!--more-->'.$content;
  }
  elseif( !empty( $_POST['short_code_reset'] ) )
  {
    $content    = $short_code.'short_code_reset';
  }
  else
  {
    $content    = $short_code.$content;
  }


  $replace  =
  [
    '＞'    =>  '≫',
    '≫＠'  =>  '≫',
  ];

  $title  = str_replace(  array_keys($replace)  ,$replace ,$title);
  //■■■■■　書き換え　■■■■■

  $post =
  [
    'post_title'  	 =>  $title,
    'post_content'   =>  $content,
    'comment_status' => 'closed',
  ];

  if( !empty( $_POST[ 'id' ] ) )
  { //上書き保存
    $post[ 'ID' ] = $_POST[ 'id' ];

    wp_update_post( $post );

    $ok = 'ok';

    if( !empty( $_POST[ 'delete_on' ]) )
    {
      wp_delete_post( $_POST[ 'id' ] );
    }


  }
  else
  { //新規保存
    $post[ 'post_status' ] = 'publish';

    wp_insert_post( $post );
  }

  if( $_POST['reload']  ){

    header('Location:'.$_POST['url'] );
    print_r( $_POST );

  }else{
    header('Location:javascript:history.go(-1).reload()');
    echo  '<br>■back■';
  }


?>


<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <title>書き出しページ</title>
  </head>

  <body>
    <h1>内容</h1>

    <?php

      echo $ok.'<br>';

      echo  '<h2>$post</h2>';
      print_r($post);

      echo  '<h2>$_POST</h2>';
      print_r($_POST);

      echo  '<h2>ID</h2>';
      echo  $_POST[ 'id' ];


      echo  '<h2>title</h2>';
      echo  $title;


      echo  '<h2>content</h2>';
      echo  $content;


    ?>

  </body>

</html>


<?php unset($post ,$title ,$content); ?>