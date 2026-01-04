
<?php

  require_once ('../../../../../wp-blog-header.php');

  $id       = $_GET[ 'id' ] ;
  $cat      = $_GET['cat'] ;
  $tag      = $_GET['cat'] ;
  $tag_not  = $_GET['tag_not'] ;

  foreach( $_GET as $key => $value ):

    $str .= $key . ' - ' . $value . '<br>';

  endforeach;

  $arr = $_GET;
  $arr[ 'reload_link' ]  = 1;
  $arr[ 'ppp' ]  = 9;

  $ret =  kx_update_cat_check( $arr );

  $_time = 0;


  if( $_GET[ 'update' ] == 'RELOAD' && !preg_match( '/post0|確認output|アップデート無し（stop_on）/' , $ret  , $matches) ):

    echo 'RELOAD_' . $_time . '秒';
    $_mete_reload = '<meta http-equiv="refresh" content="' . $_time . '; URL=">';

  elseif( $_GET[ 'update' ] == 'RELOAD' ):

    $ret = '更新なし+'.$matches[0];

  endif;



?>


<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <title>書き出しページ</title>
    <?php echo $_mete_reload; ?>

  </head>

  <body>
    <h1>内容</h1>

    <?php echo $str; ?>
    <?php echo $ret; ?>



  </body>

</html>


<?php unset($post ,$title ,$content); ?>