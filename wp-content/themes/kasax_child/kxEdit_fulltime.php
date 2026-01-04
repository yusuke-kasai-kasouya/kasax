<!-- wpのシステム読み込み -->
<?php require_once ('../../../wp-blog-header.php'); ?>

<?php
  if( empty( $_POST ))
  {
    echo "<a href='database1.html'>database1.html</a>←こちらのページからどうぞ";
  }
  else
  {

    $pattern1   = '/≫(\d{1,})(-|)(\d{1,}|)([a-z]|)(\d|)(\d|)(\d|)/';
    $pattern2  = '/＠.*$/';

    foreach( explode( ',' , $_POST[ 'id' ] )  as  $id ):

      $title_base  =  get_the_title( $id );
      $title       =  $title_base;

      if( !preg_match(  '/' . $_POST['time'] . '(＠|_)/' ,  $title )  )
      {

        $title  = preg_replace( $pattern1  , '≫'.$_POST['time']  , $title );

      }

      if  ( $_POST['title_change_on'] ):

        $title  = preg_replace( $pattern2  , '＠'.$_POST[ 'title_change'  ]  , $title );

      endif;

      if  ( $_POST[ 'plot_code_change_on' ] )
      {


        $title  = preg_replace( '/＠.*$/' , $_POST[ 'wwr_plot_code_base' ]. '$0'  , $title );




      }

      if( $title  !=  $title_base )
      {

        $post = array(

          'ID'					  => $id,
          'post_title'  	=> $title,

        ) ;

        wp_update_post( $post ) ;
        unset($post);

      }



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