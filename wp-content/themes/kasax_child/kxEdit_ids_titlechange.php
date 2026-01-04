<!-- wpのシステム読み込み -->
<?php require_once ('../../../wp-blog-header.php'); ?>

<?php
  if(empty($_POST)) {
    echo "<a href='database1.html'>database1.html</a>←こちらのページからどうぞ";
  }else{

    foreach( explode( ',' , $_POST[ 'ids' ] )  as  $id ):

      $_get_title  =  get_the_title( $id );


      $new_title = str_replace( $_POST['title_base_share'] , $_POST[ 'title_change' ] , $_get_title );


      if( $new_title  !=  $_get_title ):

        echo $new_title.'<br>';

        $post = array(

          'ID'					  => $id,
          'post_title'  	=> $new_title,

        ) ;

        wp_update_post( $post ) ;
        unset($post);

      endif;



    endforeach;

  }

?>

<head>

<?php


if( $_POST['url'] ){
  header('Location:'.$_POST['url'] );
  print_r($_POST);

}else{
  header('Location:javascript:history.go(-1).reload()');
  echo  '<br>■back■';
}



?>


</head>