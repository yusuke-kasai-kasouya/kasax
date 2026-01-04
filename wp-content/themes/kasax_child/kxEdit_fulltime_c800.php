<!-- wpのシステム読み込み -->
<?php require_once ('../../../wp-blog-header.php'); ?>

<?php
  if( empty( $_POST ))
  {
    echo "<a href='database1.html'>database1.html</a>←こちらのページからどうぞ";
  }
  else
  {
    print_r($_POST);
    echo '<hr>';

    echo '<p>cat:';
    echo $_POST[ 'cat' ];
    echo '</p>';

    echo '<p>time_base:';
    echo $_POST[ 'time_base' ];
    echo '</p>';


    $_array_ids = kx_CLASS_kxx(
    [
      'cat'     => $_POST[ 'cat' ],
      'tag'     => "c800+来歴",
      'search'  => 'c800≫来歴≫',
      'title_s' => $_POST[ 'time_base' ]. '(_|＠)',
    ] , 'array_ids' );

    echo count($_array_ids[ 'array_ids' ]);

    foreach( $_array_ids[ 'array_ids' ] as $_id ):
      $_title     = get_the_title( $_id );
      $_new_title = preg_replace( '/'.$_POST[ 'time_base' ]. '/' , $_POST[ 'time' ] , $_title );
      echo '<p>';
      echo $_title;
      echo '</p>';

      echo '<p>';
      echo $_new_title;
      echo '</p>';


      if( $_title  !=  $_new_title )
      {

        $post = array(
          'ID'					  => $_id,
          'post_title'  	=> $_new_title,
        ) ;

        wp_update_post( $post ) ;
        unset($post);

      }

      echo '<hr>';

    endforeach;


  }

?>

<head>

<?php

//return;//確認用


if( $_POST['url'] ){
  header('Location:'.$_POST['url'] );
  print_r($_POST);

}else{
  header('Location:javascript:history.go(-1).reload()');
  echo  '<br>■back■';
}



?>


</head>