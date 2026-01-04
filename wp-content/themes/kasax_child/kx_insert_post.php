<!-- wpのシステム読み込み -->
<?php require_once ('../../../wp-blog-header.php'); ?>

<?php
  if(empty($_POST))
  {
    echo "<a href='database1.html'>database1.html</a>←こちらのページからどうぞ";
  }
  else
  {

    if( !empty($_POST['title_light']) )
    {
      $title  = $_POST['title_light'];
    }
    else
    {
      //print_r( $_POST);

      if(preg_match('/^\d$/'  , $_POST['title2a1'] ))
      {
        $title2a1 =  '0'.$_POST['title2a1'];
      }
      else
      {
        $title2a1 =  $_POST['title2a1'];
      }

      if($_POST['title2a3'] ):

        $title2a2 =  $_POST['title2a2'];

      endif;

      if(preg_match('/^\d$/'  , $_POST['title2a3'] )):

        $title2a3 =  '0'.$_POST['title2a3'];

      else:
        $title2a3 =  $_POST['title2a3'];

      endif;

      $title   = '';
      $title  .= $_POST['title1'];
      $title  .= $title2a1.$_POST['title2a2'].$title2a3.$_POST['title2b'].$_POST['title2c'];
      $title  .= $_POST['title2d'].$_POST['title2e'];
      $title  .= $_POST['title3a'].$_POST['title3b'].$_POST['title3c'].$_POST['title3d'].$_POST['title4'].$_POST['title5'].$_POST['title'];

    }


    $title  = str_replace('＞'  ,'≫' , $title);

    if(preg_match('/≫：/' , $title)):
      $title  = str_replace('：'  ,'' , $title);
    endif;

    $post = array(
      'post_title'  	=>  $title,
      'post_status'   =>  'publish',
      'post_type'     =>  $_POST['post_type']
    ) ;

    if($_POST['text0f']  || $_POST['text0r']|| $_POST['text'] ):

      $post['post_content']  = $_POST['text0f'].$_POST['text0r'].$_POST['text'];

    endif;


    wp_insert_post( $post );
    unset($post);

  }

?>
<head>

<?php
if( $_POST['reload']  ){
  print_r($_POST);
  header('Location:'.$_POST['url'] );
}else{
  header('Location:javascript:history.go(-1).reload()');
}
?>

</head>