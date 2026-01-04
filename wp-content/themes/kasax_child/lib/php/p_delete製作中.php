
<?php

  /**
  * 削除★製作中
  */

  //wpのシステム読み込み
  require_once ( '../../../../../wp-blog-header.php' );

  //エラー排除
  if( empty( $_GET ) ):

    echo  "<a href='database1.html'>database1.html</a>←こちらのページからどうぞ";
    echo  'Post無し';

    return;

  endif;

  //★製作中
  wp_delete_post( $_GET[ 'id' ]  );


  if( $_GET[ 'url' ] ):

    header( 'Location:'.$_GET[ 'url' ] );
    //print_r( $_GET );

  else:

    header('Location:javascript:history.go(-1).reload()');
    echo  '<br>■back■';

  endif;



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