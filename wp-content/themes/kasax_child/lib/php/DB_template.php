<?php
  /**
   * スクリプト表示。シンプルタイプ。
   */
  require_once ('../../../../../wp-blog-header.php');

  //チェック用。残す。2025-04-30
  //echo $_GET[ 'type' ];
  //echo $_GET[ 'title' ];
  //echo '<hr>';

  /*
  $id = 2; // 動的な値を使用する場合に備えて変数を定義
  $sql_rsl = $wpdb->get_results(
      $wpdb->prepare(
          "SELECT * FROM wp_kx_temporary WHERE id = %d",
          $id
      )
  );
  */

  $data = [
    'type' => 'DB_template',
    'text1' => $_GET[ 'title' ],
    'text2' => $_GET[ 'type' ],
  ];

  $sql_rsl = kxdbTemp('DB_template', $data );

  if ($sql_rsl === true )
  {
    header('Location:'.get_permalink(8));
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
echo $_GET[ 'title' ];



?>

</body>

</html>


<?php unset($post ,$title ,$content); ?>