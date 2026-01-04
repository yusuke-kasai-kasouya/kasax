<!-- wpのシステム読み込み -->
<?php require_once ('../../../wp-blog-header.php'); ?>

<?php

  if( empty( $_POST ) )
  {
    echo "<a href='database1.html'>database1.html</a>←";
    echo  'Post無し';
  }
  else
  {
    if( preg_match( '/^\d$/' , $_POST['title2a1'] ) )
    {
      $title2a1 =  '0'.$_POST['title2a1'];
    }
    else
    {
      $title2a1 =  $_POST['title2a1'];
    }


    if($_POST['title2a3'] )
    {
      //”-”の追記。
      $title2a2 =  $_POST['title2a2'];
    }


    if(preg_match('/^\d$/'  , $_POST['title2a3'] ))
    {
      $title2a3 =  '0'.$_POST['title2a3'];
    }
    else
    {
      $title2a3 =  $_POST['title2a3'];
    }


    $title   = '';
    $title  .= $_POST['title1'];
    $title  .= $title2a1.$title2a2.$title2a3.$_POST['title2b'].$_POST['title2c'];
    $title  .= $_POST['title2d'].$_POST['title2e'];
    $title  .= $_POST['title3a'].$_POST['title3b'].$_POST['title3c'].$_POST['title3d'].$_POST['title4'].$_POST['title5'].$_POST['title'];

    $title  = str_replace( '＞' , '≫' , $title );


    if( preg_match('/≫＠/' , $title ) )
    {
      $title  = str_replace('＠'  ,'' , $title);
    }


    $post = array(
      'post_title'  	=> $title,
      'ID'					  => $_POST[ 'id' ],
    ) ;


    //content
    if( $_POST['format_off'] ==  'format_off')
    {
      $post['post_content']  = '■format_off■'.$_POST['text'];
    }
    elseif($_POST['text0f']  || $_POST['text0r']|| $_POST['text'] )
    {
      if($_POST['format_off2'] ==  'format_off2')
      {
        $post['post_content']  = $_POST['text0r'].$_POST['text'];
      }
      else
      {
        $post['post_content']  = $_POST['text0f'].$_POST['text0f2'].$_POST['text0f3'].$_POST['text0r'].$_POST['text'];
      }
    }
    elseif( $content )
    {
      $post['post_content']  = $content;
    }
    elseif( $_POST['daimei_only'] ==  'daimei_only')
    {
      //スルー
    }
    else
    {
      //コンテンツがない場合。
      $post['post_content']  = '';
    }

    wp_update_post( $post ) ;
    unset($post);
  }
?>

<head>

<?php



  if( $_POST['reload']  )
  {
    header('Location:'.$_POST['url'] );
    print_r($_POST);
  }
  else
  {
    header('Location:javascript:history.go(-1).reload()');
    echo  '<br>■back■';
  }

  echo  '<HR>$post';
  print_r($post);
  echo  '<HR>$_POST';
  print_r($_POST);
?>
</head>