<?php
  /**
   * スクリプト表示。シンプルタイプ。
   */
  require_once ('../../../../../wp-blog-header.php');

$data = [
    'type' => 'DB_list',
    'text1' => $_GET[ 'table_name' ],
    'text2' => $_GET[ 'column' ],
    'text3' => $_GET[ 'text3' ],
  ];

  $sql_rsl = kxdbTemp('DB_list', $data );

  if ($sql_rsl === true )
  {
    if( $_GET[ 'type' ] == '未設定。works用？2025年11月2日')
    {
      header('Location:'.get_permalink(6));
    }
    else
    {
      header('Location:'.get_permalink(7));
    }
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
  foreach($_GET as $value)
  {
    echo $value;
    echo'<br>';
  }

?>

</body>

</html>