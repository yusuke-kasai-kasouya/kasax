<?php

  /*
    稼働中。製作中。2020/12/20
  */

  require_once ('../../../../../wp-blog-header.php');


  $args = [ 'hide_empty'  =>  false ];

  $tags = get_tags( $args);

  $count_all  =  count($tags);


  $text = '';

  foreach( $tags as $tag) :


    if( $tag->count == 0 ):



      $text .= $tag->name . '-'. $tag->count .  '-' . $tag->term_id  .'<br>';

      $ids[]  =  $tag->term_id;

    endif;



  endforeach;

  //echo'A+';
  //wp_delete_term( 706, 'post_tag' ) ;
  //echo'+B';
  //wp_delete_term( 706, 'tag' ) ;

  $count  = count($ids)  - 20;

  $i  = 0;
  foreach( $ids as $term_id) :

    $i++;
    wp_delete_term( $term_id, 'post_tag' ) ;

    if( $i == 20 ):

      $_mete_reload = '<meta http-equiv="refresh" content="1; URL=">';
      $text = '削除中・リロード。残り'.$count;
      break;

    else:

      $text = 'TAG削除完了';

    endif;

  endforeach;

?>




<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>カテゴリー0削除ページ</title>
    <?php echo $_mete_reload; ?>
  </head>

  <body>
    <h1><?php echo $text; ?></h1>

  </body>

</html>