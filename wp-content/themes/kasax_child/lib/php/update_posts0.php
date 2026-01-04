<?php
  /**
   * スクリプト表示。シンプルタイプ。
   */
  require_once ('../../../../../wp-blog-header.php');

  //チェック用。残す。2025-04-30
  //echo $_GET[ 'type' ];
  //echo $_GET[ 'title' ];
  //echo '<hr>';
  //var_dump($_POST);

  if(empty( $_POST['type'] ))
  {
    echo 'ERROR-typeなし';
    return;
  }

  // 文字列をJSON形式の配列に変換

  echo $_POST['type'];
  echo '<br>';

  $_text1 = NULL;
  $_text2 = NULL;
  $_text3 = NULL;
  $_text4 = NULL;
  if( $_POST['type'] == 'title_change_ids')
  {

    if( !empty($_POST['checkbox']))
    {
      //echo 'A';
      $_text1 = $_POST['Title_ALL1'];
      $_text2 = $_POST['Title_ALL2'];

    }
    else
    {
      //echo 'B';
      $_text1 = '≫'.$_POST['Title_END1'];
      $_text2 = '≫'.$_POST['Title_END2'];
    }
  }
  elseif( $_POST['type'] == 'shared_titles_change')
  {
    $_text1 = $_POST['Title1'];
    $_text2 = $_POST['Title2'];
  }
  elseif($_POST['type'] == 'ChangePost_FormGet' && !empty($_POST['content_replace_on']) && $_POST['content_replace_on'] == 1)
    {
      $_text3 = $_POST['Content1'];
      $_text4 = $_POST['Content2'];
      //echo $_text4;
    }
  elseif( $_POST['type'] == 'ChangePost_FormGet')
  {
    $_text1 = $_POST['Title1'];
    $_text2 = $_POST['Title2'];


  }



  echo '<hr>';

  //echo $_POST['ids'];


  // JSON形式でエンコード
  $array = kx_sort_ids_by_title_length(explode(",", $_POST['ids']) );

  //$json_array = kx_json_encode( $array) ;

  $data = [
    'type' => 'update_posts',
    'text1' => $_text1,
    'text2' => $_text2,
    'text3' => $_text3,
    'text4' => $_text4,
    'json'  => kx_json_encode( $array ),
  ];

  $sql_rsl = kxdbTemp('update_posts', $data );


  if ($sql_rsl === true )
  {
    echo kxdbTemp_update_posts();

    $redirect_url = get_stylesheet_directory_uri() . '/lib/php/update_posts1.php';
    echo '<button onclick="window.location.href=\'' . esc_url($redirect_url) . '\'">処理開始</button>';
  }
  else
  {
    echo 'クエリに失敗しました: ';
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

//echo $_GET[ 'key' ];
//echo'<br>';
//echo $_GET[ 's' ];
//echo'<br>';
//echo $_GET[ 'title' ];



?>

</body>

</html>


<?php unset($post ,$title ,$content); ?>