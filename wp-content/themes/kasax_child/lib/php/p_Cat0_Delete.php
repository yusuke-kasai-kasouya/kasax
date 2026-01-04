<?php

  /*
    稼働中。製作中。2020/12/20
  */

  require_once ('../../../../../wp-blog-header.php');


  $args = [ 'hide_empty'  =>  false ];

  $tags = get_tags( $args);

  $count_all  =  count($tags);


  $text = '';
  //$i  = 0;
  foreach( $tags as $tag) :

    /*
    echo $tag->name;
    echo '-';
    echo $tag->count ;
    echo '<br>';
    */

    if( $tag->count == 0 ):

      //$i++;

      $text .= $tag->name . '-'. $tag->count .  '-' . $tag->term_id  .'<br>';

      $ids[]  =  $tag->term_id;

    else:
      /*
      echo $tag->name;

      echo '-';
      echo $tag->count ;
      echo '<br>';
      */

    endif;



  endforeach;
  $count  = count($ids);

  print_r(get_term(706));

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>カテゴリー0削除</title>
  </head>

  <body>
    <h1>TAG削除</h1>
    <div>
      <a href="p_Cat0_Delete2.php">削除</a>
    </div>

    <div>
    <?php echo $count; ?>/<?php echo $count_all; ?>件
    </div>

    <?php echo $text; ?>







  </body>

</html>